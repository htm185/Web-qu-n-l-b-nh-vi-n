<!-- Thao My -->
<?php
include 'components/connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ POST
    $patient_id = $_POST['patient_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $consultation_fee = $_POST['consultation_fee'];//Tiền bảo hiểm
    $medicine_fee = $_POST['medicine_fee'];//Tiền thuốc
    $test_fee = $_POST['test_fee'];//Tiền xét nghiệm
    $insurance_code = isset($_POST['insurance_code']) ? $_POST['insurance_code'] : 'Không có';//maBHYT
    $total_amount = $_POST['total_amount'];
    $payment_method = $_POST['payment_method'];
    $payment_date = date('Y-m-d'); // Ngày thanh toán hiện tại
    
        
            // Thêm hóa đơn vào bảng HoaDon
            $stmt = $conn->prepare("
                INSERT INTO hoadon (MaBenhNhan, TenBenhNhan, Khoa, TienKham, TienThuoc, TienXetNghiem, MaBaoHiem, TongTien, PhuongThucThanhToan, NgayTao)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())
            ");
            $stmt->execute([
                $patient_id,
                $name,
                $department,
                $consultation_fee,
                $medicine_fee,
                $test_fee,
                $insurance_code,
                $total_amount,
                $payment_method
            ]);

      
    

}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn</title>
    <link rel="stylesheet" href="css/hoadon.css">
</head>
<body>

<div class="invoice-container">
 
    <div class="invoice-header">
        <h1>BIÊN NHẬN THU VIỆN PHÍ</h1>
        <p>-----------------------------</p>
        <p>Ngày <?php echo date('d'); ?> Tháng <?php echo date('m'); ?> Năm <?php echo date('Y'); ?></p>
    </div>


    <div class="invoice-details">
        <p><strong>Tên BN:</strong> <?php echo htmlspecialchars($name); ?></p>
        <p><strong>Mã bệnh nhân:</strong> <?php echo htmlspecialchars($patient_id); ?></p>
        <p><strong>Khoa khám:</strong> <?php echo htmlspecialchars($department); ?></p>
        <p><strong>Mã BHYT:</strong> <?php echo htmlspecialchars($insurance_code); ?></p>
    </div>

  
    <table class="invoice-items">
        <tr>
            <th></th>
            <th>Số tiền (VND)</th>
        </tr>
        
        <tr>
            <td>Tiền thuốc</td>
            <td><?php echo number_format($medicine_fee); ?></td>
        </tr>
        <tr>
            <td>Tiền xét nghiệm</td>
            <td><?php echo number_format($test_fee); ?></td>
        </tr>
        <tr>
            <td>Tiền bảo hiểm</td>
            <td>- <?php echo number_format($consultation_fee); ?></td>
        </tr>
        <tr class="total">
            <td>Tổng cộng:</td>
            <td><?php echo number_format($total_amount); ?></td>
        </tr>
    </table>

   

    <!-- Footer -->
    <div class="invoice-footer">
        <p><strong>Thực thu:</strong> <?php echo number_format($total_amount); ?> VND</p>
    
        <p><?php echo date('d/m/Y'); ?> - Thu Tiền</p>
    </div>
</div>



</body>
</html>


