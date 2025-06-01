<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Oylama başlıklarını yükle
$oylamalar_dosya = "oylamalar.json";
$oylamalar = file_exists($oylamalar_dosya) ? json_decode(file_get_contents($oylamalar_dosya), true) : [];
if (!is_array($oylamalar)) $oylamalar = [];

// Anket silme işlemi
if (isset($_POST['sil_oylama']) && $_POST['oylama_baslik']) {
    $sil_baslik = $_POST['oylama_baslik'];
    // Oylamayı sil
    $oylamalar = array_values(array_filter($oylamalar, fn($b) => $b !== $sil_baslik));
    file_put_contents($oylamalar_dosya, json_encode($oylamalar, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    // Cevapları sil
    $veriler_dosya = "veriler.json";
    if (file_exists($veriler_dosya)) {
        $veriler = json_decode(file_get_contents($veriler_dosya), true) ?: [];
        // Tüm anketi silmek yerine, her kaydın oylamalar dizisinden ilgili başlığı sil
        foreach ($veriler as &$kayit) {
            if (isset($kayit['oylamalar']) && is_array($kayit['oylamalar'])) {
                $kayit['oylamalar'] = array_values(array_filter($kayit['oylamalar'], fn($v) => ($v['oylama_konusu'] ?? '') !== $sil_baslik));
            }
        }
        unset($kayit);
        file_put_contents($veriler_dosya, json_encode($veriler, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
    header("Location: admin.php?sil=ok");
    exit;
}

// Oylama ekleme işlemi
$oylama_hata = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["yeni_oylama"])) {
    $yeni_oylama = trim($_POST["yeni_oylama"]);
    if ($yeni_oylama !== "") {
        if (!in_array($yeni_oylama, $oylamalar)) {
            $oylamalar[] = $yeni_oylama;
            file_put_contents($oylamalar_dosya, json_encode($oylamalar, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        } else {
            $oylama_hata = "Bu oylama zaten mevcut!";
        }
    } else {
        $oylama_hata = "Oylama başlığı boş olamaz!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Admin Paneli</title>
  <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; background: url('forest-bg.jpg') no-repeat center center fixed; background-size: cover; padding: 20px; }
    .sidebar { position: absolute; top: 50%; left: 40px; width: 250px; display: flex; flex-direction: column; align-items: center; transform: translateY(-50%);}
    .logo { width: 170px; margin-bottom: 30px; border-radius: 18px; background: white; padding: 10px 10px 0 10px; box-shadow: 0 0 10px #3333; object-fit: contain; display: block;}
    .menu { width: 100%; display: flex; flex-direction: column; gap: 15px; }
    .menu a { display: block; width: 100%; text-align: center; padding: 14px 0; background: rgba(23, 61, 44, 0.85); color: #fff; border-radius: 10px; font-size: 1.20rem; font-weight: bold; text-decoration: none; letter-spacing: 1px; box-shadow: 0 2px 8px #1b2d1c33; transition: background 0.2s, transform 0.15s, box-shadow 0.2s; border: none; outline: none; }
    .menu a:hover, .menu a:focus { background: #1b422c; transform: scale(1.05); box-shadow: 0 4px 14px #1b2d1c55; }
    .logout-btn { background: #d9534f; color: #fff; border: none; border-radius: 7px; padding: 7px 18px; font-weight: bold; cursor: pointer; margin-bottom: 10px;}
    .logout-btn:hover { background: #a94442; }
    .container { background: white; padding: 24px; max-width: 950px; margin: 60px auto 0 350px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
    h2 { color: #007BFF; margin-top: 0; font-family: 'Dancing Script', cursive; font-size: 2.4rem;}
    form.oylama-ekle { margin-bottom: 28px; }
    .oylama-kutu { padding: 15px 10px; background: #f6f7f7; border-radius: 7px; border: 1px solid #e0e0e0; margin-bottom: 8px; }
    .oylama-ekle input[type="text"] { width: 70%; padding: 7px; margin-right: 10px; border-radius: 5px; border: 1px solid #ccc; }
    .oylama-ekle input[type="submit"] { padding: 7px 18px; border-radius: 5px; border: none; background: #007BFF; color: #fff; font-weight: bold; cursor: pointer; }
    .oylama-ekle input[type="submit"]:hover { background: #0056b3; }
    .hata { color: #d9534f; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f0f0f0; }
    tr:nth-child(even) { background-color: #fafafa; }
    .admin-fab { display: none !important; }
    .oylama-listesi { margin-bottom: 14px; }
    .oylama-sil-form { display: inline; margin-left: 10px; }
    .oylama-sil-form button {
      background: #d9534f;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 2px 10px;
      font-size: 0.95rem;
      cursor: pointer;
      margin-left: 6px;
    }
    .oylama-sil-form button:hover { background: #a94442; }
    .istatistik-tablosu { margin-top:32px; margin-bottom:16px;}
    .istatistik-tablosu th, .istatistik-tablosu td { text-align: center; }
    .istatistik-tablosu th { background: #dcefdc; }
    .istatistik-tablosu td { background: #f7faf7; }
    @media (max-width: 900px) {
      .sidebar { left: 10px; width: 170px; top: 50%; transform: translateY(-50%);}
      .logo { width: 120px; margin-bottom: 16px; }
      .container { margin: 100px 5px 0 110px; }
      .admin-fab { right: 16px; bottom: 16px; width: 52px; height: 52px; font-size: 1.6rem; }
    }
    @media (max-width: 650px) {
      .container { padding: 10px; }
      .sidebar { max-width: 100%; width: 90px; left: 10px; top: 50%; transform: translateY(-50%);}
      .menu a { padding: 12px 8px; font-size: 16px; }
      table, th, td { font-size: 15px; }
      .logo { width: 50px; padding: 2px; }
      .admin-fab { right: 10px; bottom: 10px; width: 44px; height: 44px; font-size: 1.2rem; }
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
      <a href="form_kayit.php">OYLAMA</a>
      <form action="logout.php" method="post" style="margin-top:10px;">
        <button type="submit" class="logout-btn">Çıkış Yap</button>
      </form>
    </div>
  </div>
  <div class="container">
    <h2>Admin Paneli</h2>
    <form class="oylama-ekle" action="admin.php" method="post">
      <div class="oylama-kutu">
        <label><strong>Yeni Oylama Başlığı:</strong></label>
        <input type="text" name="yeni_oylama" placeholder="Yeni oylama başlığı girin..." required>
        <input type="submit" value="Oylama Oluştur">
      </div>
      <?php if ($oylama_hata) { echo '<div class="hata">'.$oylama_hata.'</div>'; } ?>
    </form>
    <div style="font-size: 15px; color:#555; margin-top: 7px;">
      <b>Mevcut Oylamalar:</b>
      <ul class="oylama-listesi">
        <?php foreach ($oylamalar as $oy): ?>
          <li>
            <?php echo htmlspecialchars($oy); ?>
            <form class="oylama-sil-form" action="admin.php" method="post" onsubmit="return confirm('Bu anket ve tüm cevapları silinecek. Emin misiniz?');">
              <input type="hidden" name="oylama_baslik" value="<?php echo htmlspecialchars($oy); ?>">
              <button type="submit" name="sil_oylama">Sil</button>
            </form>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <!-- İstatistiksel özet -->
    <h3 style="margin-top:38px; margin-bottom:6px; color:#17612c;">Oylama Sonuçları İstatistikleri</h3>
    <table class="istatistik-tablosu">
      <tr>
        <th>Oylama Konusu</th>
        <th>Oylama Sayısı</th>
        <th>Ortalama Puan</th>
      </tr>
      <?php
      // Tüm verileri oku ve özetle
      $dosya = "veriler.json";
      $istatistik = [];
      if (file_exists($dosya)) {
          $veriler = json_decode(file_get_contents($dosya), true);
          if (is_array($veriler)) {
              foreach ($oylamalar as $oylama_baslik) {
                  $puanlar = [];
                  foreach ($veriler as $kayit) {
                      // Her kişinin oylamalarını kontrol et
                      if (isset($kayit['oylamalar']) && is_array($kayit['oylamalar'])) {
                          foreach ($kayit['oylamalar'] as $oy) {
                              if (($oy['oylama_konusu'] ?? '') == $oylama_baslik && is_numeric($oy['puan'])) {
                                  $puanlar[] = (int)$oy['puan'];
                              }
                          }
                      }
                  }
                  $adet = count($puanlar);
                  $ortalama = $adet > 0 ? number_format(array_sum($puanlar) / $adet, 2, ',', '.') : "-";
                  echo "<tr><td>".htmlspecialchars($oylama_baslik)."</td><td>$adet</td><td>$ortalama</td></tr>";
              }
          }
      }
      ?>
    </table>
    <form class="oylama-ekle" style="margin-top: 25px;"></form>
    <p>Burada gönderilen formları görebilirsiniz:</p>
    <table>
      <tr>
        <th>İsim</th>
        <th>Soyisim</th>
        <th>E-posta</th>
        <?php
        // Oylama başlıklarını dinamik sütun olarak ekleyelim
        foreach ($oylamalar as $oy) {
          echo "<th>".htmlspecialchars($oy)."</th>";
        }
        ?>
        <th>Öneriler</th>
      </tr>
      <?php
        if (file_exists($dosya)) {
            $veriler = json_decode(file_get_contents($dosya), true);
            if (is_array($veriler) && count($veriler) > 0) {
                foreach ($veriler as $kayit) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($kayit['isim']) . "</td>";
                    echo "<td>" . htmlspecialchars($kayit['soyisim']) . "</td>";
                    echo "<td>" . htmlspecialchars($kayit['email']) . "</td>";
                    // Her oylama başlığı için puan bul
                    foreach ($oylamalar as $oy) {
                        $puan_goster = "";
                        if (isset($kayit['oylamalar']) && is_array($kayit['oylamalar'])) {
                            foreach ($kayit['oylamalar'] as $oy_entry) {
                                if (($oy_entry['oylama_konusu'] ?? '') == $oy) {
                                    $puan_goster = htmlspecialchars($oy_entry['puan']);
                                    break;
                                }
                            }
                        }
                        echo "<td>" . $puan_goster . "</td>";
                    }
                    echo "<td>" . nl2br(htmlspecialchars($kayit['oneriler'])) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='".(4+count($oylamalar))."'>Henüz kayıt yok.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='".(4+count($oylamalar))."'>Henüz kayıt yok.</td></tr>";
        }
      ?>
    </table>
  </div>
  <a href="admin_login.php" class="admin-fab" title="Admin Girişi">
    <i class="fa-solid fa-user"></i>
  </a>
</body>
</html> 