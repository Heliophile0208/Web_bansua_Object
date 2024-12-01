<?php 
include_once '/xampp/htdocs/Web_bansua_Object/db/database.php';

class Xl_hang_sua extends Database
{
    public function __construct()
    {
        parent::__construct();
    }


    public function xl_hang_sua()
    {
        $sql = "SELECT * FROM hang_sua";
        return $this->loadAllRows($sql);
    }



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

public function lay_ten_hang_sua_theo_ma($ma_hang_sua)
{

    $sql = "SELECT ten_hang_sua FROM hang_sua WHERE ma_hang_sua = ?";
    
  
    $stmt = mysqli_prepare($this->_connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $ma_hang_sua);
    mysqli_stmt_execute($stmt);
    

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
 
    mysqli_stmt_close($stmt);
    
   
    return $data ? $data['ten_hang_sua'] : null;
}
}
?>