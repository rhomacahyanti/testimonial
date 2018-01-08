<?php 
    session_start();
    require 'connect.php';
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM user';

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
            <div class="col-xs-12">
                
                <?php 
                    if (isset($_SESSION['user'])){
                        if (time() - $_SESSION['last_time'] > 60){
                            header("Location:logout.php");
                        }    
                    else {
                        $_SESSION['last_time'] = time(); ?>
                        <h1>Welcome, <?php echo $_SESSION['user']; ?></h1>
                        <h2>Write your testimonial here</h2>
                        
                    <?php } ?>
                    
                <?php } ?>
               
            </div>
            <div class="col-xs-12">
                 <form class="form-horizontal" action="testimonial.php" method="post">
                  <div class="form-group">
                    <label class="control-label col-sm-2">Testimonial Title:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="title" placeholder="Testimonial Title">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2">Testimonial:</label>
                    <div class="col-sm-10">
                         <textarea class="form-control" rows="5" name="content" placeholder="Write your testimonial here!"></textarea>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-sm-2">Rating:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rating" placeholder="Rating 1 - 5">
                    </div>
                  </div> 
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                  </div>
                </form> 
            </div>
        </div>
        
        <div class="container" style="margin-top: 60px">
            <div class="col-xs-12">
                <?php
                    //check user email
                    $user_email = $_SESSION['email'];
                    //$user_email = 'rhoma.cahyanti@tokopedia.com';
                    $email_explode = explode('@', $user_email);
                    
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $sql = "SELECT user_id FROM user WHERE user_email = '".$user_email."'";
                    $q = $pdo->query($sql);
                    $userid = $q->fetchColumn();
                    
                    //echo "User email = " . $user_email;
                    //echo "<br>";
                    //echo "User id = " . $userid;
                    
                    if (strpos($email_explode[1], 'tokopedia.com') !== false){
                        echo "<h3>Testimonials</h3>";
                        
                        //get testimonial from all user
                        $sql = 'SELECT * FROM testimonial';
                        foreach ($pdo->query($sql) as $data) {
                                
                            echo "<div class='col-xs-12'>";
                            echo "<div class='card' style='width: 18rem;'>";
                            echo "<div class='card-body'>";
                            echo "<h3 class='card-title'>" . $data['testimonial_title'] . "</h3>";
                            echo "<small class='card-subtitle mb-2 text-muted'>Posted at: " .  $data['testimonial_created_at'] . "</small><br>";
                            echo "<small class='card-subtitle mb-2 text-muted'>Rating: " .  $data['testimonial_rating'] . "</small>";
                            echo "<blockquote class='blockquote'><p class='card-text'>" . $data['testimonial_content'] . "</p></blockquote>";
                            echo "<a class='card-link' style='margin-right: 30px; ' href='edit_testimonial.php?id=" . $data["testimonial_id"] . "'>Edit</a>";
                            echo "<a class='card-link' href='delete_testimonial.php?id=" . $data["testimonial_id"] . "' class='card-link'>Delete</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        
                        }
                    }
                    else {
                        echo "<h3>Your testimonial</h3>";
                
                         //get testimonial from user only
                        $sql = "SELECT * FROM testimonial WHERE user_id = '".$userid."'";
                        foreach ($pdo->query($sql) as $data) {
                                
                            echo "<div class='col-xs-12'>";
                            echo "<div class='card' style='width: 18rem;'>";
                            echo "<div class='card-body'>";
                            echo "<h3 class='card-title'>" . $data['testimonial_title'] . "</h3>";
                            echo "<small class='card-subtitle mb-2 text-muted'>Posted at: " .  $data['testimonial_created_at'] . "</small><br>";
                            echo "<small class='card-subtitle mb-2 text-muted'>Rating: " .  $data['testimonial_rating'] . "</small>";
                            echo "<blockquote class='blockquote'><p class='card-text'>" . $data['testimonial_content'] . "</p></blockquote>";
                            echo "<a class='card-link' style='margin-right: 30px; ' href='edit_testimonial.php?id=" . $data["testimonial_id"] . "'>Edit</a>";
                            echo "<a class='card-link' href='delete_testimonial.php?id=" . $data["testimonial_id"] . "' class='card-link'>Delete</a>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    
                ?>
               
            </div>
        </div>
       
    </body>
</html>

<?php 
    
    if ( !empty($_POST)){
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $rating = $_POST['rating'];
        $date = date('Y-m-d H:i:s');
        
        /*echo $title;
        echo $content;
        echo $rating;
        echo $date;
        
        echo '<pre>';
        var_dump($title,$content,$rating);
        echo '</pre>';*/
        
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO testimonial (testimonial_title, testimonial_content, testimonial_rating, user_id, testimonial_created_at) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($title, $content, $rating, $userid, $date));
        Database::disconnect();
        header("Location:testimonial.php");
    }
?>
