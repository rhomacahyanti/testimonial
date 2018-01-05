<?php
    require_once 'facebook_auth.php';
    //require 'connect.php';
    require 'user.php';
    
    $helper = $facebook->getRedirectLoginHelper();
    
    // Try to get access token
    /*try {
        if(isset($_SESSION['facebook_access_token'])){
            $accessToken = $_SESSION['facebook_access_token'];
        }else{
              $accessToken = $helper->getAccessToken();
        }
    } catch(FacebookResponseException $e) {
         echo 'Graph returned an error: ' . $e->getMessage();
          exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;*/
    
    
    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    
    if (! isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }
    
    // Logged in
    echo '<h3>Access Token</h3>';
    var_dump($accessToken->getValue());
    
    // The OAuth 2.0 client handler helps us manage access tokens
    $oAuth2Client = $facebook->getOAuth2Client();
    
    // Get the access token metadata from /debug_token
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    echo '<h3>Metadata</h3>';
    var_dump($tokenMetadata);
    
    // Validation (these will throw FacebookSDKException's when they fail)
    $tokenMetadata->validateAppId('217389435472767');
    // If you know the user ID this access token belongs to, you can validate it here
    //$tokenMetadata->validateUserId('123');
    $tokenMetadata->validateExpiration();
    
    if (! $accessToken->isLongLived()) {
      // Exchanges a short-lived access token for a long-lived one
      try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
      }
    
      echo '<h3>Long-lived</h3>';
      var_dump($accessToken->getValue());
    }
    
    $_SESSION['fb_access_token'] = $tokenz = (string) $accessToken;
    echo "<hr>";
    $response = $facebook->get('/me?fields=name,email', $tokenz);
    $userData = $response->getGraphNode()->asArray();
    
    /*$user = new User();
    $facebookUserData = array(
        'user_name' => $userProfile['name'],
        'user_email' => $userProfile['email']
    );
    
    $userData = $user->checkUser($facebookUserData);
    $_SESSION['userData'] = $userData;
    
    header('Location:testimonial.php');
    exit();*/

    $name = $userData['name'];
    $email = $userData['email'];
    
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $userexist = "SELECT user_name FROM user WHERE user_name = ?";
    $checkuser = $pdo->prepare($userexist);
    $checkuser->execute(array($name));
    $num_rows = $checkuser->rowCount();
    
    if ($num_rows == 0) { 		
      $query = "INSERT INTO user(user_name, user_email) VALUES(?, ?)";
      $q = $pdo->prepare($query);
      $q->execute(array($userData['name'], $userData['email']));
      //die('not found');
  	} 
  	else if ($num_rows >= 1){  	
      $query = "UPDATE user SET user_name= ?, user_email = ? WHERE user_name = ?";
      $q = $pdo->prepare($query);
      $q->execute(array($userData['name'], $userData['email'], $userData['name']));
      //die('exist');
  	}
    	
    Database::disconnect();
    
    header('Location:testimonial.php');
    exit();

?>