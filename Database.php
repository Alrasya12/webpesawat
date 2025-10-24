<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "db_tiketpesawat";
   public $conn;
 // pakai protected biar bisa diakses dari class turunan

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    // fungsi query() yang dipakai di Pesawat.php
    public function query($sql) {
        return $this->conn->query($sql);
    }
}
?>
