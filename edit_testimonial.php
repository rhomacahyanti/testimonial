<?php 
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
                <h1>Edit testimonial</h1>
            </div>
            <div class="col-xs-12">
                 <form class="form-horizontal" action="testimonial.php" method="post">
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
        
        echo $id;
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$sql = "UPDATE testimonial set testimonial_title = ?,  testimonial_content = ?, testimonial_rating = ? WHERE testimonial_id = ?";
        //$q = $pdo->prepare($sql);
        //$q->execute(array($title, $content, $rating, $id));
        
        $sql = "UPDATE testimonial_id SET 
            testimonial_id = :id
            testimonial_title = :title, 
            testimonial_content = :content,
            testimonial_rating = :rating 
            WHERE testimonial_id = :oldid";
    
        $q = $pdo->prepare($sql);
        $results = $q->execute(array(
                ":id" => $id,
                ":title"    => $title,
                ":content" => $content,
                ":rating" => $rating,
                ":id" => $_GET['id'],
        ));
        Database::disconnect();
        header("Location:testimonial.php");
    }
?>