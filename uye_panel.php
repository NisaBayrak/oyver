<?php
session_start();
if (!isset($_SESSION['uye_giris'])) {
    header("Location: uye_giris.php");
    exit;
}
$ad = $_SESSION['uye_ad'] ?? "Misafir";
$soyad = $_SESSION['uye_soyad'] ?? "";
$email = $_SESSION['uye_email'] ?? "";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Üye Paneli</title>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { min-height: 100vh; background: url('forest-bg.jpg') no-repeat center center fixed; background-size: cover; font-family: Arial, sans-serif; margin:0; }
        .sidebar { position: absolute; top: 50%; left: 40px; width: 250px; display: flex; flex-direction: column; align-items: center; transform: translateY(-50%);}
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
        h2 { color: #17612c; font-family: 'Dancing Script', cursive; font-size: 2.2rem; }
        .info { color: #17612c; font-weight: bold; margin: 10px 0 24px 0;}
        .btn { display:inline-block; margin-top: 20px; padding: 8px 22px; border-radius: 6px; border: none; background: #17612c; color: #fff; font-weight: bold; cursor: pointer;}
        .btn:hover { background: #0f3e1c; }
        @media (max-width: 900px) { .sidebar { left: 10px; width: 170px; top: 50%; transform: translateY(-50%);} }
        @media (max-width: 650px) { .container { padding: 15px 4px; } .sidebar { max-width: 100%; width: 90px; left: 10px; top: 50%; transform: translateY(-50%);} .menu a { padding: 12px 8px; font-size: 16px; } }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="menu">
        <a href="index.php">ANA SAYFA</a>
        <a href="hakkimizda.php">HAKKIMIZDA</a>
        <a href="iletisim.php">İLETİŞİM</a>
        <a href="uye_panel.php" class="active">ÜYE PANELİ</a>
        <a href="form_kayit.php">OYLAMA</a>
        <a href="uye_logout.php" style="background:#d9534f;">Çıkış Yap</a>
    </div>
</div>
<div class="container">
    <h2>Hoşgeldin <?php echo htmlspecialchars($ad); ?>!</h2>
    <div class="info">
        <?php 
            if ($_SESSION['uye_giris'] === "misafir") {
                echo "Misafir olarak giriş yaptınız.";
            } else {
                echo "Ad Soyad: ".htmlspecialchars($ad)." ".htmlspecialchars($soyad)."<br>E-posta: ".htmlspecialchars($email);
            }
        ?>
    </div>
    <a href="form_kayit.php" class="btn">Oylama Anketine Katıl</a>
    <a href="uye_logout.php" class="btn" style="background:#d9534f;margin-left:10px;">Çıkış Yap</a>
</div>
</body>
</html>