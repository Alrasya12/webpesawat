<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once "Pesawat.php";
$pesawat = new Pesawat();
$data = $pesawat->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pesawat</title>
    <style>
        /* Mengatur font dasar dan warna latar belakang */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f9; /* Latar belakang abu-abu muda */
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Styling untuk Header */
        h2, h3 {
            color: #007bff; /* Warna biru untuk judul */
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-top: 20px;
        }

        /* Styling Navigasi */
        .nav-links a {
            color: #0056b3;
            text-decoration: none;
            margin-right: 15px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #e2f0ff;
        }

        /* Styling untuk Tabel Daftar Pesawat */
        .flight-table {
            width: 100%;
            border-collapse: collapse; /* Menggabungkan border sel */
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Efek bayangan */
            background-color: #fff; /* Latar belakang putih untuk tabel */
            border-radius: 8px;
            overflow: hidden; /* Memastikan border-radius diterapkan ke child elements */
        }

        .flight-table th, .flight-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Header Tabel */
        .flight-table th {
            background-color: #007bff; /* Biru terang */
            color: white;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        /* Baris Tabel */
        .flight-table tr:nth-child(even) {
            background-color: #f9f9f9; /* Warna sedikit berbeda untuk baris genap */
        }

        .flight-table tr:hover {
            background-color: #eaf6ff; /* Highlight saat hover */
        }

        /* Styling Harga */
        .flight-table td:nth-child(3) {
            font-weight: bold;
            color: #28a745; /* Warna hijau untuk harga */
        }

        /* Styling Tombol Aksi (Pesan) */
        .action-btn {
            background-color: #ffc107; /* Warna kuning/emas untuk tombol pesan */
            color: #333;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
        }

        .action-btn:hover {
            background-color: #ffcd39;
            transform: translateY(-2px); /* Efek angkat sedikit saat hover */
        }
    </style>
</head>
<body>
    <div class="nav-links">
        <h2>Selamat datang, <?= $_SESSION['nama'] ?>!</h2>
        <a href="riwayat.php">Riwayat Pesanan</a>
        <a href="logout.php">Logout</a>
    </div>

    <hr> <h3>Daftar Pesawat</h3>

    <table class="flight-table">
        <thead>
            <tr>
                <th>Nama Pesawat</th>
                <th>Kelas</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $data->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['nama_pesawat'] ?></td>
                <td><?= $row['kelas'] ?></td>
                <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td> <td><a href="pesan.php?id=<?= $row['id'] ?>" class="action-btn">Pesan</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>