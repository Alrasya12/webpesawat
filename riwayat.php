<?php
session_start();

// Cek apakah user sudah login. Jika belum, arahkan ke login.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Pastikan Anda telah membuat class Database.php dengan benar.
require_once 'Database.php';
$db = new Database();
$conn = $db->conn; // Menggunakan koneksi yang sudah ada

// Mengamankan input user_id (Penting! Walaupun dari session, praktik yang baik adalah mengamankan)
$user_id = $conn->real_escape_string($_SESSION['user_id']);

$sql = "SELECT 
            p.id, 
            ps.nama_pesawat, 
            p.kelas, 
            p.kursi, 
            p.status, 
            p.bukti_pembayaran, 
            p.tanggal_pesan
        FROM pesanan p
        JOIN pesawat ps ON p.pesawat_id = ps.id
        WHERE p.user_id = '$user_id'
        ORDER BY p.tanggal_pesan DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pesanan</title>
    <style>
        /* Styling Umum */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef; /* Latar belakang abu-abu sangat muda */
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Header dan Navigasi */
        h2 {
            color: #007bff; /* Warna biru konsisten */
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Styling Tabel */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Efek bayangan yang lebih halus */
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .history-table th, .history-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

 
        .history-table th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            font-size: 0.85em;
            letter-spacing: 0.5px;
        }

     
        .history-table tbody tr:nth-child(even) {
            background-color: #f8f9fa; 
        }

        .history-table tbody tr:hover {
            background-color: #e9f5ff; 
        }

        /* Styling Status */
        .status-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 0.9em;
            display: inline-block;
        }

        .status-Lunas {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-Pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        /* Styling Bukti Pembayaran Link */
        .proof-link {
            color: #17a2b8; /* Warna biru muda untuk link */
            text-decoration: none;
            font-weight: 600;
        }

        .proof-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-link">&larr; Kembali ke Daftar Pesawat</a>
    
    <h2>Riwayat Pesanan Anda</h2>

    <table class="history-table">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Pesawat</th>
                <th>Kelas</th>
                <th>Kursi</th>
                <th>Status</th>
                <th>Bukti Pembayaran</th>
                <th>Tanggal Pesan</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { 
                // Mengambil nilai status dan membersihkannya untuk digunakan di nama class CSS
                $status_class = str_replace(' ', '', $row['status']); 
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama_pesawat'] ?></td>
                <td><?= $row['kelas'] ?></td>
                <td><?= $row['kursi'] ?></td>
                <td>
                    <span class="status-badge status-<?= $status_class ?>">
                        <?= $row['status'] ?>
                    </span>
                </td>
                <td>
                    <?php if ($row['bukti_pembayaran']) { ?>
                        <a href="uploads/<?= $row['bukti_pembayaran'] ?>" target="_blank" class="proof-link">Lihat Bukti</a>
                    <?php } else { ?>
                        Belum Upload
                    <?php } ?>
                </td>
                <td><?= date('d M Y, H:i', strtotime($row['tanggal_pesan'])) ?></td> </tr>
            <?php } 
            
            // Cek jika tidak ada data
            if ($result->num_rows === 0) { ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #6c757d;">
                        Belum ada riwayat pesanan.
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</body>
</html>