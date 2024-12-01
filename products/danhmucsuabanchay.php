<?php
include_once '../data/xl_sua.php'; // Kết nối đến lớp XL_SUA

$sua = new XL_SUA();
$mang_sua = $sua->DanhSachSuaBanChay(5); // Lấy danh sách 5 sữa bán chạy nhất
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục Sữa Bán Chạy</title>
    
    <style>
   .khungbao {
    display: flex;
    flex-direction: row;
    margin: 0px; 
    }    
    .sidebar {
    
    width: 220px;
    
    
}
.content-detail {
    flex-grow: 1; 
    padding: 20px;
    background-color: #fff;
    overflow-y: auto; }
table {
    width: 100%;
    border-collapse: collapse;
   
}

th, td {
    padding: 10px;
    border: 1px solid black;
    text-align: left;
}

th {
    background-color: #FF69B4;
    color: white;
}

tr:hover {
    background-color: #f1f1f1; 
}

       
    </style>
</head>
<header>
<?php  include_once '../includes/header.php';?>
<?php include_once '../includes/menu_header.php'; ?>
<body>
<div class="khungbao">
    <!-- Sidebar -->
    <div class="sidebar">
        <table>
            <thead>
                <tr>
                    <th>Danh Mục Sữa Bán Chạy</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mang_sua as $item): ?>
                    <tr>
                        <td>
                            <a href="?ma_sua=<?php echo urlencode($item['ma_sua']); ?>">
                                <?php echo htmlspecialchars($item['ten_sua']); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
 <a href="#" target="_blank">
        <img src="../../Image/side1.jpg" alt="Hình ảnh 1" width=220px >
   </a>
 <a href="#" target="_blank">
        <img src="../../Image/side2.jpg" alt="Hình ảnh 2" width=220px >
   </a>
</div>




    <!-- Content -->
    <div class="content-detail">
        <?php
        if (isset($_GET['ma_sua'])) {
            include 'ct_danhmucsuabanchay.php'; // Hiển thị chi tiết thông tin sữa
        } else {
            echo
 "<h2 style='text-align:center; color:pink'>Chọn sữa để xem chi tiết</h2>";
        }
        ?>
    </div></div>
</body>
<?php include_once '../includes/footer.php' ?>
</html>