<?php
// Fungsi bersama (dipakai semua modul). connect.php harus menyediakan variabel $conn (mysqli).
require_once __DIR__ . '/../connect.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

const DENDA_PER_HARI = 5000;                                   // denda keterlambatan per hari
const DENDA_KONDISI  = ['Baik' => 0, 'Rusak' => 20000, 'Hilang' => 50000]; // denda sesuai kondisi buku
const LAMA_PINJAM    = 7;                                      // hari

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function v($k, $d = ''){ return e($_POST[$k] ?? $d); }
function rp($n){ return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
function tgl($d){ return $d ? date('d/m/Y', strtotime($d)) : '-'; }

function q($sql, $types = '', ...$p){
    global $conn;
    $st = $conn->prepare($sql);
    if ($types) $st->bind_param($types, ...$p);
    $st->execute();
    $r = $st->get_result();
    return $r ?: true;
}
function all($sql, $types = '', ...$p){ $r = q($sql, $types, ...$p); return $r === true ? [] : $r->fetch_all(MYSQLI_ASSOC); }
function one($sql, $types = '', ...$p){ $a = all($sql, $types, ...$p); return $a[0] ?? null; }

function kodeBaru($tabel, $kolom, $prefix){
    $r = one("SELECT MAX($kolom) m FROM $tabel WHERE $kolom LIKE ?", 's', $prefix . '%');
    $n = (int)substr($r['m'] ?? '', strlen($prefix));
    return $prefix . str_pad($n + 1, 3, '0', STR_PAD_LEFT);
}
function hariTerlambat($batas, $kembali){
    return max(0, (int)floor((strtotime($kembali) - strtotime($batas)) / 86400));
}
function hitungDenda($batas, $kembali, $kondisi){
    $hari = hariTerlambat($batas, $kembali);
    return ['hari' => $hari, 'denda' => $hari * DENDA_PER_HARI + (DENDA_KONDISI[$kondisi] ?? 0)];
}
// Peminjaman yang melewati batas dan belum kembali otomatis berstatus "Terlambat"
function syncTerlambat(){
    q("UPDATE peminjaman SET status_peminjaman='Terlambat' WHERE status_peminjaman='Dipinjam' AND batas_pengembalian < CURDATE()");
}
function redirect($url, $msg = ''){
    if ($msg) $url .= (strpos($url, '?') !== false ? '&' : '?') . 'msg=' . urlencode($msg);
    header('Location: ' . $url); exit;
}
function badge($s){
    $c = ['Dipinjam' => 'blue', 'Selesai' => 'green', 'Terlambat' => 'red', 'Aktif' => 'green', 'Non-Aktif' => 'gray'][$s] ?? 'gray';
    return "<span class='badge $c'>" . e($s) . "</span>";
}
