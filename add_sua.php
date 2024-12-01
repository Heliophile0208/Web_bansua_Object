<?php
include_once __DIR__ . '../db/database.php';
include_once 'data/xl_sua.php';

$xl_sua = new xl_sua();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $xl_sua->them_sua();

    if (is_array($result)) {
  
        $ma_sua = $result['ma_sua'];  
        $message = 'Sản phẩm đã được thêm thành công.';


        $new_product = $xl_sua->lay_thong_tin_chi_tiet($ma_sua);  
    } else {
        
        $error = $result; 
    }
}

$hang_sua = $xl_sua->getHangSua();
$loai_sua = $xl_sua->getLoaiSua();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Sữa</title>
    <link rel="stylesheet" href="assets/index.css">
    <style>
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
            color: pink;
            margin-bottom: 10px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            width: 800px;
            margin: 0 auto;
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #007bff;
        }

        .btn-submit {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            cursor: pointer;
            margin: 0 auto;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

       
        .message {
            margin-top: 20px;
            padding: 20px;
            background-color: #d4edda;
            border: 1px solid #28a745;
            color: #155724;
            text-align: center;
            font-weight: bold;
        }

        .message h3 {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
        }

    
        .error {
            margin-top: 10px;
            padding: 15px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            color: #721c24;
            text-align: center;
            font-weight: bold;
        }

        .table-them {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 2px solid black;
        }

        .table-them tr {
            border: 2px solid black;
        }

        .table-them td {
            padding: 8px;
            border: 2px solid black;
            vertical-align: top;
        }

        .table-them td strong {
            color: #007bff;
            text-align: left;
            display: block;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'includes/header.php'; ?>
        <?php include 'includes/container_menu.php'; ?>

        <main class="content">
            <div class="tieude">Thêm Sữa Mới</div>
            <div class="form-container">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="ma_sua">Mã sữa:</label>
                        <input type="text" id="ma_sua" name="ma_sua" required>
                    </div>
                    <div class="form-group">
                        <label for="ten_sua">Tên sữa:</label>
                        <input type="text" id="ten_sua" name="ten_sua" required>
                    </div>
                    <div class="form-group">
                        <label for="hang_sua">Hãng sữa:</label>
                        <select id="hang_sua" name="hang_sua" required>
                            <?php foreach ($hang_sua as $row): ?>
                                <option value="<?= $row['ma_hang_sua']; ?>"><?= $row['ten_hang_sua']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="loai_sua">Loại sữa:</label>
                        <select id="loai_sua" name="loai_sua" required>
                            <?php foreach ($loai_sua as $row): ?>
                                <option value="<?= $row['ma_loai_sua']; ?>"><?= $row['ten_loai']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trong_luong">Trọng lượng (gr):</label>
                        <input type="number" id="trong_luong" name="trong_luong" required>
                    </div>
                    <div class="form-group">
                        <label for="don_gia">Đơn giá (VNĐ):</label>
                        <input type="number" id="don_gia" name="don_gia" required>
                    </div>
                    <div class="form-group">
                        <label for="tp_dinh_duong">Thành phần dinh dưỡng:</label>
                        <textarea id="tp_dinh_duong" name="tp_dinh_duong" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="loi_ich">Lợi ích:</label>
                        <textarea id="loi_ich" name="loi_ich" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="hinh">Chọn hình ảnh:</label>
                        <input type="file" id="hinh" name="hinh" required>
                    </div>
                    <div style="text-align:center">
                        <button type="submit" class="btn-submit">Thêm Mới</button>
                    </div>
                </form>

             
                <?php if (isset($error)): ?>
                    <div class="error">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                
                <?php if (isset($message)): ?>
                    <div class="message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

              
                <?php if (isset($new_product)): ?>
                    <div class="message">
                        <h3>Thông tin sản phẩm vừa thêm:</h3>
                        <table class="table-them">
                            <tr>
                                <td><strong>Mã Sữa:</strong></td>
                                <td><?php echo htmlspecialchars($new_product['ma_sua']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tên Sữa:</strong></td>
                                <td><?php echo htmlspecialchars($new_product['ten_sua']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Hãng Sữa:</strong></td>
                                <td><?php echo htmlspecialchars($new_product['ma_hang_sua']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Loại Sữa:</strong></td>
                                <td><?php echo htmlspecialchars($new_product['ma_loai_sua']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Trọng Lượng:</strong></td>
                                <td><?php echo htmlspecialchars($new_product['trong_luong']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Đơn Giá:</strong></td>
                                <td><?php echo htmlspecialchars($new_product['don_gia']); ?></td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
<?php include 'includes/footer.php'; ?>

</html>