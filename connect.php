<?php
    /*$servername = "localhost";
    $username = "riobahtiar";
    $password = "";
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=testimonial", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }*/
    
    class Database
    {
        private static $dbName = 'testimonial' ;
        private static $dbHost = 'localhost' ;
        private static $dbUsername = 'riobahtiar';
        private static $dbUserPassword = '';
         
        private static $conn  = null;
         
        public function __construct() {
            die('Init function is not allowed');
        }
         
        public static function connect()
        {
           // One connection through whole application
           if ( null == self::$conn )
           {     
            try
            {
              self::$conn =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
            }
            catch(PDOException $e)
            {
              die($e->getMessage()); 
            }
           }
           return self::$conn;
        }
         
        public static function disconnect()
        {
            self::$conn = null;
        }
    }
?>
