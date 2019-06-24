<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>edit domain</title>
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

/* Retrieve domains from database.*/
$sql = "SELECT dm_id, dm_domain, dm_domain_ace FROM denic.domain dm_domain order by dm_domain";
$result = $mysqli->query($sql);
if (!$result) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
    <!-- Customize navigation.inc to include your own navigation.-->
    <?php include('navigation.inc'); ?>
    <h2>edit domain</h2>
</div>

<div class="_body">

    <form action="domain_admin_edit.php" method="post">
        <?php
        echo "\t\t\t<select name=\"dm_domain\">\n";
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $dm_id = $row[0];
            $dm_domain = $row[1];
            $dm_domain_ace = $row[2];
            echo "\t\t\t<option value=\"$dm_id\">$dm_domain $dm_domain_ace</option>\n";
        }
        echo "\t\t\t</select>\n";
        ?>
        <input type="submit" value="select domain">
    </form>

</div>
</body>
</html>