<?php
include_once __DIR__ . '/data/xl_sua.php';


$ma_sua = isset($_GET['ma_sua']) ? $_GET['ma_sua'] : null;


if ($ma_sua) {
    $sua = new xl_sua();
    $chi_tiet_sua = $sua->xl_sua_theo_ma($ma_sua);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" href="assets/index.css">
</head>
<style>
    .content {
        flex-grow: 1;
        padding: 0px 10px 10px 10px;
    }

    .tieude {
        font-size: 24px;
        font-weight: bold;
        color: pink;
        text-align: left;
        padding: 10px 10px 0px 10px;
    }

    .product-detail {
        display: flex;
        background-color: #fff;
    }

    .product-detail img {
        width: 200px;
        height: auto;
        padding: 0px 10px
    }

    .info {
        flex: 1;
        display: flex;
        flex-direction: column;

    }

    .info strong {
        font-weight: bold;
        color: #007bff;
    }

    .no-product {
        text-align: center;
        font-size: 1.2rem;
        color: #f00;
    }
</style>

<body>

    <?php include 'includes/header.php'; ?>

    <?php include 'includes/container_menu.php'; ?>

    <main class="content">
        <?php if ($chi_tiet_sua): ?>

            <div class="tieude"><?php echo htmlspecialchars($chi_tiet_sua["ten_sua"]); ?></div>
            <div class="product-detail">

                <img src="<?php echo htmlspecialchars($chi_tiet_sua["hinh"]); ?>" alt="<?php echo htmlspecialchars($chi_tiet_sua["ten_sua"]); ?>" />
                <div class="info">



                    <p><strong>Lợi ích:</strong> <?php echo htmlspecialchars($chi_tiet_sua["loi_ich"]); ?>g</p>
                    <p><strong>Thành phần dinh dưỡng:</strong> <?php echo htmlspecialchars($chi_tiet_sua["tp_dinh_duong"]); ?></p>
                    <p><strong>Trọng lượng:</strong> <span style="color:brown;"><?php echo htmlspecialchars($chi_tiet_sua["trong_luong"]); ?>g</span> - <strong>Đơn giá:</strong><span style="color:brown;"> <?php echo number_format($chi_tiet_sua["don_gia"], 0, ',', '.'); ?> VNĐ</span></p>
                </div>
            </div>
        <?php else: ?>
            <p class="no-product">Không tìm thấy sản phẩm.</p>
        <?php endif; ?>
    </main>
    </div>


</body>

<?php include 'includes/footer.php'; ?>

</html>