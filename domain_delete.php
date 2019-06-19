<!DOCTYPE html>
<html>
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>delete domain</title>
</head>
<body>

<?php
/* Include the variables for your database connection by editing database-default.inc and renaming it to database.inc.*/
require("database.inc");

/* Retrieve domains from database.*/
$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass, $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$sql = "SELECT dm_id, dm_domain, dm_domain_ace from denic_rri.denic_domain group by dm_domain ORDER BY `denic_domain`.`dm_domain`;";
$result = $mysqli->query($sql) or die ("Couldn't execute query.");

if (!$result) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
    /* Customize navigation.inc to include your own navigation.*/
    <?php include('navigation.inc'); ?>
    <h2>delete domain</h2>
</div>

<div class="_body">
    <form action="domain_delete_result.php" method="POST">
        <?php
        echo "\t\t\t<select name=\"dm_domain\">\n";
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $dm_id = $row[0];
            $dm_domain = $row[1];
            $dm_domain_ace = $row[2];
            echo "\t\t\t<option value=\"$dm_domain\">$dm_domain $dm_domain_ace</option>\n";
        }
        echo "\t\t\t</select>\n";
        ?>
        <input type="submit" value="delete domain">
    </form>
</div>

</body>
</html>
