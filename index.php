<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Oyunu Ver!</title>
  <link href="https://fonts.googleapis.com/css?family=Dancing+Script:700&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN for user icon -->
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
    /* Sidebar dikeyde ortalı */
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
    .main-title {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(23, 61, 44, 0.75);
      color: #fff;
      padding: 38px 80px;
      border-radius: 18px;
      font-family: 'Dancing Script', cursive;
      font-size: 4rem;
      font-weight: 700;
      letter-spacing: 2px;
      box-shadow: 0 4px 32px #1b2d1c44;
      text-align: center;
      text-shadow: 2px 2px 10px #0009;
      border: none;
      outline: none;
    }
    /* Admin butonu sağ alt köşede yuvarlak ve simgeli */
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
      .main-title { font-size: 2.2rem; padding: 22px 12px; }
      .sidebar {
        left: 10px;
        width: 170px;
        top: 50%;
        transform: translateY(-50%);
      }
      .logo { width: 120px; margin-bottom: 16px; }
      .admin-fab { right: 16px; bottom: 16px; width: 52px; height: 52px; font-size: 1.6rem; }
    }
    @media (max-width: 600px) {
      .main-title { font-size: 1.3rem; padding: 12px 4px; }
      .sidebar {
        width: 90px;
        top: 50%;
        transform: translateY(-50%);
      }
      .menu a { font-size: 0.95rem; padding: 8px 0; }
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
    </div>
  </div>
  <div class="main-title">
    OYUNU VER!
  </div>
  <!-- Sağ alt köşede admin için kullanıcı simgeli yuvarlak buton -->
  <a href="admin_login.php" class="admin-fab" title="Admin Girişi">
    <i class="fa-solid fa-user"></i>
  </a>
</body>
</html> 