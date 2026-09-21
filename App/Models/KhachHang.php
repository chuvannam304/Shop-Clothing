<?php

require_once __DIR__ . '/../../config/database.php';

class KhachHang
{
    private $conn;
    private $table = 'khachhang';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Tự sinh mã khách hàng: KH01, KH02,...
    public function generateMaKH()
    {
        $sql = "SELECT MaKH
                FROM {$this->table}
                WHERE MaKH LIKE 'KH%'
                ORDER BY CAST(SUBSTRING(MaKH, 3) AS UNSIGNED) DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $khachHang = $stmt->fetch();

        if (!$khachHang) {
            return 'KH01';
        }

        $so = (int) substr($khachHang['MaKH'], 2);
        $so++;

        return 'KH' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }

    // Lấy thông tin khách hàng theo tài khoản đang đăng nhập
    public function getByMaTK($maTK)
    {
        $sql = "SELECT 
                    kh.MaKH,
                    kh.MaTK,
                    kh.HoTen,
                    kh.NgaySinh,
                    kh.GioiTinh,
                    kh.AnhDaiDien,
                    kh.NgayTao,
                    tk.Email,
                    tk.SoDienThoai
                FROM {$this->table} kh
                INNER JOIN taikhoan tk ON kh.MaTK = tk.MaTK
                WHERE kh.MaTK = :MaTK
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':MaTK' => $maTK
        ]);

        return $stmt->fetch();
    }

    // Kiểm tra tài khoản đã có hồ sơ khách hàng chưa
    public function existsByMaTK($maTK)
    {
        $sql = "SELECT MaKH
                FROM {$this->table}
                WHERE MaTK = :MaTK
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':MaTK' => $maTK
        ]);

        return $stmt->fetch();
    }

    // Tạo hồ sơ khách hàng
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaKH,
                    MaTK,
                    HoTen,
                    NgaySinh,
                    GioiTinh,
                    AnhDaiDien
                )
                VALUES
                (
                    :MaKH,
                    :MaTK,
                    :HoTen,
                    :NgaySinh,
                    :GioiTinh,
                    :AnhDaiDien
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaKH' => $data['MaKH'],
            ':MaTK' => $data['MaTK'],
            ':HoTen' => $data['HoTen'],
            ':NgaySinh' => $data['NgaySinh'],
            ':GioiTinh' => $data['GioiTinh'],
            ':AnhDaiDien' => $data['AnhDaiDien']
        ]);
    }

    // Cập nhật thông tin hồ sơ
    public function update($maTK, $data)
    {
        $sql = "UPDATE {$this->table}
                SET HoTen = :HoTen,
                    NgaySinh = :NgaySinh,
                    GioiTinh = :GioiTinh,
                    AnhDaiDien = :AnhDaiDien
                WHERE MaTK = :MaTK";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':HoTen' => $data['HoTen'],
            ':NgaySinh' => $data['NgaySinh'],
            ':GioiTinh' => $data['GioiTinh'],
            ':AnhDaiDien' => $data['AnhDaiDien'],
            ':MaTK' => $maTK
        ]);
    }
}