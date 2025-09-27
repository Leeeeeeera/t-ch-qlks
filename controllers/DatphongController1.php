<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Datphong.php';

class DatphongController1 {
    private $datphongModel;

    public function __construct() {
        // Kết nối database (mysqli)
        $db = new Database();
        $conn = $db->getConnection();
        $this->datphongModel = new Datphong($conn);
    }

    // Trang chính hiển thị danh sách
    public function index() {
        // Xử lý POST trước khi load view
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['dat_phong'])) {
                $this->add($_POST);
            } elseif (isset($_POST['cap_nhat_dat_phong'])) {
                $this->update($_POST);
            }
        }

        // Xử lý XÓA bằng GET param 'xoa'
        if (isset($_GET['xoa'])) {
            $this->delete((int)$_GET['xoa']);
        }

        $editData = isset($_GET['sua']) ? $this->datphongModel->getById((int)$_GET['sua']) : null;
        $datPhongList = $this->datphongModel->getAll();
        $phongTrong = $this->datphongModel->getPhongTrong();

        include __DIR__ . '/../views/datphong.php';
    }

    // Thêm đặt phòng
    private function add($post) {
        try {
            $this->datphongModel->add($post);
            echo "<script>alert('Đặt phòng thành công!');window.location='index.php?controller=datphong';</script>";
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: ".$e->getMessage()."');</script>";
        }
    }

    // Cập nhật đặt phòng
    private function update($post) {
        try {
            $this->datphongModel->update($post['id_datphong'], $post);
            echo "<script>alert('Cập nhật thành công!');window.location='index.php?controller=datphong';</script>";
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: ".$e->getMessage()."');</script>";
        }
    }

    // Xóa đặt phòng
    private function delete($id) {
        try {
            $this->datphongModel->delete($id);
            echo "<script>alert('Hủy thành công!');window.location='index.php?controller=datphong';</script>";
            exit;
        } catch (Exception $e) {
            echo "<script>alert('Lỗi: ".$e->getMessage()."');window.location='index.php?controller=datphong';</script>";
        }
    }
}
?>
