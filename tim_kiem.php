<?php 
include_once 'data/xl_sua.php';
include_once 'data/xl_hang_sua.php';
include_once 'data/xl_loai_sua.php';

// Lấy danh sách loại và hãng sữa
$loai_sua = (new XL_LOAI_SUA())->xl_loai_sua();
$hang_sua = (new XL_HANG_SUA())->xl_hang_sua();

$sua = new xl_sua();

// Lấy thông tin lọc từ GET
$ma_loai_sua = isset($_GET['loai_sua']) ? $_GET['loai_sua'] : null;
$ma_hang_sua = isset($_GET['hang_sua']) ? $_GET['hang_sua'] : null;
$ten_sua = isset($_GET['ten_sua']) ? $_GET['ten_sua'] : null;

// Lọc dữ liệu
$mang_sua = $sua->xl_sua_loc($ma_loai_sua, $ma_hang_sua, $ten_sua);
?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục Sữa</title>
    <style>
        /* Giao diện tổng thể */
        .wrapper {
            display: flex;
            flex-direction: column;
        }

        .content {
            flex-grow: 1;
            padding: 10px;
        }

        .tieude {
            font-size: 24px;
            font-weight: bold;
            color: #FF69B4;
            margin-bottom: 10px;
        }

        /* Form tìm kiếm */
        .form-container {
            background-color: #fff;
            padding: 20px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            display: grid;
            grid-template-columns: 0.5fr 1fr 0.5fr 1fr;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
            width:200px
        }

        input[type="text"],
        select {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #007bff;
        }

        button[type="submit"] {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Giao diện cho từng sản phẩm */
        .product-item {
            display: flex;
            align-items: center;
            border: 2px solid #ccc;
            padding: 15px;
            margin: 15px 15px 0px 15px;
            
            border-radius: 8px;
            background-color: #f9f9f9;
        }
.tieude {
margin-bottom:-20px;

}
        .product-item img {
            width: 100px; /* Kích thước hình ảnh */
            height: auto;
            margin-right: 15px; /* Khoảng cách giữa hình ảnh và thông tin */
        }

        .product-item div {
            flex-grow: 1;
        }

        .product-item h3 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }

        .product-item p {
            margin: 5px 0;
            color: #555;
        }
.content-detail {
background-color:pink
}
        
    </style>
</head>

<body>
<div class="wrapper">
<?php include_once 'includes/header.php'; ?>
    <?php include_once 'includes/container_menu.php'; ?>
    <div class="content">
        <div class="tieude">Danh Mục Sữa</div>
        
        <!-- Form tìm kiếm -->
        <div class="form-container">
            <form method="GET">
                <div class="form-group">
                    <label for="loai_sua">Chọn Loại Sữa:</label>
                    <select name="loai_sua">
                        <option value="">-- Chọn Loại Sữa --</option>
                        <?php foreach ($loai_sua as $loai): ?>
                            <option value="<?php echo $loai['ma_loai_sua']; ?>" <?php echo $ma_loai_sua == $loai['ma_loai_sua'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($loai['ten_loai']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="hang_sua">Chọn Hãng Sữa:</label>
                    <select name="hang_sua">
                        <option value="">-- Chọn Hãng Sữa --</option>
                        <?php foreach ($hang_sua as $hang): ?>
                            <option value="<?php echo $hang['ma_hang_sua']; ?>" <?php echo $ma_hang_sua == $hang['ma_hang_sua'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($hang['ten_hang_sua']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ten_sua">Tìm kiếm theo tên sữa:</label>
                    <input type="text" name="ten_sua" value="<?php echo htmlspecialchars($ten_sua ?? ''); ?>" />
                </div>
                <button type="submit">Tìm kiếm</button>
            </form>
        </div>

        <!-- Kết quả tìm kiếm -->
        <div class="content-detail">
 
    <?php if (!empty($mang_sua)): ?>
  
      <h3><strong>Số lượng kết quả tìm thấy: </strong><?php echo count($mang_sua); ?></h3>
        <?php foreach ($mang_sua as $sua_item): ?>
<div class="tieude"><h3 style="background-color:pink; padding-left:10px"><?php echo htmlspecialchars($sua_item['ten_sua']); ?>
 - <?php echo htmlspecialchars($sua_item['ma_hang_sua']); ?>
</h3></div>
            <div class="product-item">

                <img src="<?php echo htmlspecialchars($sua_item['hinh']); ?>" alt="<?php echo htmlspecialchars($sua_item['ten_sua']); ?>" />

                <div>
                                  
                   
 <p><strong>Thành phần dinh dưỡng:</strong> <?php echo htmlspecialchars($sua_item['tp_dinh_duong']); ?></p>


 <p><strong>Lợi ích:</strong> <?php echo htmlspecialchars($sua_item['loi_ich']); ?></p>
                    <p><strong>Trọng Lượng:</strong> <?php echo htmlspecialchars($sua_item['trong_luong']); ?>g</p>
                    <p><strong>Đơn Giá:</strong> <?php echo number_format($sua_item['don_gia'], 0, ',', '.'); ?> VNĐ</p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không tìm thấy sữa nào.</p>
    <?php endif; ?>
    </div>


</body>
<?php include_once 'includes/footer.php'; ?>
</html>