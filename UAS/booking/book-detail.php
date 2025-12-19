<?php
require_once '../config.php';
include '../header.php';

$id = $_GET['id'] ?? ''; // ID Jadwal
$query = mysqli_query($koneksi, "SELECT * FROM schedules WHERE id = '$id'");
$bus = mysqli_fetch_assoc($query);

if (!$bus) {
    redirect('index.php');
}
?>

<div style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <h2 style="color: #001BB7; margin-bottom: 25px;">Data Penumpang</h2>
            <form action="process.php" method="POST">
                <input type="hidden" name="schedule_id" value="<?php echo $bus['id']; ?>">
                <input type="hidden" name="travel_date" value="<?php echo $bus['operational_date']; ?>">
                <input type="hidden" name="price" value="<?php echo $bus['price']; ?>">

                <div style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom: 8px; font-weight: bold;">Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" name="passenger_name" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px;" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-weight: bold;">Nomor Identitas/NIK</label>
                        <input type="text" name="passenger_identity" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px;" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-weight: bold;">Nomor WhatsApp</label>
                        <input type="tel" name="passenger_phone" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px;" required>
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <label style="display:block; margin-bottom: 8px; font-weight: bold;">Jumlah Kursi</label>
                    <input type="number" name="num_passengers" min="1" max="<?php echo $bus['available_seats']; ?>" value="1" style="width:100%; padding:12px; border:1px solid #ddd; border-radius:6px;" required>
                </div>

                <button type="submit" style="width:100%; background:#FF8040; color:white; border:none; padding:15px; border-radius:8px; font-size:16px; font-weight:bold; cursor:pointer;">
                    Lanjutkan ke Pembayaran
                </button>
            </form>
        </div>

        <div style="background: #001BB7; color: white; padding: 25px; border-radius: 12px; height: fit-content;">
            <h3 style="border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 15px; margin-bottom: 15px;">Ringkasan</h3>
            <p style="margin-bottom: 5px; opacity: 0.8;">Bus:</p>
            <p style="font-weight: bold; font-size: 18px; margin-bottom: 15px;"><?php echo $bus['bus_number']; ?> (<?php echo ucfirst($bus['bus_type']); ?>)</p>
            
            <p style="margin-bottom: 5px; opacity: 0.8;">Rute:</p>
            <p style="font-weight: bold; margin-bottom: 15px;"><?php echo $bus['origin']; ?> ➔ <?php echo $bus['destination']; ?></p>
            
            <p style="margin-bottom: 5px; opacity: 0.8;">Keberangkatan:</p>
            <p style="font-weight: bold;"><?php echo format_date($bus['operational_date']); ?> | <?php echo format_time($bus['departure_time']); ?></p>
        </div>

    </div>
</div>

<?php include '../footer.php'; ?>