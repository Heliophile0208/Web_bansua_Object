<?php
include_once 'data/xl_khachhang.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xl_khach_hang = new XL_KHACH_HANG();

    $is_added = $xl_khach_hang->them_khach_hang();

    if ($is_added === 'Mã khách hàng đã tồn tại') {
        $message = '<div class="error">Mã khách hàng đã tồn tại. Vui lòng nhập mã khác.</div>';
    } elseif ($is_added) {

        $message = '<div class="message">Thêm khách hàng thành công!</div>';
        $new_customer = $xl_khach_hang->lay_thong_tin_khach_hang($is_added);
    } else {

        $message = '<div class="error">Lỗi khi thêm khách hàng. Vui lòng thử lại.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khách Hàng</title>
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
            margin: 0 auto;
            width: 800px;
        }

        .form-group {
            display: grid;
            grid-template-columns: 0.5fr 1fr 0.5fr 1fr;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .form-group .full-width {
            grid-column: span 2;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #007bff;
        }

        .radio-group {
            display: flex;
            gap: 10px;
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
    </style>
</head>

<body>
    <div class="wrapper">

        <?php include 'includes/header.php'; ?>
        <?php include 'includes/container_menu.php'; ?>

        <main class="content">
            <div class="tieude">Thêm Khách Hàng Mới</div>
            <div class="form-container">
                <form action="" method="POST">
                 
                    <div class="form-group">
                        <label for="ma_khach_hang">Mã KH:</label>
                        <input type="text" id="ma_khach_hang" name="ma_khach_hang" required>

                        <label for="ten_khach_hang">Tên KH:</label>
                        <input type="text" id="ten_khach_hang" name="ten_khach_hang" required>
                    </div>
                    <div class="form-group">
                        <label>Phái:</label>
                        <div class="radio-group">
                            <input type="radio" id="phai_nam" name="phai" value="Nam" required>
                            <label for="phai_nam">Nam</label>
                            <input type="radio" id="phai_nu" name="phai" value="Nữ" required>
                            <label for="phai_nu">Nữ</label>
                        </div>

                        <label for="dia_chi">Địa chỉ:</label>
                        <input type="text" id="dia_chi" name="dia_chi" required>
                    </div>
                    <div class="form-group">
                        <label for="dien_thoai">Điện Thoại:</label>
                        <input type="text" id="dien_thoai" name="dien_thoai" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div style="text-align:center">
                        <button type="submit" class="btn-submit">Thêm Mới</button>
                    </div>
                </form>
                <?php if (isset($message)) echo $message; ?>

        
                <?php if (isset($new_customer)): ?>
                    <div class="message">
                        <h3>Thông tin khách hàng vừa thêm:</h3>
                        <table class="table-them">
                            <tr>
                                <td><strong>Mã KH:</strong></td>
                                <td><?php echo htmlspecialchars($new_customer['ma_khach_hang']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tên KH:</strong></td>
                                <td><?php echo htmlspecialchars($new_customer['ten_khach_hang']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Phái:</strong></td>
                                <td><?php echo htmlspecialchars($new_customer['phai'] == 1 ? 'Nam' : 'Nữ'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Địa chỉ:</strong></td>
                                <td><?php echo htmlspecialchars($new_customer['dia_chi']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Điện thoại:</strong></td>
                                <td><?php echo htmlspecialchars($new_customer['dien_thoai']); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><?php echo htmlspecialchars($new_customer['email']); ?></td>
                            </tr>
                        </table>
                    </div>
                <?php endif; ?>
        </main>
    </div>
</body>

<?php include 'includes/footer.php'; ?>

</html>