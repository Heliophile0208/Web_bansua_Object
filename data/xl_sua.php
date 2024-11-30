<?php 
include_once __DIR__ . '/../db/database.php';

class xl_sua extends Database {

    function __construct() {
        parent::__construct(); // gọi constructor của lớp cha (Database)
    }

    // Hiện danh sách tất cả các sữa
    public function xl_sua_all(){
        $sql = "SELECT * FROM sua";
        return $this->loadAllRows($sql);
    }
public function xl_sua_loc($ma_loai_sua = null, $ma_hang_sua = null, $ten_sua = null) {
    $sql = "SELECT * FROM sua WHERE 1=1";
    $params = [];
    $types = '';

    // Thêm điều kiện lọc loại sữa
    if (!empty($ma_loai_sua)) {
        $sql .= " AND ma_loai_sua = ?";
        $params[] = $ma_loai_sua;
        $types .= 's';
    }

    // Thêm điều kiện lọc hãng sữa
    if (!empty($ma_hang_sua)) {
        $sql .= " AND ma_hang_sua = ?";
        $params[] = $ma_hang_sua;
        $types .= 's';
    }

    // Thêm điều kiện tìm kiếm theo tên sữa
    if (!empty($ten_sua)) {
        $sql .= " AND ten_sua LIKE ?";
        $params[] = '%' . $ten_sua . '%';
        $types .= 's';
    }

    $stmt = $this->_connection->prepare($sql); // Sử dụng _connection từ lớp Database
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $this->_connection->error);
    }

    if ($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Lỗi thực thi truy vấn: " . $stmt->error);
    }

    // Lấy dữ liệu từ kết quả truy vấn
    $sua_list = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $sua_list;
}

    
    // Sửa thông tin sữa
    public function sua_sua($ma_sua) {
        $ten_sua = $_POST['ten_sua'] ?? '';
        $ma_hang_sua = $_POST['ma_hang_sua'] ?? '';
        $ma_loai_sua = $_POST['ma_loai_sua'] ?? '';
        $trong_luong = $_POST['trong_luong'] ?? '';
        $don_gia = $_POST['don_gia'] ?? '';
        $tp_dinh_duong = $_POST['tp_dinh_duong'] ?? '';
        $loi_ich = $_POST['loi_ich'] ?? '';
        $hinh = $_FILES["hinh"]["name"] ? basename($_FILES["hinh"]["name"]) : null;

        if ($hinh) {
            $target_dir = "Image/";
            $target_file = $target_dir . $hinh;
            if (move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file)) {
                // Hình ảnh đã được tải lên thành công
            } else {
                echo "Không thể upload hình ảnh mới.";
                return; // Ngừng thực hiện nếu không thể tải ảnh
            }
        }

        $sql = "UPDATE sua SET ten_sua=?, ma_hang_sua=?, ma_loai_sua=?, trong_luong=?, don_gia=?, tp_dinh_duong=?, loi_ich=?".($hinh ? ", hinh=?" : "")." WHERE ma_sua=?";
        $stmt = mysqli_prepare($this->_connection, $sql);

        if ($hinh) {
            mysqli_stmt_bind_param($stmt, "sssssssss", $ten_sua, $ma_hang_sua, $ma_loai_sua, $trong_luong, $don_gia, $tp_dinh_duong, $loi_ich, $hinh, $ma_sua);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssss", $ten_sua, $ma_hang_sua, $ma_loai_sua, $trong_luong, $don_gia, $tp_dinh_duong, $loi_ich, $ma_sua);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Chuyển hướng sau khi sửa sữa
        header('Location: add_sua.php?page=xl_sua');
        exit();
    }

    // Xóa sữa
    public function xoa_sua($ma_sua) {
        $sql = "DELETE FROM sua WHERE ma_sua = ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $ma_sua);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Chuyển hướng sau khi xóa sữa
        header('Location: index.php?page=xl_sua');
        exit();
    }

    // Tìm kiếm sữa theo tên
    public function tim_kiem_sua($ten_sua) {
        $sql = "SELECT * FROM sua WHERE ten_sua LIKE ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        $like_param = '%' . $ten_sua . '%';
        mysqli_stmt_bind_param($stmt, 's', $like_param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    // Lấy danh sách sữa theo hãng và loại
    public function danh_sach_theo_hang_loai($ma_hang_sua, $ma_loai_sua) {
        $sql = "SELECT * FROM sua WHERE ma_hang_sua = ? AND ma_loai_sua = ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $ma_hang_sua, $ma_loai_sua);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    // Lấy danh sách sữa bán chạy
    public function DanhSachSuaBanChay($limit = 10) {
        $sql = "SELECT s.ma_sua, s.ten_sua, SUM(ct.so_luong) as tong_so_luong 
                FROM ct_hoa_don ct
                JOIN sua s ON ct.ma_sua = s.ma_sua 
                GROUP BY s.ma_sua, s.ten_sua 
                ORDER BY tong_so_luong DESC 
                LIMIT ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, "i", $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }

    // Lấy chi tiết sữa
    public function ChiTietSua($ma_sua) {
        $sql = "SELECT sua.*, hang_sua.ten_hang_sua 
                FROM sua 
                JOIN hang_sua ON sua.ma_hang_sua = hang_sua.ma_hang_sua 
                WHERE sua.ma_sua = ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $ma_sua);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_assoc($result) : null;
    }

    // Lấy danh sách hãng sữa
    public function getHangSua() {
        $sql = "SELECT ma_hang_sua, ten_hang_sua FROM hang_sua";
        $result = mysqli_query($this->_connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $hang_sua = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $hang_sua[] = $row;
            }
            return $hang_sua;
        } else {
            return [];
        }
    }

    // Lấy danh sách loại sữa
    public function getLoaiSua() {
        $sql = "SELECT ma_loai_sua, ten_loai FROM loai_sua";
        $result = mysqli_query($this->_connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $loai_sua = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $loai_sua[] = $row;
            }
            return $loai_sua;
        } else {
            return [];
        }
    }
public function them_sua()
{
    // Lấy dữ liệu từ POST
    $ma_sua = $_POST['ma_sua'] ?? '';
    $ten_sua = $_POST['ten_sua'] ?? '';
    $hang_sua = $_POST['hang_sua'] ?? '';  
    $loai_sua = $_POST['loai_sua'] ?? '';  
    $trong_luong = $_POST['trong_luong'] ?? '';
    $don_gia = $_POST['don_gia'] ?? '';
    $tp_dinh_duong = $_POST['tp_dinh_duong'] ?? '';
    $loi_ich = $_POST['loi_ich'] ?? '';

    // Kiểm tra mã sữa có tồn tại hay không
    $sql_check = "SELECT ma_sua FROM sua WHERE ma_sua = ?";
    $stmt_check = mysqli_prepare($this->_connection, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 's', $ma_sua);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    mysqli_stmt_close($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Nếu mã sữa đã tồn tại
        return 'Mã sữa đã tồn tại';
    }

    // Xử lý hình ảnh
    $hinh = $_FILES['hinh']['name'] ?? '';
    $hinh_tmp = $_FILES['hinh']['tmp_name'] ?? '';
    $hinh_size = $_FILES['hinh']['size'] ?? 0;
    $hinh_error = $_FILES['hinh']['error'] ?? 0;

    // Kiểm tra lỗi ảnh
    if ($hinh_error === 0) {
        // Kiểm tra kích thước và định dạng ảnh
        $hinh_ext = strtolower(pathinfo($hinh, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($hinh_ext, $allowed_ext)) {
            return 'Lỗi: Định dạng hình ảnh không hợp lệ';
        }

        // Tạo tên mới cho hình ảnh
        $new_hinh_name = uniqid('', true) . '.' . $hinh_ext;
        $target_dir = "Image/";  // Thư mục lưu trữ hình ảnh
        $target_file = $target_dir . $new_hinh_name;

        // Di chuyển file ảnh vào thư mục
        if (!move_uploaded_file($hinh_tmp, $target_file)) {
            return 'Lỗi khi tải hình ảnh lên';
        }
    } else {
        return 'Lỗi khi tải hình ảnh lên';
    }

    // Nếu mã sữa chưa tồn tại, thực hiện thêm sản phẩm sữa mới
    $sql_insert = "INSERT INTO sua (ma_sua, ten_sua, ma_hang_sua, ma_loai_sua, trong_luong, don_gia, tp_dinh_duong, loi_ich, hinh) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($this->_connection, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, 'sssssssss', $ma_sua, $ten_sua, $hang_sua, $loai_sua, $trong_luong, $don_gia, $tp_dinh_duong, $loi_ich, $target_file);
    $is_inserted = mysqli_stmt_execute($stmt_insert);
    mysqli_stmt_close($stmt_insert);

    if ($is_inserted) {
        // Sau khi thêm sản phẩm, lấy thông tin chi tiết sản phẩm mới
        return $this->lay_thong_tin_chi_tiet($ma_sua);
    } else {
        return 'Lỗi khi thêm sản phẩm. Vui lòng thử lại.';
    }
}
public function lay_thong_tin_chi_tiet($ma_sua)
{
    $sql = "SELECT * FROM sua WHERE ma_sua = ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        
        if (!$stmt) {
            die('Lỗi chuẩn bị câu truy vấn: ' . mysqli_error($this->_connection));
        }

        mysqli_stmt_bind_param($stmt, "s", $ma_sua);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }

        mysqli_stmt_close($stmt);
    }

    // Phương thức để lấy danh sách sữa theo hãng
    public function xl_sua_theo_hang($ma_hang_sua) {
        return $this->xl_sua_theo_dieu_kien('ma_hang_sua', $ma_hang_sua);
    }

    // Phương thức để lấy danh sách sữa theo loại
    public function xl_sua_theo_loai($ma_loai_sua) {
        return $this->xl_sua_theo_dieu_kien('ma_loai_sua', $ma_loai_sua);
    }

    // Phương thức lấy sữa theo mã
    public function xl_sua_theo_ma($ma_sua) {
        $sql = "SELECT * FROM sua WHERE ma_sua = ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        
        if (!$stmt) {
            die('Lỗi chuẩn bị câu truy vấn: ' . mysqli_error($this->_connection));
        }

        mysqli_stmt_bind_param($stmt, "s", $ma_sua);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }

        mysqli_stmt_close($stmt);
    }

    // Phương thức xử lý dữ liệu sữa theo điều kiện
    private function xl_sua_theo_dieu_kien($field, $value) {
        $sql = "SELECT * FROM sua WHERE $field = ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $value);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }
}
?>
