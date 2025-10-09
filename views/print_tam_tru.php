<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>TỜ KHAI THAY ĐỔI THÔNG TIN CƯ TRÚ</title>
    <style>
        /* ...copy toàn bộ style từ view mẫu bạn cung cấp... */
        body { font-family: "Times New Roman", serif; margin: 40px; font-size: 14px; line-height: 1.6; }
        h2, h3 { font-size: 14px; text-align: center; margin: 0; }
        .center { text-align: center; }
        .title { font-size: 14px; margin-bottom: 10px; }
        .detail { width: 100%; border-collapse: collapse; font-size: 11px; margin-top: 10px; }
        .detail, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; vertical-align: middle; }
        .detail td {height: 17px;}
        .cccd { border-collapse: collapse; width: 100%; }
        .cccd td { text-align: left; }
        .cccd td:first-child { width: 40%; border: none; }
        .section-title { font-weight: bold; margin-top: 20px; }
        ol { margin-top: 10px; }
        hr { margin: 30px 0; }
        .signature { width: 100%; border-collapse: collapse; font-size: 11px;  border: 0px solid black; }
        .signature td { width: 25%; height: 100px; text-align: center; vertical-align: top; padding: 10px; border: 0px solid black; }
    </style>
</head>
<body>
    <p style="text-align:right ;"><i>
        Mẫu CT01 ban hành kèm theo Thông tư số 66/2023/TT-BCA<br>
        ngày 17/11/2023 của Bộ trưởng Bộ Công an
    </i></p>
    <div class="center title">
        <b>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM </b><br>
        <i>Độc lập – Tự do – Hạnh phúc</i>
    </div>
    <h2>TỜ KHAI THAY ĐỔI THÔNG TIN CƯ TRÚ</h2>
    <p><strong>Kính gửi<sup>(1)</sup>:</strong> Công an xã Lai Khê, TP Hải Phòng</p>
    <?php
    // Xác định chủ hộ và thành viên
    $chu_ho = null;
    $thanh_vien = [];
    if (count($active_customers) == 1) {
        // Chỉ có người khai, không có chủ hộ, không có thành viên
        $nguoi_khai = $active_customers[0];
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
    <p>1. Họ, chữ đệm và tên: 

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
?>  </p>
<table class="cccd" style="font-size:14px">
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
    8. Mối quan hệ với chủ hộ: <?= (isset($chu_ho) && $chu_ho) ? 'Chủ hộ' : '' ?></p>
<table class="cccd" style="font-size:14px">
    <tr>
        <td class="cccd1">4. Số định danh cá nhân của chủ hộ:</td>
        <?php
        $cccd = (isset($chu_ho) && $chu_ho) ? str_split($chu_ho['cccd']) : [];
        for ($i = 0; $i < 12; $i++) {
            echo '<td style="text-align:center;">' . ($cccd[$i] ?? '') . '</td>';
        }
        ?>
    </tr>
</table>
<p>10. Nội dung đề nghị <sup>(2)</sup>: Đăng ký tạm trú thời hạn ..... tháng tại địa chỉ: Đội 6, thôn Minh Thành, xã Lai Khê, Thành phố Hải Phòng</p>
    <p>11. Những thành viên trong hộ gia đình cùng thay đổi:</p>
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
                for ($i = $row; $i <= 9; $i++) {
                    echo '<tr><td> </td><td> </td><td> </td><td> </td><td> </td><td> </td></tr>';
                }
            } else {
                // Nếu chỉ có 1 người, để trống toàn bộ bảng
                for ($i = 1; $i <= 9; $i++) {
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

    </table>
    <br><br><br>
    <p class="section-title">Chú thích:</p>
    
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
dụng VNeID  <br>
</body>
</html>
