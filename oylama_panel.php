<?php
// Oylama sonuçlarını örnek olarak hazırladık. Gerçek uygulamada veriler veriler.json'dan çekilebilir.
$sonuclar = [
    "Çok Kötü" => 4,
    "Kötü" => 6,
    "Orta" => 10,
    "İyi" => 15,
    "Çok İyi" => 8
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Oylama Sonuçları</title>
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
        .panel-box {
            background: rgba(255,255,255,0.92);
            margin: 60px auto 0 auto;
            border-radius: 16px;
            box-shadow:0 0 18px #00331133;
            max-width: 600px;
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
            margin: 0 0 32px 0;
        }
        #grafik {
            display: block;
            margin: 0 auto 24px auto;
            max-width: 420px;
            background: #fff;
            padding: 16px;
            border-radius: 14px;
            box-shadow: 0 1px 8px #1b2d1c22;
        }
        @media (max-width: 900px) {
            .sidebar { left: 10px; width: 170px; top: 50%; transform: translateY(-50%);}
            .logo { width: 120px; margin-bottom: 16px; }
            .panel-box { width: 98vw; padding: 22px 3vw; max-width: 98vw;}
        }
        @media (max-width: 650px) {
            .sidebar { width: 90px; }
            .logo { width: 50px; padding: 2px; }
            .panel-box { padding: 10px 2vw; }
            h2 { font-size: 1.5rem; }
            #grafik { max-width: 97vw; }
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
            <a href="uye_panel.php" class="uye">ÜYE PANELİ</a>
            <a href="form_kayit.php">OYLAMA</a>
            <a href="oylama_panel.php" class="active">SONUÇLAR</a>
        </div>
    </div>
    <div class="panel-box">
        <h2>Oylama Sonuçları</h2>
        <canvas id="grafik" width="400" height="400"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // PHP'den gelen verileri JS'ye aktar
    var veri = <?= json_encode(array_values($sonuclar)) ?>;
    var etiket = <?= json_encode(array_keys($sonuclar)) ?>;
    var renkler = ['#a00','#bb6600','#666','#1b8d1c','#007BFF'];
    var ctx = document.getElementById('grafik').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: etiket,
            datasets: [{
                data: veri,
                backgroundColor: renkler
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
    </script>
</body>
</html>