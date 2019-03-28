<?php header("content-type:text/html;charset=utf-8");
/*
 * 操作数据库类
 * */
class Mysql{
    private $hostName = "127.0.0.1:3306";
    private $usrName = "root";
    private $passWord = "Xiaopeng117";
    private $port = "3306";
    private $dbname = "app_flyingman";
    private $content;//连接句柄
    private $retval;//查询数据库句柄

    //连接数据库构造函数
    public function __construct()
    {
        $this->content = mysqli_connect($this->hostName,$this->usrName,$this->passWord,$this->dbname,$this->port);
        if (!$this->content){
            echo "<h2>服务器有点小问题，错误码：0001</h2>";
            die();
        }
    }
    //创建数据表函数
    public function creatTable($sqlStr){
        if (!mysqli_query($this->content,$sqlStr)){
            echo "<h2>服务器有点忙，请稍后再试，错误码：0002</h2> " ;
        }
    }
    //插入数据表
    public function insertTable($sqlStr){
        if (!mysqli_query($this->content,$sqlStr)){
            echo "<h2>服务器有点忙，请稍后再试，错误码：0003</h2>";
            return false;
        }else{
            return true;
        }
    }
    //更新数据表
    public function updateTable($sqlStr){
        if (!mysqli_query($this->content,$sqlStr)){
            echo "<h2>服务器有点忙，请稍后再试，错误码：0004</h2>";
            return false;
        }else{
            return true;
        }
    }
    //查询数据表内容
		public function selectTable($sqlStr,$flag){
        $this->retval = mysqli_query($this->content,$sqlStr);
        if($this->retval) {
            if ($flag) {
                ///返回一个关联数组
                return (mysqli_fetch_array($this->retval, MYSQLI_ASSOC));
            }else{
                return (mysqli_fetch_all($this->retval, MYSQLI_ASSOC));
            }
        }else{
            echo "<h2>服务器有点忙，请稍后再试，错误码：0006</h2>";
            return false;
        }
    }

    //删除数据表
    public function dropTable($sqlStr){
        if (!mysqli_query($this->content,$sqlStr)){
            echo "<h2>服务器有点忙，请稍后再试，错误码：0005</h2>";
            return false;
        }else{
            return true;
        }
    }
    //断开连接析构函数
    public function __destruct()
    {
        mysqli_close($this->content);
    }
}
