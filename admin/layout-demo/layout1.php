<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn dịch vụ phòng trọ</title>
    <link rel="shortcut icon" href="itro-logo-vuong.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .container {
            max-width: 960px;
            margin: 40px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            padding: 30px 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 15px;
            border-bottom: 3px solid #0d47a1;
        }

        .header h2 {
            font-size: 28px;
            color: #0d47a1;
            margin-bottom: 6px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 2px 0;
            font-size: 15px;
            color: #333;
        }

        .invoice-card {
            border: 1px solid #dce3f0;
            border-radius: 10px;
            margin-bottom: 35px;
            padding: 25px;
            background: #fafbff;
        }

        .section-title {
            font-weight: 700;
            color: #1a237e;
            margin: 20px 0 10px;
            font-size: 17px;
            text-transform: uppercase;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 20px;
            margin-bottom: 10px;
        }

        .info-item {
            background: #fff;
            border: 1px solid #e0e4ec;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            color: #0d47a1;
            font-weight: 600;
        }

        .sub-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .sub-table th {
            background: #1a237e;
            color: #fff;
            padding: 8px;
            font-weight: 500;
            text-align: center;
        }

        .sub-table td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .highlight {
            background: #e3f2fd;
            font-weight: bold;
            color: #0d47a1;
        }

        .total-section {
            background: #f0f4ff;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        .total-section div {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 15px;
        }

        .total-section .total-pay {
            font-weight: 700;
            color: #1a237e;
            font-size: 18px;
            border-top: 2px solid #ccc;
            padding-top: 10px;
            margin-top: 5px;
        }

        .qr-box {
            text-align: center;
            margin-top: 25px;
        }

        .qr-box img {
            width: 130px;
            height: 130px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
            padding: 8px;
        }

        .error-message {
            text-align: center;
            padding: 25px;
            font-size: 18px;
            color: #c62828;
            background: #ffebee;
            border-radius: 8px;
        }

        a.back-link {
            display: block;
            width: fit-content;
            margin: 25px auto 0;
            padding: 10px 25px;
            background: #1a237e;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        a.back-link:hover {
            background: #303f9f;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .container {
                padding: 20px;
            }
        }
		@media print {
            body{
                background: #fff;
            }
            header{
                display:none;
            }
            footer {
                display:none;
            }
            .container{
                width: 100%;
                margin: 0px;
                border-radius: 0px;
            	box-shadow: 0 0 0;
            	padding: 10px 0px;
            }
            .header{
                margin-bottom: 10px;
                padding-bottom: 10px;
            }
            .invoice-card {
            border: none;
            /* border-radius: 10px; */
            margin-bottom: 35px;
            padding: 5px;
            background: #fafbff;
            }
            .info-item {
                border: none;
            }
        .section-title {
            font-weight: 700;
            color: #1a237e;
            margin: 10px 0 10px;
            font-size: 17px;
            text-transform: uppercase;
        }


            .back-link{
                display:none;
            }
		}
    </style>
</head>
<body>
        <?php include 'views/partials/header.php'; ?>

<div class="container">
    <div class="header">
        <h2>NHÀ TRỌ CHÚ QUẢNG</h2>
        <p>Địa chỉ: Đội 6, thôn Minh Thành, Lai Khê, TP Hải Phòng</p>
        <p>SĐT: 0352.153.772</p>
    </div>
    <h2 style="text-align:center;"> HÓA ĐƠN DỊCH VỤ PHÒNG TRỌ </h2>
    <?php if (!empty($results)): ?>
        <?php foreach ($results as $row): ?>
            <div class="invoice-card">
                <?php
                require_once __DIR__ . '/../config/database.php';
                $electric = null;
                $water = null;
                if ($row['electricity_id']) {
                    $stmt2 = $pdo->prepare('SELECT * FROM electricity WHERE id = ?');
                    $stmt2->execute([$row['electricity_id']]);
                    $electric = $stmt2->fetch();
                }
                if ($row['water_id']) {
                    $stmt3 = $pdo->prepare('SELECT * FROM water WHERE id = ?');
                    $stmt3->execute([$row['water_id']]);
                    $water = $stmt3->fetch();
                }
                $so_nguoi = isset($row['so_nguoi']) ? (int)$row['so_nguoi'] : 1;
                $phi_dv = $so_nguoi === 1 ? 30000 : ($so_nguoi === 2 ? 50000 : 0);
                ?>

                <div class="section-title">Thông tin chung</div>
                <div class="info-grid">
                    <div class="info-item"><span class="info-label">Phòng</span><span class="info-value"><?= $room ?></span></div>
                    <div class="info-item"><span class="info-label">Tháng</span><span class="info-value"><?= $month ?>/<?=$year?></span></div>
                    <div class="info-item"><span class="info-label">Tiền phòng</span><span class="info-value"><?= number_format($row['tien_phong']) ?> đ</span></div>
                    <div class="info-item"><span class="info-label">Phí dịch vụ</span><span class="info-value"><?= number_format($phi_dv) ?> đ</span></div>
                    <!--<div class="info-item"><span class="info-label">Trạng thái</span><span class="info-value"><?= htmlspecialchars($row['status']) ?></span></div>-->
                </div>

                <div class="section-title">Chi tiết điện</div>
                <?php if ($electric): ?>
                    <table class="sub-table">
                        <tr><th>CSC</th><th>CSM</th><th>Tiêu thụ</th><th>Đơn giá</th><th>Tổng tiền</th></tr>
                        <tr>
                            <td><?= htmlspecialchars($electric['CSC']) ?></td>
                            <td><?= htmlspecialchars($electric['CSM']) ?></td>
                            <td><?= htmlspecialchars($electric['DTT']) ?></td>
                            <td><?= number_format($electric['unit_price']) ?></td>
                            <td class="highlight"><?= number_format($electric['total']) ?> đ</td>
                        </tr>
                    </table>
                <?php else: ?>
                    <div class="info-item"><span>Không có dữ liệu điện</span></div>
                <?php endif; ?>

                <div class="section-title">Chi tiết nước</div>
                <?php if ($water): ?>
                    <table class="sub-table">
                        <tr><th>CSC</th><th>CSM</th><th>Tiêu thụ</th><th>Đơn giá</th><th>Tổng tiền</th></tr>
                        <tr>
                            <td><?= htmlspecialchars($water['CSC']) ?></td>
                            <td><?= htmlspecialchars($water['CSM']) ?></td>
                            <td><?= htmlspecialchars($water['DTT']) ?></td>
                            <td><?= number_format($water['unit_price']) ?></td>
                            <td class="highlight"><?= number_format($water['total']) ?> đ</td>
                        </tr>
                    </table>
                <?php else: ?>
                    <div class="info-item"><span>Không có dữ liệu nước</span></div>
                <?php endif; ?>

                <div class="section-title">Tổng kết</div>
                <div class="total-section">
                    <div><span>Tổng tiền:</span><span><?= number_format($row['tong_tien']) ?> đ</span></div>
                    <div><span>Giảm giá:</span><span>- <?= number_format($row['discount']) ?> đ</span></div>
                    <div class="total-pay"><span>Cần thanh toán:</span><span><?= number_format($row['total_discount']) ?> đ</span></div>
                </div>
                <?php if ($row['status'] !== 'Đã thanh toán'): ?>
                    <!-- <div class="section-title">Thanh toán</div> -->
                    <?php if (!empty($row['qr_url'])): ?>
                        <div class="qr-box">
                            <img src="<?= htmlspecialchars($row['qr_url']) ?>" alt="QR thanh toán">
                            <div style="margin-top:6px;color:#555;">Quét mã để thanh toán nhanh</div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                	<p style="text-align:center;">Hóa đơn đã được thanh toán<p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="error-message">Không tìm thấy hóa đơn phù hợp.</div>
    <?php endif; ?>

<!---    <a href="?action=history_search" class="back-link">← Quay lại tra cứu</a> -->
</div>
<?php include 'views/partials/footer.php'; ?>

</body>
</html>
