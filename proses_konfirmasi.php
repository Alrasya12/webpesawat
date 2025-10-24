<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

require_once "Database.php";
$db = new Database();

$id = $_GET['id'];
$db->query("UPDATE pesanan SET status='Dikonfirmasi' WHERE id='$id'");

header("Location: admin_dashboard.php");
exit;
?>
