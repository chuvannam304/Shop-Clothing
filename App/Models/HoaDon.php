<?php

require_once __DIR__ . '/../../config/database.php';

class HoaDon
{
    private $conn;
    private $table = 'HoaDon';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT hd.*,
                       kh.HoTen AS TenKhachHang,
                       pttt.TenPhuongThuc,
                       ttdh.TenTrangThai,
                       mgg.MaCode
                FROM {$this->table} hd
                INNER JOIN KhachHang kh ON hd.MaKH = kh.MaKH
                INNER JOIN PhuongThucThanhToan pttt ON hd.MaPhuongThuc = pttt.MaPhuongThuc
                INNER JOIN TrangThaiDonHang ttdh ON hd.MaTrangThai = ttdh.MaTrangThai
                LEFT JOIN MaGiamGia mgg ON hd.MaGiamGia = mgg.MaGiamGia
                ORDER BY hd.NgayDat DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById($maHD)
    {
        $sql = "SELECT hd.*,
                       kh.HoTen AS TenKhachHang,
                       tk.Email,
                       tk.SoDienThoai,
                       pttt.TenPhuongThuc,
                       ttdh.TenTrangThai,
                       mgg.MaCode
                FROM {$this->table} hd
                INNER JOIN KhachHang kh ON hd.MaKH = kh.MaKH
                INNER JOIN TaiKhoan tk ON kh.MaTK = tk.MaTK
                INNER JOIN PhuongThucThanhToan pttt ON hd.MaPhuongThuc = pttt.MaPhuongThuc
                INNER JOIN TrangThaiDonHang ttdh ON hd.MaTrangThai = ttdh.MaTrangThai
                LEFT JOIN MaGiamGia mgg ON hd.MaGiamGia = mgg.MaGiamGia
                WHERE hd.MaHD = :MaHD
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaHD' => $maHD]);

        return $stmt->fetch();
    }

    public function getChiTiet($maHD)
    {
        $sql = "SELECT ct.*,
                       sp.TenSP,
                       sp.HinhAnhChinh,
                       ms.TenMau,
                       s.TenSize,
                       bt.MaSKU
                FROM ChiTietHoaDon ct
                INNER JOIN SanPhamBienThe bt ON ct.MaBienThe = bt.MaBienThe
                INNER JOIN SanPham sp ON bt.MaSP = sp.MaSP
                INNER JOIN MauSac ms ON bt.MaMau = ms.MaMau
                INNER JOIN Size s ON bt.MaSize = s.MaSize
                WHERE ct.MaHD = :MaHD";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaHD' => $maHD]);

        return $stmt->fetchAll();
    }

    public function updateTrangThai($maHD, $maTrangThai)
    {
        $sql = "UPDATE {$this->table}
                SET MaTrangThai = :MaTrangThai
                WHERE MaHD = :MaHD";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaTrangThai' => $maTrangThai,
            ':MaHD' => $maHD
        ]);
    }

    public function updateTrangThaiThanhToan($maHD, $trangThaiThanhToan)
    {
        $sql = "UPDATE {$this->table}
                SET TrangThaiThanhToan = :TrangThaiThanhToan
                WHERE MaHD = :MaHD";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':TrangThaiThanhToan' => $trangThaiThanhToan,
            ':MaHD' => $maHD
        ]);
    }

    public function search($keyword)
    {
        $sql = "SELECT hd.*,
                       kh.HoTen AS TenKhachHang,
                       pttt.TenPhuongThuc,
                       ttdh.TenTrangThai
                FROM {$this->table} hd
                INNER JOIN KhachHang kh ON hd.MaKH = kh.MaKH
                INNER JOIN PhuongThucThanhToan pttt ON hd.MaPhuongThuc = pttt.MaPhuongThuc
                INNER JOIN TrangThaiDonHang ttdh ON hd.MaTrangThai = ttdh.MaTrangThai
                WHERE hd.MaHD LIKE :Keyword
                   OR kh.HoTen LIKE :Keyword
                   OR hd.HoTenNguoiNhan LIKE :Keyword
                   OR hd.SoDienThoaiNhan LIKE :Keyword
                ORDER BY hd.NgayDat DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':Keyword' => '%' . $keyword . '%']);

        return $stmt->fetchAll();
    }
}