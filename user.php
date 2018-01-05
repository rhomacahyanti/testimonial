<?php
class User {
    private $dbHost     = "localhost";
    private $dbUsername = "riobahtiar";
    private $dbPassword = "";
    private $dbName     = "testimonial";
    private $userTbl    = 'user';
    
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
       
        $conn = new PDO("mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
     
    public static function disconnect()
    {
        self::$conn = null;
    }
    
    function checkUser($userData = array()){
        $pdo = User::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $userexist = "SELECT user_name FROM user WHERE user_name = ?";
        $checkuser = $pdo->prepare($userexist);
        $checkuser->execute(array($name));
        $check = $checkuser->fetchColumn();
        
        if (empty($check)) { 		
    	    // Insert user data
            $query = "INSERT INTO user(user_name, user_email) VALUES(?, ?)";
            $q = $pdo->prepare($query);
            $result = $q->execute(array($userData['name'], $userData['email']));	
    	} 
    	else {  	
        	// Update user data if already exists
            $query = "UPDATE user WHERE user_name = ?";
            $q = $pdo->prepare($query);
            $result = $q->execute(array($userData['name']));
    	}
    	
        return $result;
    }
}

?>