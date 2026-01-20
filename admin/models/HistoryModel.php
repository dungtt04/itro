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
}
