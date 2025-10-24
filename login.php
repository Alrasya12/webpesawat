<?php
session_start();
require_once "User.php";
$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $user->login($_POST['email'], $_POST['password']);
    if ($data) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #007bff; /* Latar belakang biru penuh */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        .login-card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        h2 {
            color: #0056b3;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: 600;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        button[type="submit"] {
            padding: 12px;
            background-color: #ffc107; /* Warna kuning konsisten untuk aksi utama */
            color: #333;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #ffcd39;
            transform: translateY(-1px);
        }

        p {
            margin-top: 25px;
            color: #6c757d;
        }

        p a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login</h2>

        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php } ?>

        <form method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <button type="submit">Masuk</button>
        </form>
        
        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>