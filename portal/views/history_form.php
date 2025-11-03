<?php 
require_once __DIR__ . '/../config/languages.php';
// Debug information
// error_log('Current Language: ' . $currentLang);
// error_log('Translation function exists: ' . (function_exists('t') ? 'Yes' : 'No'));
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
  <meta charset="UTF-8">
  <title><?php echo t('bill_lookup'); ?></title>
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
      margin: 60px auto;
      background: #fff;
      padding: 40px 50px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h2 {
      margin-bottom: 10px;
      color: #0a3d91;
      font-size: 1.8em;
    }

    .subtitle {
      font-size: 0.95em;
      color: #666;
      margin-bottom: 25px;
    }

    form label {
      display: block;
      text-align: left;
      margin: 10px 0 5px;
      font-weight: 600;
    }

    input, select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 1em;
      transition: all 0.2s ease;
    }

    input:focus, select:focus {
      border-color: #0a3d91;
      box-shadow: 0 0 6px rgba(10, 61, 145, 0.2);
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #0a3d91;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.1em;
      cursor: pointer;
      transition: all 0.25s ease;
      margin-top: 10px;
    }

    button:hover {
      background-color: #082f72;
      transform: translateY(-2px);
    }

    .radio-group {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .note {
      font-size: 0.9em;
      color: #c00;
      background: #fff5f5;
      border-radius: 8px;
      padding: 10px;
      text-align: left;
    }

    /* Thêm phần căn hàng Tháng + Năm */
    .month-year-group {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 15px;
    }

    .month-field,
    .year-field {
      flex: 1;
    }

    .month-field label,
    .year-field label {
      display: block;
      text-align: left;
      margin-bottom: 5px;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <?php include 'portal/views/partials/header.php'; ?>

  <div class="container">
    <h2><?php echo t('bill_lookup'); ?></h2>
    <p class="subtitle"><?php echo t('enter_info'); ?></p>

    <form method="post" id="searchForm">
      <div class="radio-group">
        <!-- 
        <label>
          <input type="radio" name="search_type" value="month" checked onchange="toggleSearchType()">
          <?php echo t('by_room_month_year'); ?>
        </label>
        <label>
          <input type="radio" name="search_type" value="code" onchange="toggleSearchType()">
          <?php echo t('by_transaction_code'); ?>
        </label> -->
      </div>

      <div id="searchByMonth">
        <label><?php echo t('room'); ?>:</label>
        <select name="room" required>
          <option value=""><?php echo t('select_room'); ?></option>
          <?php if (!empty($rooms)) foreach ($rooms as $r): ?>
            <option value="<?= htmlspecialchars($r['room_code']) ?>">
              <?= htmlspecialchars($r['room_code']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <div class="month-year-group">
          <div class="month-field">
            <label><?php echo t('month'); ?>:</label>
            <select name="month" required>
              <option value=""><?php echo t('select_month'); ?></option>
              <?php
                $months = t('months');
                for ($m = 1; $m <= 12; $m++):
                  $label = (is_array($months) && isset($months[$m])) ? $months[$m] : (t('month_number') . ' ' . $m);
              ?>
                <option value="<?= $m ?>"><?= htmlspecialchars($label) ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <div class="year-field">
            <label><?php echo t('year'); ?>:</label>
            <input type="number" name="year" min="2000" max="2100" required placeholder="<?php echo t('year_placeholder'); ?>">
          </div>
        </div>
      </div>

      <div id="searchByCode" style="display:none;">
        <label><?php echo t('transaction_code'); ?>:</label>
        <input type="text" name="addinfo" disabled placeholder="<?php echo t('transaction_code'); ?>">
        <div class="note">
          <?php echo t('feature_development'); ?>  
          <?php echo t('use_room_search'); ?>
        </div>
      </div>

      <button type="submit"><?php echo t('search'); ?></button>
    </form>
  </div>

  <?php include 'portal/views/partials/footer.php'; ?>

  <script>
    function toggleSearchType() {
      var type = document.querySelector('input[name="search_type"]:checked').value;
      document.getElementById('searchByMonth').style.display = (type === 'month') ? '' : 'none';
      document.getElementById('searchByCode').style.display = (type === 'code') ? '' : 'none';
    }

    // Auto-fill current year
    document.addEventListener("DOMContentLoaded", function() {
      const yearInput = document.querySelector('input[name="year"]');
      if (yearInput && !yearInput.value) {
        yearInput.value = new Date().getFullYear();
      }
    });
  </script>
</body>
</html>
