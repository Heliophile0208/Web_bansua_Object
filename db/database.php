<?php
class Database
{
    protected $_sql;
    protected $_connection;
    protected $_cur = null;
    
    public function __construct()
    {
        $this->_connection = @mysqli_connect("localhost", "root", '', "ql_ban_sua");
        if (!$this->_connection) {
            die('Không thể kết nối MySQL: ' . mysqli_connect_error());
        }

        // Set the character set to UTF-8
        if (!mysqli_set_charset($this->_connection, 'utf8')) {
            die('Error loading character set utf8: ' . mysqli_error($this->_connection));
        }
    }

    public function setQuery($sql)
    {
        $this->_sql = $sql;
    }

    public function loadAllRows($sql)  
    {
        $this->setQuery($sql);
        if (!$cur = $this->query()) {
            return null;
        }
        $array = [];
        while ($row = mysqli_fetch_assoc($cur)) {
            $array[] = $row;
        }
        mysqli_free_result($cur);
        return $array;
    }

    public function query()
    {
        if (!$this->_sql) {
            return null;
        }
        $this->_cur = mysqli_query($this->_connection, $this->_sql);
        if (!$this->_cur) {
            die('Query failed: ' . mysqli_error($this->_connection));
        }
        return $this->_cur;
    }

    public function disconnect()
    {
        if ($this->_connection) {
            mysqli_close($this->_connection);
        }
    }

    public function __destruct()
    {
        $this->disconnect();
    }

public function executeQuery($sql, $params = [])
{
    $stmt = mysqli_prepare($this->_connection, $sql);
    if ($params) {
        $types = str_repeat('s', count($params)); 
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

public function fetchAll($sql, $params = [])
{
    $result = $this->executeQuery($sql, $params);
    return $result ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
}}
