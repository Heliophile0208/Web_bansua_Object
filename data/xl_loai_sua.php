<?php
include_once '../db/database.php';

class xl_loai_sua extends Database
{
    public function __construct()
    {
        parent::__construct(); 
    }

    // Hiện danh sách loại sữa
    public function xl_loai_sua()
    {
        $sql = "SELECT * FROM loai_sua";
        return $this->loadAllRows($sql);
    }
public function xl_sua_theo_loai($ma_loai_sua) {
    if (!$ma_loai_sua) {
        return []; // Trả về mảng rỗng nếu không có mã loại sữa
    }

    $conn = $this->connect();
    $sql = "SELECT * FROM sua WHERE ma_loai_sua = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ma_loai_sua);
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


    // Thêm mới loại sữa
    public function them_loai_sua()
    {
        $ma_loai_sua = $_POST['ma_loai_sua'] ?? '';
        $ten_loai = $_POST['ten_loai'] ?? '';

        
        $sql = "INSERT INTO loai_sua (ma_loai_sua, ten_loai) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $ma_loai_sua, $ten_loai);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php?page=xl_loai_sua');
        exit();
    }

    // Sửa loại sữa
    public function sua_loai_sua($ma_loai_sua)
    {
        $ten_loai = $_POST['ten_loai'] ?? '';

        
        $sql = "UPDATE loai_sua SET ten_loai=? WHERE ma_loai_sua=?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $ten_loai, $ma_loai_sua);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php?page=xl_loai_sua');
        exit();
    }

    // Xóa loại sữa
    public function xoa_loai_sua($ma_loai_sua)
    {
        
        $sql = "DELETE FROM loai_sua WHERE ma_loai_sua=?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $ma_loai_sua);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php?page=xl_loai_sua');
        exit();
    }
    public function tim_kiem_sua($ten_loai)
    {
        $sql = "SELECT * FROM loai_sua WHERE ten_loai LIKE ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        $like_param = '%' . $ten_loai . '%';
        mysqli_stmt_bind_param($stmt, 's', $like_param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }
// Lấy tên loại sữa từ mã loại sữa
public function lay_ten_loai_sua_theo_ma($ma_loai_sua)
{
    // Chuẩn bị câu lệnh SQL để truy vấn tên loại sữa
    $sql = "SELECT ten_loai FROM loai_sua WHERE ma_loai_sua = ?";
    
    // Sử dụng prepared statement để tránh SQL Injection
    $stmt = mysqli_prepare($this->_connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $ma_loai_sua); // 's' là kiểu dữ liệu string
    mysqli_stmt_execute($stmt);
    
    // Lấy kết quả trả về
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    // Đóng prepared statement
    mysqli_stmt_close($stmt);
    
    // Trả về tên loại sữa nếu có kết quả, nếu không trả về null
    return $data ? $data['ten_loai'] : null;
}}
?>