<?php

require_once __DIR__ . '/../../config/database.php';

class TaiKhoan
{
    private $conn;
    private $table = 'taikhoan';

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Tự sinh mã tài khoản: TK01, TK02,...
    public function generateMaTK()
    {
        $sql = "SELECT MaTK
                FROM {$this->table}
                WHERE MaTK LIKE 'TK%'
                ORDER BY CAST(SUBSTRING(MaTK, 3) AS UNSIGNED) DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $taiKhoan = $stmt->fetch();

        if (!$taiKhoan) {
            return 'TK01';
        }

        $so = (int) substr($taiKhoan['MaTK'], 2);
        $so++;

        return 'TK' . str_pad($so, 2, '0', STR_PAD_LEFT);
    }

    // Tìm tài khoản theo email
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Email = :Email
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':Email' => $email
        ]);

        return $stmt->fetch();
    }

    // Tìm tài khoản theo số điện thoại
    public function getBySoDienThoai($soDienThoai)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE SoDienThoai = :SoDienThoai
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':SoDienThoai' => $soDienThoai
        ]);

        return $stmt->fetch();
    }

    // Tìm tài khoản bằng email hoặc số điện thoại
    public function getByLogin($login)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Email = :Login
                OR SoDienThoai = :Login
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':Login' => $login
        ]);

        return $stmt->fetch();
    }

    // Thêm tài khoản
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (
                    MaTK,
                    Email,
                    SoDienThoai,
                    MatKhau,
                    LoaiDangNhap,
                    VaiTro,
                    TrangThai
                )
                VALUES
                (
                    :MaTK,
                    :Email,
                    :SoDienThoai,
                    :MatKhau,
                    :LoaiDangNhap,
                    :VaiTro,
                    :TrangThai
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':MaTK' => $data['MaTK'],
            ':Email' => $data['Email'],
            ':SoDienThoai' => $data['SoDienThoai'],
            ':MatKhau' => $data['MatKhau'],
            ':LoaiDangNhap' => $data['LoaiDangNhap'],
            ':VaiTro' => $data['VaiTro'],
            ':TrangThai' => $data['TrangThai']
        ]);
    }
    
    // ADMIN - DANH SÁCH TÀI KHOẢN
    
    public function getAll()
    {
        $sql = "SELECT
                tk.MaTK,
                tk.Email,
                tk.SoDienThoai,
                tk.VaiTro,
                tk.TrangThai,
                tk.NgayTao,
                kh.MaKH,
                kh.HoTen
            FROM taikhoan tk
            LEFT JOIN khachhang kh ON tk.MaTK = kh.MaTK
            ORDER BY tk.NgayTao DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    
    // ADMIN - CHI TIẾT TÀI KHOẢN
    
    public function getById($maTK)
    {
        $sql = "SELECT
                tk.MaTK,
                tk.Email,
                tk.SoDienThoai,
                tk.VaiTro,
                tk.TrangThai,
                tk.NgayTao,
                kh.MaKH,
                kh.HoTen,
                kh.NgaySinh,
                kh.GioiTinh,
                kh.AnhDaiDien
            FROM taikhoan tk
            LEFT JOIN khachhang kh ON tk.MaTK = kh.MaTK
            WHERE tk.MaTK = :MaTK
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':MaTK' => $maTK
        ]);

        return $stmt->fetch();
    }


    
    // ADMIN - KHÓA / MỞ TÀI KHOẢN
    
    public function updateTrangThai($maTK, $trangThai)
    {
        $sql = "UPDATE taikhoan
            SET TrangThai = :TrangThai
            WHERE MaTK = :MaTK";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':TrangThai' => $trangThai,
            ':MaTK' => $maTK
        ]);
    }


    
    // ADMIN - cấp quyền
    
    public function updateVaiTro($maTK, $vaiTro)
    {
        $sql = "UPDATE taikhoan
            SET VaiTro = :VaiTro
            WHERE MaTK = :MaTK";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':VaiTro' => $vaiTro,
            ':MaTK' => $maTK
        ]);
    }
}
