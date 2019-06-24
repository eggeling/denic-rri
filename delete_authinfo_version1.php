<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>delete authinfo version 2</title>
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

/* Retrieve domains with active authinfo from database.*/
$result = $mysqli->query('SELECT * FROM denic.domain WHERE dm_authinfo = \'1\' order by dm_domain ');
if (!$result) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
    <!-- Customize navigation.inc to include your own navigation.-->
    <?php include('navigation.inc'); ?>
    <h2>delete authinfo version 1</h2>
</div>

<div class="_body">
    <form action="delete_authinfo_version1_result.php" method="POST">

        <?php
        echo "<select name=\"dm_domain\">\n";
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $dm_id = $row[0];
            $dm_domain = $row[2];
            $dm_domain_ace = $row[3];
            echo "\t\t\t\t\t\t\t<option value=\"$dm_domain\">$dm_domain $dm_domain_ace</option>\n";
        }
        echo "\t\t\t\t\t\t\t</select>\n";
        ?>
        <input type="SUBMIT" value="delete authinfo">
    </form>
</div>

</body>
</html>