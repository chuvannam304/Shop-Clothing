<?php

require_once __DIR__ . '/../../config/database.php';

class ChiTietHoaDon
{
    private $conn;
    private $table = 'ChiTietHoaDon';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getByMaHD($maHD)
    {
        $sql = "SELECT ct.*,
                   sp.MaSP,
                   sp.TenSP,
                   ms.TenMau,
                   s.TenSize,
                   bt.MaSKU,
                   (
                       SELECT ha.DuongDan
                       FROM HinhAnhSanPham ha
                       WHERE ha.MaSP = sp.MaSP
                       ORDER BY ha.LaAnhChinh DESC, ha.ThuTu ASC
                       LIMIT 1
                   ) AS HinhAnhChinh
            FROM ChiTietHoaDon ct
            INNER JOIN SanPhamBienThe bt ON ct.MaBienThe = bt.MaBienThe
            INNER JOIN SanPham sp ON bt.MaSP = sp.MaSP
            INNER JOIN MauSac ms ON bt.MaMau = ms.MaMau
            INNER JOIN Size s ON bt.MaSize = s.MaSize
            WHERE ct.MaHD = :MaHD";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaHD' => $maHD
        ]);

        return $stmt->fetchAll();
    }

    public function getById($maCTHD)
    {
        $sql = "SELECT ct.*, sp.TenSP, sp.HinhAnhChinh, bt.MaSKU,
                       ms.TenMau, s.TenSize
                FROM {$this->table} ct
                INNER JOIN SanPhamBienThe bt ON ct.MaBienThe = bt.MaBienThe
                INNER JOIN SanPham sp ON bt.MaSP = sp.MaSP
                INNER JOIN MauSac ms ON bt.MaMau = ms.MaMau
                INNER JOIN Size s ON bt.MaSize = s.MaSize
                WHERE ct.MaCTHD = :MaCTHD
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaCTHD' => $maCTHD]);

        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (MaCTHD, MaHD, MaBienThe, SoLuong, DonGia, ThanhTien)
                VALUES
                (:MaCTHD, :MaHD, :MaBienThe, :SoLuong, :DonGia, :ThanhTien)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaCTHD' => $data['MaCTHD'],
            ':MaHD' => $data['MaHD'],
            ':MaBienThe' => $data['MaBienThe'],
            ':SoLuong' => $data['SoLuong'],
            ':DonGia' => $data['DonGia'],
            ':ThanhTien' => $data['ThanhTien']
        ]);
    }

    public function deleteByMaHD($maHD)
    {
        $sql = "DELETE FROM {$this->table} WHERE MaHD = :MaHD";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':MaHD' => $maHD]);
    }

    public function generateMaCTHD()
    {
        $sql = "SELECT MaCTHD
                FROM {$this->table}
                WHERE MaCTHD LIKE 'CTHD%'
                ORDER BY CAST(SUBSTRING(MaCTHD, 5) AS UNSIGNED) DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $chiTiet = $stmt->fetch();

        if (!$chiTiet) {
            return 'CTHD01';
        }

        $so = (int) substr($chiTiet['MaCTHD'], 4);
        $so++;

        return 'CTHD' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
}
