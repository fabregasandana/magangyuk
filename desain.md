# PRD: Redesign UI/UX — Magang Komdigi Monitoring

**Tanggal:** 13 November 2026  
**Status:** Ready for Implementation  
**Tech Stack:** Laravel + Tailwind CSS + JavaScript

---

## 1. Overview

Melakukan redesign menyeluruh pada UI/UX website monitoring magang (Landing Page, Login, Dashboard Peserta, Dashboard Pembimbing, dan Dashboard Admin) agar lebih modern, profesional, konsisten dengan identitas visual Kominfo, serta memiliki animasi dan interaksi yang lebih baik.

### Keputusan teknis yang digunakan

- Framework Backend: Laravel
- Frontend: Laravel Blade + Tailwind CSS
- JavaScript: Vanilla JavaScript
- Font: Plus Jakarta Sans
- Icon: Lucide Icons
- Animasi dasar: tailwindcss-animate + CSS Animation
- Animasi advanced: GSAP
- Animasi elemen dan SVG: Anime.js
- Animasi visual berbasis pixel/karakter: Canvas API
- Efek grafis interaktif: WebGL
- Chart: ApexCharts
- Interaktivitas: Alpine.js
- Build Tool: Vite

**Catatan:** Seluruh library animasi harus kompatibel dengan Laravel Blade. Tidak perlu mengubah arsitektur frontend menjadi React.

---

## 2. Problem Statement

UI saat ini masih kurang modern, warna belum selaras dengan identitas Kominfo, komponen kurang konsisten, serta animasi dan interaktivitas masih minim.

Hal ini membuat pengalaman pengguna (terutama di dashboard) terasa kurang premium dan kurang nyaman digunakan dalam jangka panjang.

---

## 3. Goals & Success Metrics

### Goals

- Meningkatkan kesan modern, profesional, dan rapi.
- Menyelaraskan visual dengan identitas Kominfo.
- Memberikan micro-interaction dan animasi yang halus namun tidak berlebihan.
- Menyediakan Dark Mode & Light Mode.
- Meningkatkan konsistensi komponen di seluruh halaman.
- Menghadirkan animasi modern dan interaktif pada Landing Page.
- Memberikan interaksi visual yang lebih menarik pada dashboard tanpa mengurangi usability.
- Memastikan seluruh animasi berjalan optimal pada desktop maupun mobile.

### Success Metrics

- Visual terasa lebih modern dan konsisten.
- Animasi terasa smooth (tidak lag / tidak berlebihan).
- Pengguna merasa lebih nyaman menggunakan dashboard.
- Komponen (button, card, badge, table, chart) seragam di semua role.
- Animasi tidak mengganggu fungsi utama aplikasi.
- Tidak terjadi konflik antara beberapa library animasi.
- Performa website tetap optimal.

---

## 4. Design Direction

### Gaya Utama

Soft Glassmorphism / Frosted Glass UI.

### Prinsip Desain

- Dark Mode sebagai default di semua dashboard.
- Glassmorphism (card statistik, modal, header).
- Hierarki visual yang jelas.
- Spacing dan typography yang konsisten.
- Animasi bersifat supportive (membantu pemahaman), bukan mengganggu.
- Gunakan animasi yang memiliki tujuan visual dan fungsional.
- Hindari animasi berlebihan pada halaman dashboard yang berisi banyak data.

### Referensi gaya

- Linear / Vercel (clean + subtle).
- Stripe Dashboard (profesional).
- Retool / modern admin panel (data-dense tapi tetap rapi).
- theready.com
- locomotive.ca
- rainbow.me
- gamma.app
- Aesthetic interactive website dengan GSAP, Anime.js, Canvas, dan WebGL.

---

## 5. Technical Stack (Keputusan Final)

| Kebutuhan                | Tools / Library            | Keterangan                                     |
| ------------------------ | -------------------------- | ---------------------------------------------- |
| Backend                  | Laravel                    | Backend utama                                  |
| Frontend                 | Laravel Blade              | Rendering halaman                              |
| Styling                  | Tailwind CSS               | Styling utama                                  |
| Font                     | Plus Jakarta Sans          | Modern & readable                              |
| Icon                     | Lucide Icons               | Konsisten & ringan                             |
| Animasi dasar            | tailwindcss-animate        | Enter/exit, fade, slide                        |
| CSS Animation            | CSS Keyframes & Transition | Hover, loading, shimmer, micro-interaction     |
| Animasi advanced         | GSAP                       | Counter, stagger, timeline, scroll animation   |
| Animasi elemen           | Anime.js                   | Text reveal, SVG animation, stagger, transform |
| Visual berbasis karakter | Canvas API                 | ASCII animation, ripple, particle              |
| Grafis interaktif        | WebGL                      | Background visual dan efek grafis interaktif   |
| Chart                    | ApexCharts                 | Sudah digunakan, diperbaiki styling-nya        |
| Interaktivitas           | Alpine.js                  | Cocok dengan Laravel Blade                     |
| Build Tool               | Vite                       | Mengelola JavaScript dan CSS                   |

### Pembagian tanggung jawab library

**A. GSAP**
Digunakan untuk:

- ScrollTrigger.
- Scroll reveal.
- Counter animation.
- Stagger animation.
- Timeline animation.
- Progress animation.
- Parallax.
- Animasi kompleks yang membutuhkan pengaturan urutan.

**B. Anime.js**
Digunakan untuk:

- Text reveal.
- Word-by-word animation.
- SVG stroke animation.
- Transform dan opacity animation.
- Stagger pada elemen sederhana.
- Animasi angka atau elemen dekoratif jika tidak menggunakan GSAP.

**C. CSS Animation**
Digunakan untuk:

- Hover button.
- Card hover.
- Loading skeleton.
- Shimmer effect.
- Pulse effect.
- Floating animation.
- Toast notification.
- Transisi Dark Mode dan Light Mode.
- Micro-interaction.

**D. Canvas API**
Digunakan untuk:

- ASCII Ripple.
- ASCII Terrain.
- Particle animation.
- Interactive wave effect.
- Visualisasi karakter atau pola bergerak.
- Efek visual yang merespons posisi mouse.

**E. WebGL**
Digunakan untuk:

- Animated background.
- Light Tunnel effect.
- Interactive visual effect.
- Particle field berbasis GPU.
- Distortion dan shader effect.
- Efek visual 3D pada Landing Page.

Catatan: WebGL menggunakan implementasi JavaScript dan shader secara langsung. Jangan menambahkan Three.js kecuali memang diperlukan untuk kebutuhan objek 3D yang kompleks.

---

## 6. Color System (Kominfo Inspired)

### Dark Mode (Default Dashboard)

| Token | Warna | Penggunaan |
|---|---|---|
| Background Gradient | `#101426` | Latar utama |
| Background Sekunder | `#1A2340` | Latar sekunder |
| Glass Card | `#252E48B3` | Card; dapat menggunakan backdrop blur secara selektif |
| Sidebar & Primary | `#5B7CFF` | Sidebar, aksi utama dan elemen primary |
| Accent | `#8BAAFF` | Aksen dan highlight |
| Solid Surface | `#202940` | Permukaan |
| Success | `#10B981` | Status berhasil |
| Warning | `#F59E0B` | Status peringatan |
| Danger | `#EF4444` | Status error atau berbahaya |
| Text Primary | `#F1F5FF` | Teks utama |
| Text Secondary | `#B8C4E0` | Teks sekunder |

### Light Mode

| Token | Warna | Penggunaan |
|---|---|---|
| Background Gradient | `#E8EEFF` | Latar utama |
| Background Sekunder | `#DCE8FF` | Latar sekunder |
| Glass Card | `#FFFFFFB3` | Card |
| Sidebar & Primary | `#FFFFFFB3` | Sidebar & Aksi Utama |
| Text Primary | `#1E293B` | Teks utama |
| Accent | `#60A5FA` | Aksen dan highlight |
| Solid Surface | `#F8FAFF	` | Permukaan |

---

## 7. Scope

### In Scope

- Redesign Landing Page, Login, Dashboard Peserta, Dashboard Pembimbing, Dashboard Admin.
- Implementasi Dark Mode + Light Mode (dengan toggle & persist di localStorage).
- Penerapan font Plus Jakarta Sans secara global.
- Penggantian seluruh icon menjadi Lucide Icons.
- Perbaikan dan standardisasi komponen (Button, Card, Badge, Stat Card, Table, Form, Modal, Bottom Nav).
- Integrasi tailwindcss-animate untuk animasi dasar.
- Implementasi CSS Animation untuk micro-interaction.
- Integrasi GSAP untuk animasi advanced.
- Integrasi Anime.js untuk animasi elemen, teks, dan SVG.
- Integrasi Canvas API untuk efek visual interaktif.
- Implementasi WebGL untuk efek grafis interaktif yang relevan.
- Perbaikan tampilan ApexCharts agar sesuai dengan design system baru.
- Responsive (mobile-first).

### Ketentuan penggunaan animasi berdasarkan halaman

**Landing Page**

- Text reveal.
- Scroll reveal.
- Stagger animation.
- Animated counter.
- Parallax ringan.
- SVG animation.
- Particle atau ripple background.
- WebGL background jika relevan.
- Hover animation pada card dan button.

**Login Page**

- Entrance animation.
- Floating background element.
- Animated input focus.
- Button micro-interaction.
- Transisi login state.
- Loading animation.

**Dashboard Peserta**

- Animated statistic counter.
- Progress bar animation.
- Stagger pada card statistik.
- Animated status badge.
- Transisi modal dan dropdown.
- Loading skeleton.

**Dashboard Pembimbing**

- Animated statistic counter.
- Progress animation.
- Stagger pada daftar peserta.
- Animasi notifikasi.
- Transisi modal.

**Dashboard Admin**

- Animated statistic counter.
- Chart entrance animation.
- Progress animation.
- Stagger pada data dan tabel.
- Animated notification.
- Transisi modal dan dropdown.

Catatan: Canvas API dan WebGL lebih diprioritaskan untuk Landing Page. Jangan menerapkan efek grafis berat pada seluruh halaman dashboard.

---

## 8. Animation Guidelines

### A. Menggunakan tailwindcss-animate

Digunakan untuk:

- Page enter/exit.
- Modal & dropdown.
- Toast / notification.
- Hover state sederhana.
- Skeleton loading.

### B. Menggunakan CSS Animation

Digunakan untuk:

- Button hover.
- Card hover.
- Shimmer effect.
- Floating element.
- Pulse animation.
- Loading indicator.
- Input focus.
- Theme transition.
- Micro-interaction.

Gunakan CSS Animation untuk efek sederhana yang tidak memerlukan JavaScript.

### C. Menggunakan GSAP

Digunakan untuk:

- Counter angka (skor, statistik, countdown).
- Stagger animation pada list/card.
- Progress bar / circular progress yang animated.
- Timeline animation pada onboarding atau empty state.
- Subtle parallax atau reveal pada Landing Page.
- ScrollTrigger animation.
- Complex entrance animation.

### D. Menggunakan Anime.js

Digunakan untuk:

- Text reveal animation.
- Word-by-word text animation.
- SVG stroke drawing.
- Animated typography.
- Transform animation.
- Stagger animation.
- Decorative element animation.
- Micro-interaction yang membutuhkan kontrol JavaScript.

### E. Menggunakan Canvas API

Implementasikan efek visual custom menggunakan HTML Canvas.

Efek yang dapat diterapkan:

- ASCII Ripple Animation.
- ASCII Terrain Animation.
- Particle Animation.
- Interactive Wave Animation.
- Mouse-responsive Visual Effect.

Ketentuan:

- Gunakan requestAnimationFrame.
- Hindari perhitungan berat setiap frame.
- Batasi jumlah partikel.
- Optimalkan ukuran canvas berdasarkan ukuran layar.
- Gunakan devicePixelRatio secara terkontrol.
- Hentikan atau kurangi animasi ketika canvas tidak terlihat.
- Bersihkan animation frame dan event listener ketika komponen tidak lagi digunakan.

### F. Menggunakan WebGL

Gunakan WebGL untuk menghasilkan visual interaktif dan efek grafis yang tidak dapat dibuat secara efisien menggunakan CSS biasa.

Efek yang dapat diterapkan:

- Light Tunnel.
- Animated Shader Background.
- Particle Field.
- Distortion Effect.
- Interactive Background.
- Visualisasi grafis berbasis GPU.

Ketentuan:

- Utamakan WebGL pada Landing Page.
- Jangan membuat efek WebGL yang menghalangi interaksi pengguna.
- Periksa dukungan WebGL pada browser.
- Sediakan fallback CSS jika WebGL tidak tersedia.
- Batasi kompleksitas shader.
- Optimalkan rendering pada perangkat mobile.
- Hentikan rendering ketika elemen tidak terlihat atau halaman tidak aktif.
- Tangani WebGL context loss dengan baik.
- Jangan menjalankan beberapa WebGL canvas berat secara bersamaan tanpa alasan.

### G. Prinsip Animasi Global

- Durasi ideal: 0.3s – 0.6s untuk micro-interaction.
- Animasi kompleks boleh memiliki durasi lebih panjang jika diperlukan.
- Jangan berlebihan (hindari animasi yang membuat user menunggu).
- Hormati prefers-reduced-motion.
- Hindari animasi yang mengganggu pembacaan data.
- Gunakan transform dan opacity jika memungkinkan.
- Hindari animasi properti layout secara terus-menerus.
- Animasi harus tetap responsif pada layar kecil.
- Jangan menjalankan animasi yang sama pada satu elemen melalui beberapa library sekaligus.
- Pastikan seluruh animasi dapat dibersihkan ketika halaman atau komponen dilepas.

---

## 9. Animation Architecture & Performance

### A. Library Management

- Integrasikan seluruh library melalui NPM dan Vite.
- Hindari penggunaan CDN jika library sudah tersedia melalui NPM.
- Pisahkan implementasi animasi berdasarkan fungsi.
- Buat reusable animation utility.
- Hindari kode animasi berulang pada setiap halaman.

Contoh struktur:

resources/

- js/
  - app.js
  - animations/
    - gsap.js
    - anime.js
    - canvas.js
    - webgl.js
    - css-animations.js
  - components/
  - pages/

### B. Animation Lifecycle

- Setiap animasi harus memiliki mekanisme cleanup.
- Hapus event listener ketika tidak digunakan.
- Hentikan requestAnimationFrame ketika komponen tidak aktif.
- Gunakan IntersectionObserver untuk mendeteksi elemen yang terlihat.
- Hindari animasi berjalan terus-menerus di background jika tidak diperlukan.

### C. Performance

- Lazy load Canvas dan WebGL.
- Gunakan dynamic import untuk library yang hanya diperlukan pada halaman tertentu.
- Hindari memuat seluruh library animasi pada halaman yang tidak membutuhkannya.
- Optimalkan penggunaan GPU dan CPU.
- Hindari penggunaan terlalu banyak particle.
- Gunakan fallback untuk browser yang tidak mendukung fitur tertentu.
- Pastikan animasi tidak menghambat interaksi form, tabel, dan dashboard.

### D. Accessibility

- Hormati prefers-reduced-motion.
- Sediakan alternatif tanpa animasi.
- Jangan menggunakan animasi berkedip berlebihan.
- Pastikan konten tetap dapat dibaca ketika animasi gagal.
- Jangan menjadikan animasi sebagai satu-satunya indikator status.

---

## 10. Prioritas Pengerjaan

| Prioritas | Item                         | Keterangan                                      |
| --------- | ---------------------------- | ----------------------------------------------- |
| P0        | Setup Foundation             | Font, Color, Icon, Dark/Light Mode              |
| P0        | Komponen Dasar               | Button, Card, Badge, Stat Card, Input           |
| P0        | Animasi Dasar                | tailwindcss-animate + CSS                       |
| P0        | Dashboard Peserta            | Sebagai acuan utama                             |
| P1        | Dashboard Pembimbing & Admin | Mengikuti pola Dashboard Peserta                |
| P1        | Landing Page + Login         | First impression                                |
| P1        | Anime.js Integration         | Text, SVG, dan stagger                          |
| P2        | GSAP Advanced Animation      | Counter, ScrollTrigger, Timeline                |
| P2        | Canvas API                   | Ripple, Terrain, Particle                       |
| P2        | WebGL                        | Interactive background dan visual effect        |
| P2        | Chart Styling                | Sesuaikan ApexCharts                            |
| P2        | Performance Optimization     | Lazy loading, cleanup, dan responsive animation |

---

## 11. Deliverables

- Color system + Typography (Plus Jakarta Sans) yang sudah diimplementasikan.
- Icon system menggunakan Lucide Icons.
- Komponen UI yang konsisten.
- Dark Mode & Light Mode berfungsi penuh.
- Dashboard Peserta, Pembimbing, dan Admin yang sudah di-redesign.
- Landing Page & Login yang sudah diperbaiki.
- Animasi dasar menggunakan tailwindcss-animate.
- CSS Animation untuk micro-interaction.
- GSAP untuk animasi advanced.
- Anime.js untuk animasi teks, SVG, dan elemen interaktif.
- Canvas API untuk visual effect custom.
- WebGL untuk efek grafis interaktif yang relevan.
- ApexCharts yang sudah disesuaikan dengan design system baru.
- Seluruh animasi responsive dan optimal.
- Fallback untuk perangkat atau browser yang tidak mendukung fitur tertentu.
- Dokumentasi singkat penggunaan dan struktur animasi.

---

## 12. Important Instructions for AI Agent

1. Sebelum melakukan perubahan, periksa seluruh struktur project Laravel yang sudah ada.
2. Pelajari sistem autentikasi, role, routing, controller, Blade, dan database.
3. Jangan menghapus atau merusak fitur yang sudah berjalan.
4. Jangan mengubah business logic hanya untuk kebutuhan redesign.
5. Pertahankan semua fungsi Dashboard Peserta, Pembimbing, dan Admin.
6. Gunakan Laravel Blade sebagai frontend utama.
7. Jangan mengubah project menjadi React.
8. Gunakan library animasi sesuai pembagian tanggung jawab yang telah ditentukan.
9. Jangan menerapkan GSAP dan Anime.js secara bersamaan pada elemen yang sama.
10. Prioritaskan performa dan pengalaman pengguna dibandingkan banyaknya animasi.
11. Pastikan seluruh animasi memiliki cleanup dan mendukung prefers-reduced-motion.
12. Gunakan Clean Code, reusable components, dan modular JavaScript.
13. Hindari duplikasi CSS dan JavaScript.
14. Jangan membuat efek visual hanya sebagai dekorasi jika mengganggu fungsi aplikasi.
15. Setelah implementasi, lakukan pengujian seluruh halaman pada desktop dan mobile.
16. Pastikan tidak ada error JavaScript, error console, atau konflik library.
17. Jangan menghapus fitur lama tanpa alasan teknis yang jelas.

**Final Objective:**

Menghasilkan website Magang Komdigi Monitoring yang modern, profesional, interaktif, memiliki animasi berkualitas tinggi seperti website modern berbasis GSAP dan Anime.js, serta tetap ringan, responsif, accessible, dan stabil sebagai aplikasi Laravel.

**Note:** Tulis kode dengan prinsip Clean Code. Hindari AI slop. Prioritaskan kualitas implementasi, konsistensi desain, performa, dan maintainability dibandingkan sekadar menambahkan banyak efek animasi.
