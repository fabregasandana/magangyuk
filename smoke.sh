#!/usr/bin/env bash
# Smoke test: login tiap role lalu hit semua halaman milik role tersebut.
# Pakai: bash smoke.sh <email> <password> <url1> <url2> ...
set -u
BASE="http://127.0.0.1:8899"
JAR="$(mktemp)"
EMAIL="$1"; PASS="$2"; shift 2

token() {
  curl -s -c "$JAR" -b "$JAR" "$BASE/login" \
    | grep -oE 'name="_token" value="[^"]+"' | head -1 | sed -E 's/.*value="([^"]+)".*/\1/'
}

T=$(token)
CODE=$(curl -s -o /dev/null -w '%{http_code}' -c "$JAR" -b "$JAR" -L \
  -d "_token=$T" -d "email=$EMAIL" -d "password=$PASS" "$BASE/login")
echo "LOGIN $EMAIL -> $CODE"

for U in "$@"; do
  C=$(curl -s -o /dev/null -w '%{http_code}' -c "$JAR" -b "$JAR" "$BASE$U")
  printf '%-6s %s\n' "$C" "$U"
done
rm -f "$JAR"
