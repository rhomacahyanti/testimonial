<?php 
    require 'facebook.php';
    
    $facebook = new Facebook(array(
        'appId' => '217389435472767',
        'secret' => '702d1603ca4fb8bbf324452415d1aaf0'
    ));
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
    <div class="container" style="margin-top: 200px">
        <div class="row justify-content-center">
            <div class="col-xs-6 col-md-offset-3" align="center">
                <h1>Welcome to the Testimonial Page</h1>
                
                <?php 
                    if ($facebook->getUser() == 0){
                        $login = $facebook->getLoginUrl(); 
                    
                        echo "<h3 style='margin-top: 150px'>Please log in before you send your testimonial</h3>";
                        echo "<a href='$login'><button class='btn btn-primary'> Log in with Facebook</button></a>";
                        /*<form>
                            <input type="button" onclick="window.location'<?php echo $login; ?>'" value="Log in with facebook" class="btn btn-primary"/>
                        </form>*/
                    } 
                    else 
                        echo "<h3 style='margin-top: 150px'>Youre already log in with facebook</h3>";
                ?>
            </div>
        </div>
    </div>
    </body>
</html>