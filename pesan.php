<?php
session_start();
require_once "Pesawat.php";
$pesawat = new Pesawat();
$data = $pesawat->getById($_GET['id']);
$kursi_tersedia = $pesawat->getKursiTersedia($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pesan Tiket</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f9;
            color: #333;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .booking-card {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 25px;
            text-align: center;
        }

        .flight-details p {
            margin: 8px 0;
            font-size: 1.1em;
        }

        .flight-details b {
            color: #0056b3;
            font-weight: 700;
        }
        
        .flight-details .price {
            color: #28a745;
            font-size: 1.2em;
        }

        form {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        select, input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f8f9fa;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        select:focus, input[type="file"]:focus {
            border-color: #007bff;
            outline: none;
        }
        
        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #ffc107;
            color: #333;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .submit-btn:hover {
            background-color: #ffcd39;
            transform: translateY(-1px);
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 15px;
            border: 1px solid #0056b3;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-link:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>
<body>
<div class="booking-card">
    <h2>Pesan Tiket Pesawat</h2>
    
    <div class="flight-details">
        <p><b>Pesawat:</b> <?= $data['nama_pesawat'] ?> (<?= $data['kelas'] ?>)</p>
        <p class="price"><b>Harga:</b> Rp<?= number_format($data['harga']) ?></p>
    </div>

    <form method="POST" action="proses_pesan.php" enctype="multipart/form-data">
        <input type="hidden" name="id_pesawat" value="<?= $data['id'] ?>">
        <input type="hidden" name="kelas" value="<?= $data['kelas'] ?>">
        
        <div class="form-group">
            <label for="nomor_kursi">Pilih Nomor Kursi:</label>
            <select name="nomor_kursi" id="nomor_kursi" required>
                <?php foreach ($kursi_tersedia as $k) { ?>
                    <option value="<?= $k ?>"><?= strtoupper($k) ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="bukti">Upload Bukti Pembayaran:</label>
            <input type="file" name="bukti" id="bukti" accept="image/*" required>
        </div>

        <button type="submit" class="submit-btn">Pesan Sekarang</button>
    </form>
</div>

<a href="index.php" class="back-link">Kembali</a>
</body>
</html>