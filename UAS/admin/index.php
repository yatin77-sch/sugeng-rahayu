<?php
require_once '../config.php';
// Cek fungsi is_admin() dari includes/functions.php
if (!is_admin()) redirect('../signin.php');

include 'header-admin.php'; 
?>

<h1 style="color: #001BB7;">Statistik Operasional</h1>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px;">
    <div style="background: white; padding: 25px; border-radius: 10px; border-left: 5px solid #001BB7;">
        <h4 style="margin: 0; color: #666;">Total Booking</h4>
        <h2 style="margin: 10px 0 0;">1,240</h2>
    </div>
    <div style="background: white; padding: 25px; border-radius: 10px; border-left: 5px solid #FF8040;">
        <h4 style="margin: 0; color: #666;">Pending Refund</h4>
        <h2 style="margin: 10px 0 0;">12</h2>
    </div>
    <div style="background: white; padding: 25px; border-radius: 10px; border-left: 5px solid #4CAF50;">
        <h4 style="margin: 0; color: #666;">Pendapatan</h4>
        <h2 style="margin: 10px 0 0;">Rp 15.4M</h2>
    </div>
</div>

<div style="margin-top: 40px; background: white; padding: 20px; border-radius: 10px;">
    <h3 style="margin-bottom: 20px;">Daftar Pesanan Terbaru</h3>
    <p style="color: #888;">Menampilkan 10 transaksi terakhir...</p>
</div>

<?php include '../footer.php'; ?>