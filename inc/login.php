<?php
require_once("inc/config.php");  
require("inc/database.php");
if(isset($_POST['submit'])){
  $errMsg = '';
  //username and password sent from Form
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  
  if($username == '')
     $errMsg .= 'You must enter your Username<br>';
  
  if($password == '')
     $errMsg .= 'You must enter your Password<br>';
  
  
  if($errMsg == ''){
     $records = $db->prepare('SELECT * FROM users WHERE username = ?');
     $records->bindParam(1, $username);
     $records->execute();
     $results = $records->fetch(PDO::FETCH_ASSOC);

     if(count($results) > 0 && password_verify($password, $results['password'])){
        $_SESSION['username'] = $results['username'];
        $_SESSION['user_id'] = $results['user_id'];
        $_SESSION['first_name'] = $results['first_name'];
        $_SESSION['default_workbook'] = $results['default_workbook'];
        header('Location:../');
        exit;
     }else{
        $errMsg .= 'Username and Password are not found<br>';
     }
  }
}

if(isset($errMsg)){
    echo '<div style="color:#FF0000;text-align:center;font-size:12px;">'.$errMsg.'</div>';
    }
?>
<form action="" method="post" style="max-width: 330px; padding: 15px; margin: 0 auto;">
    <h3>Please sign in</h3>
    <div class="form-group">
        <label for"username">Username:</label>
        <input type="text" name="username" class="form-control"/>
    </div>
    <div class="form-group">
        <label for"password">Password:</label>
        <input type="password" name="password" class="form-control" />
    </div>
    <input type="submit" name='submit' value="Submit" class="btn btn-info" value="Submit"/><br />
</form>