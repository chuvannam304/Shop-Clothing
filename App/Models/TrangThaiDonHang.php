<?php

require_once __DIR__ . '/../../config/database.php';

class TrangThaiDonHang
{
    private $conn;
    private $table = 'TrangThaiDonHang';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}
                ORDER BY ThuTu ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById($maTrangThai)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaTrangThai = :MaTrangThai
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':MaTrangThai' => $maTrangThai
        ]);

        return $stmt->fetch();
    }
}