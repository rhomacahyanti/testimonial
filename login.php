<?php 
    session_start();
    require_once 'facebook_auth.php';
    require 'connect.php';
    
    /*if (isset($_SESSION['access_token']));{
        header('Location: index.php');
        exit();
    }*/

    $helper = $facebook->getRedirectLoginHelper();
    $redirectURL = "https://rhoma-riobahtiar.c9users.io/testimonial/callback.php";
    $permission = ['email'];
    $loginURL = $helper->getLoginUrl($redirectURL, $permission);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Testimonial</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-xs-6 col-md-offset-3" align="center">
                <h1>Welcome to the Testimonial Page</h1>
                <h3 style='margin-top: 50px'>Please log in before sending your testimonial</h3>
                <a href="<?php echo $loginURL; ?>"><button class="btn btn-primary"> Log in with Facebook</button></a>
                
                
            </div>
        </div>
        <div class="row" style="margin-top: 30px; ">
            <div class="col-xs-12">
                <?php
                    //get testimonial
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'SELECT * FROM testimonial';
                    foreach ($pdo->query($sql) as $data) {
                            
                        echo "<div class='col-xs-4'>";
                        echo "<div class='card' style='width: 18rem;'>";
                        echo "<div class='card-body'>";
                        echo "<h3 class='card-title'>" . $data['testimonial_title'] . "</h3>";
                        echo "<small class='card-subtitle mb-2 text-muted'>Posted at: " .  $data['testimonial_created_at'] . "</small><br>";
                        echo "<small class='card-subtitle mb-2 text-muted'>Rating: " .  $data['testimonial_rating'] . "</small>";
                        echo "<blockquote class='blockquote'><p class='card-text'>" . $data['testimonial_content'] . "</p></blockquote>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                           
                    }
                   Database::disconnect();
                ?>
            </div>
            
        </div>
    </div>
    </body>
</html>