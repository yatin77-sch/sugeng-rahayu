<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = mysqli_real_escape_string($koneksi, $_POST['booking_code']);
    
    // Cek apakah kode ada dan sudah dibayar
    $check = mysqli_query($koneksi, "SELECT id FROM bookings WHERE booking_code = '$code' AND payment_status = 'paid'");
    
    if (mysqli_num_rows($check) > 0) {
        // Logika check-in sederhana: update status atau generate seat jika belum ada
        set_flash('success', 'Check-in Berhasil!');
        header("Location: success.php?code=" . $code);
    } else {
        set_flash('error', 'Kode Booking tidak ditemukan atau belum dibayar.');
        header("Location: index.php");
    }
}