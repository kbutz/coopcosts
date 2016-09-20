<?php
/*
 * Returns a random row matching the weather_code
 */

function add_expense($user_id, $amt, $description, $date, $workbook_id) {
    require("../inc/database.php");
    try {
        $results = $db->prepare("
            INSERT INTO expenses(user_id, amt, description, date, workbook_id) VALUES(?, ?, ?, ?, ?)
            ");

        $results->execute(array($user_id, $amt, $description, $date, $workbook_id));

    } catch (Exception $e) {
        echo "Problem adding expense " . $e;
        exit;
    }
}

function delete_expense($id) {
    require("../inc/database.php");
    try {
        $results = $db->prepare("
            DELETE FROM expenses WHERE id=?
            ");
        $results->bindParam(1, $id);
        $results->execute();

    } catch (Exception $e) {
        echo "Problem deleting entry " . $e;
        exit;
    }
}

function get_workbooks($id) {
    require("inc/database.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM workbookusers
            WHERE user_id = ?
            ");
        $results->bindParam(1, $id);
        $results->execute();
    } catch (Exception $e) {
        echo "Problem fetching expenses: " . $e;
        exit;
    }
    $workbook_array= $results->fetchAll(PDO::FETCH_ASSOC);;
    return $workbook_array;
}

function get_workbook_name($id) {
    require("inc/database.php");
    try {
        $results = $db->prepare("
            SELECT workbookname
            FROM workbooks
            WHERE id = ?
            ");
        $results->bindParam(1, $id);
        $results->execute();
    } catch (Exception $e) {
        echo "Problem fetching expenses: " . $e;
        exit;
    }
    $workbook_array= $results->fetchAll(PDO::FETCH_ASSOC);;
    return $workbook_array;
}

function get_workbook_users($workbook_id) {
    require("inc/database.php");
    try {
        $results = $db->prepare("
            SELECT *
            FROM workbookusers
            WHERE workbook_id = ?
            ");
        $results->bindParam(1, $workbook_id);
        $results->execute();
    } catch (Exception $e) {
        echo "Problem fetching expenses: " . $e;
        exit;
    }
    $workbook_array= $results->fetchAll(PDO::FETCH_ASSOC);
    return $workbook_array;
}

function get_all_expenses($workbook_id) {
	require("inc/database.php");
	try {
        $results = $db->prepare("
            SELECT * 
            FROM expenses
            LEFT OUTER JOIN users ON expenses.user_id = users.user_id
            WHERE workbook_id = ?
            ORDER BY `date`
            ");
        $results->bindParam(1, $workbook_id);
        $results->execute();
    } catch (Exception $e) {
        echo "Problem fetching expenses: " . $e;
        exit;
    }
    $expense_array= $results->fetchAll(PDO::FETCH_ASSOC);
    return $expense_array;
}

function get_expense_range($workbook_id, $date) {
    require("inc/database.php");
    $pagination_date_min = $date . "-1";
    $pagination_date_max = $date . "-31";
    try {
        $results = $db->prepare("
            SELECT * 
            FROM expenses
            LEFT OUTER JOIN users ON expenses.user_id = users.user_id
            WHERE workbook_id = ?
            AND date BETWEEN ? AND ?
            ORDER BY `date`
            ");
        $results->bindParam(1, $workbook_id);
        $results->bindParam(2, $pagination_date_min);
        $results->bindParam(3, $pagination_date_max);
        $results->execute();
    } catch (Exception $e) {
        echo "Problem fetching expenses: " . $e;
        exit;
    }
    $expense_array= $results->fetchAll(PDO::FETCH_ASSOC);
    return $expense_array;
}
