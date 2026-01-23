<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hợp đồng thuê trọ</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            line-height: 1.5;
            margin: 2.54cm;
            font-size: 16px;
        }

        h2,
        h3 {
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }

        .indent {
            margin-left: 30px;
        }

        @media print {
            @page {
                size: A4;
                margin: 2.54cm;
            }

            body {
                margin: 0;
                font-size: 16px;
                font-family: "Times New Roman", serif;
                line-height: 1.5;
            }
        }
    </style>
</head>

<body>
    <h3>CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>Độc lập - Tự do - Hạnh phúc</h3>
    <table style="width: 100%;">
        <tr>

            <td style="text-align: left;">
                <i>
                    Số <?= isset($customer['id']) ? str_pad($customer['id'], 3, '0', STR_PAD_LEFT) : '……' ?>/HĐTT
                </i>
            </td>
            <td style="text-align: right;">
                <i>
                    Lai Khê, ngày …. tháng …… năm 202….
                </i>
            </td>
        </tr>
    </table>
    <h2>HỢP ĐỒNG THUÊ TRỌ</h2>
    <p>Hôm nay, ngày …. tháng …. năm ….., tại Nhà trọ chú Quảng, đội 6, thôn Minh Thành, Lai Khê, Thành  phố Hải Phòng</p>
    <p class="section-title">Chúng tôi gồm có:</p>
    <p><strong>BÊN CHO THUÊ (BÊN A):</strong></p>
    <div class="indent">
        Ông/bà: TĂNG TIẾN QUẢNG<br>
        Năm sinh: 1970<br>
        CMND/CCCD số: 030070001028<br>
        Ngày cấp: ……/……/…………<br>
        Nơi cấp: Cục Cảnh sát QLHC về TTXH<br>
        Địa chỉ: Thôn Minh Thành, Lai Khê, TP Hải Phòng<br>
        Điện thoại: 0352153772<br>
        Là chủ sở hữu nhà trọ: Nhà trọ Chú Quảng
    </div>
    <p><strong>BÊN THUÊ (BÊN B):</strong></p>
    <div class="indent">
        Ông/bà: <?= htmlspecialchars($customer['name']) ?><br>
        Năm sinh: <?= htmlspecialchars($customer['dob']) ?><br>
        CMND/CCCD số: <?= htmlspecialchars($customer['cccd']) ?><br>
        Ngày cấp: <?= htmlspecialchars($customer['cccd_date']) ?> - Nơi cấp: <?= htmlspecialchars($customer['cccd_place']) ?><br>
        Nơi thường trú: <?= htmlspecialchars($customer['address']) ?><br>
        Điện thoại: <?= htmlspecialchars($customer['phone']) ?><br>
        Email: …………………………………………………………………………<br>
        Mã số thuế (nếu có): ……………………………………………………………<br>
        Tài khoản số: ………………………… tại ngân hàng: …………………………
    </div>
    <p class="section-title">ĐIỀU 1. ĐỐI TƯỢNG CỦA HỢP ĐỒNG</p>
    <p>Bên A đồng ý cho Bên B thuê phòng trọ số <b><?= htmlspecialchars($customer['room']) ?></b> tại địa chỉ Đội 6, thôn Minh Thành, Lai Khê, Kim Thành, Hải Dương thuộc sở hữu hợp pháp của Bên A.
        Chi tiết phòng như sau: <br>
        Bao gồm: Hệ thống điện nước đã sẵn sàng sử dụng được, các bóng đèn trong phòng, hệ thống điều hoà và bình nóng lạnh hoạt động tốt và hệ thống công tắc, các bồn rửa mặt, bồn vệ sinh đều sử dụng tốt.
    </p>


    <p class="section-title">ĐIỀU 2. GIÁ CHO THUÊ VÀ THANH TOÁN</p>
    <p>2.1. Giá cho thuê phòng trọ là <b>1.200.000 đồng/ tháng</b> <i>(Bằng chữ: Một triệu hai trăm nghìn đồng)</i> <br>
        Giá cho thuê này đã bao gồm các chi phí về quản lý, bảo trì và vận hành .
        <br>
        2.2. Các chi phí khác gồm: <br>
        Điện: 3.000 đồng/kWh <br>
        Nước: 15.000 đồng/khối <br>
        Phí thu gom rác và an ninh: 30.000 đồng/người <br>

        2.3. Bên B sẽ thanh toán tiền thuê phòng trọ cho Bên A vào ngày 10 đến 13 tháng, bằng tiền mặt hoặc chuyển khoản vào tài khoản của Bên A.
        <br>
    </p>

    <p class="section-title">ĐIỀU 3. THỜI HẠN THUÊ VÀ THỜI ĐIỂM GIAO NHẬN PHÒNG TRỌ
    </p>
    <p>3.1. Thời hạn thuê phòng trọ nêu trên là 06 tháng, kể từ ngày <?= isset($customer['created_at']) && $customer['created_at'] ? date('d/m/Y', strtotime($customer['created_at'])) : '……/……/……' ?> <br>
        3.2. Thời điểm giao nhận phòng trọ là ngày <?= isset($customer['created_at']) && $customer['created_at'] ? date('d', strtotime($customer['created_at'])) : '......' ?> tháng <?= isset($customer['created_at']) && $customer['created_at'] ? date('m', strtotime($customer['created_at'])) : '......' ?> năm <?= isset($customer['created_at']) && $customer['created_at'] ? date('Y', strtotime($customer['created_at'])) : '.........' ?>
    </p>

    <p class="section-title">ĐIỀU 4. NGHĨA VỤ VÀ QUYỀN CỦA BÊN A</p>
    <p>
        <b>
            4.1. Nghĩa vụ của bên A:
        </b> <br>
        a) Giao phòng trọ và trang thiết bị gắn liền với phòng trọ (nếu có) cho bên B theo đúng hợp đồng; <br>
        b) Phổ biến cho bên B quy định về quản lý sử dụng phòng trọ;<br>
        c) Bảo đảm cho bên B sử dụng ổn định nhà trong thời hạn thuê;<br>
        d) Bảo dưỡng, sửa chữa nhà theo định kỳ hoặc theo thỏa thuận; nếu bên A không bảo dưỡng, sửa chữa nhà mà gây thiệt hại cho bên B, thì phải bồi thường; <br>
        e) Tạo điều kiện cho bên B sử dụng thuận tiện diện tích thuê; <br>
        f) Nộp các khoản thuế về nhà và đất (nếu có); <br>
        g) Hướng dẫn, đôn đốc bên B thực hiện đúng các quy định về đăng ký tạm trú. <br>
        <b>
            4.2. Quyền của bên A:
        </b>
        <br>
        a) Yêu cầu bên B trả đủ tiền thuê nhà đúng kỳ hạn như đã thỏa thuận;<br>
        b) Trường hợp chưa hết hạn hợp đồng mà bên A cải tạo phòng và được bên B đồng ý thì bên A được quyền điều chỉnh giá cho thuê phòng trọ. Giá cho thuê phòng trọ mới do các bên thỏa thuận; trong trường hợp không thoả thuận được thì bên A có quyền đơn phương chấm dứt hợp đồng thuê phòng trọ và phải bồi thường cho bên B theo quy định của pháp luật;<br>
        c) Yêu cầu bên B có trách nhiệm trong việc sửa chữa phần hư hỏng, bồi thường thiệt hại do lỗi của bên B gây ra;<br>
        d) Cải tạo, nâng cấp nhà cho thuê khi được bên B đồng ý, nhưng không được gây phiền hà cho bên B sử dụng chỗ ở;<br>
        e) Được lấy lại nhà cho thuê khi hết hạn hợp đồng thuê, nếu hợp đồng không quy định thời hạn thuê thì bên cho thuê muốn lấy lại nhà phải báo cho bên thuê biết trước 03 ngày;<br>
        f) Đơn phương chấm dứt thực hiện hợp đồng thuê nhà nhưng phải báo cho bên B biết trước ít nhất 01 ngày nếu không có thỏa thuận khác và yêu cầu bồi thường thiệt hại nếu bên B có một trong các hành vi sau đây:<br>
        - Không trả tiền thuê nhà liên tiếp trong 3 tháng trở lên mà không có lý do chính đáng;<br>
        - Sử dụng nhà không đúng mục đích thuê như đã thỏa thuận trong hợp đồng;<br>
        - Tự ý đục phá, cơi nới, cải tạo, phá dỡ phòng trọ đang thuê;<br>
        - Bên B chuyển đổi, cho mượn, cho thuê lại phòng trọ đang thuê mà không có sự đồng ý của bên A;<br>
        - Làm mất trật tự, vệ sinh môi trường, ảnh hưởng nghiêm trọng đến sinh hoạt của những người xung quanh đã được bên A hoặc trưởng thôn nhắc nhở mà vẫn không khắc phục;<br>
        - Thuộc trường hợp khác theo quy định của pháp luật.<br>
    </p>

    <p class="section-title">ĐIỀU 5. NGHĨA VỤ VÀ QUYỀN CỦA BÊN B</p>
    <p>
        <b>
            5.1. Nghĩa vụ của bên B:<br>
        </b>
        a) Sử dụng nhà đúng mục đích đã thỏa thuận, giữ gìn phòng trọ và có trách nhiệm trong việc sửa chữa những hư hỏng do mình gây ra;<br>
        b) Trả đủ tiền thuê nhà đúng kỳ hạn đã thỏa thuận;<br>
        c) Trả tiền điện, nước, dịch vụ và các chi phí phát sinh khác trong thời gian thuê nhà;<br>
        d) Trả nhà cho bên A theo đúng thỏa thuận.<br>
        e) Chấp hành đầy đủ những quy định về quản lý sử dụng phòng trọ.<br>
        f) Không được chuyển nhượng hợp đồng thuê nhà hoặc cho người khác thuê lại trừ trường hợp được bên A đồng ý bằng văn bản;<br>
        g) Chấp hành các quy định về giữ gìn vệ sinh môi trường và an ninh trật tự trong khu vực cư trú;<br>
        h) Giao lại nhà cho bên A trong các trường hợp chấm dứt hợp đồng.<br>
        <b>
            5.2. Quyền của bên B:
        </b>
        a) Nhận phòng trọ và trang thiết bị gắn liền (nếu có) theo đúng thỏa thuận;<br>
        b) Được đổi nhà đang thuê với bên thuê khác, nếu được bên A đồng ý bằng văn bản;<br>
        c) Được cho thuê lại phòng đang thuê, nếu được bên cho thuê đồng ý bằng văn bản;<br>
        d) Yêu cầu bên A sửa chữa nhà đang cho thuê trong trường hợp nhà bị hư hỏng nặng;<br>
        e) Được ưu tiên ký hợp đồng thuê tiếp, nếu đã hết hạn thuê mà nhà vẫn dùng để cho thuê;<br>
        g) Thông báo cho bên A trước khi trả phòng trọ 3 ngày.<br>
        g)Đơn phương chấm dứt thực hiện hợp đồng thuê nhà nhưng phải báo cho bên A biết trước ít nhất 30 ngày nếu không có thỏa thuận khác và yêu cầu bồi thường thiệt hại nếu bên A có một trong các hành vi sau đây:<br>
        - Không sửa chữa phòng trọ khi có hư hỏng nặng;<br>
        - Tăng giá thuê phòng trọ bất hợp lý hoặc tăng giá thuê mà không thông báo cho bên thuê phòng trọ biết trước theo thỏa thuận;<br>
        - Quyền sử dụng phòng trọ bị hạn chế do lợi ích của người thứ ba.<br>
    </p>

    <p class="section-title">ĐIỀU 6. QUYỀN TIẾP TỤC THUÊ PHÒNG</p>
    <p>
        6.1. Trường hợp chủ sở hữu phòng trọ chết mà thời hạn thuê phòng trọ vẫn còn thì bên B được tiếp tục thuê đến hết hạn hợp đồng. Người thừa kế có trách nhiệm tiếp tục thực hiện hợp đồng thuê phòng trọ đã ký kết trước đó, trừ trường hợp các bên có thỏa thuận khác. Trường hợp chủ sở hữu không có người thừa kế hợp pháp theo quy định của pháp luật thì phòng trọ đó thuộc quyền sở hữu của Nhà nước và người đang thuê phòng trọ được tiếp tục thuê theo quy định về quản lý, sử dụng phòng trọ thuộc sở hữu nhà nước.<br>
        6.2. Trường hợp chủ sở hữu phòng trọ chuyển quyền sở hữu phòng trọ đang cho thuê cho người khác mà thời hạn thuê phòng trọ vẫn còn thì bên B được tiếp tục thuê đến hết hạn hợp đồng; chủ sở hữu phòng trọ mới có trách nhiệm tiếp tục thực hiện hợp đồng thuê phòng trọ đã ký kết trước đó, trừ trường hợp các bên có thỏa thuận khác.<br>
        6.3. Khi bên B chết mà thời hạn thuê phòng trọ vẫn còn thì người đang cùng sinh sống với bên B được tiếp tục thuê đến hết hạn hợp đồng thuê phòng trọ, trừ trường hợp thuê nhà ở công vụ hoặc các bên có thỏa thuận khác hoặc pháp luật có quy định khác.<br>
    </p>

    <p class="section-title">ĐIỀU 7. TRÁCH NHIỆM DO VI PHẠM HỢP ĐỒNG</p>
    <p>Trong quá trình thực hiện hợp đồng mà phát sinh tranh chấp, các bên cùng nhau thương lượng giải quyết; trong trường hợp không tự giải quyết được, cần phải thực hiện bằng cách hòa giải; nếu hòa giải không thành thì đưa ra Tòa án có thẩm quyền theo quy định của pháp luật.</p>

    <p class="section-title">ĐIỀU 8. CÁC THỎA THUẬN KHÁC</p>
    <p>
        8.1. Việc sửa đổi, bổ sung hoặc hủy bỏ hợp đồng này phải lập thành văn bản mới có giá trị để thực hiện.<br>
        8.2. Việc chấm dứt hợp đồng thuê phòng trọ được thực hiện khi có một trong các trường hợp sau đây:<br>
        a) Hợp đồng thuê phòng trọ hết hạn; trường hợp trong hợp đồng không xác định thời hạn thì hợp đồng chấm dứt sau 90 ngày, kể từ ngày bên A thông báo cho bên B biết việc chấm dứt hợp đồng;<br>
        b) Phòng trọ cho thuê không còn;<br>
        c) Phòng trọ cho thuê bị hư hỏng nặng, có nguy cơ sập đổ hoặc thuộc khu vực đã có quyết định thu hồi đất, giải tỏa nhà ở hoặc có quyết định phá dỡ của cơ quan nhà nước có thẩm quyền; nhà ở cho thuê thuộc diện bị Nhà nước trưng mua, trưng dụng để sử dụng vào các mục đích khác.<br>
        Bên A phải thông báo bằng văn bản cho bên B biết trước 30 ngày về việc chấm dứt hợp đồng thuê phòng trọ quy định tại điểm này, trừ trường hợp các bên có thỏa thuận khác;<br>
        d) Hai bên thỏa thuận chấm dứt hợp đồng trước thời hạn;<br>
        e) Bên B chết hoặc có tuyên bố mất tích của Tòa án mà khi chết, mất tích không có ai đang cùng chung sống;<br>
        f) Chấm dứt khi một trong các bên đơn phương chấm dứt thực hiện hợp đồng thuê phòng trọ.<br>
    </p>

    <p class="section-title">ĐIỀU 9. CAM KẾT CỦA CÁC BÊN</p>
    <p>
        Bên A và bên B chịu trách nhiệm trước pháp luật về những lời cùng cam kết sau đây:<br>
        9.1. Đã khai đúng sự thật và tự chịu trách nhiệm về tính chính xác của những thông tin về nhân thân đã ghi trong hợp đồng này.<br>
        9.2. Thực hiện đúng và đầy đủ tất cả những thỏa thuận đã ghi trong hợp đồng này; nếu bên nào vi phạm mà gây thiệt hại, thì phải bồi thường cho bên kia hoặc cho người thứ ba (nếu có).<br>
        Trong quá trình thực hiện nếu phát hiện thấy những vấn đề cần thoả thuận thì hai bên có thể lập thêm Phụ lục hợp đồng. Nội dung Phụ lục hợp đồng có giá trị pháp lý như hợp đồng chính.<br>
        9.3. Hợp đồng này có giá trị kể từ ngày hai bên ký kết.<br>
        Hợp đồng được lập thành 02 (hai) bản, mỗi bên giữ một bản và có giá trị như nhau.<br>
    </p>

    <br>
    <table style="width: 100%; text-align: center;">
        <tr>
            <th>BÊN CHO THUÊ</th>
            <th>BÊN THUÊ</th>
        </tr>
        <tr>
            <td>Ký, ghi rõ họ và tên</td>
            <td>Ký, ghi rõ họ và tên</td>

        </tr>
    </table>
</body>

</html>