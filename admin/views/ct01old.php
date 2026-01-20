<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>TỜ KHAI THAY ĐỔI THÔNG TIN CƯ TRÚ</title>
    <style>
        /* ...copy toàn bộ style từ view mẫu bạn cung cấp... */
        body {
            font-family: "Times New Roman", serif;
            /* margin: 40px; */
            font-size: 16px;
            line-height: 1.6;
        }

        h2,
        h3 {
            font-size: 16px;
            text-align: center;
            margin: 0;
        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .content {
            /* font-size: 15px; */
            padding: 0
        }

        .detail {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            /* margin-top: 10px; */
        }

        .detail,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        .detail td {
            height: 17px;
        }

        .cccd {
            border-collapse: collapse;
            width: 100%;
            /* font-size: 15px; */
        }

        .cccd td {
            text-align: left;
        }

        .cccd td:first-child {
            width: 40%;
            border: none;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }

        ol {
            margin-top: 10px;
        }

        hr {
            margin: 30px 0;
        }

        .signature {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            border: 0px solid black;
        }

        .signature td {
            width: 25%;
            text-align: center;
            vertical-align: top;
            border: 0px solid black;
        }
        .signature td i{
            font-size: 12px;
        }

        .signature .vneid-infor td {
            font-size: 12px;
            text-align: left;
            padding-top: 0;
            font-size: 10px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
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
            background: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 14px;
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

        .print-buttons {
            margin-bottom: 20px;
            text-align: center;
        }

        .print-buttons button,
        .print-buttons a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            background-color: #093d62;
            color: white;
            text-decoration: none;
        }

        .print-buttons button:hover,
        .print-buttons a:hover {
            background-color: #1e7e34;
        }

        @media print {
            .print-buttons {
                display: none;
            }
            .modal {
                display: none;
            }
        }
    </style>
</head>

<body>
<!-- Modal for requesting content -->
<div id="contentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Nhập nội dung đề nghị</div>
        <form id="contentForm">
            <div class="form-group">
                <label for="requestContent">Nội dung đề nghị:</label>
                <input type="text" id="requestContent" name="requestContent" value="Đăng ký tạm trú" required>
            </div>
            <div class="form-group">
                <label for="duration">Thời hạn:</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <select id="duration" name="duration">
                        <option value="">Chọn thời hạn</option>
                        <option value="3">3 tháng</option>
                        <option value="6">6 tháng</option>
                        <option value="9">9 tháng</option>
                        <option value="12">12 tháng</option>
                    </select>
                    <label style="display: flex; align-items: center; gap: 5px; margin: 0; font-weight: normal;">
                        <input type="checkbox" id="noExpiry" name="noExpiry">
                        Không có thời hạn
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ nhà trọ:</label>
                <input type="text" id="address" name="address" value="Đội 6, thôn Minh Thành, xã Lai Khê, Thành phố Hải Phòng" required>
            </div>
            <div class="form-group" id="datesGroup">
                <label>Ngày in: <span id="currentDate"></span></label>
                <label>Ngày hết hạn: <span id="expiryDate" style="color: #093d62; font-weight: bold;"></span></label>
            </div>
            <div class="info-text" id="previewText"></div>
            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeModal()">Hủy</button>
                <button type="button" class="btn-confirm" onclick="confirmContent()">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<div class="print-buttons">
    <button onclick="openModal()">Nhập nội dung đề nghị</button>
    <button onclick="window.print()">In tài liệu</button>
</div>

<?php if (isset($all_ct01)): ?>
<?php foreach ($all_ct01 as $active_customers): ?>
<div style="page-break-after: always;">
    <p style="text-align:center; font-size:14px;">
            Mẫu CT01 ban hành kèm theo Thông tư số 53/2025/TT-BCA<br>
            ngày 01/07/2025 của Bộ trưởng Bộ Công an
        </p>
    <div class="center title">
        <b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </b><br>
        <i>Độc lập – Tự do – Hạnh phúc</i>
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
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ HỘ<sup>(3)</sup></b></td>
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ SỞ HỮU <br> CHỖ Ở HỢP PHÁP<sup>(4)</sup></b></td>
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHA, MẸ <br>HOẶC NGƯỜI GIÁM HỘ<sup>(5)</sup> </b></td>
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>NGƯỜI KÊ KHAI<sup>(6)</sup></b></td>
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
    <br><br><br>
</div>
<?php endforeach; ?>
<?php else: ?>
    <p style="text-align:center; font-size:13px;"><i>
            Mẫu CT01 ban hành kèm theo Thông tư số 53/2025/TT-BCA<br>
            ngày 01/07/2025 của Bộ trưởng Bộ Công an
        </i></p>
    <div class="center title">
        <b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </b><br>
        <i>Độc lập – Tự do – Hạnh phúc</i>
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
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ HỘ<sup>(3)</sup></b></td>
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHỦ SỞ HỮU <br> CHỖ Ở HỢP PHÁP<sup>(4)</sup></b></td>
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>Ý KIẾN CỦA CHA, MẸ <br>HOẶC NGƯỜI GIÁM HỘ<sup>(5)</sup> </b></td>
            <td><i>....., ngày ..... tháng ..... năm ..... </i> <br><b>NGƯỜI KÊ KHAI<sup>(6)</sup></b></td>
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
    <!-- <p class="section-title">Chú thích:</p>
    
(1) Cơ quan đăng ký cư trú. <br>
(2) Ghi rõ ràng, cụ thể nội dung đề nghị. Ví dụ: đăng ký thường trú; đăng ký tạm trú; tách
hộ; xác nhận thông tin về cư trú... <br>
(3) Áp dụng đối với các trường hợp quy định tại khoản 2, khoản 3, khoản 5, khoản 6 Điều
20; khoản 1 Điều 25; điểm a khoản 1 Điều 26 Luật Cư trú. Việc lấy ý kiến của chủ hộ
được thực hiện theo các phương thức sau: <br>
a) Chủ hộ ghi rõ nội dung đồng ý và ký, ghi rõ họ tên vào Tờ khai. <br>
b) Chủ hộ xác nhận nội dung đồng ý thông qua ứng dụng VNeID hoặc các dịch vụ công
trực tuyến khác. <br>
c) Chủ hộ có văn bản riêng ghi rõ nội dung đồng ý (văn bản này không phải công chứng,
chứng thực). <br>
(4) Áp dụng đối với các trường hợp quy định tại khoản 2, khoản 3, khoản 4, khoản 5,
khoản 6 Điều 20; khoản 1 Điều 25 Luật Cư trú; điểm a khoản 1 Điều 26 Luật Cư trú. Việc
lấy ý kiến của chủ sở hữu chỗ ở hợp pháp được thực hiện theo các phương thức sau: <br>
a) Chủ sở hữu chỗ ở hợp pháp ghi rõ nội dung đồng ý và ký, ghi rõ họ tên vào Tờ khai.
b) Chủ sở hữu chỗ ở hợp pháp xác nhận nội dung đồng ý thông qua ứng dụng VNeID
hoặc các dịch vụ công trực tuyến khác.  <br>
c) Chủ sở hữu chỗ ở hợp pháp có văn bản riêng ghi rõ nội dung đồng ý (văn bản này
không phải công chứng, chứng thực). <br>
Ghi chú: Trường hợp chủ sở hữu hợp chỗ ở hợp pháp gồm nhiều cá nhân, tổ chức thì phải
có ý kiến đồng ý của tất cả các đồng sở hữu trừ trường hợp đã có thỏa thuận về việc cử đại
diện có ý kiến đồng ý; Trường hợp chủ sở hữu chỗ ở hợp pháp xác nhận nội dung đồng ý
thông qua ứng dụng VNeID thì công dân phải kê khai thông tin về họ, chữ đệm, tên và số
ĐDCN của chủ sở hữu chỗ ở hợp pháp. <br>
(5) Áp dụng đối với trường hợp người chưa thành niên, người hạn chế hành vi dân sự,
người không đủ năng lực hành vi dân sự có thay đổi thông tin về cư trú. Việc lấy ý kiến
của cha, mẹ hoặc người giám hộ được thực hiện theo các phương thức sau:  <br>
a) Cha, mẹ hoặc người giám hộ ghi rõ nội dung đồng ý và ký, ghi rõ họ tên vào Tờ khai. <br>
b) Cha, mẹ hoặc người giám hộ xác nhận nội dung đồng ý thông qua ứng dụng VNeID
hoặc các dịch vụ công trực tuyến khác. <br>
c) Cha, mẹ hoặc người giám hộ có văn bản riêng ghi rõ nội dung đồng ý (văn bản này
không phải công chứng, chứng thực). <br>
(6) Trường hợp nộp trực tiếp người kê khai ký, ghi rõ họ, chữ đệm và tên vào Tờ khai. Trường hợp
nộp qua cổng dịch vụ công hoặc ứng dụng VNeID thì người kê khai không phải ký vào mục này. <br>
(7) Chỉ kê khai thông tin khi công dân đề nghị xác nhận nội dung đồng ý thông qua ứng
dụng VNeID  <br> -->
<?php endif; ?>

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
    
    // Setup noExpiry checkbox event
    document.getElementById('noExpiry').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('duration').required = false;
            document.getElementById('datesGroup').style.display = 'none';
            document.getElementById('duration').value = '';
        } else {
            document.getElementById('duration').required = true;
            document.getElementById('datesGroup').style.display = 'block';
        }
        updateExpiryDate();
    });
    
    // Setup request content and address change events
    document.getElementById('requestContent').addEventListener('change', updateExpiryDate);
    document.getElementById('address').addEventListener('change', updateExpiryDate);
}

function updateExpiryDate() {
    const noExpiry = document.getElementById('noExpiry').checked;
    const duration = document.getElementById('duration').value;
    
    if (noExpiry) {
        document.getElementById('expiryDate').textContent = '';
        const content = document.getElementById('requestContent').value;
        const address = document.getElementById('address').value;
        const previewText = content + ' - ' + address;
        document.getElementById('previewText').textContent = 'Xem trước: ' + previewText;
        return;
    }
    
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

function openModal() {
    document.getElementById('contentModal').style.display = 'block';
    updateExpiryDate();
}

function closeModal() {
    document.getElementById('contentModal').style.display = 'none';
}

function confirmContent() {
    const content = document.getElementById('requestContent').value;
    const duration = document.getElementById('duration').value;
    const address = document.getElementById('address').value;
    const noExpiry = document.getElementById('noExpiry').checked;
    
    if (!content || !address) {
        alert('Vui lòng điền đầy đủ thông tin');
        return;
    }
    
    if (!noExpiry && !duration) {
        alert('Vui lòng chọn thời hạn hoặc chọn không có thời hạn');
        return;
    }
    
    let finalText = '';
    
    if (noExpiry) {
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
    
    closeModal();
}

// Close modal when clicking outside of it
window.addEventListener('click', function(event) {
    const modal = document.getElementById('contentModal');
    if (event.target === modal) {
        closeModal();
    }
});
</script>
</body>

</html>
