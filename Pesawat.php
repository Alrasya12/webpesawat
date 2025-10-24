<?php
require_once "Database.php";

class Pesawat extends Database {

    public function getAll() {
        return $this->query("SELECT * FROM pesawat");
    }

    public function getById($id) {
        $result = $this->query("SELECT * FROM pesawat WHERE id='$id'");
        return $result->fetch_assoc();
    }

    public function getKursiTersedia($id_pesawat) {
        $all = ['1a','1b','1c','2a','2b','2c','3a','3b','3c'];
        $result = $this->query("SELECT kursi FROM pesanan WHERE pesawat_id='$id_pesawat'");
        $terpakai = [];
        while($row = $result->fetch_assoc()) {
            $terpakai[] = $row['kursi'];
        }
        return array_diff($all, $terpakai);
    }
}
?>
