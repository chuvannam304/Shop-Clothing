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
    // Tự sinh mã hóa đơn: HD01, HD02,...
    public function generateMaHD()
    {
        $sql = "SELECT MaHD
            FROM {$this->table}
            WHERE MaHD LIKE 'HD%'
            ORDER BY CAST(SUBSTRING(MaHD, 3) AS UNSIGNED) DESC
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $hoaDon = $stmt->fetch();

        if (!$hoaDon) {
            return 'HD01';
        }

        $so = (int) substr($hoaDon['MaHD'], 2);
        $so++;

        return 'HD' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }

    // Tự sinh mã chi tiết hóa đơn: CTHD01, CTHD02,...
    public function generateMaCTHD()
    {
        $sql = "SELECT MaCTHD
            FROM ChiTietHoaDon
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

    // Lấy phương thức thanh toán đang hoạt động
    public function getPaymentMethods()
    {
        $sql = "SELECT *
            FROM PhuongThucThanhToan
            WHERE TrangThai = 1
            ORDER BY TenPhuongThuc ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy trạng thái đầu tiên của đơn hàng
    public function getFirstOrderStatus()
    {
        $sql = "SELECT *
            FROM TrangThaiDonHang
            WHERE TrangThai = 1
            ORDER BY ThuTu ASC
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetch();
    }

    // Tạo hóa đơn
    public function createOrder($data)
    {
        $sql = "INSERT INTO {$this->table}
            (
                MaHD,
                MaKH,
                MaDiaChi,
                MaPhuongThuc,
                MaTrangThai,
                MaGiamGia,
                HoTenNguoiNhan,
                SoDienThoaiNhan,
                DiaChiGiaoHang,
                TongTien,
                TienGiam,
                PhiVanChuyen,
                ThanhTien,
                TrangThaiThanhToan,
                GhiChu
            )
            VALUES
            (
                :MaHD,
                :MaKH,
                :MaDiaChi,
                :MaPhuongThuc,
                :MaTrangThai,
                :MaGiamGia,
                :HoTenNguoiNhan,
                :SoDienThoaiNhan,
                :DiaChiGiaoHang,
                :TongTien,
                :TienGiam,
                :PhiVanChuyen,
                :ThanhTien,
                :TrangThaiThanhToan,
                :GhiChu
            )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaHD' => $data['MaHD'],
            ':MaKH' => $data['MaKH'],
            ':MaDiaChi' => $data['MaDiaChi'],
            ':MaPhuongThuc' => $data['MaPhuongThuc'],
            ':MaTrangThai' => $data['MaTrangThai'],
            ':MaGiamGia' => $data['MaGiamGia'] ?? null,
            ':HoTenNguoiNhan' => $data['HoTenNguoiNhan'],
            ':SoDienThoaiNhan' => $data['SoDienThoaiNhan'],
            ':DiaChiGiaoHang' => $data['DiaChiGiaoHang'],
            ':TongTien' => $data['TongTien'],
            ':TienGiam' => $data['TienGiam'] ?? 0,
            ':PhiVanChuyen' => $data['PhiVanChuyen'] ?? 0,
            ':ThanhTien' => $data['ThanhTien'],
            ':TrangThaiThanhToan' => $data['TrangThaiThanhToan'] ?? 'ChuaThanhToan',
            ':GhiChu' => $data['GhiChu'] ?? null
        ]);
    }

    // Tạo chi tiết hóa đơn
    public function createOrderDetail($data)
    {
        $sql = "INSERT INTO ChiTietHoaDon
            (
                MaCTHD,
                MaHD,
                MaBienThe,
                SoLuong,
                DonGia,
                ThanhTien
            )
            VALUES
            (
                :MaCTHD,
                :MaHD,
                :MaBienThe,
                :SoLuong,
                :DonGia,
                :ThanhTien
            )";

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

    // Trừ tồn kho khi đặt hàng
    public function decreaseStock($maBienThe, $soLuong)
    {
        $sql = "UPDATE SanPhamBienThe
            SET SoLuongTon = SoLuongTon - :SoLuong
            WHERE MaBienThe = :MaBienThe
            AND SoLuongTon >= :SoLuong";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':SoLuong' => $soLuong,
            ':MaBienThe' => $maBienThe
        ]);

        return $stmt->rowCount() > 0;
    }

    // Transaction
    public function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function rollBack()
    {
        if ($this->conn->inTransaction()) {
            return $this->conn->rollBack();
        }

        return false;
    }
    // Lấy đơn hàng của một khách hàng
    public function getByMaKH($maKH, $status = 'all', $keyword = '')
    {
        $sql = "SELECT hd.*,
                   pttt.TenPhuongThuc,
                   ttdh.TenTrangThai
            FROM {$this->table} hd
            INNER JOIN PhuongThucThanhToan pttt ON hd.MaPhuongThuc = pttt.MaPhuongThuc
            INNER JOIN TrangThaiDonHang ttdh ON hd.MaTrangThai = ttdh.MaTrangThai
            WHERE hd.MaKH = :MaKH";

        $params = [
            ':MaKH' => $maKH
        ];

        switch ($status) {
            case 'cho-thanh-toan':
                $sql .= " AND hd.TrangThaiThanhToan = 'ChuaThanhToan'
                      AND hd.MaPhuongThuc <> 'PT01'
                      AND hd.MaTrangThai <> 'TT06'";
                break;

            case 'van-chuyen':
                $sql .= " AND hd.MaTrangThai IN ('TT01', 'TT02', 'TT03')";
                break;

            case 'cho-giao-hang':
                $sql .= " AND hd.MaTrangThai = 'TT04'";
                break;

            case 'hoan-thanh':
                $sql .= " AND hd.MaTrangThai = 'TT05'";
                break;

            case 'da-huy':
                $sql .= " AND hd.MaTrangThai = 'TT06'";
                break;

            case 'hoan-tien':
                $sql .= " AND hd.TrangThaiThanhToan = 'HoanTien'";
                break;
        }

        if ($keyword != '') {
            $sql .= " AND (
                    hd.MaHD LIKE :Keyword
                    OR EXISTS (
                        SELECT 1
                        FROM ChiTietHoaDon ct
                        INNER JOIN SanPhamBienThe bt ON ct.MaBienThe = bt.MaBienThe
                        INNER JOIN SanPham sp ON bt.MaSP = sp.MaSP
                        WHERE ct.MaHD = hd.MaHD
                        AND sp.TenSP LIKE :Keyword
                    )
                  )";

            $params[':Keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY hd.NgayDat DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
