<?php
  include_once __DIR__ . '/../../config/languages.php';
?>
<style>
  
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

</style>
<!-- views/partials/footer.php -->
<footer style="background: #f5f5f5; text-align: center; padding: 20px 10px; margin-top: 40px; font-size: 0.9em; color: #666;">
  <p class="guide-link">
    
    © 2025 - 
    <?php echo $currentLang === 'vi' ? 'Hệ thống quản lý nhà trọ <b>iTrọ</b>' : '<b>iTrọ</b> Motel Management system'; ?> -
  </p>
    | Email: <a class="guide-link" href="mailto:admin@dungtt.id.vn">admin@dungtt.id.vn</a> | <a class="guide-link" href="/admin"> <?php echo t('login'); ?></a>
</footer>
