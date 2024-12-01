<?php
include_once 'db/database.php';

class XL_KHACH_HANG extends Database
{
    public function __construct()
    {
        parent::__construct();
    }


    public function lay_danh_sach_khach_hang()
    {
        $sql = "SELECT * FROM khach_hang";
        return $this->loadAllRows($sql);
    }

  
    public function them_khach_hang()
    {
        $ma_khach_hang = $_POST['ma_khach_hang'] ?? '';
        $ten_khach_hang = $_POST['ten_khach_hang'] ?? '';
        $phai = $_POST['phai'] == 'Nam' ? 1 : 0; 
        $dia_chi = $_POST['dia_chi'] ?? '';
        $dien_thoai = $_POST['dien_thoai'] ?? '';
        $email = $_POST['email'] ?? '';

    
        $sql_check = "SELECT ma_khach_hang FROM khach_hang WHERE ma_khach_hang = ?";
        $stmt_check = mysqli_prepare($this->_connection, $sql_check);
        mysqli_stmt_bind_param($stmt_check, 's', $ma_khach_hang);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        mysqli_stmt_close($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
  
            return 'Mã khách hàng đã tồn tại';
        }

        $sql_insert = "INSERT INTO khach_hang (ma_khach_hang, ten_khach_hang, phai, dia_chi, dien_thoai, email) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($this->_connection, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, 'ssisss', $ma_khach_hang, $ten_khach_hang, $phai, $dia_chi, $dien_thoai, $email);
        $is_inserted = mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);

        if ($is_inserted) {
            return $ma_khach_hang;
        } else {
            return 'Lỗi khi thêm khách hàng. Vui lòng thử lại.';
        }
    }


    public function lay_thong_tin_khach_hang($ma_khach_hang)
    {
        $sql = "SELECT * FROM khach_hang WHERE ma_khach_hang = ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $ma_khach_hang);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $customer_info = mysqli_fetch_assoc($result); 
        mysqli_stmt_close($stmt);

        return $customer_info;
    }


    public function xoa_khach_hang($ma_khach_hang)
    {
        $sql = "DELETE FROM khach_hang WHERE ma_khach_hang=?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $ma_khach_hang);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header('Location: index.php?page=xl_khach_hang');
        exit();
    }

 
    public function tim_kiem_khach_hang($ten_khach_hang)
    {
        $sql = "SELECT * FROM khach_hang WHERE ten_khach_hang LIKE ?";
        $stmt = mysqli_prepare($this->_connection, $sql);
        $like_param = '%' . $ten_khach_hang . '%';
        mysqli_stmt_bind_param($stmt, 's', $like_param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
    }
}
?>