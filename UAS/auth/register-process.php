<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $phone = mysqli_real_escape_string($koneksi, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi Password
    if ($password !== $confirm_password) {
        set_flash('error', 'Konfirmasi password tidak cocok!');
        header("Location: ../signup.php");
        exit;
    }

    // Cek apakah email sudah terdaftar
    $check_email = mysqli_query($koneksi, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        set_flash('error', 'Email sudah digunakan!');
        header("Location: ../signup.php");
        exit;
    }

    // Hash Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert ke Database
    $query = "INSERT INTO users (name, email, phone, password, role, status) 
              VALUES ('$name', '$email', '$phone', '$hashed_password', 'user', 'active')";

    if (mysqli_query($koneksi, $query)) {
        set_flash('success', 'Registrasi berhasil! Silakan login.');
        header("Location: ../signin.php");
    } else {
        set_flash('error', 'Terjadi kesalahan sistem.');
        header("Location: ../signup.php");
    }
}