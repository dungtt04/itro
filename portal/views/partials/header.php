<?php
include_once __DIR__ . '/../../config/languages.php';
// Ensure we have a current language value available for the header
if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}
if (!isset($currentLang) || empty($currentLang)) {
  $currentLang = $_SESSION['lang'] ?? 'vi';
}
?>
<style>
  
    .link {
      display: inline-block;
      /* margin-top: 15px; */
      color: #ffffffff;
      font-weight: bold;
      text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: 0.2s;
    }

    .link:hover {
      border-bottom: 1px solid #ffffffff;
    }

</style>
<!-- views/partials/header.php -->
<header style="background: #0a3d91; color: white; padding: 12px 0; text-align: center; position: sticky; top: 0; z-index: 100;">
  <div style="max-width: 1000px; margin: auto; display: flex; align-items: center; justify-content: space-between; padding: 0 20px;">
    <div style="display: flex; align-items: center; gap: 10px;">
    <a href="/">
      <img src="portal/itro-logo-vuong.png" alt="iTrọ Logo" width="40" style="border-radius: 8px;">
    </a>
      <div style="text-align: left;">
        <!-- <div style="font-weight: bold; font-size: 18px;">
          <?php echo $currentLang === 'vi' ? 'iTrọ - NHÀ TRỌ CHÚ QUẢNG' : 'iTrọ - TANG TIEN QUANG MOTEL'; ?>
        </div>
        <div style="font-size: 13px;">
          <?php echo $currentLang === 'vi' ? 'Đội 6, thôn Minh Thành, Lai Khê, TP Hải Phòng' : 'Minh Thanh Village, Lai Khe, Hai Phong City'; ?>
        </div> -->
                <div style="font-weight: bold; font-size: 18px;">
          <?php echo $currentLang === 'vi' ? '<a class="link" href="/">HỆ THỐNG QUẢN LÝ NHÀ TRỌ iTrọ</a>' : '<a class="link" href="/">iTrọ HOSTEL MANAGEMENT</a>'; ?>
        </div>
        <div style="font-size: 13px;">
          <?php echo $currentLang === 'vi' ? 'Phát triển bởi <a class="link" href="http://dungtt.id.vn">Tăng Tiến Dũng</a>' : 'Developed by <a class="link" href="http://dungtt.id.vn">Tăng Tiến Dũng</a>'; ?>
        </div>

      </div>
    </div>

    <div style="display: flex; gap: 10px; align-items: center;">
      <div class="lang-buttons" style="display: flex; gap: 5px;">
        <a href="?lang=vi<?php echo isset($_GET['action']) ? '&action='.$_GET['action'] : ''; ?>" 
          style="background: <?php echo $currentLang === 'vi' ? '#0a3d91' : 'white'; ?>; 
                 color: <?php echo $currentLang === 'vi' ? 'white' : '#0a3d91'; ?>; 
                 padding: 6px 12px; 
                 border-radius: 6px; 
                 font-size: 14px;
                 text-decoration: none; 
                 border: 1px solid white;
                 transition: 0.2s;">
          VN
        </a>
        <a href="?lang=en<?php echo isset($_GET['action']) ? '&action='.$_GET['action'] : ''; ?>" 
          style="background: <?php echo $currentLang === 'en' ? '#0a3d91' : 'white'; ?>; 
                 color: <?php echo $currentLang === 'en' ? 'white' : '#0a3d91'; ?>; 
                 padding: 6px 12px; 
                 border-radius: 6px; 
                 font-size: 14px;
                 text-decoration: none; 
                 border: 1px solid white;
                 transition: 0.2s;">
          EN
        </a>
      </div>
      <!--<a href="/admin" 
         style="background: white; color: #0a3d91; padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: 0.2s;">
        <?php echo $currentLang === 'vi' ? 'Admin' : 'Admin'; ?>
      </a>-->
    </div>
  </div>
</header>
