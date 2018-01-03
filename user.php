<?php
    class User{
        private $dbhost = "localhost";
        private $dbusername = "riobahtiar";
        private $dbpassword = "";
        private $dbname = "testimonial";
        private $dbtable = "user";
        
        function __construct(){
            if (!isset($this->db)){
                $conn = new mysqli($this->dbhost, $this->dbusername, $this->dbpassword, $this->dbname);
                if($conn->connect_error){
                    die("Failed to connect with MySQL: " . $conn->connect_error);
                }else{
                    $this->db = $conn;
                }
            }
        }
        
        function checkUser($userData = array()){
            if(!empty($userData)){
                // Check whether user data already exists in database
                $prevQuery = "SELECT * FROM ".$this->dbtable." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
                $prevResult = $this->db->query($prevQuery);
                if($prevResult->num_rows > 0){
                    // Update user data if already exists
                    $query = "UPDATE ".$this->dbtablel." SET user_name = '".$userData['first_name']."', user_email = '".$userData['email']."', user_facebook_url = '".$userData['link']."' WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
                    $update = $this->db->query($query);
                }else{
                    // Insert user data
                    $query = "INSERT INTO ".$this->userTbl." SET user_name = '".$userData['first_name']."', email = '".$userData['email']."', user_facebook_url = '".$userData['link']."', oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."'";
                    $insert = $this->db->query($query);
                }
                
                // Get user data from the database
                $result = $this->db->query($prevQuery);
                $userData = $result->fetch_assoc();
            }
            
            // Return user data
            return $userData;
    
        }
    }
?>