<?php
session_start();
$error = "";

// Giriş denemeleri limiti (ör: 5)
if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;
if (!isset($_SESSION['login_blocked_until'])) $_SESSION['login_blocked_until'] = 0;

$dogru_kullanici = "nisabayrak58@gmail.com";
$dogru_sifre = "nisa5834"; // DÜZ METİN ŞİFRE

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['login_blocked_until'] > time()) {
        $kalan = $_SESSION['login_blocked_until'] - time();
        $error = "Çok fazla hatalı deneme! Lütfen $kalan saniye sonra tekrar deneyin.";
    } else {
        $kullanici = $_POST["kullanici"] ?? "";
        $sifre = $_POST["sifre"] ?? "";
        if ($kullanici === $dogru_kullanici && $sifre === $dogru_sifre) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['login_attempts'] = 0;
            $_SESSION['login_blocked_until'] = 0;
            header("Location: admin.php");
            exit();
        } else {
            $_SESSION['login_attempts'] += 1;
            if ($_SESSION['login_attempts'] >= 5) {
                $_SESSION['login_blocked_until'] = time() + 60;
                $error = "Çok fazla hatalı deneme! 1 dakika sonra tekrar deneyin.";
            } else {
                $error = "Kullanıcı adı veya şifre hatalı!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş</title>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { min-height: 100vh; background: url('forest-bg.jpg') no-repeat center center fixed; background-size: cover; font-family: Arial, sans-serif; margin:0; }
        .sidebar { position: absolute; top: 50%; left: 40px; width: 250px; display: flex; flex-direction: column; align-items: center; transform: translateY(-50%);}
        .logo { width: 170px; margin-bottom: 30px; border-radius: 18px; background: white; padding: 10px 10px 0 10px; box-shadow: 0 0 10px #3333; object-fit: contain; display: block;}
        .menu { width: 100%; display: flex; flex-direction: column; gap: 15px; }
        .menu a { display: block; width: 100%; text-align: center; padding: 14px 0; background: rgba(23, 61, 44, 0.85); color: #fff; border-radius: 10px; font-size: 1.20rem; font-weight: bold; text-decoration: none; letter-spacing: 1px; box-shadow: 0 2px 8px #1b2d1c33; transition: background 0.2s, transform 0.15s, box-shadow 0.2s;}
        .menu a:hover, .menu a:focus, .menu a.active { background: #1b422c; transform: scale(1.05); box-shadow: 0 4px 14px #1b2d1c55; }
        .container {
            background: white;
            padding: 32px 42px;
            max-width: 420px;
            width: 95%;
            border-radius: 13px;
            box-shadow: 0 0 18px #ccc;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0;
        }
        h2 { color: #007BFF; font-family: 'Dancing Script', cursive; font-size: 2.2rem; }
        label { display: block; margin: 18px 0 7px 0; font-weight: bold;}
        input[type="text"], input[type="password"] { width: 96%; padding: 7px; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { padding: 8px 22px; border-radius: 6px; border: none; background: #007BFF; color: #fff; font-weight: bold; cursor: pointer; margin-top: 18px; }
        input[type="submit"]:hover { background: #0056b3; }
        .error { color: #d9534f; font-weight: bold; margin-top: 10px;}
        .admin-fab {
            position: fixed;
            right: 32px;
            bottom: 32px;
            width: 64px;
            height: 64px;
            background: #17612c;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px #222a8c33;
            font-size: 2.3rem;
            z-index: 1000;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            border: none;
            outline: none;
            text-decoration: none;
        }
        .admin-fab:hover, .admin-fab:focus {
            background: #0f3e1c;
            transform: scale(1.09);
            box-shadow: 0 8px 22px #1b2d1c55;
            color: #ffe600;
            text-decoration: none;
        }
        @media (max-width: 900px) { .sidebar { left: 10px; width: 170px; top: 50%; transform: translateY(-50%);} .logo { width: 120px; margin-bottom: 16px; } .admin-fab { right: 16px; bottom: 16px; width: 52px; height: 52px; font-size: 1.6rem; } }
        @media (max-width: 650px) { .container { padding: 15px 4px; } .sidebar { max-width: 100%; width: 90px; left: 10px; top: 50%; transform: translateY(-50%);} .menu a { padding: 12px 8px; font-size: 16px; } .logo { width: 50px; padding: 2px; } .admin-fab { right: 10px; bottom: 10px; width: 44px; height: 44px; font-size: 1.2rem; } }
    </style>
</head>
<body>
<div class="sidebar">
    <img src="mayis-logo.png" alt="İstanbul 29 Mayıs Üniversitesi" class="logo">
    <div class="menu">
        <a href="index.php">ANA SAYFA</a>
        <a href="hakkimizda.php">HAKKIMIZDA</a>
        <a href="iletisim.php">İLETİŞİM</a>
        <a href="form_kayit.php">OYLAMA</a>
        <?php if (isset($_SESSION['uye_giris'])): ?>
            <a href="uye_panel.php">ÜYE PANELİ</a>
        <?php else: ?>
            <a href="login.php">ÜYE GİRİŞİ</a>
        <?php endif; ?>
    </div>
</div>
<div class="container">
    <h2>Admin Girişi</h2>
    <form method="post">
        <label>Kullanıcı Adı</label>
        <input type="text" name="kullanici" placeholder="E-posta" required>
        <label>Şifre</label>
        <input type="password" name="sifre" placeholder="Şifre" required>
        <input type="submit" value="Giriş Yap">
        <?php if($error){ echo "<div class='error'>$error</div>"; } ?>
    </form>
</div>
<a href="admin_login.php" class="admin-fab" title="Admin Girişi">
    <i class="fa-solid fa-user"></i>
</a>
</body>
</html>