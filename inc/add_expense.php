<?php
require_once("../inc/config.php");
include("../inc/coopfunctions.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // the form has fields for q and units, temporarily passing "error" for error handling
    $user_id = intval($_POST["user_id"]);
    $amt = floatval($_POST["amt"]);
    $description = $_POST["description"];
    $date = $_POST["date"];
    $workbook_id = $_POST["workbook_id"];
}

add_expense($user_id, $amt, $description, $date, $workbook_id);


header("Location:../?wb=".$workbook_id);
