<?php

require_once __DIR__ . '/../../config/database.php';

class MauSac
{
    private $conn;
    private $table = 'mausac';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả màu sắc
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY TenMau ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy màu đang hoạt động
    public function getActive()
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE TrangThai = 1
                ORDER BY TenMau ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy màu theo mã
    public function getById($maMau)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaMau = :MaMau";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaMau' => $maMau
        ]);

        return $stmt->fetch();
    }

    // Thêm màu
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaMau,
                    TenMau,
                    MaHex,
                    TrangThai
                )
                VALUES
                (
                    :MaMau,
                    :TenMau,
                    :MaHex,
                    :TrangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaMau' => $data['MaMau'],
            ':TenMau' => $data['TenMau'],
            ':MaHex' => $data['MaHex'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }
    public function generateMaMau()
    {
        $sql = "SELECT MaMau
            FROM {$this->table}
            WHERE MaMau LIKE 'MAU%'
            ORDER BY CAST(SUBSTRING(MaMau, 4) AS UNSIGNED) DESC
            LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $mau = $stmt->fetch();
        if (!$mau) {
            return 'MAU01';
        }

        $so = (int) substr($mau['MaMau'], 3);
        $so++;

        return 'MAU' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
    // Cập nhật màu
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    TenMau = :TenMau,
                    MaHex = :MaHex,
                    TrangThai = :TrangThai
                WHERE MaMau = :MaMau";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaMau' => $data['MaMau'],
            ':TenMau' => $data['TenMau'],
            ':MaHex' => $data['MaHex'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    // Xóa màu
    public function delete($maMau)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaMau = :MaMau";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaMau' => $maMau
        ]);
    }
}
