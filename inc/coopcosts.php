
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // the form has fields for q and units, temporarily passing "error" for error handling
    if (empty($_GET)) {
        $wb = $_SESSION["default_workbook"];
        $d = date("Y-m");
        $lastm = date("Y-m", mktime(0, 0, 0, date("m")-1, 1, date("Y")));
        $nextm = date("Y-m", mktime(0, 0, 0, date("m")+1, 1, date("Y")));
    } else {
        $wb = htmlspecialchars($_GET["wb"]);
        if (empty($_GET["d"])) {
            $d = date("Y-m");
        } else {
            $d = htmlspecialchars($_GET["d"]);
        }
        $nextmonth = new DateTime($d.'-01');
        $nextmonth->add(new DateInterval('P1M'));
        $nextm = $nextmonth->format('Y-m');
        $lastmonth = new DateTime($d.'-01');
        $lastmonth->sub(new DateInterval('P1M'));
        $lastm = $lastmonth->format('Y-m');
    }
    $wb_url = "?wb=" . $wb;
}
?>

<div>
    <h3>Welcome, <?php echo $_SESSION["first_name"] ?></h3>
    <p>Add a house expense below:</p>
    <form action="/inc/add_expense.php" method="post" class="form-inline">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"] ?>"/>
        <input type="hidden" name="workbook_id" value="<?php echo $wb ?>" />
        <div class="form-group">
            <label for="amt">Ammount: </label>
            <div class="input-group">
                <div class="input-group-addon">$</div>
                <input type="text" step="any" id="amt" name="amt" class="form-control" placeholder="42.24" />
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description: </label>
            <input type="text" name="description" class="form-control" placeholder="Trader Joes"/>
        </div>
        <div class="form-group">
            <label for="date">Date of expense: </label>
            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
        </div>
        <input type="submit" />
    </form>
    <form action="" method="get">
        <select name="wb" class="form-control" onchange="this.form.submit()">
            <option value="">Your workbooks</option>
        <?php
            $workbook_array = get_workbooks($_SESSION["user_id"]);
            foreach ($workbook_array as $workbook_id) {
                $workbook_name = get_workbook_name($workbook_id["workbook_id"]);
                echo "<option value='" . $workbook_id["workbook_id"] . "'>" . $workbook_name[0]["workbookname"] . "</option>";
            }
        ?>
        </select>
    </form>
    <p class="text-center">
        <a href="<?php echo $wb_url . '&d=' . $lastm ; ?>"><span class="glyphicon glyphicon-chevron-left"></span> Last Month</a>
        <a href="<?php echo $wb_url . '&d=' . $nextm ; ?>">Next Month <span class="glyphicon glyphicon-chevron-right"></span></a><br/>
        <?php echo $d; ?>
    </p>
    <form action="/inc/delete_expense.php" method="post">
    <?php
        // Gets $workbook_array from the get_workbooks() function in the 'Select workbook' section above
        // Needs to be refactored because this feels wrong
        $users_workbooks = array();
        foreach ($workbook_array as $workbook_id) {
            $users_workbooks[] = $workbook_id["workbook_id"];
        }
        if (in_array($wb, $users_workbooks)) {
            $all_expenses = get_expense_range($wb, $d);
            echo "<table class='table table-striped'>";
            $kyle_owed = 0;
            $hazel_owed = 0;
            $chad_owed = 0;
            $keara_owed = 0;
                
            foreach ($all_expenses as $exp) {
                if ($exp['user_id'] == 1)
                    $kyle_owed += $exp['amt'];
                else if ($exp['user_id'] == 2)
                    $hazel_owed += $exp['amt'];
                else if ($exp['user_id'] == 3)
                    $chad_owed += $exp['amt'];
                else if ($exp['user_id'] == 4)
                    $keara_owed += $exp['amt'];

        ?>
            <tr>
                <td><?php echo $exp['username'] ?></td>
                <td><?php echo $exp['amt'] ?></td>
                <td><?php echo $exp['description'] ?></td>
                <td><?php echo $exp['date'] ?></td>
                <td>
                <?php 
                    if ($exp['user_id'] == $_SESSION['user_id']){
                ?>
                <button type="submit" name="deleteItem" value="<?php echo $exp['id']; ?>">Delete entry</button>
                <?php 
                    }
                ?>
                </td>
            </tr>
        <?php
            }
        echo "</table></form>";
        echo "Kyle is owed " . ($kyle_owed/4) . " from each housemate. <br/>";
        echo "Hazel is owed " . ($hazel_owed/4) . " from each housemate. <br/>";
        echo "Chad is owed " . ($chad_owed/4) . " from each housemate. <br/>";
        echo "Keara is owed " . ($keara_owed/4) . " from each housemate. <br/>";
        } else {
            echo "You do not have access to that workbook.";
        }
    ?>
      </div>