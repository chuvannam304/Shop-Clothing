<?php

require_once __DIR__ . '/../../config/database.php';

class DiaChi
{
    private $conn;
    private $table = 'diachi';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Tự sinh mã địa chỉ: DC01, DC02,...
    public function generateMaDiaChi()
    {
        $sql = "SELECT MaDiaChi
                FROM {$this->table}
                WHERE MaDiaChi LIKE 'DC%'
                ORDER BY CAST(SUBSTRING(MaDiaChi, 3) AS UNSIGNED) DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $diaChi = $stmt->fetch();

        if (!$diaChi) {
            return 'DC01';
        }

        $so = (int) substr($diaChi['MaDiaChi'], 2);
        $so++;

        return 'DC' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }

    // Lấy tất cả địa chỉ của khách hàng
    public function getByMaKH($maKH)
    {
        $sql = "SELECT *
                FROM {$this->table}
                WHERE MaKH = :MaKH
                ORDER BY MacDinh DESC, MaDiaChi DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaKH' => $maKH
        ]);

        return $stmt->fetchAll();
    }

    // Lấy một địa chỉ
    public function getById($maDiaChi)
    {
        $sql = "SELECT *
                FROM {$this->table}
                WHERE MaDiaChi = :MaDiaChi
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaDiaChi' => $maDiaChi
        ]);

        return $stmt->fetch();
    }

    // Lấy địa chỉ mặc định
    public function getDefault($maKH)
    {
        $sql = "SELECT *
                FROM {$this->table}
                WHERE MaKH = :MaKH
                  AND MacDinh = 1
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaKH' => $maKH
        ]);

        return $stmt->fetch();
    }

    // Kiểm tra khách hàng đã có địa chỉ chưa
    public function hasAddress($maKH)
    {
        $sql = "SELECT MaDiaChi
                FROM {$this->table}
                WHERE MaKH = :MaKH
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaKH' => $maKH
        ]);

        return $stmt->fetch();
    }

    // Bỏ địa chỉ mặc định hiện tại
    public function clearDefault($maKH)
    {
        $sql = "UPDATE {$this->table}
                SET MacDinh = 0
                WHERE MaKH = :MaKH";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaKH' => $maKH
        ]);
    }

    // Thêm địa chỉ
    public function create($data)
    {
        // Nếu là địa chỉ mặc định thì bỏ mặc định của địa chỉ cũ
        if ((int) $data['MacDinh'] === 1) {
            $this->clearDefault($data['MaKH']);
        }

        $sql = "INSERT INTO {$this->table}
                (
                    MaDiaChi,
                    MaKH,
                    HoTenNguoiNhan,
                    SoDienThoai,
                    DiaChiChiTiet,
                    PhuongXa,
                    QuanHuyen,
                    TinhThanh,
                    MacDinh
                )
                VALUES
                (
                    :MaDiaChi,
                    :MaKH,
                    :HoTenNguoiNhan,
                    :SoDienThoai,
                    :DiaChiChiTiet,
                    :PhuongXa,
                    :QuanHuyen,
                    :TinhThanh,
                    :MacDinh
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaDiaChi' => $data['MaDiaChi'],
            ':MaKH' => $data['MaKH'],
            ':HoTenNguoiNhan' => $data['HoTenNguoiNhan'],
            ':SoDienThoai' => $data['SoDienThoai'],
            ':DiaChiChiTiet' => $data['DiaChiChiTiet'],
            ':PhuongXa' => $data['PhuongXa'],
            ':QuanHuyen' => $data['QuanHuyen'],
            ':TinhThanh' => $data['TinhThanh'],
            ':MacDinh' => $data['MacDinh']
        ]);
    }

    // Cập nhật địa chỉ
    public function update($data)
    {
        if ((int) $data['MacDinh'] === 1) {
            $this->clearDefault($data['MaKH']);
        }

        $sql = "UPDATE {$this->table}
                SET HoTenNguoiNhan = :HoTenNguoiNhan,
                    SoDienThoai = :SoDienThoai,
                    DiaChiChiTiet = :DiaChiChiTiet,
                    PhuongXa = :PhuongXa,
                    QuanHuyen = :QuanHuyen,
                    TinhThanh = :TinhThanh,
                    MacDinh = :MacDinh
                WHERE MaDiaChi = :MaDiaChi
                  AND MaKH = :MaKH";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaDiaChi' => $data['MaDiaChi'],
            ':MaKH' => $data['MaKH'],
            ':HoTenNguoiNhan' => $data['HoTenNguoiNhan'],
            ':SoDienThoai' => $data['SoDienThoai'],
            ':DiaChiChiTiet' => $data['DiaChiChiTiet'],
            ':PhuongXa' => $data['PhuongXa'],
            ':QuanHuyen' => $data['QuanHuyen'],
            ':TinhThanh' => $data['TinhThanh'],
            ':MacDinh' => $data['MacDinh']
        ]);
    }

    // Đặt địa chỉ làm mặc định
    public function setDefault($maKH, $maDiaChi)
    {
        $this->clearDefault($maKH);

        $sql = "UPDATE {$this->table}
                SET MacDinh = 1
                WHERE MaDiaChi = :MaDiaChi
                  AND MaKH = :MaKH";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaDiaChi' => $maDiaChi,
            ':MaKH' => $maKH
        ]);
    }

    // Xóa địa chỉ
    public function delete($maDiaChi, $maKH)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaDiaChi = :MaDiaChi
                  AND MaKH = :MaKH";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaDiaChi' => $maDiaChi,
            ':MaKH' => $maKH
        ]);
    }
}