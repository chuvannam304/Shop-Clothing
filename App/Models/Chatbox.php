<?php

class Chatbox
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getProductData()
    {
        $sql = "SELECT 
                    sp.MaSP,
                    sp.TenSP,
                    sp.GioiTinh,
                    sp.ChatLieu,
                    sp.MoTa,
                    l.TenLoai,
                    nh.TenNhanHieu,
                    ms.TenMau,
                    s.TenSize,
                    bt.MaSKU,
                    bt.GiaBan,
                    bt.SoLuongTon
                FROM sanpham sp
                LEFT JOIN loai l ON sp.MaLoai = l.MaLoai
                LEFT JOIN nhanhieu nh ON sp.MaNhanHieu = nh.MaNhanHieu
                LEFT JOIN sanphambienthe bt ON sp.MaSP = bt.MaSP
                LEFT JOIN mausac ms ON bt.MaMau = ms.MaMau
                LEFT JOIN size s ON bt.MaSize = s.MaSize
                WHERE sp.TrangThai = 1
                AND bt.TrangThai = 1
                ORDER BY sp.TenSP ASC
                LIMIT 100";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}