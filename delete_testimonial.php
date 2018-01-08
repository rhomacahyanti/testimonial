<?php 
    session_start();
    require 'connect.php';
    
    $id = 0;
     
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( !empty($_POST)) {
        $id = $_POST['id'];
         
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM testimonial  WHERE testimonial_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        Database::disconnect();
        header("Location: testimonial.php");
         
    } 
    
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
                        <h1>Delete testimonial?</h1>
                        
                    <?php } ?>
                    
                <?php } ?>
                
            </div>
            <div class="col-xs-12">
                <script type="text/javascript">
                    function Message(form) {
                        alert("Delete Success"); 
                        form.submit();
                    }
                </script>
                
                <form class="form-horizontal" action="delete_testimonial.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-error">Are you sure to delete this testimonial?</p>
                    <div class="form-actions">
                        
                        <button type="submit" class="btn btn-danger" onClick="Message(this.form)">Yes</button>
                        <button class="btn" onClick="document.location.href='testimonial.php'">No</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>