<?php
require_once __DIR__ . '/../config/languages.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">

<head>
  <meta charset="UTF-8">
  <title>Privacy Policy</title>
  <link rel="shortcut icon" href="portal/itro-logo-vuong.png" type="image/x-icon">
  <link rel="stylesheet" href="views/style.css">
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: linear-gradient(135deg, #e9f1ff, #ffffff);
      margin: 0;
      color: #333;
    }

    .container {
      max-width: 800px;
      margin: 80px auto;
      background: #fff;
      padding: 40px 50px;
      border-radius: 16px;
      box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
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

    .title {
      font-size: 1.7em;
      text-align: center;
      color: #0a3d91;
      margin-bottom: 30px;
    }

    /* ===== MODAL ===== */
    .modal-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      align-items: center;
      justify-content: center;
    }

    .modal {
      background: #fff;
      width: 420px;
      padding: 25px 30px;
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
      position: relative;
    }

    .modal h3 {
      margin-top: 0;
      color: #0a3d91;
      text-align: center;
    }

    .close-btn {
      position: absolute;
      top: 12px;
      right: 15px;
      font-size: 20px;
      cursor: pointer;
      color: #999;
    }

    .close-btn:hover {
      color: #000;
    }

    input[type="text"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0 12px;
    }

    .home-btn {
      width: 100%;
      background: #0a3d91;
      color: #fff;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 10px;
    }

    .home-btn:hover {
      background: #08306b;
    }

    .info p {
      margin: 6px 0;
      font-size: 0.95em;
    }

    .accepted {
      margin-top: 15px;
      padding: 10px;
      background: #e6f6ea;
      color: #1e7e34;
      border-radius: 8px;
      font-weight: 600;
      text-align: center;
    }
  </style>
</head>

<body>

  <?php include 'portal/views/partials/header.php'; ?>

  <div class="container">
    <a href="/" class="guide-link">
      ← <?php echo $currentLang === 'vi' ? 'Quay về trang chủ' : 'Back to home'; ?>
    </a>
    <h3 class="title">
      <?php echo $currentLang === 'vi'
        ? 'CHÍNH SÁCH BẢO VỆ DỮ LIỆU CÁ NHÂN'
        : 'PRIVACY POLICY';
      ?>
    </h3>

    <?php if ($currentLang === 'vi'): ?>

      <h3>1. Mục đích thu thập dữ liệu</h3>
      <p>
        Chúng tôi thu thập và xử lý dữ liệu cá nhân của khách thuê nhằm phục vụ công tác
        quản lý thuê trọ, thực hiện hợp đồng thuê nhà, khai báo tạm trú và các nghĩa vụ
        pháp lý liên quan.
      </p>

      <h3>2. Loại dữ liệu được thu thập</h3>
      <ul>
        <li>Họ và tên</li>
        <li>Số CMND/CCCD/Hộ chiếu</li>
        <li>Số điện thoại</li>
        <li>Ngày sinh, địa chỉ thường trú</li>
        <li>Thông tin hợp đồng và phòng trọ</li>
      </ul>

      <h3>3. Phạm vi sử dụng dữ liệu</h3>
      <p>
        Dữ liệu cá nhân chỉ được sử dụng nội bộ cho mục đích quản lý và không được chia sẻ
        cho bên thứ ba, trừ trường hợp có yêu cầu từ cơ quan nhà nước có thẩm quyền.
      </p>

      <h3>4. Thời gian lưu trữ</h3>
      <p>
        Dữ liệu được lưu trữ trong thời gian hợp đồng còn hiệu lực hoặc theo quy định của pháp luật.
        Sau khi hết thời hạn, dữ liệu sẽ được xóa hoặc ẩn.
      </p>

      <h3>5. Quyền của khách thuê</h3>
      <ul>
        <li>Được biết về việc xử lý dữ liệu cá nhân</li>
        <li>Yêu cầu chỉnh sửa hoặc cập nhật thông tin</li>
        <li>Yêu cầu xóa dữ liệu theo quy định pháp luật</li>
        <li>Rút lại sự đồng ý (không ảnh hưởng đến xử lý trước đó)</li>
      </ul>

      <h3>6. Cam kết bảo mật</h3>
      <p>
        Chúng tôi áp dụng các biện pháp kỹ thuật và quản lý cần thiết để bảo vệ dữ liệu cá nhân
        khỏi truy cập trái phép, mất mát hoặc rò rỉ.
      </p>

    <?php else: ?>

      <h3>1. Purpose of Data Collection</h3>
      <p>
        We collect and process personal data to manage rental services, perform rental contracts,
        declare temporary residence, and comply with legal obligations.
      </p>

      <h3>2. Types of Data Collected</h3>
      <ul>
        <li>Full name</li>
        <li>ID/Passport number</li>
        <li>Phone number</li>
        <li>Date of birth and permanent address</li>
        <li>Rental and contract information</li>
      </ul>

      <h3>3. Scope of Data Use</h3>
      <p>
        Personal data is used internally only and will not be shared with third parties
        unless required by competent authorities.
      </p>

      <h3>4. Data Retention</h3>
      <p>
        Data is stored during the contract period or as required by law, and will be deleted
        or anonymized afterward.
      </p>

      <h3>5. User Rights</h3>
      <ul>
        <li>Right to be informed</li>
        <li>Right to access and correct data</li>
        <li>Right to request data deletion</li>
        <li>Right to withdraw consent</li>
      </ul>

      <h3>6. Data Security</h3>
      <p>
        We implement appropriate technical and organizational measures to protect personal data
        against unauthorized access or disclosure.
      </p>

    <?php endif; ?>


    <!-- NÚT MỞ POPUP -->
    <button id="openModalBtn" class="home-btn">
      Đồng ý chia sẻ dữ liệu
    </button>
  </div>

  <!-- ===== MODAL ===== -->
  <div class="modal-overlay" id="modal">
    <div class="modal">
      <span class="close-btn" id="closeModal">&times;</span>

      <h3>Xác nhận đồng ý chia sẻ dữ liệu</h3>

      <label>Số CCCD</label>
      <input type="text" id="cccd" placeholder="Nhập số CCCD">

      <button id="searchBtn" class="home-btn">Tìm thông tin</button>

      <div id="resultBox" style="display:none" class="info">
        <p><strong>Họ tên:</strong> <span id="name"></span></p>
        <p><strong>Ngày sinh:</strong> <span id="dob"></span></p>
        <p><strong>Địa chỉ:</strong> <span id="address"></span></p>
        <p><strong>Phòng:</strong> <span id="room"></span></p>
        <!-- KHU VỰC ĐỒNG Ý -->
        <div id="consentArea"></div>
      </div>
    </div>
  </div>

  <script>
    const modal = document.getElementById('modal');

    function formatDateDMY(dateStr) {
      if (!dateStr) return '';
      const date = new Date(dateStr);
      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const year = date.getFullYear();
      return `${day}/${month}/${year}`;
    }
    document.getElementById('openModalBtn').onclick = () => {
      modal.style.display = 'flex';
    };

    document.getElementById('closeModal').onclick = () => {
      modal.style.display = 'none';
    };

    document.getElementById('searchBtn').onclick = () => {
      const cccd = document.getElementById('cccd').value.trim();
      if (!cccd) return alert('Vui lòng nhập CCCD');

      fetch('/index.php?action=find_by_cccd', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            cccd
          })
        })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            alert('Không tìm thấy thông tin');
            return;
          }

          document.getElementById('name').innerText = data.name;
          document.getElementById('dob').innerText = formatDateDMY(data.dob);
          document.getElementById('address').innerText = data.address;
          document.getElementById('room').innerText = data.room;
          document.getElementById('resultBox').style.display = 'block';

          const consentArea = document.getElementById('consentArea');
          consentArea.innerHTML = '';

          if (data.policy_status === 'accept') {
            consentArea.innerHTML = `
        <div class="accepted">
          ✓ Bạn đã đồng ý chia sẻ dữ liệu cá nhân
        </div>
      `;
          } else {
            consentArea.innerHTML = `
        <label style="display:block;margin-top:15px">
          <input type="checkbox" id="agreeCheckbox">
          Tôi đã đọc <a href="/?action=privacy_policy" class="guide-link">Chính sách bảo vệ dữ liệu cá nhân</a> và đồng ý chia sẻ dữ liệu cá nhân cho hệ thống
        </label>
        <button class="home-btn" onclick="submitConsent('${cccd}')">
          Gửi xác nhận
        </button>
      `;
          }
        });
    };

    function submitConsent(cccd) {
      if (!document.getElementById('agreeCheckbox')?.checked) {
        alert('Bạn cần đồng ý');
        return;
      }

      fetch('/index.php?action=accept_policy', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            cccd
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert('Xác nhận thành công');
            location.reload();
          }
        });
    }
  </script>

  <?php include 'portal/views/partials/footer.php'; ?>
</body>

</html>