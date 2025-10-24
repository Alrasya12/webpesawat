<?php
require_once "Database.php";

class User extends Database {

    public function register($nama, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->query("INSERT INTO user (nama, email, password) VALUES ('$nama', '$email', '$hash')");
    }

    public function login($email, $password) {
        $result = $this->query("SELECT * FROM user WHERE email='$email'");
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if (password_verify($password, $data['password'])) {
                return $data;
            }
        }
        return false;
    }
}
?>
