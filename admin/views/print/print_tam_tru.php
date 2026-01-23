
<?php
// $isFormExist = !empty($all_ct01);

$title = 'In tờ khai tạm trú';
$headContent =
    '<style>
  body { font-family: Arial, sans-serif; background: #f0f4f8; color: #333;}
  .container { max-width: 700px; margin: 40px auto 40px 40px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; }
  .infor{ position: fixed; right: 20px; top: 50%; transform: translateY(-50%); width: 350px; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 20px; z-index: 1000; max-height: 80vh; overflow-y: auto; }
  .declaration{  width: 100%; margin: 20px auto; font-family: "Times New Roman", serif; }
  h2, h3 { text-align: center; margin: 5px 0; }
  .underline { text-decoration: underline solid 1px black; }
  .button { text-align: center; }
  .btn-print {  margin:0 auto 18px auto; background:#093d62; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; width:max-content; }
  .btn-print:hover { background:#1e7e34; }
  .infor a {  margin:0 auto 18px auto; background: #ff0000ff; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-size:16px; font-weight:500; cursor:pointer; text-decoration:none; width:max-content; }
  .infor a:hover { background: #c90000ff; }
  .info { font-size: 14px; text-align: center; margin-bottom: 20px; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
  th, td { padding: 6px; text-align: left; border-bottom: 1px solid #ccc; }
  .total { font-weight: bold; text-align: right; }
  .note { font-size: 13px; margin-top: 10px; }
  .footer_invoice { text-align: center; margin-top: 20px; font-size: 14px; color: #555; }
  .container3{ max-width: 500px; margin: 100px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #093d6240; padding: 32px 28px; text-align: center; }
  
  /* Form styles */
  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 14px;
  }

  .form-group input,
  .form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
  }

  .form-group input:focus,
  .form-group select:focus {
    outline: none;
    border-color: #093d62;
  }

  .info-text {
    background: #f9f9f9;
    padding: 10px;
    border-radius: 4px;
    margin-top: 10px;
    font-size: 12px;
    border: 1px solid #e0e0e0;
    max-height: 150px;
    overflow-y: auto;
  }

  .modal-buttons {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 20px;
  }

  .modal-buttons button {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
  }

  .btn-confirm {
    background-color: #093d62;
    color: white;
  }

  .btn-confirm:hover {
    background-color: #1e7e34;
  }

  .btn-cancel {
    background-color: #ccc;
    color: #333;
  }

  .btn-cancel:hover {
    background-color: #999;
  }

  /* Declaration styles */
  .declaration h2,
  .declaration h3 {
    font-size: 16px;
    text-align: center;
    margin: 0;
  }

  .declaration .center {
    text-align: center;
  }

  .declaration .title {
    font-size: 16px;
    margin-bottom: 10px;
  }

  .declaration .content {
    padding: 0;
  }

  .declaration .detail {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  .declaration .detail,
  .declaration th,
  .declaration td {
    border: 1px solid black;
  }

  .declaration th,
  .declaration td {
    padding: 6px;
    text-align: center;
    vertical-align: middle;
  }

  .declaration .detail td {
    height: 17px;
  }

  .declaration .cccd {
    border-collapse: collapse;
    width: 100%;
  }

  .declaration .cccd td {
    text-align: left;
  }

  .declaration .cccd td:first-child {
    width: 40%;
    border: none;
  }

  .declaration .signature {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    border: 0px solid black;
  }

  .declaration .signature td {
    width: 25%;
    text-align: center;
    vertical-align: top;
    border: 0px solid black;
  }

  .declaration .signature td i{
    font-size: 12px;
  }

  .declaration .signature .vneid-infor td {
    font-size: 12px;
    text-align: left;
    padding-top: 0;
    font-size: 10px;
  }
    .separator {
        border: none;
        border-top: 2px dashed #ccc;
        margin: 20px 0;
    }
  @media print {
    body { margin: 0; padding: 0; background-color: #fff; }
    .container{ box-shadow: none; margin: 0; padding: 0; border-radius: 0; }
    .infor { display: none; }
    .menu-bar, footer { display: none; }
    .declaration { page-break-inside: avoid; }
    .separator { display: none; }
  }
  @media (max-width: 800px) {
    .container {  margin: 0; border-radius: 0; box-shadow: none; padding: 20px; }
    .infor {
      position: static;
      width: 100%;
      transform: none;
      max-height: none;
      margin-bottom: 20px;
      top: auto;
      right: auto;
    }
    .declaration {width: 100%; margin: 0; }
  }
</style>';
ob_start();

?>
<div class="infor">
    <div class="content">
        <h3>Tờ khai tạm trú</h3>
        <form id="contentForm" style="margin-top: 15px;">
            <div class="form-group">
                <label for="requestContent">Nội dung đề nghị:</label>
                <input type="text" id="requestContent" name="requestContent" value="Đăng ký tạm trú" required>
            </div>
            <div class="form-group">
                <label for="duration">Thời hạn:</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <select id="duration" name="duration" style="flex: 1;">
                        <option value="">Chọn thời hạn</option>
                        <option value="3">3 tháng</option>
                        <option value="6">6 tháng</option>
                        <option value="9">9 tháng</option>
                        <option value="12">12 tháng</option>
                        <option value="noExpiry">Không có thời hạn</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ nhà trọ:</label>
                <input type="text" id="address" name="address" value="Đội 6, thôn Minh Thành, xã Lai Khê, Thành phố Hải Phòng" required>
            </div>
            <div class="form-group" id="datesGroup">
                <label style="margin-bottom: 3px;">Ngày in: <span id="currentDate" style="font-weight: bold; color: #093d62;"></span></label>
                <label>Ngày hết hạn: <span id="expiryDate" style="color: #093d62; font-weight: bold;"></span></label>
            </div>
            <div class="info-text" id="previewText" style="min-height: 60px;"></div>
            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="resetForm()">Đặt lại</button>
                <button type="button" class="btn-confirm" onclick="confirmContent()">Cập nhật</button>
            </div>
        </form>
    </div> <br>
</div>
<div class="container">
    <!-- Right sidebar with form -->

    <!-- Left side with declaration forms -->
    <div class="declaration">
        <?php if (!empty($all_ct01)): ?>
            <?php foreach ($all_ct01 as $active_customers): ?>
                <div style="page-break-after: always;">
                    <p style="text-align:center; font-size:14px;">
                        Mẫu CT01 ban hành kèm theo Thông tư số 53/2025/TT-BCA<br>
                        ngày 01/07/2025 của Bộ trưởng Bộ Công an
                    </p>
                    <div class="center title">
                        <b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </b><br>
                        <i class="underline">Độc lập – Tự do – Hạnh phúc</i>
                    </div>
                    <h2>TỜ KHAI THAY ĐỔI THÔNG TIN CƯ TRÚ</h2>
                    <p><strong>Kính gửi<sup>(1)</sup>:</strong> Công an xã Lai Khê, TP Hải Phòng</p>
                    <div class="content">

                        <?php
                        // Xác định chủ hộ và thành viên
                        $chu_ho = null;
                        $thanh_vien = [];
                        if (count($active_customers) == 1) {
                            // Nếu phòng có 1 người thì người khai là chủ hộ luôn
                            $chu_ho = $active_customers[0];
                            $nguoi_khai = $chu_ho;
                            $thanh_vien = [];
                        } elseif (count($active_customers) == 2) {
                            foreach ($active_customers as $c) {
                                if ($c['type_of_tenant'] === 'Chính') $chu_ho = $c;
                                else $thanh_vien[] = $c;
                            }
                            $nguoi_khai = $chu_ho;
                        } else {
                            // Có thể mở rộng cho nhiều hơn 2 người nếu cần
                            $nguoi_khai = null;
                        }
                        ?>
                        <p>1. Họ, chữ đệm và tên khai sinh:
                            <span style="text-transform: uppercase; ">
                                <?= isset($nguoi_khai) ? htmlspecialchars($nguoi_khai['name']) : '' ?>
                            </span>
                        </p>
                        <p>2. Ngày, tháng, năm sinh: <?= isset($nguoi_khai) && $nguoi_khai['dob'] ? date('d/m/Y', strtotime($nguoi_khai['dob'])) : '' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Giới tính:
                            <?php
                            $gender = '';
                            if (isset($nguoi_khai) && !empty($nguoi_khai['cccd']) && strlen($nguoi_khai['cccd']) >= 4) {
                                $digit = (int)$nguoi_khai['cccd'][3];
                                $gender = ($digit % 2 == 0) ? 'Nam' : 'Nữ';
                            }
                            echo $gender;
                            ?> </p>
                        <table class="cccd">
                            <tr>
                                <td class="cccd1">4. Số định danh cá nhân:</td>
                                <?php
                                $cccd = isset($nguoi_khai) ? str_split($nguoi_khai['cccd']) : [];
                                for ($i = 0; $i < 12; $i++) {
                                    echo '<td style="text-align:center">' . ($cccd[$i] ?? '') . '</td>';
                                }
                                ?>
                            </tr>
                        </table>
                        <p>5. Số điện thoại liên hệ: <?= isset($nguoi_khai) ? htmlspecialchars($nguoi_khai['phone'] ?? '') : '' ?> 6. Email: </p>
                        <p>7. Họ, chữ đệm và tên chủ hộ:
                            <span style="text-transform: uppercase;">
                                <?= (isset($chu_ho) && $chu_ho) ? htmlspecialchars($chu_ho['name']) : '' ?>
                            </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            8. Mối quan hệ với chủ hộ: <?= (isset($chu_ho) && $chu_ho) ? 'Chủ hộ' : '' ?>
                        </p>
                        <table class="cccd">
                            <tr>
                                <td class="cccd1">9. Số định danh cá nhân của chủ hộ:</td>
                                <?php
                                $cccd = (isset($chu_ho) && $chu_ho) ? str_split($chu_ho['cccd']) : [];
                                for ($i = 0; $i < 12; $i++) {
                                    echo '<td style="text-align:center;">' . ($cccd[$i] ?? '') . '</td>';
                                }
                                ?>
                            </tr>
                        </table>
                        <p>10. Nội dung đề nghị <sup>(2)</sup>: <span id="contentText"> </span></p>
                        <p>11. Những thành viên trong hộ gia đình cùng thay đổi:</p>
                    </div>
                    <table class="detail">
                        <thead>
                            <tr>
                                <th>TT</th>
                                <th>Họ, chữ đệm <br> và tên</th>
                                <th>Ngày, tháng, <br>năm sinh</th>
                                <th>Giới <br> tính</th>
                                <th>Số định danh <br>cá nhân</th>
                                <th>Mối quan hệ <br>với chủ hộ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($active_customers) == 2) {
                                $row = 1;
                                foreach ($thanh_vien as $tv) {
                                    // Xác định giới tính từ số thứ 4 của cccd
                                    $tv_gender = '';
                                    if (!empty($tv['cccd']) && strlen($tv['cccd']) >= 4) {
                                        $digit = (int)$tv['cccd'][3];
                                        $tv_gender = ($digit % 2 == 0) ? 'Nam' : 'Nữ';
                                    }
                                    echo '<tr>';
                                    echo '<td>' . $row++ . '</td>';
                                    echo '<td>  <span style="text-transform: uppercase;">' . htmlspecialchars($tv['name']) . '</span></td>';
                                    echo '<td>' . ($tv['dob'] ? date('d/m/Y', strtotime($tv['dob'])) : '') . '</td>';
                                    echo '<td>' . $tv_gender . '</td>';
                                    echo '<td>' . htmlspecialchars($tv['cccd']) . '</td>';
                                    echo '<td></td>';
                                    echo '</tr>';
                                }
                            } else {
                                // Nếu chỉ có 1 người, để trống toàn bộ bảng
                                for ($i = 1; $i <= 6; $i++) {
                                    echo '<tr><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td></tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="signature">
                        <tr>
                            <td><i> ....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ HỘ<sup>(3)</sup></b></td>
                            <td><i> ....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ SỞ HỮU <br> CHỖ Ở HỢP PHÁP<sup>(4)</sup></b></td>
                            <td><i> ....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHA, MẸ <br>HOẶC NGƯỜI GIÁM HỘ<sup>(5)</sup> </b></td>
                            <td><i> ....., ngày ..... tháng ..... năm ..... </i> <br><b>NGƯỜI KÊ KHAI<sup>(6)</sup></b></td>
                        </tr>
                        <tr style="height:60px;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="vneid-infor">
                            <td></td>
                            <td>(7) Họ và tên: <br> TĂNG TIẾN QUẢNG
                                <br>(7) Số định danh cá nhân: <br>030070001028
                            </td>
                            <td>(7) Họ và tên: <br>..................
                                <br>(7) Số định danh cá nhân: <br>.................
                            </td>
                            <td style="text-align:center"><b><?php echo isset($nguoi_khai) ? htmlspecialchars($nguoi_khai['name']) : '' ?></b></td>
                        </tr>
                    </table>
                    <!-- <br><br><br> -->
                </div>
                <hr class="separator" style="border: none; border-top: 2px dashed #ccc; margin: 20px 0;">
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; font-size:13px;">
                    Mẫu CT01 ban hành kèm theo Thông tư số 53/2025/TT-BCA<br>
                    ngày 01/07/2025 của Bộ trưởng Bộ Công an
                </p>
            <div class="center title">
                <b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </b><br>
                <i class="underline">Độc lập – Tự do – Hạnh phúc</i>
            </div>
            <h2>TỜ KHAI THAY ĐỔI THÔNG TIN CƯ TRÚ</h2>
            <p><strong>Kính gửi<sup>(1)</sup>:</strong> Công an xã Lai Khê, TP Hải Phòng</p>
            <div class="content">


                <?php
                // Xác định chủ hộ và thành viên
                $chu_ho = null;
                $thanh_vien = [];
                if (count($active_customers) == 1) {
                    // Nếu phòng có 1 người thì người khai là chủ hộ luôn
                    $chu_ho = $active_customers[0];
                    $nguoi_khai = $chu_ho;
                    $thanh_vien = [];
                } elseif (count($active_customers) == 2) {
                    foreach ($active_customers as $c) {
                        if ($c['type_of_tenant'] === 'Chính') $chu_ho = $c;
                        else $thanh_vien[] = $c;
                    }
                    $nguoi_khai = $chu_ho;
                } else {
                    // Có thể mở rộng cho nhiều hơn 2 người nếu cần
                    $nguoi_khai = null;
                }
                ?>
                <p>1. Họ, chữ đệm và tên khai sinh:

                    <span style="text-transform: uppercase; ">
                        <?= isset($nguoi_khai) ? htmlspecialchars($nguoi_khai['name']) : '' ?>
                    </span>
                </p>
                <p>2. Ngày, tháng, năm sinh: <?= isset($nguoi_khai) && $nguoi_khai['dob'] ? date('d/m/Y', strtotime($nguoi_khai['dob'])) : '' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3. Giới tính:
                    <?php
                    $gender = '';
                    if (isset($nguoi_khai) && !empty($nguoi_khai['cccd']) && strlen($nguoi_khai['cccd']) >= 4) {
                        $digit = (int)$nguoi_khai['cccd'][3];
                        $gender = ($digit % 2 == 0) ? 'Nam' : 'Nữ';
                    }
                    echo $gender;
                    ?> </p>
                <table class="cccd">
                    <tr>
                        <td class="cccd1">4. Số định danh cá nhân:</td>
                        <?php
                        $cccd = isset($nguoi_khai) ? str_split($nguoi_khai['cccd']) : [];
                        for ($i = 0; $i < 12; $i++) {
                            echo '<td style="text-align:center">' . ($cccd[$i] ?? '') . '</td>';
                        }
                        ?>
                    </tr>
                </table>
                <p>5. Số điện thoại liên hệ: <?= isset($nguoi_khai) ? htmlspecialchars($nguoi_khai['phone'] ?? '') : '' ?> 6. Email: </p>
                <p>7. Họ, chữ đệm và tên chủ hộ:
                    <span style="text-transform: uppercase;">
                        <?= (isset($chu_ho) && $chu_ho) ? htmlspecialchars($chu_ho['name']) : '' ?>
                    </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    8. Mối quan hệ với chủ hộ: <?= (isset($chu_ho) && $chu_ho) ? 'Chủ hộ' : '' ?>
                </p>
                <table class="cccd">
                    <tr>
                        <td class="cccd1">9. Số định danh cá nhân của chủ hộ:</td>
                        <?php
                        $cccd = (isset($chu_ho) && $chu_ho) ? str_split($chu_ho['cccd']) : [];
                        for ($i = 0; $i < 12; $i++) {
                            echo '<td style="text-align:center;">' . ($cccd[$i] ?? '') . '</td>';
                        }
                        ?>
                    </tr>
                </table>
                <p>10. Nội dung đề nghị <sup>(2)</sup>: <span id="contentText"></span></p>
                <p>11. Những thành viên trong hộ gia đình cùng thay đổi:</p>
            </div>
            <table class="detail">
                <thead>
                    <tr>
                        <th>TT</th>
                        <th>Họ, chữ đệm <br> và tên</th>
                        <th>Ngày, tháng, <br>năm sinh</th>
                        <th>Giới <br> tính</th>
                        <th>Số định danh <br>cá nhân</th>
                        <th>Mối quan hệ <br>với chủ hộ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($active_customers) == 2) {
                        $row = 1;
                        foreach ($thanh_vien as $tv) {
                            // Xác định giới tính từ số thứ 4 của cccd
                            $tv_gender = '';
                            if (!empty($tv['cccd']) && strlen($tv['cccd']) >= 4) {
                                $digit = (int)$tv['cccd'][3];
                                $tv_gender = ($digit % 2 == 0) ? 'Nam' : 'Nữ';
                            }
                            echo '<tr>';
                            echo '<td>' . $row++ . '</td>';
                            echo '<td>  <span style="text-transform: uppercase;">' . htmlspecialchars($tv['name']) . '</span></td>';
                            echo '<td>' . ($tv['dob'] ? date('d/m/Y', strtotime($tv['dob'])) : '') . '</td>';
                            echo '<td>' . $tv_gender . '</td>';
                            echo '<td>' . htmlspecialchars($tv['cccd']) . '</td>';
                            echo '<td></td>';
                            echo '</tr>';
                        }
                        // Thêm dòng trống cho đủ 9 dòng
                        // for ($i = $row; $i <= 9; $i++) {
                        //     echo '<tr><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td></tr>';
                        // }
                    } else {
                        // Nếu chỉ có 1 người, để trống toàn bộ bảng
                        for ($i = 1; $i <= 6; $i++) {
                            echo '<tr><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td></tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <table class="signature">
                <tr>
                    <td><i> ....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ HỘ<sup>(3)</sup></b></td>
                    <td><i> ....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ SỞ HỮU <br> CHỖ Ở HỢP PHÁP<sup>(4)</sup></b></td>
                    <td><i> ....., ngày ..... tháng ..... năm .....  </i> <br><b>Ý KIẾN CỦA CHA, MẸ <br>HOẶC NGƯỜI GIÁM HỘ<sup>(5)</sup> </b></td>
                    <td><i> ....., ngày ..... tháng ..... năm .....  </i> <br><b>NGƯỜI KÊ KHAI<sup>(6)</sup></b></td>
                </tr>
                <tr style="height:60px;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="vneid-infor">
                    <td></td>
                    <td>(7) Họ và tên: <br> TĂNG TIẾN QUẢNG
                        <br>(7) Số định danh cá nhân: <br>030070001028
                    </td>
                    <td>(7) Họ và tên: <br>..................
                        <br>(7) Số định danh cá nhân: <br>................
                    </td>
                    <td style="text-align:center"><b><?php echo isset($nguoi_khai) ? htmlspecialchars($nguoi_khai['name']) : '' ?></b></td>
                </tr>

            </table>
            <br><br><br>
    </div>
</div>
<!--  -->
<!-- <div class="container3">
            <h2>Không có tờ khai nào</h2>
            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php?controller=history" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #093d62; color: #fff; text-decoration: none; border-radius: 6px;">Quay lại</a>
            </div>
        </div> -->
<?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>

<script>
    // Initialize modal and date
    document.addEventListener('DOMContentLoaded', function() {
        initializeDates();
        setupEventListeners();
    });

    function initializeDates() {
        // Set current date
        const today = new Date();
        const dayStr = String(today.getDate()).padStart(2, '0');
        const monthStr = String(today.getMonth() + 1).padStart(2, '0');
        const yearStr = today.getFullYear();
        const currentDateText = dayStr + '/' + monthStr + '/' + yearStr;
        document.getElementById('currentDate').textContent = currentDateText;
    }

    function setupEventListeners() {
        // Setup duration change event
        document.getElementById('duration').addEventListener('change', updateExpiryDate);

        // Setup request content and address change events
        document.getElementById('requestContent').addEventListener('change', updateExpiryDate);
        document.getElementById('address').addEventListener('change', updateExpiryDate);
    }

    function updateExpiryDate() {
        const duration = document.getElementById('duration').value;
        const isNoExpiry = duration === 'noExpiry';

        if (isNoExpiry) {
            document.getElementById('datesGroup').style.display = 'none';
            document.getElementById('expiryDate').textContent = '';
            const content = document.getElementById('requestContent').value;
            const address = document.getElementById('address').value;
            const previewText = content + ' - ' + address;
            document.getElementById('previewText').textContent = 'Xem trước: ' + previewText;
            return;
        }

        document.getElementById('datesGroup').style.display = 'block';

        if (!duration) {
            document.getElementById('expiryDate').textContent = '';
            document.getElementById('previewText').textContent = '';
            return;
        }

        const today = new Date();
        const expiryDate = new Date(today);
        expiryDate.setMonth(expiryDate.getMonth() + parseInt(duration));

        const dayStr = String(expiryDate.getDate()).padStart(2, '0');
        const monthStr = String(expiryDate.getMonth() + 1).padStart(2, '0');
        const yearStr = expiryDate.getFullYear();
        const expiryDateText = dayStr + '/' + monthStr + '/' + yearStr;

        document.getElementById('expiryDate').textContent = expiryDateText;

        // Update preview text
        const content = document.getElementById('requestContent').value;
        const address = document.getElementById('address').value;
        const currentDateText = document.getElementById('currentDate').textContent;
        const previewText = content + ' thời hạn ' + duration + ' tháng, từ ngày ' + currentDateText + ' đến ngày ' + expiryDateText + ' tại địa chỉ ' + address;
        document.getElementById('previewText').textContent = 'Xem trước: ' + previewText;
    }

    function confirmContent() {
        const content = document.getElementById('requestContent').value;
        const duration = document.getElementById('duration').value;
        const address = document.getElementById('address').value;
        const isNoExpiry = duration === 'noExpiry';

        if (!content || !address) {
            alert('Vui lòng điền đầy đủ thông tin');
            return;
        }

        if (!duration) {
            alert('Vui lòng chọn thời hạn');
            return;
        }

        let finalText = '';

        if (isNoExpiry) {
            // Format: {nội dung} - {địa chỉ}
            finalText = content + ' - ' + address;
        } else {
            // Calculate dates
            const today = new Date();
            const expiryDate = new Date(today);
            expiryDate.setMonth(expiryDate.getMonth() + parseInt(duration));

            const dayStr = String(today.getDate()).padStart(2, '0');
            const monthStr = String(today.getMonth() + 1).padStart(2, '0');
            const yearStr = today.getFullYear();
            const currentDateText = dayStr + '/' + monthStr + '/' + yearStr;

            const expiryDayStr = String(expiryDate.getDate()).padStart(2, '0');
            const expiryMonthStr = String(expiryDate.getMonth() + 1).padStart(2, '0');
            const expiryYearStr = expiryDate.getFullYear();
            const expiryDateText = expiryDayStr + '/' + expiryMonthStr + '/' + expiryYearStr;

            // Build the content text
            finalText = content + ' thời hạn ' + duration + ' tháng, từ ngày ' + currentDateText + ' đến ngày ' + expiryDateText + ' tại địa chỉ ' + address;
        }

        // Update all contentText spans
        const contentTexts = document.querySelectorAll('#contentText');
        contentTexts.forEach(function(element) {
            element.textContent = finalText;
        });
    }

    function resetForm() {
        document.getElementById('requestContent').value = 'Đăng ký tạm trú';
        document.getElementById('duration').value = '';
        document.getElementById('address').value = 'Đội 6, thôn Minh Thành, xã Lai Khê, Thành phố Hải Phòng';
        document.getElementById('datesGroup').style.display = 'block';
        updateExpiryDate();
        const contentTexts = document.querySelectorAll('#contentText');
        contentTexts.forEach(function(element) {
            element.textContent = '';
        });
    }

    // Close modal when clicking outside of it
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('contentModal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>