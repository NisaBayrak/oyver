<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kullanıcı bilgilerini sessiondan çek
    if (isset($_SESSION['uye_giris']) && $_SESSION['uye_giris'] === true) {
        $isim = $_SESSION['uye_ad'] ?? '';
        $soyisim = $_SESSION['uye_soyad'] ?? '';
        $email = $_SESSION['uye_email'] ?? '';
    } else {
        // Misafir ise
        $isim = "Misafir";
        $soyisim = "";
        $email = "";
    }

    $oylama_konusu = $_POST['oylama_konusu'] ?? [];
    $puanlar = $_POST['puan'] ?? [];
    $oneriler = $_POST['oneriler'] ?? '';

    $kayit = [
        'isim' => $isim,
        'soyisim' => $soyisim,
        'email' => $email,
        'oylamalar' => [],
        'oneriler' => $oneriler,
    ];
    foreach ($oylama_konusu as $i => $konu) {
        $kayit['oylamalar'][] = [
            'oylama_konusu' => $konu,
            'puan' => $puanlar[$i] ?? '',
        ];
    }

    $dosya = 'veriler.json';
    $mevcut = file_exists($dosya) ? json_decode(file_get_contents($dosya), true) : [];
    $mevcut = is_array($mevcut) ? $mevcut : [];
    $mevcut[] = $kayit;
    file_put_contents($dosya, json_encode($mevcut, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    echo "<script>alert('Oylamanız kaydedildi!');window.location='index.php';</script>";
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>