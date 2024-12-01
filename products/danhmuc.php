<?php
include_once '../data/xl_sua.php';
include_once '../data/xl_hang_sua.php';
include_once '../data/xl_loai_sua.php';


$loai_sua = (new XL_LOAI_SUA())->xl_loai_sua();
$hang_sua = (new XL_HANG_SUA())->xl_hang_sua();

$sua = new xl_sua();


$ma_loai_sua = isset($_GET['loai_sua']) ? $_GET['loai_sua'] : null;
$ma_hang_sua = isset($_GET['hang_sua']) ? $_GET['hang_sua'] : null;


if ($ma_loai_sua) {

    $mang_sua = $sua->xl_sua_theo_loai($ma_loai_sua);
} elseif ($ma_hang_sua) {

    $mang_sua = $sua->xl_sua_theo_hang($ma_hang_sua);
} else {

    $mang_sua = $sua->xl_sua_all();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục Sữa</title>

    <style>
        .khungbao {
            display: flex;
            flex-direction: row;
            margin: 0px;
            align-items: flex-start;

            max-width: 100%;

        }

        .sidebar {
            width: 220px;
            background-color: #f8f8f8;

        }

        .content-detail {
            flex-grow: 1;
            background-color: #fff;
            margin: 10px 20px 10px 20px;
        }

        table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
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
    <?php include_once '../includes/header.php'; ?>
    <?php include_once '../includes/menu_header.php'; ?>

    <body>
        <div class="khungbao">
            <div class="sidebar">

                <table>
                    <thead>
                        <tr>
                            <th>Loại Sữa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loai_sua as $loai): ?>
                            <tr>
                                <td>
                                    <a href="?loai_sua=<?php echo urlencode($loai['ma_loai_sua']); ?>">
                                        <?php echo htmlspecialchars($loai['ten_loai']); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <table>
                    <thead>
                        <tr>
                            <th>Hãng Sữa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hang_sua as $hang): ?>
                            <tr>
                                <td>
                                    <a href="?hang_sua=<?php echo urlencode($hang['ma_hang_sua']); ?>">
                                        <?php echo htmlspecialchars($hang['ten_hang_sua']); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>

            <div class="content-detail">
                <?php
                    include 'ds_sua_loc.php';

                ?>
            </div>
            <div>
                <?php include '../products/bannerside.php' ?>

            </div>
        </div>


    </body>
    <?php include_once '../includes/footer.php'; ?>

</html>