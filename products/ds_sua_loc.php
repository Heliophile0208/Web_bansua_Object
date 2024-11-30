<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sữa</title>
    <style>
        h2 {
            color: pink;
        }
        .loc {
  margin:0}

        .image {
            flex: 1;
        }

        .image img {
            width: 100%;
            max-width: 150px;
            border-radius: 8px;
        }

        .info {
            flex: 2;
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
<div class="loc">

<?php
include_once '../data/xl_hang_sua.php'; 
include_once '../data/xl_loai_sua.php'; 
$hang_sua_obj = new xl_hang_sua();
$loai_sua_obj = new xl_loai_sua();
$hang_sua = $_GET['hang_sua'] ?? null;
$loai_sua = $_GET['loai_sua'] ?? null;
if ($hang_sua) {
  
    $ten_hang_sua = $hang_sua_obj->lay_ten_hang_sua_theo_ma($hang_sua);
    echo "<h2 style='text-align:center'>Danh sách sữa của hãng: " . htmlspecialchars($ten_hang_sua) . "</h2>";

    
} elseif ($loai_sua) {
    
    $ten_loai_sua =
$loai_sua_obj->lay_ten_loai_sua_theo_ma($loai_sua);
    echo "<h2 style='text-align:center'>Danh sách sữa loại: " . htmlspecialchars($ten_loai_sua) . "</h2>";
    
   
} else {
    
    echo "<h2 style='text-align:center'>Danh sách tất cả sữa</h2>";
   
}

// Hiển thị danh sách sữa
if (!empty($mang_sua)) {
    echo "<table>";
    echo "<thead>
            <tr>
                <th>Hình</th>
                <th>Tên Sữa</th>
                <th>Loại Sữa</th>
                <th>Hãng Sữa</th>
                <th>Giá</th>
            </tr>
          </thead>";
    echo "<tbody>";

    foreach ($mang_sua as $sua) {
        
        $ten_loai_sua = $loai_sua_obj->lay_ten_loai_sua_theo_ma($sua['ma_loai_sua']);
       
        $ten_hang_sua = $hang_sua_obj->lay_ten_hang_sua_theo_ma($sua['ma_hang_sua']);

        echo "<tr>";
        
        
        if (!empty($sua['hinh'])) {
            echo "<td><img src='../" . htmlspecialchars($sua['hinh']) . "' alt='" . htmlspecialchars($sua['ten_sua']) . "' width='100'></td>";
        } else {
            echo "<td>Không có hình</td>";
        }
        
        
        echo "<td>" . htmlspecialchars($sua['ten_sua']) . "</td>";

        
        echo "<td>" . ($ten_loai_sua ? htmlspecialchars($ten_loai_sua) : 'Không tìm thấy loại') . "</td>";

      
        echo "<td>" . ($ten_hang_sua ? htmlspecialchars($ten_hang_sua) : 'Không tìm thấy hãng') . "</td>";

        
        echo "<td>" . number_format($sua['don_gia']) . " VND</td>";

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<h3 style='text-align:center'>Không tìm thấy sản phẩm nào phù hợp.</h3>";
}
?>
</div>
</body>
</html>