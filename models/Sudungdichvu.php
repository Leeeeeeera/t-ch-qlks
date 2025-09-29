<?php
class Sudungdichvu {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getGiaDichVu($id_dichvu) {
        $sql = "SELECT gia FROM dichvu WHERE id_dichvu = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id_dichvu]);
        return $stmt->fetchColumn();
    }

    public function insertSudungdv($id_datphong, $id_dichvu, $so_luong, $thanh_tien) {
        $sql = "INSERT INTO sudungdichvu (id_datphong, id_dichvu, so_luong, thanh_tien)
                VALUES (:id_datphong, :id_dichvu, :so_luong, :thanh_tien)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_datphong' => $id_datphong,
            ':id_dichvu'   => $id_dichvu,
            ':so_luong'    => $so_luong,
            ':thanh_tien'  => $thanh_tien
        ]);
    }

    public function getPhongDat() {
        $sql = "SELECT datphong.*, phong.so_phong, khachhang.ho_ten
                FROM datphong
                JOIN phong ON datphong.id_phong = phong.id_phong
                JOIN khachhang ON datphong.id_khachhang = khachhang.id_khachhang
                WHERE phong.trang_thai = 'Đã đặt'";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDichVu() {
        $sql = "SELECT * FROM dichvu ORDER BY ten_dich_vu";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSudungdv() {
        $sql = "SELECT sudungdichvu.*, phong.so_phong, dichvu.ten_dich_vu, dichvu.gia, khachhang.ho_ten
                FROM sudungdichvu
                JOIN datphong ON sudungdichvu.id_datphong = datphong.id_datphong
                JOIN dichvu ON sudungdichvu.id_dichvu = dichvu.id_dichvu
                JOIN phong ON datphong.id_phong = phong.id_phong
                JOIN khachhang ON datphong.id_khachhang = khachhang.id_khachhang
                ORDER BY sudungdichvu.id_sudungdv DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
