<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Sudungdichvu.php';
require_once __DIR__ . '/../core/Auth.php';

require_login();
check_permission(['ADMIN','NHANVIEN']);

// ✅ Kết nối PDO từ Database::getConnection()
$pdo = Database::getConnection();
$model = new Sudungdichvu($pdo);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['them_sudungdv'])) {
    $id_datphong = (int)$_POST['id_datphong'];
    $id_dichvu   = (int)$_POST['id_dichvu'];
    $so_luong    = (int)$_POST['so_luong'];

    try {
        $gia = $model->getGiaDichVu($id_dichvu);
        if ($gia === false) {
            throw new Exception("Không tìm thấy dịch vụ");
        }

        $thanh_tien = $so_luong * $gia;
        $model->insertSudungdv($id_datphong, $id_dichvu, $so_luong, $thanh_tien);
        $message = "Thêm dịch vụ sử dụng thành công!";
    } catch (Exception $e) {
        $message = "Lỗi khi thêm dịch vụ: " . $e->getMessage();
    }
}

// Lấy dữ liệu cho View
$phong_dat_result = $model->getPhongDat();
$dichvu_result    = $model->getAllDichVu();
$sudungdv_result  = $model->getAllSudungdv();

// Gọi view hiển thị
include __DIR__ . '/../views/sudungdichvu.php';
