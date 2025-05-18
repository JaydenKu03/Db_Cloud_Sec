<?php
    // FOR MYSQL VERSION
    // function OpenCon(){
    //     $dbhost = "localhost";
    //     $dbuser = "root";
    //     $dbpass = "";
    //     $db = "fyp_web";
    //     $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) 
    //     or die("Connect failed : \n".$conn -> error);

    //     return $conn;
    // }

    // function CloseCon($conn) {
    //     $conn ->close();
    // }

    //SQL Server Connection
    function OpenCon() {
        $serverName = "MYSERVER";
        $database = "FYP_System";
        $uid = "php_login";
        $pass = 'Pa$$'; 
    
        $conn = [
            "Database" => $database,
            "Uid" => $uid,
            "PWD" => $pass
        ];
    
        $conn = sqlsrv_connect($serverName, $conn);
    
        if(!$conn)
            die(print_r(sqlsrv_errors(),true));
        else 
            // echo "Connection Established<br>";
            return $conn;
    }
?>