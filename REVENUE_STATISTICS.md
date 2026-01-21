# Chức Năng Thống Kê Doanh Thu

## Mô Tả
Chức năng thống kê doanh thu từ bảng `nhatro_history` được tích hợp vào dashboard và cung cấp các báo cáo chi tiết theo tháng, theo năm, cũng như so sánh doanh thu giữa các năm.

## Các Trường Dữ Liệu Được Thống Kê

Chức năng này sử dụng các trường sau từ bảng `nhatro_history`:

- **e_total**: Tổng tiền điện
- **w_total**: Tổng tiền nước
- **tong_tien**: Tổng tiền (tổng phí)
- **discount**: Chiết khấu
- **total_discount**: Tổng tiền sau chiết khấu (doanh thu thực tế)
- **service_fee**: Phí dịch vụ

## Các Tệp Được Tạo/Sửa Đổi

### 1. **Model** - `admin/models/HistoryModel.php`
Thêm các method thống kê:

- `getMonthlyStats($month, $year)` - Lấy thống kê tổng quát theo tháng
- `getYearlyStats($year)` - Lấy thống kê tổng quát theo năm
- `getMonthlyRevenueByYear($year)` - Lấy doanh thu từng tháng trong năm
- `getMonthlyRevenueByRoom($month, $year)` - Lấy doanh thu theo phòng trong tháng
- `getYearlyRevenueAll()` - Lấy doanh thu tất cả các năm

### 2. **Controller** - `admin/controllers/RevenueController.php` (mới)
Xử lý các yêu cầu thống kê:

- `action=monthly` - Thống kê theo tháng
- `action=yearly` - Thống kê theo năm
- `action=comparison` - So sánh doanh thu giữa các năm

### 3. **View** - Dashboard và Revenue Views

#### `admin/views/dashboard.php` (sửa đổi)
- Thêm phần thống kê doanh thu vào dashboard
- Hiển thị thống kê theo tháng và năm
- Nút "Xem chi tiết" để link đến trang thống kê chi tiết

#### `admin/views/revenue_monthly.php` (mới)
- Thống kê doanh thu chi tiết theo tháng
- Bảng doanh thu từng phòng
- Filter theo tháng/năm

#### `admin/views/revenue_yearly.php` (mới)
- Thống kê doanh thu chi tiết theo năm
- Bảng doanh thu từng tháng trong năm
- Filter theo năm

#### `admin/views/revenue_comparison.php` (mới)
- So sánh doanh thu giữa các năm
- Bảng tổng hợp tất cả các năm

### 4. **Controller** - `admin/controllers/DashboardController.php` (sửa đổi)
Thêm require HistoryModel và các biến thống kê:

```php
require_once __DIR__ . '/../models/HistoryModel.php';

$monthlyRevenueStats = HistoryModel::getMonthlyStats($statMonth, $statYear);
$monthlyRevenueByRoom = HistoryModel::getMonthlyRevenueByRoom($statMonth, $statYear);
$yearlyRevenueStats = HistoryModel::getYearlyStats($statYearOnly);
$monthlyRevenueInYear = HistoryModel::getMonthlyRevenueByYear($statYearOnly);
$yearlyAllRevenueStats = HistoryModel::getYearlyRevenueAll();
```

## Cách Sử Dụng

### 1. Dashboard
- Vào **Dashboard** để xem thống kê doanh thu tổng quát của tháng hiện tại
- Nhấn nút **"Xem chi tiết →"** để xem báo cáo chi tiết

### 2. Trang Thống Kê Chi Tiết
URL: `index.php?controller=revenue&action=monthly`

**Các tab có sẵn:**
- **Theo Tháng** - Thống kê chi tiết theo tháng
- **Theo Năm** - Thống kê chi tiết theo năm
- **So Sánh** - So sánh doanh thu qua các năm

### 3. Thống Kê Theo Tháng
```
URL: index.php?controller=revenue&action=monthly&month=MM&year=YYYY
```
Hiển thị:
- Doanh thu tháng (sau chiết khấu)
- Tiền phòng, tiền điện, tiền nước, phí dịch vụ
- Bảng chi tiết doanh thu theo phòng

### 4. Thống Kê Theo Năm
```
URL: index.php?controller=revenue&action=yearly&year=YYYY
```
Hiển thị:
- Tổng doanh thu cả năm
- Bảng doanh thu chi tiết từng tháng
- So sánh các tháng trong năm

### 5. So Sánh Doanh Thu
```
URL: index.php?controller=revenue&action=comparison
```
Hiển thị:
- Bảng so sánh doanh thu tất cả các năm
- Tổng hợp doanh thu theo từng loại

## Các Chỉ Số Thống Kê

### Thống Kê Tháng:
- 💰 **Doanh Thu (Sau Chiết Khấu)**: `SUM(total_discount)`
- 🏠 **Tiền Phòng**: Có thể từ trường `tien_phong` hoặc tính toán
- 🌞 **Tiền Điện**: `SUM(e_total)`
- 💧 **Tiền Nước**: `SUM(w_total)`
- ⚙️ **Phí Dịch Vụ**: `SUM(service_fee)`
- 📊 **Số Hóa Đơn**: `COUNT(*)`
- 💵 **Doanh Thu Trung Bình**: `AVG(total_discount)`

### Thống Kê Năm:
- Cùng như tháng nhưng tính cho cả năm

## Ghi Chú

1. Format ngày tháng năm: Sử dụng `mmyy` (ví dụ: `012026` cho tháng 1 năm 2026)
2. Tất cả số tiền được format theo chuẩn Việt Nam (dấu phân cách hàng ngàn)
3. Dashboard chỉ hiển thị thống kê tháng/năm hiện tại
4. Có thể lọc theo tháng/năm tùy ý trong trang thống kê chi tiết
5. Yêu cầu table `nhatro_history` phải có các trường: `e_total`, `w_total`, `tong_tien`, `discount`, `total_discount`, `service_fee`, `mmyy`, `room`

## Ví Dụ SQL Query

### Lấy doanh thu tháng 1 năm 2026:
```sql
SELECT 
    SUM(total_discount) as total_revenue,
    SUM(e_total) as electricity_revenue,
    SUM(w_total) as water_revenue,
    SUM(service_fee) as service_revenue
FROM nhatro_history 
WHERE mmyy = '012026'
```

### Lấy doanh thu từng phòng:
```sql
SELECT 
    room,
    SUM(total_discount) as total_revenue,
    SUM(e_total) as electricity_revenue,
    SUM(w_total) as water_revenue
FROM nhatro_history 
WHERE mmyy = '012026'
GROUP BY room
ORDER BY room ASC
```

## Hỗ Trợ

Nếu có vấn đề:
1. Kiểm tra xem bảng `nhatro_history` có đúng các trường cần thiết
2. Kiểm tra format `mmyy` có đúng (2 chữ số tháng + 4 chữ số năm)
3. Kiểm tra kết nối database
