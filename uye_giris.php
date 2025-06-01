<?php
session_start();
$error = "";

if (isset($_SESSION['uye_giris']) && $_SESSION['uye_giris'] === true) {
    header("Location: uye_panel.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['giris'])) {
        $email = trim($_POST['email'] ?? '');
        $sifre = trim($_POST['sifre'] ?? '');

        $uyeler = file_exists('uyeler.json') ? json_decode(file_get_contents('uyeler.json'), true) : [];

        foreach ($uyeler as $uye) {
            // password_verify yerine doğrudan eşitlik kontrolü
            if ($uye['email'] === $email && $uye['sifre'] === $sifre) {
                $_SESSION['uye_giris'] = true;
                $_SESSION['uye_email'] = $email;
                $_SESSION['uye_ad'] = $uye['ad'];
                $_SESSION['uye_soyad'] = $uye['soyad'];
                header("Location: uye_panel.php");
                exit;
            }
        }

        $error = "E-posta veya şifre hatalı!";
    } elseif (isset($_POST['misafir'])) {
        $_SESSION['uye_giris'] = "misafir";
        header("Location: uye_panel.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Üye Girişi / Misafir Giriş</title>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background: url('forest-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }
        .sidebar {
            position: absolute;
            top: 50%;
            left: 40px;
            transform: translateY(-50%);
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 2;
        }
        .logo {
            width: 170px;
            margin-bottom: 30px;
            border-radius: 18px;
            background: white;
            padding: 10px 10px 0 10px;
            box-shadow: 0 0 10px #3333;
            object-fit: contain;
            display: block;
        }
        .menu {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .menu a {
            display: block;
            width: 100%;
            text-align: center;
            padding: 14px 0;
            background: rgba(23, 61, 44, 0.85);
            color: #fff;
            border-radius: 10px;
            font-size: 1.20rem;
            font-weight: bold;
            text-decoration: none;
            letter-spacing: 1px;
            box-shadow: 0 2px 8px #1b2d1c33;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .menu a:hover, .menu a:focus, .menu a.active {
            background: #1b422c;
            transform: scale(1.05);
            box-shadow: 0 4px 14px #1b2d1c55;
        }
        .menu .uye { background: #226c36;}
        /* Container ve Form */
        .container {
            background: rgba(255,255,255,0.92);
            margin: 60px auto 0 auto;
            border-radius: 16px;
            box-shadow:0 0 18px #00331133;
            max-width: 400px;
            padding: 38px 32px 32px 32px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 90vw;
        }
        h2 {
            color: #17612c;
            text-align: center;
            font-family: 'Dancing Script', cursive;
            font-size: 2.4rem;
            margin-top: 0;
        }
        form {
            margin-bottom: 12px;
        }
        label {
            display: block;
            color: #17612c;
            font-weight: bold;
            margin-bottom: 5px;
            margin-top: 14px;
            font-size: 1.08rem;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #b6ccb4;
            border-radius: 7px;
            font-size: 1.06rem;
            margin-bottom: 8px;
            background: #f4f8f7;
            transition: border .18s;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #17612c;
            outline: none;
        }
        input[type="submit"], .btn {
            background: #17612c;
            color: #fff;
            font-weight: bold;
            border-radius: 7px;
            border: none;
            padding: 12px 0;
            font-size: 1.1rem;
            transition: background 0.2s;
            margin-top: 22px;
            width: 100%;
            cursor: pointer;
            letter-spacing: 1px;
        }
        input[type="submit"]:hover, .btn:hover {
            background: #0f3e1c;
        }
        .error {
            color: #d9534f;
            background: #fff3f3;
            border: 1px solid #d9534f;
            padding: 10px 15px;
            border-radius: 7px;
            text-align: center;
            margin-top: 14px;
            margin-bottom: 0;
            font-size: 1.06rem;
        }
        .register-link {
            text-align: center;
            margin-top: 18px;
            font-size: 1.04rem;
        }
        .register-link a {
            color: #17612c;
            font-weight: bold;
            text-decoration: underline;
        }
        @media (max-width: 900px) {
            .sidebar { left: 10px; width: 170px; top: 50%; transform: translateY(-50%);}
            .logo { width: 120px; margin-bottom: 16px; }
            .container { width: 98vw; padding: 22px 3vw; max-width: 98vw;}
        }
        @media (max-width: 650px) {
            .sidebar { width: 90px; }
            .logo { width: 50px; padding: 2px; }
            .container { padding: 10px 2vw; }
            h2 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
<div class="sidebar">
    <img src="mayis-logo.png" alt="İstanbul 29 Mayıs Üniversitesi" class="logo">
    <div class="menu">
        <a href="index.php">ANA SAYFA</a>
        <a href="hakkimizda.php">HAKKIMIZDA</a>
        <a href="iletisim.php">İLETİŞİM</a>
        <a href="uye_giris.php" class="active">ÜYE GİRİŞİ</a>
        <a href="form_kayit.php">OYLAMA</a>
    </div>
</div>
<div class="container">
    <h2>Üye Girişi</h2>
    <form method="post" id="girisFormu" autocomplete="off">
        <label>E-Posta</label>
        <input type="email" name="email" placeholder="E-posta" required id="email_giris">
        <label>Şifre</label>
        <input type="password" name="sifre" placeholder="Şifre" required>
        <input type="submit" name="giris" value="Giriş Yap">
    </form>
    <form method="post" style="margin-top:18px;">
        <input type="submit" name="misafir" value="Üye Olmadan Devam Et" class="btn">
    </form>
    <div class="register-link">
        Hesabınız yok mu? <a href="uye_kayit.php">Kayıt Ol</a>
    </div>
    <?php if($error){ echo "<div class='error'>$error</div>"; } ?>
</div>
</body>
</html>