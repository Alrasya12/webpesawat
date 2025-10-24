<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

require_once "Database.php";
$db = new Database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db->query("DELETE FROM pesanan WHERE id='$id'");
}

header("Location: admin_dashboard.php");
exit;
?>
