<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

/**
 * Sanitizer HTML untuk konten rich-editor CMS.
 *
 * Editor di panel admin memakai `document.execCommand` lalu mengirim
 * innerHTML apa adanya ke server, jadi HTML dari pengguna wajib dibersihkan
 * sebelum disimpan (ancaman stored XSS). Strategi: parse sebagai DOM, buang
 * elemen berbahaya beserta isinya, "unwrap" elemen di luar whitelist, dan
 * sisakan hanya atribut yang aman dengan skema URL yang diizinkan.
 */
class Sanitizer
{
    /** Elemen yang dihapus bersama seluruh isinya. */
    private const HAPUS_TOTAL = [
        'script', 'style', 'iframe', 'object', 'embed', 'link', 'meta',
        'base', 'form', 'input', 'button', 'select', 'textarea', 'svg', 'math',
    ];

    /** Elemen yang boleh tetap ada => daftar atribut yang diizinkan. */
    private const IZIN = [
        'p' => [],
        'br' => [],
        'hr' => [],
        'div' => [],
        'span' => [],
        'strong' => [],
        'b' => [],
        'em' => [],
        'i' => [],
        'u' => [],
        's' => [],
        'strike' => [],
        'small' => [],
        'sub' => [],
        'sup' => [],
        'code' => [],
        'pre' => [],
        'blockquote' => [],
        'ul' => [],
        'ol' => [],
        'li' => [],
        'h1' => [],
        'h2' => [],
        'h3' => [],
        'h4' => [],
        'h5' => [],
        'h6' => [],
        'a' => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'table' => [],
        'thead' => [],
        'tbody' => [],
        'tr' => [],
        'td' => [],
        'th' => [],
    ];

    /** Skema URL yang diterima pada href/src. */
    private const SKEMA_AMAN = ['http', 'https', 'mailto', 'tel'];

    /**
     * Bersihkan HTML. Mengembalikan string HTML yang aman disimpan.
     */
    public static function html(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $sebelumnya = libxml_use_internal_errors(true);

        // Pembungkus + deklarasi encoding agar UTF-8 tidak rusak dan dokumen
        // tidak otomatis diberi <html>/<body>.
        $dom->loadHTML(
            '<?xml encoding="UTF-8"?><div id="__sanitizer_root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET,
        );

        libxml_clear_errors();
        libxml_use_internal_errors($sebelumnya);

        $xpath = '//*[@id="__sanitizer_root"]';
        $root = (new DOMXPath($dom))->query($xpath)->item(0);
        if (! $root instanceof DOMElement) {
            return '';
        }

        self::prosesAnak($root);

        $hasil = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $hasil .= $dom->saveHTML($child);
        }

        return trim($hasil);
    }

    /** Teks biasa: buang seluruh tag. */
    public static function teks(?string $nilai): string
    {
        return trim(strip_tags((string) $nilai));
    }

    /**
     * Proses seluruh anak sebuah node. Snapshot dulu karena daftar anak
     * berubah saat elemen dihapus atau di-unwrap.
     */
    private static function prosesAnak(DOMNode $parent): void
    {
        $anak = [];
        for ($c = $parent->firstChild; $c !== null; $c = $c->nextSibling) {
            $anak[] = $c;
        }

        foreach ($anak as $node) {
            self::proses($node);
        }
    }

    private static function proses(DOMNode $node): void
    {
        if (! $node instanceof DOMElement) {
            // Teks dibiarkan; komentar & processing instruction dibuang.
            if ($node->nodeType !== XML_TEXT_NODE && $node->nodeType !== XML_CDATA_SECTION_NODE) {
                $node->parentNode?->removeChild($node);
            }

            return;
        }

        $tag = strtolower($node->nodeName);

        if (in_array($tag, self::HAPUS_TOTAL, true)) {
            $node->parentNode?->removeChild($node);

            return;
        }

        if (! array_key_exists($tag, self::IZIN)) {
            // Elemen di luar whitelist: angkat isinya ke parent, buang
            // pembungkusnya, lalu periksa isi yang baru dipindahkan itu.
            foreach (self::unwrap($node) as $pindahan) {
                self::proses($pindahan);
            }

            return;
        }

        self::bersihkanAtribut($node, self::IZIN[$tag]);
        self::prosesAnak($node);
    }

    /**
     * Pindahkan seluruh anak $node ke parentnya, lalu hapus $node.
     *
     * @return array<int,DOMNode> node yang dipindahkan
     */
    private static function unwrap(DOMElement $node): array
    {
        $parent = $node->parentNode;
        if ($parent === null) {
            return [];
        }

        $pindahan = [];
        while ($node->firstChild !== null) {
            $child = $node->firstChild;
            $parent->insertBefore($child, $node);
            $pindahan[] = $child;
        }

        $parent->removeChild($node);

        return $pindahan;
    }

    /**
     * @param  array<int,string>  $atributDiizinkan
     */
    private static function bersihkanAtribut(DOMElement $node, array $atributDiizinkan): void
    {
        $nama = [];
        foreach (iterator_to_array($node->attributes) as $attr) {
            $nama[] = $attr->nodeName;
        }

        foreach ($nama as $attr) {
            $rendah = strtolower($attr);

            if (! in_array($rendah, $atributDiizinkan, true)) {
                $node->removeAttribute($attr);

                continue;
            }

            if (in_array($rendah, ['href', 'src'], true) && ! self::urlAman((string) $node->getAttribute($attr))) {
                $node->removeAttribute($attr);
            }
        }

        // Tautan eksternal selalu dibuka aman.
        if (strtolower($node->nodeName) === 'a' && $node->getAttribute('target') === '_blank') {
            $node->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private static function urlAman(string $url): bool
    {
        $url = trim($url);
        if ($url === '') {
            return false;
        }

        // Relatif (/, #, ?) dan fragment selalu diterima.
        if (preg_match('#^[/?\#]#', $url) === 1) {
            return true;
        }

        // URL tanpa skema (mis. "kegiatan") diterima sebagai path relatif.
        if (str_contains($url, ':') === false) {
            return true;
        }

        $skema = strtolower((string) preg_replace('/[^a-z]/i', '', substr($url, 0, (int) strpos($url, ':'))));

        return in_array($skema, self::SKEMA_AMAN, true);
    }
}
