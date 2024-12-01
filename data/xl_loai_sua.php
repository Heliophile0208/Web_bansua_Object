<?php
include_once '/xampp/htdocs/Web_bansua_Object/db/database.php';

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

public function lay_ten_loai_sua_theo_ma($ma_loai_sua)
{

    $sql = "SELECT ten_loai FROM loai_sua WHERE ma_loai_sua = ?";
    

    $stmt = mysqli_prepare($this->_connection, $sql);
    mysqli_stmt_bind_param($stmt, 's', $ma_loai_sua); 
    mysqli_stmt_execute($stmt);
    
 
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    

    mysqli_stmt_close($stmt);
    
   
    return $data ? $data['ten_loai'] : null;
}}
?>