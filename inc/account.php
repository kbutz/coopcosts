/*
 * User admin TODO
 * 
 */

// Set default workbook

<?php

?>
	<select name="workbook_id">
        <?php
            $workbook_array = get_workbooks($_SESSION["user_id"]);
            foreach ($workbook_array as $workbook_id) {
                $workbook_name = get_workbook_name($workbook_id["workbook_id"]);
                echo "<option value='" . $workbook_id["workbook_id"] . "'>" . $workbook_name[0]["workbookname"] . "</option>";
            }
        ?>
        </select>

<!--
    $workbook_array = get_workbooks(1);
    foreach ($workbook_array as $i) {
        echo $i["workbook_id"] . ", ";
    }
    $workbook_user_array = get_workbook_users(1);
    foreach ($workbook_user_array as $user_id=>$j) {
        echo $j["user_id"] . ", ";
    }
 -->