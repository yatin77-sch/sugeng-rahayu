<?php
// includes/functions.php

// Fungsi format mata uang
function format_currency($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Fungsi format tanggal Indonesia
function format_date($date) {
    return date('d F Y', strtotime($date));
}

// Fungsi alert/notifikasi (Flash Message)
function set_flash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

function display_flash() {
    if (isset($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $type => $message) {
            $color = ($type == 'success') ? '#4CAF50' : '#f44336';
            echo "<div style='background: $color; color: white; padding: 15px; margin: 10px 0; border-radius: 5px; text-align: center;'>$message</div>";
        }
        unset($_SESSION['flash']);
    }
}

// Cek Login
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Cek Admin
function is_admin() {
    return (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
}
?>