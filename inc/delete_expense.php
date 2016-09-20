<?php
require_once("../inc/config.php");
include("../inc/coopfunctions.php");
if(isset($_POST['deleteItem']) and is_numeric($_POST['deleteItem']))
{
  // here comes your delete query: use $_POST['deleteItem'] as your id
  $delete = $_POST['deleteItem'];
  delete_expense($delete);
}

header("Location:../");