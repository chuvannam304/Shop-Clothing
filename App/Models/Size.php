<?php

require_once __DIR__ . '/../../config/database.php';

class Size
{
    private $conn;
    private $table = 'size';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả size
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}
                ORDER BY TenSize ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy size theo mã
    public function getById($maSize)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE MaSize = :MaSize";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSize' => $maSize
        ]);

        return $stmt->fetch();
    }

    // Thêm size
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaSize,
                    TenSize,
                    MoTa
                )
                VALUES
                (
                    :MaSize,
                    :TenSize,
                    :MoTa
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSize' => $data['MaSize'],
            ':TenSize' => $data['TenSize'],
            ':MoTa' => $data['MoTa']
        ]);
    }
    // Tự sinh mã size
    public function generateMaSize()
    {
        $sql = "SELECT MaSize
            FROM {$this->table}
            WHERE MaSize LIKE 'SIZE%'
            ORDER BY CAST(SUBSTRING(MaSize, 5) AS UNSIGNED) DESC
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $size = $stmt->fetch();

        if (!$size) {
            return 'SIZE01';
        }

        $so = (int) substr($size['MaSize'], 4);
        $so++;

        return 'SIZE' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
    // Cập nhật size
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    TenSize = :TenSize,
                    MoTa = :MoTa
                WHERE MaSize = :MaSize";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSize' => $data['MaSize'],
            ':TenSize' => $data['TenSize'],
            ':MoTa' => $data['MoTa']
        ]);
    }
public function getByName($tenSize)
{
    $sql = "SELECT * FROM {$this->table}
            WHERE TenSize = :TenSize";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':TenSize' => $tenSize
    ]);

    return $stmt->fetch();
}
    // Xóa size
    public function delete($maSize)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaSize = :MaSize";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSize' => $maSize
        ]);
    }
}
