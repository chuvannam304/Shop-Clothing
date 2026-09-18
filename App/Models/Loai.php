<?php

require_once __DIR__ . '/../../config/database.php';

class Loai
{
    private $conn;
    private $table = 'loai';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY TenLoai ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getActive()
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE TrangThai = 1
                ORDER BY TenLoai ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById($maLoai)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaLoai = :MaLoai";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaLoai' => $maLoai
        ]);

        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaLoai,
                    TenLoai,
                    MoTa,
                    TrangThai
                )
                VALUES
                (
                    :MaLoai,
                    :TenLoai,
                    :MoTa,
                    :TrangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaLoai' => $data['MaLoai'],
            ':TenLoai' => $data['TenLoai'],
            ':MoTa' => $data['MoTa'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    TenLoai = :TenLoai,
                    MoTa = :MoTa,
                    TrangThai = :TrangThai
                WHERE MaLoai = :MaLoai";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaLoai' => $data['MaLoai'],
            ':TenLoai' => $data['TenLoai'],
            ':MoTa' => $data['MoTa'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }
    public function generateMaLoai()
    {
        $sql = "SELECT MaLoai
            FROM {$this->table}
            WHERE MaLoai LIKE 'LOAI%'
            ORDER BY CAST(SUBSTRING(MaLoai, 5) AS UNSIGNED) DESC
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $loai = $stmt->fetch();

        if (!$loai) {
            return 'LOAI01';
        }

        $so = (int) substr($loai['MaLoai'], 4);
        $so++;

        return 'LOAI' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
    public function delete($maLoai)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaLoai = :MaLoai";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaLoai' => $maLoai
        ]);
    }
}
