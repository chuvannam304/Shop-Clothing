<?php

require_once __DIR__ . '/../../config/database.php';

class SanPham
{
    private $conn;
    private $table = 'sanpham';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Lấy tất cả sản phẩm
    public function getAll()
    {
        $sql = "SELECT 
                sp.*,
                l.TenLoai,
                nh.TenNhanHieu,
                (
                    SELECT h.DuongDan
                    FROM hinhanhsanpham h
                    WHERE h.MaSP = sp.MaSP
                    ORDER BY h.LaAnhChinh DESC, h.ThuTu ASC
                    LIMIT 1
                ) AS AnhChinh
            FROM {$this->table} sp
            INNER JOIN loai l ON sp.MaLoai = l.MaLoai
            INNER JOIN nhanhieu nh ON sp.MaNhanHieu = nh.MaNhanHieu
            ORDER BY sp.NgayTao DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    //
    public function getHomeProducts()
    {
        $sql = "SELECT
                sp.MaSP,
                sp.TenSP,
                MIN(bt.GiaBan) AS GiaBan,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSP = sp.MaSP
                    ORDER BY ha.LaAnhChinh DESC, ha.ThuTu ASC
                    LIMIT 1
                ) AS HinhAnh
            FROM sanpham sp
            INNER JOIN sanphambienthe bt ON sp.MaSP = bt.MaSP
            WHERE sp.TrangThai = 1
              AND bt.TrangThai = 1
            GROUP BY sp.MaSP, sp.TenSP
            ORDER BY sp.NgayTao DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    // Lấy sản phẩm theo mã
    // Lấy chi tiết sản phẩm theo mã
    public function getById($maSP)
    {
        $sql = "SELECT
                sp.*,
                l.TenLoai,
                nh.TenNhanHieu
            FROM sanpham sp
            INNER JOIN loai l ON sp.MaLoai = l.MaLoai
            INNER JOIN nhanhieu nh ON sp.MaNhanHieu = nh.MaNhanHieu
            WHERE sp.MaSP = :MaSP
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSP' => $maSP
        ]);

        return $stmt->fetch();
    }
    // LẤY ALL ảnh
    public function getImages($maSP)
    {
        $sql = "SELECT *
            FROM hinhanhsanpham
            WHERE MaSP = :MaSP
            ORDER BY LaAnhChinh DESC, ThuTu ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSP' => $maSP
        ]);

        return $stmt->fetchAll();
    }
    // lấy biến thể
    public function getVariants($maSP)
    {
        $sql = "SELECT
                bt.MaBienThe,
                bt.MaSP,
                bt.MaMau,
                bt.MaSize,
                bt.MaSKU,
                bt.GiaBan,
                bt.SoLuongTon,
                bt.TrangThai,
                ms.TenMau,
                ms.MaHex,
                s.TenSize
            FROM sanphambienthe bt
            INNER JOIN mausac ms ON bt.MaMau = ms.MaMau
            INNER JOIN size s ON bt.MaSize = s.MaSize
            WHERE bt.MaSP = :MaSP
              AND bt.TrangThai = 1
            ORDER BY ms.TenMau ASC, s.TenSize ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaSP' => $maSP
        ]);

        return $stmt->fetchAll();
    }
    // lấy sp cùng loại
    // Lấy sản phẩm cùng loại
    public function getRelatedProducts($maSP, $maLoai)
    {
        $sql = "SELECT
                sp.MaSP,
                sp.TenSP,
                MIN(bt.GiaBan) AS GiaBan,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSP = sp.MaSP
                    ORDER BY ha.LaAnhChinh DESC, ha.ThuTu ASC
                    LIMIT 1
                ) AS HinhAnh
            FROM sanpham sp
            INNER JOIN sanphambienthe bt ON sp.MaSP = bt.MaSP
            WHERE sp.MaLoai = :MaLoai
              AND sp.MaSP != :MaSP
              AND sp.TrangThai = 1
              AND bt.TrangThai = 1
            GROUP BY sp.MaSP, sp.TenSP
            ORDER BY sp.NgayTao DESC
            LIMIT 10";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaLoai' => $maLoai,
            ':MaSP' => $maSP
        ]);

        return $stmt->fetchAll();
    }
    // Thêm sản phẩm
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaSP,
                    MaLoai,
                    MaNhanHieu,
                    TenSP,
                    MoTa,
                    ChatLieu,
                    GioiTinh,
                    TrangThai
                )
                VALUES
                (
                    :MaSP,
                    :MaLoai,
                    :MaNhanHieu,
                    :TenSP,
                    :MoTa,
                    :ChatLieu,
                    :GioiTinh,
                    :TrangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSP' => $data['MaSP'],
            ':MaLoai' => $data['MaLoai'],
            ':MaNhanHieu' => $data['MaNhanHieu'],
            ':TenSP' => $data['TenSP'],
            ':MoTa' => $data['MoTa'],
            ':ChatLieu' => $data['ChatLieu'],
            ':GioiTinh' => $data['GioiTinh'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }

    // Cập nhật sản phẩm
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET
                    MaLoai = :MaLoai,
                    MaNhanHieu = :MaNhanHieu,
                    TenSP = :TenSP,
                    MoTa = :MoTa,
                    ChatLieu = :ChatLieu,
                    GioiTinh = :GioiTinh,
                    TrangThai = :TrangThai
                WHERE MaSP = :MaSP";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSP' => $data['MaSP'],
            ':MaLoai' => $data['MaLoai'],
            ':MaNhanHieu' => $data['MaNhanHieu'],
            ':TenSP' => $data['TenSP'],
            ':MoTa' => $data['MoTa'],
            ':ChatLieu' => $data['ChatLieu'],
            ':GioiTinh' => $data['GioiTinh'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }
    // Tự sinh mã sản phẩm
    public function generateMaSP()
    {
        $sql = "SELECT MaSP
            FROM {$this->table}
            WHERE MaSP LIKE 'SP%'
            ORDER BY CAST(SUBSTRING(MaSP, 3) AS UNSIGNED) DESC
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $sanPham = $stmt->fetch();

        if (!$sanPham) {
            return 'SP01';
        }

        $so = (int) substr($sanPham['MaSP'], 2);
        $so++;

        return 'SP' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }
    // lấy sản phẩm
    public function getByCategoryName($tenLoai)
    {
        $sql = "SELECT
                sp.MaSP,
                sp.TenSP,
                sp.MaLoai,
                sp.GioiTinh,
                sp.MoTa,
                l.TenLoai,
                MIN(bt.GiaBan) AS GiaBan,
                (
                    SELECT ha.DuongDan
                    FROM hinhanhsanpham ha
                    WHERE ha.MaSP = sp.MaSP
                    ORDER BY ha.LaAnhChinh DESC, ha.ThuTu ASC
                    LIMIT 1
                ) AS HinhAnh
            FROM sanpham sp
            INNER JOIN loai l ON sp.MaLoai = l.MaLoai
            INNER JOIN sanphambienthe bt ON sp.MaSP = bt.MaSP
            WHERE l.TenLoai LIKE :TenLoai
              AND sp.TrangThai = 1
              AND bt.TrangThai = 1
            GROUP BY
                sp.MaSP,
                sp.TenSP,
                sp.MaLoai,
                sp.GioiTinh,
                sp.MoTa,
                l.TenLoai
            ORDER BY sp.NgayTao DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':TenLoai' => '%' . $tenLoai . '%'
        ]);

        return $stmt->fetchAll();
    }
    // Xóa sản phẩm
    public function delete($maSP)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE MaSP = :MaSP";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaSP' => $maSP
        ]);
    }
}
