<?php 
include_once '../db/database.php';

class Xl_hang_sua extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    // Hiện danh sách hàng sữa
    public function xl_hang_sua()
    {
        $sql = "SELECT * FROM hang_sua";
        return $this->loadAllRows($sql);
    }
public function xl_sua_theo_hang($ma_hang_sua) {
    if (!$ma_hang_sua) {
        return []; // Trả về mảng rỗng nếu không có mã hãng sữa
    }

    $conn = $this->connect();
    $sql = "SELECT * FROM sua WHERE ma_hang_sua = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ma_hang_sua);
    $stmt->execute();
    $result = $stmt->get_result();

    $sua_list = [];
    while ($row = $result->fetch_assoc()) {
        $sua_list[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $sua_list;
}

    // Thêm mới hàng sữa
    public function them_hang_sua()
    {
        $ma_hang_sua = $_POST['ma_hang_sua'] ?? '';
        $ten_hang_sua = $_POST['ten_hang_sua'] ?? '';
        $dia_chi = $_POST['dia_chi'] ?? '';
        $dien_thoai = $_POST['dien_thoai'] ?? '';
        $email = $_POST['email'] ?? '';


        $sql = "INSERT INTO hang_sua (ma_hang_sua, ten_hang_sua, dia_chi, dien_thoai, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 'sssss', $ma_hang_sua, $ten_hang_sua, $dia_chi, $dien_thoai, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php?page=xl_hang_sua');
        exit();
    }

    // Sửa hàng sữa
    public function sua_hang_sua($ma_hang_sua)
    {
        $ten_hang_sua = $_POST['ten_hang_sua'] ?? '';
        $dia_chi = $_POST['dia_chi'] ?? '';
        $dien_thoai = $_POST['dien_thoai'] ?? '';
        $email = $_POST['email'] ?? '';

    
        $sql = "UPDATE hang_sua SET ten_hang_sua=?, dia_chi=?, dien_thoai=?, email=? WHERE ma_hang_sua=?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssi', $ten_hang_sua, $dia_chi, $dien_thoai, $email, $ma_hang_sua);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php?page=xl_hang_sua');
        exit();
    }

 
    public function xoa_hang_sua($ma_hang_sua)
    {
      
        $sql = "DELETE FROM hang_sua WHERE ma_hang_sua=?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $ma_hang_sua);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php?page=xl_hang_sua');
        exit();
    }

    // Tìm kiếm hàng sữa
    public function tim_kiem_hang_sua($ten_hang_sua)
    {
        $sql = "SELECT * FROM hang_sua WHERE ten_hang_sua LIKE ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        $like_param = '%' . $ten_hang_sua . '%';
        mysqli_stmt_bind_param($stmt, 's', $like_param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }
// Lấy tên hãng sữa từ mã hãng sữa
public function lay_ten_hang_sua_theo_ma($ma_hang_sua)
{
    // Chuẩn bị câu lệnh SQL để truy vấn tên hãng sữa
    $sql = "SELECT ten_hang_sua FROM hang_sua WHERE ma_hang_sua = ?";
    
    // Sử dụng prepared statement để tránh SQL Injection
    $stmt = mysqli_prepare($this->_connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $ma_hang_sua); // 's' là kiểu dữ liệu string
    mysqli_stmt_execute($stmt);
    
    // Lấy kết quả trả về
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    // Đóng prepared statement
    mysqli_stmt_close($stmt);
    
    // Trả về tên hãng sữa nếu có kết quả, nếu không trả về null
    return $data ? $data['ten_hang_sua'] : null;
}
}
?>