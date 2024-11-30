
<?php
include_once __DIR__ . '/data/xl_sua.php';

$sua = new xl_sua();
$suaMang = $sua->xl_sua_all(); 


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Hãy Khám Phá Thế Giới Sữa</title>
    <link rel="stylesheet" href="assets/index.css">
   
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/menu_header.php'; ?>
    <div class="container">
        <main class="content">
            
            
            <!-- Danh sách sản phẩm -->
            <div class="tieude">THÔNG TIN CÁC SẢN PHẨM</div>
            <table>
                
<?php
if ($suaMang && count($suaMang) > 0) {
    echo "<table>";
    $count = 0;
    foreach ($suaMang as $dong) {
        if ($count > 0 && $count % 5 == 0) {
            echo "</tr><tr>"; 
        }

        $duong_dan_hinh = $dong["hinh"];
        if (!file_exists($duong_dan_hinh)) {
            $duong_dan_hinh = "images/default-image.jpg"; 
        }

        // Hiển thị sản phẩm
        echo "<td>
                <a href='chi_tiet.php?ma_sua=" . htmlspecialchars($dong["ma_sua"]) . "'>
                    <table class='product-table'>
                        <tr>
                            <td class='info'>
                                <strong>" . htmlspecialchars($dong["ten_sua"]) . "</strong><br>" 
                                . htmlspecialchars($dong["trong_luong"]) . "g - " 
                                . number_format($dong["don_gia"], 0, ',', '.') . " VNĐ
                            </td>
                        </tr>
                        <tr>
                            <td><img src='" . htmlspecialchars($duong_dan_hinh) . "' alt='" . htmlspecialchars($dong["ten_sua"]) . "'></td>
                        </tr>
                    </table>
                </a>
            </td>";
        $count++;
    }
    echo "</tr>";
    echo "</table>";
} else {
    echo "<tr><td colspan='5'>Không có dữ liệu</td></tr>";
}
?>
            </table>
        </main>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>