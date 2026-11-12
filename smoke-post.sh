#!/usr/bin/env bash
# Smoke test aksi POST: login, ambil token dari halaman, lalu kirim form.
# Pakai: bash smoke-post.sh <email> <password> <halaman_token> <path_post> [field=nilai ...]
set -u
BASE="http://127.0.0.1:8899"
JAR="$(mktemp)"
EMAIL="$1"; PASS="$2"; HALAMAN="$3"; POST="$4"; shift 4

token() {
  curl -s -c "$JAR" -b "$JAR" "$BASE$1" \
    | grep -oE 'name="_token" value="[^"]+"' | head -1 | sed -E 's/.*value="([^"]+)".*/\1/'
}

T=$(token /login)
CODE=$(curl -s -o /dev/null -w '%{http_code}' -c "$JAR" -b "$JAR" -L \
  -d "_token=$T" -d "email=$EMAIL" -d "password=$PASS" "$BASE/login")
echo "LOGIN $EMAIL -> $CODE"

T=$(token "$HALAMAN")
echo "TOKEN dari $HALAMAN -> ${T:0:8}..."

ARGS=(-d "_token=$T")
for F in "$@"; do ARGS+=(-d "$F"); done

OUT=$(curl -s -D - -o /dev/null -w '' -c "$JAR" -b "$JAR" "${ARGS[@]}" "$BASE$POST")
echo "POST $POST -> $(echo "$OUT" | head -1 | tr -d '\r')"
echo "$OUT" | grep -i '^location:' | tr -d '\r'

LOC=$(echo "$OUT" | grep -i '^location:' | head -1 | sed -E 's/^[Ll]ocation: //' | tr -d '\r')
if [ -n "$LOC" ]; then
  curl -s -c "$JAR" -b "$JAR" "$LOC" | grep -oE '(berhasil|gagal|tidak|wajib|sudah|belum)[^<]{0,120}' | head -3
fi
rm -f "$JAR"
