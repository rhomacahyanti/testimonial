<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Testimonial</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    </head>
    
    <body>
        
        <div class="container">
            <div class="col-xs-12">
                <h1>Welcome to the Testimonial Page</h1>
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
                         <textarea class="form-control" rows="5" name="rating" placeholder="Rating 1 - 5"></textarea>
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
    
      
    require 'connect.php';
    
    if ( !empty($_POST)){
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $rating = $_POST['rating'];
        $date = date('Y-m-d H:i:s');
        
        echo $title;
        echo $content;
        echo $rating;
        echo $date;
        
        echo '<pre>';
        var_dump($title,$content,$rating);
        echo '</pre>';
        
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO testimonial (testimonial_title, testimonial_content, testimonial_rating, testimonial_created_at) values(?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($title, $content, $rating, $date));
        Database::disconnect();
        header("testimonial.php");
    }
?>
