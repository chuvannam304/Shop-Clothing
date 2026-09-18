<?php

require_once __DIR__ . '/../../config/database.php';

class SanPham
{
    private $conn;
    private $table = 'sanpham';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả sản phẩm
    public function getAll()
    {
        $sql = "SELECT 
                    sp.*,
                    l.TenLoai,
                    nh.TenNhanHieu
                FROM {$this->table} sp
                INNER JOIN loai l ON sp.MaLoai = l.MaLoai
                INNER JOIN nhanhieu nh ON sp.MaNhanHieu = nh.MaNhanHieu
                ORDER BY sp.NgayTao DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy sản phẩm theo mã
    public function getById($maSP)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaSP = :MaSP";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSP' => $maSP
        ]);

        return $stmt->fetch();
    }

    // Thêm sản phẩm
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaSP,
                    MaLoai,
                    MaNhanHieu,
                    TenSP,
                    MoTa,
                    ChatLieu,
                    GioiTinh,
                    TrangThai
                )
                VALUES
                (
                    :MaSP,
                    :MaLoai,
                    :MaNhanHieu,
                    :TenSP,
                    :MoTa,
                    :ChatLieu,
                    :GioiTinh,
                    :TrangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSP' => $data['MaSP'],
            ':MaLoai' => $data['MaLoai'],
            ':MaNhanHieu' => $data['MaNhanHieu'],
            ':TenSP' => $data['TenSP'],
            ':MoTa' => $data['MoTa'],
            ':ChatLieu' => $data['ChatLieu'],
            ':GioiTinh' => $data['GioiTinh'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    // Cập nhật sản phẩm
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    MaLoai = :MaLoai,
                    MaNhanHieu = :MaNhanHieu,
                    TenSP = :TenSP,
                    MoTa = :MoTa,
                    ChatLieu = :ChatLieu,
                    GioiTinh = :GioiTinh,
                    TrangThai = :TrangThai
                WHERE MaSP = :MaSP";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSP' => $data['MaSP'],
            ':MaLoai' => $data['MaLoai'],
            ':MaNhanHieu' => $data['MaNhanHieu'],
            ':TenSP' => $data['TenSP'],
            ':MoTa' => $data['MoTa'],
            ':ChatLieu' => $data['ChatLieu'],
            ':GioiTinh' => $data['GioiTinh'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }
    // Tự sinh mã sản phẩm
    public function generateMaSP()
    {
        $sql = "SELECT MaSP
            FROM {$this->table}
            WHERE MaSP LIKE 'SP%'
            ORDER BY CAST(SUBSTRING(MaSP, 3) AS UNSIGNED) DESC
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $sanPham = $stmt->fetch();

        if (!$sanPham) {
            return 'SP01';
        }

        $so = (int) substr($sanPham['MaSP'], 2);
        $so++;

        return 'SP' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
    // Xóa sản phẩm
    public function delete($maSP)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaSP = :MaSP";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSP' => $maSP
        ]);
    }
}
