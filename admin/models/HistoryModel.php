<?php
// models/HistoryModel.php
require_once __DIR__ . '/../db.php';
class HistoryModel
{
    public static function getAll()
    {
        global $pdo;
        $sql = "SELECT h.*, 
            e.total AS tien_dien, e.CSC AS CSC, e.CSM AS CSM, e.DTT AS DTT, 
            w.total AS tien_nuoc, w.CSC AS CSC_NUOC, w.CSM AS CSM_NUOC, w.DTT AS DTT_NUOC, r.room_code AS room_code
            FROM nhatro_history h
            LEFT JOIN electricity e ON h.electricity_id = e.id
            LEFT JOIN water w ON h.water_id = w.id
            LEFT JOIN room r ON h.room_id = r.id
            ORDER BY h.id DESC";
        $rows = $pdo->query($sql)->fetchAll();
        // Ensure fields always exist (even if null)
        foreach ($rows as &$row) {
            foreach (['CSC', 'CSM', 'DTT', 'CSC_NUOC', 'CSM_NUOC', 'DTT_NUOC', 'e_old', 'e_new', 'e_used', 'e_unit_price', 'e_total', 'w_old', 'w_new', 'w_used', 'w_unit_price', 'w_total'] as $k) {
                if (!array_key_exists($k, $row) || $row[$k] === null) $row[$k] = '';
            }
        }
        return $rows;
    }
    public static function filter($room = '', $month = '', $status = '')
    {
        global $pdo;
        $sql = "SELECT h.*, 
                e.total AS tien_dien, e.CSC AS CSC, e.CSM AS CSM, e.DTT AS DTT, 
                w.total AS tien_nuoc, w.CSC AS CSC_NUOC, w.CSM AS CSM_NUOC, w.DTT AS DTT_NUOC,
                r.room_code AS room_code
            FROM nhatro_history h
            LEFT JOIN electricity e ON h.electricity_id = e.id
            LEFT JOIN water w ON h.water_id = w.id
            LEFT JOIN room r ON h.room_id = r.id
            WHERE 1=1";

        $params = [];

        if ($room !== '') {
            $sql .= " AND r.room_code = ?";
            $params[] = $room;
        }

        if ($month !== '') {
            $sql .= " AND h.month = ?";
            $params[] = $month;
        }

        if ($status !== '') {
            $sql .= " AND h.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY h.id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        // Ensure fields always exist (even if null)
        foreach ($rows as &$row) {
            foreach (['CSC', 'CSM', 'DTT', 'CSC_NUOC', 'CSM_NUOC', 'DTT_NUOC', 'e_old', 'e_new', 'e_used', 'e_unit_price', 'e_total', 'w_old', 'w_new', 'w_used', 'w_unit_price', 'w_total'] as $k) {
                if (!array_key_exists($k, $row) || $row[$k] === null) $row[$k] = '';
            }
        }
        return $rows;
    }

    public static function markPaid($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE nhatro_history SET status='Đã thanh toán' WHERE id=?");
        return $stmt->execute([$id]);
    }
    public static function markPaidMultiple($ids = [])
    {
        global $pdo;
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE nhatro_history SET status='Đã thanh toán' WHERE id IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($ids);
    }

    public static function delete($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM nhatro_history WHERE id=?");
        return $stmt->execute([$id]);
    }
    // Tra cứu hóa đơn theo room, month, year
    public static function findInvoices($room, $month = null, $year = null)
    {
        global $pdo;
        $sql = "SELECT * FROM nhatro_history WHERE room = ?";
        $params = [$room];
        if ($month) {
            $sql .= " AND month = ?";
            $params[] = $month;
        }
        if ($year) {
            $sql .= " AND year = ?";
            $params[] = $year;
        }
        $sql .= " ORDER BY year DESC, month DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Lấy tổng doanh thu theo tháng
     */
    public static function getMonthlyRevenue($month, $year) {
        global $pdo;
        $mmyy = sprintf('%02d%04d', $month, $year);
        
        $stmt = $pdo->prepare("SELECT 
            SUM(total_discount) as total_revenue,
            SUM(tong_tien) as gross_revenue,
            SUM(e_total) as electricity_revenue,
            SUM(w_total) as water_revenue,
            SUM(service_fee) as service_revenue,
            SUM(tien_phong) as room_revenue,
            COUNT(*) as invoice_count
            FROM nhatro_history 
            WHERE mmyy = ?");
        $stmt->execute([$mmyy]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy tổng doanh thu theo năm
     */
    public static function getYearlyRevenue($year) {
        global $pdo;
        
        $stmt = $pdo->prepare("SELECT 
            SUM(total_discount) as total_revenue,
            SUM(tong_tien) as gross_revenue,
            SUM(e_total) as electricity_revenue,
            SUM(w_total) as water_revenue,
            SUM(service_fee) as service_revenue,
            SUM(tien_phong) as room_revenue,
            COUNT(*) as invoice_count
            FROM nhatro_history 
            WHERE mmyy LIKE ?");
        $stmt->execute(['_'.$year]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy doanh thu theo từng tháng trong năm
     */
    public static function getMonthlyRevenueByYear($year) {
        global $pdo;
        
        $stmt = $pdo->prepare("SELECT 
            LEFT(mmyy, 2) as month,
            SUM(total_discount) as total_revenue,
            SUM(tong_tien) as gross_revenue,
            SUM(e_total) as electricity_revenue,
            SUM(w_total) as water_revenue,
            SUM(service_fee) as service_revenue,
            SUM(tien_phong) as room_revenue,
            COUNT(*) as invoice_count
            FROM nhatro_history 
            WHERE mmyy LIKE ?
            GROUP BY LEFT(mmyy, 2)
            ORDER BY month ASC");
        $stmt->execute(['%'.$year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy doanh thu theo từng năm
     */
    public static function getYearlyRevenueAll() {
        global $pdo;
        
        $stmt = $pdo->prepare("SELECT 
            SUBSTRING(mmyy, 3, 4) as year,
            SUM(total_discount) as total_revenue,
            SUM(tong_tien) as gross_revenue,
            SUM(e_total) as electricity_revenue,
            SUM(w_total) as water_revenue,
            SUM(service_fee) as service_revenue,
            SUM(tien_phong) as room_revenue,
            COUNT(*) as invoice_count
            FROM nhatro_history 
            GROUP BY SUBSTRING(mmyy, 3, 4)
            ORDER BY year ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy thống kê tổng quát theo tháng
     */
    public static function getMonthlyStats($month, $year) {
        global $pdo;
        $mmyy = sprintf('%02d%04d', $month, $year);
        
        $stmt = $pdo->prepare("SELECT 
            COUNT(DISTINCT room) as total_rooms,
            SUM(total_discount) as total_revenue,
            SUM(tong_tien) as gross_revenue,
            SUM(discount) as total_discount_amount,
            SUM(e_total) as electricity_revenue,
            SUM(w_total) as water_revenue,
            SUM(service_fee) as service_revenue,
            SUM(tien_phong) as room_revenue,
            AVG(total_discount) as avg_revenue,
            COUNT(*) as invoice_count
            FROM nhatro_history 
            WHERE mmyy = ?");
        $stmt->execute([$mmyy]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy thống kê tổng quát theo năm
     */
    public static function getYearlyStats($year) {
        global $pdo;
        
        $stmt = $pdo->prepare("SELECT 
            COUNT(DISTINCT room) as total_rooms,
            SUM(total_discount) as total_revenue,
            SUM(tong_tien) as gross_revenue,
            SUM(discount) as total_discount_amount,
            SUM(e_total) as electricity_revenue,
            SUM(w_total) as water_revenue,
            SUM(service_fee) as service_revenue,
            SUM(tien_phong) as room_revenue,
            AVG(total_discount) as avg_revenue,
            COUNT(*) as invoice_count
            FROM nhatro_history 
            WHERE mmyy LIKE ?");
        $stmt->execute(['%'.$year]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Lấy doanh thu theo phòng trong tháng
     */
    public static function getMonthlyRevenueByRoom($month, $year) {
        global $pdo;
        $mmyy = sprintf('%02d%04d', $month, $year);
        
        $stmt = $pdo->prepare("SELECT 
            room,
            SUM(total_discount) as total_revenue,
            SUM(tong_tien) as gross_revenue,
            SUM(e_total) as electricity_revenue,
            SUM(w_total) as water_revenue,
            SUM(service_fee) as service_revenue,
            SUM(tien_phong) as room_revenue
            FROM nhatro_history 
            WHERE mmyy = ?
            GROUP BY room
            ORDER BY room ASC");
        $stmt->execute([$mmyy]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
