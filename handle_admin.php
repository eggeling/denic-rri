<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>edit handle</title>
</head>
<body>

<?php

/* Include the variables for your database connection by editing database-default.inc and renaming it to database.inc.*/
require("database.inc");
$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass, $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

/* Retrieve the handles from the database.*/
$result = $mysqli->query('SELECT hd_id, hd_handle, hd_name FROM denic.handle order by hd_handle');
if (!$result) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
    <!-- Customize navigation.inc to include your own navigation.-->
    <?php include('navigation.inc'); ?>
    <h2>edit handle</h2>
</div>

<div class="_body">

    <form action="handle_admin_edit.php" method="POST">
        <?php
        echo "\t\t\t\t\t\t<select name=\"selected_record\">\n";
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $hd_id = $row[0];
            $hd_handle = $row[1];
            $hd_name = $row[2];
            echo "\t\t\t\t\t\t<option value=\"$hd_id\">$hd_handle $hd_name</option>\n";
        }
        echo "\t\t\t\t\t\t</select><br>\n";
        ?>
        <input type="submit" value="select handle">
    </form>
</div>

</body>
</html>
