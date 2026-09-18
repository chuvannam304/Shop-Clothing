<?php

require_once __DIR__ . '/../../config/database.php';

class NhanHieu
{
    private $conn;
    private $table = 'nhanhieu';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả nhãn hiệu
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY TenNhanHieu ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy nhãn hiệu đang hoạt động
    public function getActive()
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE TrangThai = 1
                ORDER BY TenNhanHieu ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy nhãn hiệu theo mã
    public function getById($maNhanHieu)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaNhanHieu = :MaNhanHieu";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaNhanHieu' => $maNhanHieu
        ]);

        return $stmt->fetch();
    }

    // Thêm nhãn hiệu
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaNhanHieu,
                    TenNhanHieu,
                    Logo,
                    MoTa,
                    TrangThai
                )
                VALUES
                (
                    :MaNhanHieu,
                    :TenNhanHieu,
                    :Logo,
                    :MoTa,
                    :TrangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaNhanHieu' => $data['MaNhanHieu'],
            ':TenNhanHieu' => $data['TenNhanHieu'],
            ':Logo' => $data['Logo'],
            ':MoTa' => $data['MoTa'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    // Cập nhật nhãn hiệu
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    TenNhanHieu = :TenNhanHieu,
                    Logo = :Logo,
                    MoTa = :MoTa,
                    TrangThai = :TrangThai
                WHERE MaNhanHieu = :MaNhanHieu";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaNhanHieu' => $data['MaNhanHieu'],
            ':TenNhanHieu' => $data['TenNhanHieu'],
            ':Logo' => $data['Logo'],
            ':MoTa' => $data['MoTa'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }
    public function generateMaNhanHieu()
    {
        $sql = "SELECT MaNhanHieu
            FROM {$this->table}
            WHERE MaNhanHieu LIKE 'NH%'
            ORDER BY CAST(SUBSTRING(MaNhanHieu, 3) AS UNSIGNED) DESC
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $nhanHieu = $stmt->fetch();

        if (!$nhanHieu) {
            return 'NH01';
        }

        $so = (int) substr($nhanHieu['MaNhanHieu'], 2);
        $so++;

        return 'NH' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
    // Xóa nhãn hiệu
    public function delete($maNhanHieu)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaNhanHieu = :MaNhanHieu";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaNhanHieu' => $maNhanHieu
        ]);
    }
}
