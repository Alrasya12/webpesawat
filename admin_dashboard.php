<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

require_once "Database.php";
$db = new Database();

$result = $db->query("
    SELECT psn.id, u.nama AS nama_user, p.nama_pesawat, psn.kelas, psn.kursi, psn.status, psn.tanggal_pesan
    FROM pesanan psn
    JOIN user u ON psn.user_id = u.id
    JOIN pesawat p ON psn.pesawat_id = p.id
    ORDER BY psn.tanggal_pesan DESC
");
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard Admin</title></head>
<body>
<h2>Dashboard Admin</h2>
<p>Selamat datang, <?= $_SESSION['admin'] ?>!</p>
<a href="admin_logout.php">Logout</a>

<h3>Daftar Pesanan Tiket</h3>
<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Nama User</th>
    <th>Pesawat</th>
    <th>Kelas</th>
    <th>Kursi</th>
    <th>Status</th>
    <th>Tanggal</th>
    <th>Aksi</th>
</tr>
<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['nama_user'] ?></td>
    <td><?= $row['nama_pesawat'] ?></td>
    <td><?= $row['kelas'] ?></td>
    <td><?= $row['kursi'] ?></td>
    <td><?= $row['status'] ?></td>
    <td><?= $row['tanggal_pesan'] ?></td>
    <td>
        <?php if ($row['status'] == 'Menunggu Konfirmasi') { ?>
            <a href="proses_konfirmasi.php?id=<?= $row['id'] ?>">Konfirmasi</a> |
        <?php } else { ?>
            ✅ |
        <?php } ?>
        <a href="hapus_pesanan.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</a>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
