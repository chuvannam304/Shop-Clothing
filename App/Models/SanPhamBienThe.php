<?php

require_once __DIR__ . '/../../config/database.php';

class SanPhamBienThe
{
    private $conn;
    private $table = 'sanphambienthe';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả biến thể của 1 sản phẩm
    public function getBySanPham($maSP)
    {
        $sql = "SELECT 
                    bt.*,
                    m.TenMau,
                    m.MaHex,
                    s.TenSize
                FROM {$this->table} bt
                INNER JOIN mausac m ON bt.MaMau = m.MaMau
                INNER JOIN size s ON bt.MaSize = s.MaSize
                WHERE bt.MaSP = :MaSP
                ORDER BY m.TenMau ASC, s.TenSize ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSP' => $maSP
        ]);

        return $stmt->fetchAll();
    }

    // Lấy biến thể theo mã
    public function getById($maBienThe)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaBienThe = :MaBienThe";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaBienThe' => $maBienThe
        ]);

        return $stmt->fetch();
    }

    // Kiểm tra SKU đã tồn tại chưa
    public function getBySKU($maSKU)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaSKU = :MaSKU";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSKU' => $maSKU
        ]);

        return $stmt->fetch();
    }

    // Kiểm tra sản phẩm đã có màu + size này chưa
    public function checkBienThe($maSP, $maMau, $maSize)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaSP = :MaSP
                AND MaMau = :MaMau
                AND MaSize = :MaSize";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSP' => $maSP,
            ':MaMau' => $maMau,
            ':MaSize' => $maSize
        ]);

        return $stmt->fetch();
    }

    // Thêm biến thể
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaBienThe,
                    MaSP,
                    MaMau,
                    MaSize,
                    MaSKU,
                    GiaBan,
                    SoLuongTon,
                    TrangThai
                )
                VALUES
                (
                    :MaBienThe,
                    :MaSP,
                    :MaMau,
                    :MaSize,
                    :MaSKU,
                    :GiaBan,
                    :SoLuongTon,
                    :TrangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaBienThe' => $data['MaBienThe'],
            ':MaSP' => $data['MaSP'],
            ':MaMau' => $data['MaMau'],
            ':MaSize' => $data['MaSize'],
            ':MaSKU' => $data['MaSKU'],
            ':GiaBan' => $data['GiaBan'],
            ':SoLuongTon' => $data['SoLuongTon'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    // Cập nhật biến thể
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    MaMau = :MaMau,
                    MaSize = :MaSize,
                    MaSKU = :MaSKU,
                    GiaBan = :GiaBan,
                    SoLuongTon = :SoLuongTon,
                    TrangThai = :TrangThai
                WHERE MaBienThe = :MaBienThe";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaBienThe' => $data['MaBienThe'],
            ':MaMau' => $data['MaMau'],
            ':MaSize' => $data['MaSize'],
            ':MaSKU' => $data['MaSKU'],
            ':GiaBan' => $data['GiaBan'],
            ':SoLuongTon' => $data['SoLuongTon'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    // Xóa biến thể
    public function delete($maBienThe)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaBienThe = :MaBienThe";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaBienThe' => $maBienThe
        ]);
    }
}