<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>İletişim</title>
  <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN for social & user icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    .content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(255,255,255,0.8);
      padding: 40px 70px;
      border-radius: 16px;
      box-shadow: 0 0 14px #00331133;
      max-width: 600px;
      text-align: center;
    }
    h1 {
      font-family: 'Dancing Script', cursive;
      color: #17503a;
      font-size: 2.3rem;
      margin-bottom: 18px;
    }
    .social {
      margin-top: 18px;
      display: flex;
      justify-content: center;
      gap: 20px;
    }
    .social a {
      display: inline-block;
      text-decoration: none;
      color: #17503a;
      transition: color 0.2s;
      font-size: 2rem;
    }
    .social a:hover {
      color: #007BFF;
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
      .sidebar { left: 10px; width: 170px; top: 50%; transform: translateY(-50%);}
      .logo { width: 120px; margin-bottom: 16px; }
      .content { padding: 20px 10px; }
      .admin-fab { right: 16px; bottom: 16px; width: 52px; height: 52px; font-size: 1.6rem; }
    }
    @media (max-width: 600px) {
      .sidebar { width: 90px; }
      .logo { width: 50px; padding: 2px; }
      .content { padding: 8px 2px; font-size: 15px; }
      .social a { font-size: 1.3rem; }
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
      <a href="iletisim.php" class="active">İLETİŞİM</a>
      <a href="form_kayit.php">OYLAMA</a>
    </div>
  </div>
  <div class="content">
    <h1>İletişim</h1>
    <p>
      Bizimle iletişim kurmak için aşağıdaki mail adresini kullanabilirsiniz:<br>
      <b>nisabayrak58@gmail.com</b><br>
      Ayrıca sosyal medya hesabım üzerinden de ulaşabilirsiniz!
    </p>
    <div class="social">
      <a href="https://instagram.com/nisabayrak58" target="_blank" title="Instagram">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="mailto:nisabayrak58@gmail.com" title="E-posta">
        <i class="fas fa-envelope"></i>
      </a>
      <!-- Dilerseniz diğer sosyal medya hesaplarınızı da ekleyebilirsiniz -->
    </div>
  </div>
  <a href="admin_login.php" class="admin-fab" title="Admin Girişi">
    <i class="fa-solid fa-user"></i>
  </a>
</body>
</html>