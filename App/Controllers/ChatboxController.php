<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Chatbox.php';

class ChatboxController
{
    private $chatboxModel;

    public function __construct()
    {
        global $conn;
        $this->chatboxModel = new Chatbox($conn);
    }

    public function send()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Phương thức không hợp lệ.'
            ]);
            exit;
        }

        $message = trim($_POST['message'] ?? '');

        if ($message === '') {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng nhập nội dung.'
            ]);
            exit;
        }

        try {
            $products = $this->chatboxModel->getProductData();
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Không thể đọc dữ liệu sản phẩm.'
            ]);
            exit;
        }

        $productContext = '';
        $productIds = [];

        foreach ($products as $product) {
            if (!empty($product['MaSP'])) {
                $productIds[$product['MaSP']] = true;
            }

            $productContext .=
                "Mã SP: " . ($product['MaSP'] ?? '') .
                " | Tên: " . ($product['TenSP'] ?? '') .
                " | Loại: " . ($product['TenLoai'] ?? '') .
                " | Nhãn hiệu: " . ($product['TenNhanHieu'] ?? '') .
                " | Giới tính: " . ($product['GioiTinh'] ?? '') .
                " | Chất liệu: " . ($product['ChatLieu'] ?? '') .
                " | Màu: " . ($product['TenMau'] ?? '') .
                " | Size: " . ($product['TenSize'] ?? '') .
                " | SKU: " . ($product['MaSKU'] ?? '') .
                " | Giá: " . number_format((float) ($product['GiaBan'] ?? 0), 0, ',', '.') . " VNĐ" .
                " | Trạng thái: " . ($product['TrangThaiTonKho'] ?? '') .
                "\n";
        }

        $totalProducts = count($productIds);

        $url = 'http://localhost:11434/api/chat';

        $data = [
            'model' => 'qwen3:1.7b',
            'stream' => false,
            'think' => false,
            'keep_alive' => '10m',
            'options' => [
                'num_predict' => 150,
                'temperature' => 0.2
            ],
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Bạn là trợ lý tư vấn của cửa hàng thời trang NamShop.

Chỉ hỗ trợ các câu hỏi liên quan đến thời trang, quần áo, sản phẩm và mua sắm tại NamShop.

Chỉ được sử dụng dữ liệu sản phẩm NamShop được cung cấp.

Không được tự bịa sản phẩm, giá, màu, size, nhãn hiệu hoặc trạng thái còn hàng.

Tuyệt đối không được nói, đoán hoặc tự tạo số lượng tồn kho cụ thể.

Nếu trạng thái là "Còn hàng" thì chỉ được nói sản phẩm hiện còn hàng.

Nếu trạng thái là "Hết hàng" thì chỉ được nói sản phẩm hiện đã hết hàng.

Nếu khách hỏi "còn bao nhiêu sản phẩm", "tồn bao nhiêu" hoặc câu hỏi tương tự thì không được đưa ra con số tồn kho. Hãy trả lời rằng NamShop chỉ cung cấp thông tin còn hàng hoặc hết hàng.

Số lượng sản phẩm của shop phải sử dụng đúng tổng số sản phẩm được cung cấp, không được đếm các biến thể màu hoặc size thành sản phẩm riêng.

Nếu không tìm thấy sản phẩm phù hợp trong dữ liệu thì hãy nói hiện chưa tìm thấy sản phẩm phù hợp.

Giá tiền phải hiển thị theo định dạng tiền Việt Nam.

Trả lời bằng tiếng Việt, ngắn gọn, thân thiện và dễ hiểu.'
                ],
                [
                    'role' => 'user',
                    'content' => "TỔNG SỐ SẢN PHẨM NAMSHOP: " . $totalProducts .
                        "\n\nDỮ LIỆU SẢN PHẨM NAMSHOP HIỆN TẠI:\n" .
                        $productContext .
                        "\nCÂU HỎI CỦA KHÁCH:\n" .
                        $message
                ]
            ]
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($ch);

        if ($response === false) {
            curl_close($ch);

            echo json_encode([
                'success' => false,
                'message' => 'Không thể kết nối với trợ lý NamShop.'
            ]);
            exit;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode !== 200) {
            echo json_encode([
                'success' => false,
                'message' => 'Trợ lý NamShop đang gặp lỗi.'
            ]);
            exit;
        }

        $result = json_decode($response, true);

        $answer = trim($result['message']['content'] ?? '');

        if ($answer === '') {
            echo json_encode([
                'success' => false,
                'message' => 'Trợ lý chưa thể trả lời câu hỏi này.'
            ]);
            exit;
        }

        echo json_encode([
            'success' => true,
            'message' => $answer
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }
}