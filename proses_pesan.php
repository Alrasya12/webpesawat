<?php
session_start();
require_once "Database.php";

$db = new Database();
$conn = $db->conn; // ✅ ambil koneksi langsung, bukan $db->connect()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Silakan login terlebih dahulu!');window.location='login.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $pesawat_id = $_POST['id_pesawat'];
    $kelas = $_POST['kelas'];
    $kursi = $_POST['nomor_kursi'];

    // Upload bukti pembayaran (opsional)
    $bukti_pembayaran = null;
    if (!empty($_FILES['bukti']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES["bukti"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
            $bukti_pembayaran = $file_name;
        }
    }

    // Simpan ke tabel pesanan
    $sql = "INSERT INTO pesanan (user_id, pesawat_id, kelas, kursi, bukti_pembayaran, status)
            VALUES ('$user_id', '$pesawat_id', '$kelas', '$kursi', '$bukti_pembayaran', 'Menunggu Konfirmasi')";

    if ($conn->query($sql)) {
        echo "<script>alert('Pesanan berhasil dibuat!');window.location='riwayat.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
