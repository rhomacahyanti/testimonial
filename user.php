<?php
    require 'connect.php';
class User {
    
    function checkUser($userData = array()){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $userexist = "SELECT user_name FROM user WHERE user_name = ?";
        $checkuser = $pdo->prepare($userexist);
        $checkuser->execute(array($name));
        $userexist = "SELECT user_name FROM user WHERE user_name = ?";
        $checkuser = $pdo->prepare($userexist);
        $checkuser->execute(array($name));
        $num_rows = $checkuser->fetchColumn();
        
        if ($num_rows == 0) { 		
          $query = "INSERT INTO user(user_name, user_email) VALUES(?, ?)";
          $q = $pdo->prepare($query);
          $q->execute(array($userData['name'], $userData['email']));	
      	} 
      	else if ($num_rows == 1){  	
          $query = "UPDATE user WHERE user_name = ?";
          $q = $pdo->prepare($query);
          $q->execute(array($userData['name'], $userData['email']));
      	}
    	
    	
        return $result;
    }
}

?>