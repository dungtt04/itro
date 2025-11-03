<?php
require_once __DIR__ . '/../config/languages.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
  <meta charset="UTF-8">
  <title><?php echo $currentLang === 'vi' ? 'Trang khách hàng' : 'Customer Portal'; ?></title>
  <link rel="shortcut icon" href="portal/itro-logo-vuong.png" type="image/x-icon">
  <link rel="stylesheet" href="views/style.css">
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: linear-gradient(135deg, #e9f1ff, #ffffff);
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      max-width: 600px;
      margin: 80px auto;
      background: #fff;
      padding: 40px 50px;
      border-radius: 16px;
      box-shadow: 0 4px 18px rgba(0,0,0,0.1);
      text-align: center;
    }

    img {
      width: 100px;
      margin-bottom: 15px;
    }

    h2 {
      color: #0a3d91;
      font-size: 1.6em;
      margin-bottom: 30px;
    }

    .home-btn {
      display: block;
      background-color: #0a3d91;
      color: white;
      text-decoration: none;
      padding: 14px;
      margin: 12px 0;
      border-radius: 10px;
      font-size: 1.05em;
      font-weight: 600;
      transition: all 0.25s ease;
    }

    .home-btn:hover {
      background-color: #082f72;
      transform: translateY(-2px);
    }

    .guide-link {
      display: inline-block;
      margin-top: 15px;
      color: #0a3d91;
      font-weight: 600;
      text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: 0.2s;
    }

    .guide-link:hover {
      border-bottom: 1px solid #0a3d91;
    }

    footer {
      margin-top: 30px;
      font-size: 0.9em;
      color: #777;
    }

  </style>
</head>
<body>
	<?php include 'portal/views/partials/header.php'; ?>
  <div class="container">
    <img src="/portal/itro-logo.png" alt="iTrọ Logo">
    <h2><?php echo t('welcome_title'); ?></h2>
    <a href="?action=history_search" class="home-btn"><?php echo t('start_button'); ?></a>

    <a href="https://drive.google.com/file/d/1SFMiDqcMl4odW-J52ofDDeZMyF7I9Arm/view?usp=sharing" target="_blank" class="guide-link">
      <?php echo t('user_guide'); ?>
    </a>
  </div>
<?php include 'portal/views/partials/footer.php'; ?>

</body>
</html>
