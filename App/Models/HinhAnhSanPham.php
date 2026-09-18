<?php

require_once __DIR__ . '/../../config/database.php';

class HinhAnhSanPham
{
    private $conn;
    private $table = 'hinhanhsanpham';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả hình của một sản phẩm
    public function getBySanPham($maSP)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaSP = :MaSP
                ORDER BY LaAnhChinh DESC, ThuTu ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSP' => $maSP
        ]);

        return $stmt->fetchAll();
    }

    // Lấy hình theo mã
    public function getById($maHinh)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaHinh = :MaHinh";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaHinh' => $maHinh
        ]);

        return $stmt->fetch();
    }

    // Thêm hình ảnh
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaHinh,
                    MaSP,
                    DuongDan,
                    LaAnhChinh,
                    ThuTu
                )
                VALUES
                (
                    :MaHinh,
                    :MaSP,
                    :DuongDan,
                    :LaAnhChinh,
                    :ThuTu
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaHinh' => $data['MaHinh'],
            ':MaSP' => $data['MaSP'],
            ':DuongDan' => $data['DuongDan'],
            ':LaAnhChinh' => $data['LaAnhChinh'],
            ':ThuTu' => $data['ThuTu']
        ]);
    }

    // Cập nhật ảnh
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    DuongDan = :DuongDan,
                    LaAnhChinh = :LaAnhChinh,
                    ThuTu = :ThuTu
                WHERE MaHinh = :MaHinh";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaHinh' => $data['MaHinh'],
            ':DuongDan' => $data['DuongDan'],
            ':LaAnhChinh' => $data['LaAnhChinh'],
            ':ThuTu' => $data['ThuTu']
        ]);
    }

    // Bỏ ảnh chính của tất cả ảnh thuộc sản phẩm
    public function resetAnhChinh($maSP)
    {
        $sql = "UPDATE {$this->table}
                SET LaAnhChinh = 0
                WHERE MaSP = :MaSP";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSP' => $maSP
        ]);
    }

    // Xóa hình ảnh
    public function delete($maHinh)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaHinh = :MaHinh";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaHinh' => $maHinh
        ]);
    }
}