<?php 
    session_start();
    require 'connect.php';
    
    $id = $_GET['id'];
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM testimonial WHERE testimonial_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    
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
                        <h1>Edit testimonial</h1>
                        
                    <?php } ?>
                    
                <?php } ?>
                
            </div>
            <div class="col-xs-12">
                 <form class="form-horizontal" method="post">
                  <div class="form-group">
                    <label class="control-label col-sm-2">Testimonial Title:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="title" value="<?php echo $data['testimonial_title']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2">Testimonial:</label>
                    <div class="col-sm-10">
                         <textarea class="form-control" rows="5" name="content"><?php echo $data['testimonial_content']; ?></textarea>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="control-label col-sm-2">Rating:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rating" value="<?php echo $data['testimonial_rating']; ?>">
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
    </body>
</html>

<?php
    
    $id = $_GET['id'];
    
    if ( !empty($_POST)){
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $rating = $_POST['rating'];
        $created_at = $data['testimonial_created_at'];
        
        
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE testimonial SET testimonial_title = ?,  testimonial_content = ?, testimonial_rating = ?, testimonial_created_at = ? WHERE testimonial_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($title, $content, $rating, $created_at, $id));
        
        echo "Post ID = " . $id;
        echo "<br>:";
        echo "Edit Success";
        
        header("Location:testimonial.php");
    }
?>