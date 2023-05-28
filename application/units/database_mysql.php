<?php
$servername = "localhost";
$username = "user";
$password = "Thr*nexp02011";
$dbname = "person";

$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];

//try {
//    $connect = new PDO($dsn, $username, $password, $options);
//} catch (PDOException $e) {
//    die("Connection failed: " . $e->getMessage());
//}






$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {
    $connect = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if(!$connect)
{
    require_once Error404;
    exit;
    //or die('������ ����������� � ������� MySQL -> '.mysqli_error());
}

    // mysqli_set_charset("utf8");
    // mysqli_select_db('kadrobot');

	function Query($sql)
    {
        $query = mysqli_query($connect, $sql);
        if(!$query)exit(mysqli_error());

        $row = mysqli_fetch_array($query, mysqli_ASSOC);
        $dan = array();
        $dan = $row;
        return $dan;
    }
    /*
    *����� ��� ������ ���� ������� ����� �������� ��� ������� �� ����� ���
    */

    function query_array($sql)
    {
        $q = mysqli_query($connect, $sql);
        if(!$q)exit(mysqli_error());

        $a = array();
        $i = 0;
        while($row = mysqli_fetch_array($q, mysqli_ASSOC))
        {
            foreach($row as $r=>$v)
            {
                $a[$i][$r] = $v;
            }
            $i++;
        }
        return $a;
    }

    function Execute($sql)
    {
        $query = mysqli_query($connect, $sql)or die(false);
        if(!$query){
            return mysqli_error();
        }else return true;
    }

    class My_sql_db
    {
        private $connect;

        function __construct()
        {
            $this->connect = mysqli_connect("localhost", "user", "Thr*nexp02011", "person");

            if(!$this->connect)
            {
                die('Could not connect: '.mysqli_error());
            }

            mysqli_set_charset($this->connect, "utf8");
        }


        public function Query($sql)
        {
            // $query = mysqli_query($this->connect, $sql, 'MYSQLI_USE_RESULT');
            // if(!$query)exit(mysqli_error());

            // $row = mysqli_fetch_array($query, mysqli_ASSOC);
            // $dan = array();
            // $dan = $row;
            // return $dan;
            return $this->Select($sql);
        }
        /*
        *����� ��� ������ ���� ������� ����� �������� ��� ������� �� ����� ���
        */

        public function Select($sql)
        {
            //echo $sql;



            $mysqli = new mysqli("localhost","user","Thr*nexp02011","person");

            // Check connection
            if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
            }

            // Perform query
            $row = array();
            if ($result = $mysqli -> query($sql)) {
                $row = $result -> fetch_all(MYSQLI_ASSOC);
                $result -> free_result();
            }
            $mysqli -> close();
            return $row;
        }

//        public function Execute($sql)
//        {
//            $query = mysqli_query($this->connect, $sql)or die(false);
//            if(!$query){
//                return mysqli_error();
//            }else return true;
//        }

        public function Execute($sql) {

            $mysqli = new mysqli("localhost","user","Thr*nexp02011","person");

            // Check connection
            if ($mysqli -> connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
                exit();
            }

          //  echo $sql;

            if ($mysqli->query($sql)) {
                return true;
            } else {
                return $mysqli->error;
            }
        }

    }
?>
