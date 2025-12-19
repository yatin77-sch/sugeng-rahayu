<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan user login sesuai SRS
    if (!isset($_SESSION['user_id'])) {
        set_flash('error', 'Silakan login untuk memesan tiket.');
        header("Location: ../signin.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $schedule_id = $_POST['schedule_id'];
    $travel_date = $_POST['travel_date'];
    $p_name = mysqli_real_escape_string($koneksi, $_POST['passenger_name']);
    $p_phone = mysqli_real_escape_string($koneksi, $_POST['passenger_phone']);
    $p_email = mysqli_real_escape_string($koneksi, $_POST['passenger_email']);
    $p_identity = mysqli_real_escape_string($koneksi, $_POST['passenger_identity']);
    $num_seats = $_POST['num_passengers'];
    $price_per_seat = $_POST['price'];
    $total_price = $num_seats * $price_per_seat;
    
    // Generate Kode Booking Unik
    $booking_code = "SR-" . strtoupper(substr(md5(time()), 0, 8));

    // Mulai Transaksi Database
    mysqli_begin_transaction($koneksi);

    try {
        // 1. Simpan ke tabel bookings
        $query_booking = "INSERT INTO bookings (booking_code, user_id, schedule_id, booking_date, travel_date, 
                          passenger_name, passenger_phone, passenger_email, passenger_identity, 
                          num_passengers, total_price, payment_status, booking_status) 
                          VALUES (?, ?, ?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, 'pending', 'active')";
        
        $stmt = mysqli_prepare($koneksi, $query_booking);
        mysqli_stmt_bind_param($stmt, "siisssssid", $booking_code, $user_id, $schedule_id, $travel_date, 
                               $p_name, $p_phone, $p_email, $p_identity, $num_seats, $total_price);
        mysqli_stmt_execute($stmt);

        // 2. Update sisa kursi di tabel schedules
        mysqli_query($koneksi, "UPDATE schedules SET available_seats = available_seats - $num_seats WHERE id = $schedule_id");

        mysqli_commit($koneksi);
        header("Location: success.php?code=" . $booking_code);
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        set_flash('error', 'Gagal memproses pesanan.');
        header("Location: index.php");
    }
}