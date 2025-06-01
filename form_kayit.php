<?php
session_start();
if (!isset($_SESSION['uye_giris'])) {
    header("Location: uye_giris.php");
    exit;
}
// Oylama başlıklarını oku
$oylamalar = [];
$oylamalar_dosya = "oylamalar.json";
if (file_exists($oylamalar_dosya)) {
    $oylamalar = json_decode(file_get_contents($oylamalar_dosya), true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Oylama</title>
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
        /* Oylama Alanı */
        .oylama-wrapper {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 90vw;
            max-width: 600px;
            min-height: 420px;
            background: rgba(255,255,255,0.92);
            border-radius: 16px;
            box-shadow: 0 0 18px #00331133;
            padding: 38px 32px 32px 32px;
            box-sizing: border-box;
            overflow-y: auto;
            max-height: 90vh;
            z-index: 1;
        }
        .oylama-title {
            text-align: center;
            font-family: 'Dancing Script', cursive;
            font-size: 2.4rem;
            color: #17503a;
            margin-bottom: 32px;
        }
        .oylamalar-list {
            display: flex;
            flex-direction: column;
            gap: 28px;
            overflow-y: auto;
            max-height: 65vh;
            padding-right: 5px;
        }
        .oylama-card {
            background: #f3f6f4;
            border-radius: 12px;
            box-shadow: 0 2px 10px #1b2d1c22;
            padding: 22px 30px 18px 30px;
            margin: 0 auto;
            width: 95%;
            max-width: 510px;
            min-width: 220px;
        }
        .oylama-card h3 {
            color: #007B55;
            font-size: 1.35rem;
            margin-bottom: 14px;
            text-align: left;
            font-weight: bold;
        }
        .puan-group {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            align-items: center;
            margin-top: 7px;
        }
        .puan-group label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .puan-group input[type="radio"] {
            appearance: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid #007B55;
            background: #fff;
            box-shadow: 0 1px 4px #1b2d1c11;
            margin-bottom: 3px;
            outline: none;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }
        .puan-group input[type="radio"]:checked {
            background: #007B55;
            border-color: #007B55;
        }
        .puan-group span {
            color: #007B55;
            font-weight: bold;
            font-size: 1.05rem;
        }
        .puan-desc {
            font-size: 12px;
            text-align: center;
            color: #555;
            margin-top: 8px;
            font-style: italic;
        }
        .oneriler-card {
            background: #fffbe0;
            border: 2px dashed #bba700;
            border-radius: 12px;
            box-shadow: 0 1px 7px #1b2d1c11;
            padding: 22px 30px 18px 30px;
            margin: 0 auto;
            width: 95%;
            max-width: 510px;
            min-width: 220px;
        }
        .oneriler-card h3 {
            color: #a88600;
            font-size: 1.2rem;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .oneriler-card textarea {
            min-height: 40px;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 7px 10px;
            font-size: 1rem;
            resize: vertical;
            width: 100%;
        }
        .submit-btn {
            background: #17612c;
            color: #fff;
            font-weight: bold;
            border-radius: 7px;
            border: none;
            padding: 12px 0;
            font-size: 1.1rem;
            transition: background 0.2s;
            margin: 32px auto 0 auto;
            width: 260px;
            display: block;
            cursor: pointer;
            letter-spacing: 1px;
        }
        .submit-btn:hover { background: #0f3e1c; }

        @media (max-width: 900px) {
            .sidebar { left: 10px; width: 170px; top: 50%; transform: translateY(-50%);}
            .logo { width: 120px; margin-bottom: 16px; }
            .oylama-wrapper { width: 98vw; padding: 22px 3vw; max-width: 98vw;}
            .oylama-card, .oneriler-card { max-width: 95vw; }
        }
        @media (max-width: 650px) {
            .sidebar { width: 90px; }
            .logo { width: 50px; padding: 2px; }
            .oylama-card, .oneriler-card { padding: 10px 4px; font-size: 14px; }
            .oylama-title { font-size: 1.4rem;}
            .oylama-wrapper { padding: 5px 1vw;}
        }
        .oylamalar-list::-webkit-scrollbar {
            width: 8px;
        }
        .oylamalar-list::-webkit-scrollbar-thumb {
            background: #b7c5bd;
            border-radius: 6px;
        }
        .oylamalar-list::-webkit-scrollbar-track {
            background: #e4ece6;
            border-radius: 6px;
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
            <?php if(isset($_SESSION['uye_giris'])): ?>
                <a href="uye_panel.php" class="uye">ÜYE PANELİ</a>
                <a href="uye_logout.php" style="background:#d9534f;">Çıkış Yap</a>
            <?php else: ?>
                <a href="uye_giris.php" class="uye">ÜYE GİRİŞİ</a>
                <a href="uye_kayit.php" class="uye">Kayıt Ol</a>
            <?php endif; ?>
            <a href="form_kayit.php" class="active">OYLAMA</a>
        </div>
    </div>
    <div class="oylama-wrapper">
        <div class="oylama-title">Oylama</div>
        <form method="post" action="oylama_kaydet.php">
            <div class="oylamalar-list">
                <?php if (empty($oylamalar)): ?>
                    <div style="text-align:center; color:#b22222; font-size:1.1rem;">Henüz anket eklenmemiş.</div>
                <?php else: ?>
                    <?php foreach ($oylamalar as $i => $oylama_konusu): ?>
                    <div class="oylama-card">
                        <h3><?php echo htmlspecialchars($oylama_konusu); ?></h3>
                        <input type="hidden" name="oylama_konusu[]" value="<?php echo htmlspecialchars($oylama_konusu); ?>">
                        <div class="puan-group">
                            <label>
                                <input type="radio" name="puan[<?php echo $i; ?>]" value="1" required>
                                <span>1</span>
                                <span style="font-size:11px; color:#a00;">Çok Kötü</span>
                            </label>
                            <label>
                                <input type="radio" name="puan[<?php echo $i; ?>]" value="2">
                                <span>2</span>
                                <span style="font-size:11px; color:#bb6600;">Kötü</span>
                            </label>
                            <label>
                                <input type="radio" name="puan[<?php echo $i; ?>]" value="3">
                                <span>3</span>
                                <span style="font-size:11px; color:#666;">Orta</span>
                            </label>
                            <label>
                                <input type="radio" name="puan[<?php echo $i; ?>]" value="4">
                                <span>4</span>
                                <span style="font-size:11px; color:#1b8d1c;">İyi</span>
                            </label>
                            <label>
                                <input type="radio" name="puan[<?php echo $i; ?>]" value="5">
                                <span>5</span>
                                <span style="font-size:11px; color:#007BFF;">Çok İyi</span>
                            </label>
                        </div>
                        <div class="puan-desc">Her soru için puanınızı seçiniz.</div>
                    </div>
                    <?php endforeach; ?>
                    <div class="oneriler-card">
                        <h3>Öneri ve Görüşleriniz</h3>
                        <textarea name="oneriler" placeholder="Öneri ve görüşlerinizi buraya yazabilirsiniz..." rows="3"></textarea>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($oylamalar)): ?>
            <button type="submit" class="submit-btn">Gönder</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html> 