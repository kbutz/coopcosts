<?php


ob_start();
session_start();
require_once("inc/config.php");
include("inc/coopfunctions.php");   

if(isset($_SESSION['username'])) {
    $logged_in = true;
}
else {
    $logged_in = false;
}

include("inc/header.php");
?>
            
<div class="container">
   <?php 
    
    if($logged_in){
        if (empty(get_workbooks($_SESSION["user_id"]))){
            echo "Create a workbook.";
        } else {
            include("inc/coopcosts.php");
        }
    }
    else {
        include("inc/login.php");
    }
    ?>
</div><!-- /.container -->
                

<?php include("inc/footer.php"); ?>