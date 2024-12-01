
<?php
if (isset($_GET['ma_sua'])) {
    include_once '../data/xl_sua.php'; // Kết nối đến lớp XL_SUA
    $ma_sua = $_GET['ma_sua'];
    $sua = new xl_sua();
    $chiTiet = $sua->ChiTietSua($ma_sua);} ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sữa</title>
    <style>
        h2 {
            color: pink;
            text-align: center;    
        }
      
      .container-detail {
            display: flex;
            align-items: flex-start;
            max-width: 1000px;
            margin: auto;
        }
        .image {
            flex: 1;
        }
        .image img {
            width: 100%;
            max-width: 150px;
        }
        .info {
            flex: 3;
            
        }
        .info p {
            margin: 5px 0;
            font-size: 16px;
        }
        .info p strong {
            color: #333;
        }
    </style>
</head>
<body>
<?php if ($chiTiet): ?>
    <h2><?php echo htmlspecialchars($chiTiet['ten_sua']); ?> - <?php echo htmlspecialchars($chiTiet['ten_hang_sua']); ?></h2>
    <div class="container-detail">
        <div class="image">
            <img src="../<?php echo htmlspecialchars($chiTiet['hinh']); ?>" alt="<?php echo htmlspecialchars($chiTiet['ten_sua']); ?>">
        </div>
        <div class="info">
            
            <strong>Thành phần dinh dưỡng:</strong><br> <?php echo htmlspecialchars($chiTiet['tp_dinh_duong']); ?>
    
<br>    
           
            <strong>Lợi ích:</strong><br>
 <?php echo htmlspecialchars($chiTiet['loi_ich']); ?>
         <p><strong>Trọng lượng:</strong><span style="color:brown"> 
 <?php echo htmlspecialchars($chiTiet['trong_luong']); ?> gram
 </span> - <strong>Đơn giá:</strong><span style="color:brown"> <?php echo number_format($chiTiet['don_gia'], 0, ',', '.'); ?> VNĐ</span></p>
</div>
    </div>
<?php else: ?>
    <p>Không tìm thấy thông tin sữa.</p>
<?php endif; ?>
</body>
</html>