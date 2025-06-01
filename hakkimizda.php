<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Oyunu Ver! - Hakkımızda</title>
  <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    html, body { height: 100%; margin: 0; padding: 0; }
    body {
      min-height: 100vh;
      background: url('forest-bg.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      font-family: Arial, sans-serif;
      overflow-x: hidden;
    }
    .sidebar {
      position: absolute;
      left: 40px;
      top: 50%;
      transform: translateY(-50%);
      width: 250px;
      display: flex;
      flex-direction: column;
      align-items: center;
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
      border: none;
      outline: none;
    }
    .menu a:hover, .menu a:focus {
      background: #1b422c;
      transform: scale(1.05);
      box-shadow: 0 4px 14px #1b2d1c55;
    }
    .content-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(255,255,255,0.92);
      padding: 40px 42px;
      max-width: 600px;
      width: 95%;
      border-radius: 18px;
      box-shadow: 0 0 18px #00331133;
      text-align: center;
      z-index: 1;
    }
    h1 {
      color: #17612c;
      font-family: 'Dancing Script', cursive;
      font-size: 2.6rem;
      margin-bottom: 18px;
      margin-top: 0;
    }
    p {
      color: #226c36;
      font-size: 1.12rem;
      margin-bottom: 18px;
      margin-top: 0;
    }
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
    @media (max-width: 900px) {
      .sidebar {
        left: 10px;
        width: 170px;
      }
      .logo { width: 120px; margin-bottom: 16px; }
      .content-container {
        padding: 16px 6vw;
        max-width: 98vw;
      }
      h1 { font-size: 1.7rem; }
    }
    @media (max-width: 600px) {
      .sidebar { width: 90px; }
      .menu a { font-size: 0.95rem; padding: 8px 0; }
      .logo { width: 50px; padding: 2px; }
      .content-container { padding: 8px 2vw; }
      h1 { font-size: 1.15rem; }
      p { font-size: 0.98rem; }
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
    </div>
  </div>
  <div class="content-container">
    <h1>Hakkımızda</h1>
    <p>
      <b>Oyunu Ver!</b> platformu, İstanbul 29 Mayıs Üniversitesi öğrencilerinin okul hakkındaki görüş ve önerilerini kolayca iletebilmesi için oluşturulmuş bir anket sistemidir.<br><br>
      Amacımız; öğrencilerimizin okul ortamını, temizlik, hizmet ve diğer konularda değerlendirmesine olanak tanımak ve yönetim ile öğrenciler arasında güçlü bir iletişim köprüsü kurmaktır.<br><br>
      Tüm katılımcıların görüşleri bizim için değerlidir. Katılımınız için teşekkürler!
    </p>
  </div>
   <a href="admin_login.php" class="admin-fab" title="Admin Girişi">
    <i class="fa-solid fa-user"></i>
  </a>
</body>
</html> 