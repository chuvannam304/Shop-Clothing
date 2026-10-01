<?php

require_once __DIR__ . '/../../config/database.php';

class GioHang
{
    private $conn;
    private $table = 'giohang';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Tự sinh mã giỏ hàng: GH01, GH02,...
    public function generateMaGioHang()
    {
        $sql = "SELECT MaGioHang
                FROM {$this->table}
                WHERE MaGioHang LIKE 'GH%'
                ORDER BY CAST(SUBSTRING(MaGioHang, 3) AS UNSIGNED) DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $gioHang = $stmt->fetch();

        if (!$gioHang) {
            return 'GH01';
        }

        $so = (int) substr($gioHang['MaGioHang'], 2);
        $so++;

        return 'GH' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
    // Đếm tổng số lượng sản phẩm trong giỏ của khách hàng
    public function countCartItems($maKH)
    {
        $sql = "SELECT COALESCE(SUM(ct.SoLuong), 0) AS TongSoLuong
            FROM giohang gh
            INNER JOIN chitietgiohang ct
                ON gh.MaGioHang = ct.MaGioHang
            WHERE gh.MaKH = :MaKH
              AND gh.TrangThai = 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaKH' => $maKH
        ]);

        $result = $stmt->fetch();

        return (int) ($result['TongSoLuong'] ?? 0);
    }
    // Tự sinh mã chi tiết giỏ hàng: CTGH01, CTGH02,...
    public function generateMaCTGH()
    {
        $sql = "SELECT MaCTGH
                FROM chitietgiohang
                WHERE MaCTGH LIKE 'CTGH%'
                ORDER BY CAST(SUBSTRING(MaCTGH, 5) AS UNSIGNED) DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $chiTiet = $stmt->fetch();

        if (!$chiTiet) {
            return 'CTGH01';
        }

        $so = (int) substr($chiTiet['MaCTGH'], 4);
        $so++;

        return 'CTGH' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }

    // Lấy giỏ hàng đang hoạt động của khách hàng
    public function getActiveCart($maKH)
    {
        $sql = "SELECT *
                FROM {$this->table}
                WHERE MaKH = :MaKH
                  AND TrangThai = 1
                ORDER BY NgayTao DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaKH' => $maKH
        ]);

        return $stmt->fetch();
    }

    // Tạo giỏ hàng mới
    public function createCart($maKH)
    {
        $maGioHang = $this->generateMaGioHang();

        $sql = "INSERT INTO {$this->table}
                (
                    MaGioHang,
                    MaKH,
                    TrangThai
                )
                VALUES
                (
                    :MaGioHang,
                    :MaKH,
                    1
                )";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaGioHang' => $maGioHang,
            ':MaKH' => $maKH
        ]);

        return $maGioHang;
    }

    // Kiểm tra biến thể đã có trong giỏ chưa
    public function getCartItem($maGioHang, $maBienThe)
    {
        $sql = "SELECT *
                FROM chitietgiohang
                WHERE MaGioHang = :MaGioHang
                  AND MaBienThe = :MaBienThe
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaGioHang' => $maGioHang,
            ':MaBienThe' => $maBienThe
        ]);

        return $stmt->fetch();
    }

    // Thêm biến thể mới vào giỏ
    public function addItem($maGioHang, $maBienThe, $soLuong)
    {
        $sql = "INSERT INTO chitietgiohang
                (
                    MaCTGH,
                    MaGioHang,
                    MaBienThe,
                    SoLuong
                )
                VALUES
                (
                    :MaCTGH,
                    :MaGioHang,
                    :MaBienThe,
                    :SoLuong
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaCTGH' => $this->generateMaCTGH(),
            ':MaGioHang' => $maGioHang,
            ':MaBienThe' => $maBienThe,
            ':SoLuong' => $soLuong
        ]);
    }

    // Nếu sản phẩm đã có trong giỏ thì cộng số lượng
    public function updateItemQuantity($maCTGH, $soLuong)
    {
        $sql = "UPDATE chitietgiohang
                SET SoLuong = :SoLuong
                WHERE MaCTGH = :MaCTGH";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':SoLuong' => $soLuong,
            ':MaCTGH' => $maCTGH
        ]);
    }

    // Xóa một sản phẩm khỏi giỏ
    public function deleteItem($maCTGH, $maGioHang)
    {
        $sql = "DELETE FROM chitietgiohang
            WHERE MaCTGH = :MaCTGH
              AND MaGioHang = :MaGioHang";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaCTGH' => $maCTGH,
            ':MaGioHang' => $maGioHang
        ]);
    }

    // Xóa toàn bộ sản phẩm trong giỏ
    public function clearCart($maGioHang)
    {
        $sql = "DELETE FROM chitietgiohang
                WHERE MaGioHang = :MaGioHang";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaGioHang' => $maGioHang
        ]);
    }
    // Lấy danh sách sản phẩm trong giỏ hàng
    public function getCartItems($maGioHang)
    {
        $sql = "SELECT
                ct.MaCTGH,
                ct.MaGioHang,
                ct.MaBienThe,
                ct.SoLuong,

                bt.MaSP,
                bt.MaMau,
                bt.MaSize,
                bt.MaSKU,
                bt.GiaBan,
                bt.SoLuongTon,

                sp.TenSP,

                ms.TenMau,
                ms.MaHex,

                s.TenSize,

                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSP = sp.MaSP
                    ORDER BY ha.LaAnhChinh DESC, ha.ThuTu ASC
                    LIMIT 1
                ) AS HinhAnh

            FROM chitietgiohang ct

            INNER JOIN sanphambienthe bt
                ON ct.MaBienThe = bt.MaBienThe

            INNER JOIN sanpham sp
                ON bt.MaSP = sp.MaSP

            INNER JOIN mausac ms
                ON bt.MaMau = ms.MaMau

            INNER JOIN size s
                ON bt.MaSize = s.MaSize

            WHERE ct.MaGioHang = :MaGioHang

            ORDER BY ct.MaCTGH DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaGioHang' => $maGioHang
        ]);

        return $stmt->fetchAll();
    }
}
