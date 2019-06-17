<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>create authinfo version 1</title>
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
$sql = "SELECT dm_id, dm_domain, dm_domain_ace FROM denic.denic_domain group by dm_domain order by dm_domain";
$result_domain = $mysqli->query($sql);
if (!$result_domain) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
    /* Customize navigation.inc to include your own navigation.*/
    <?php include('navi.inc'); ?>
    <h2>create authinfo1</h2>
</div>

<div class="_body">
    <form action="create_authinfo_version1_result.php" method="POST">
        <?php
        echo "<select name=\"dm_domain\">\n";
        while ($row = $result_domain->fetch_array(MYSQLI_NUM)) {
            $dm_id = $row[0];
            $dm_domain = $row[1];
            $dm_domain_ace = $row[2];
            echo "\t\t\t\t\t\t\t<option value=\"$dm_domain\">$dm_domain $dm_domain_ace</option>\n";
        }
        echo "\t\t\t\t\t\t\t</select><br>\n";
        ?>
        Authinfo:
        <input name="dm_authinfo" title="dm_authinfo" size="16" maxlength="16"><br>
        Expire:
        <input name="dm_authexpire" title="dm_authexpire" size="8" maxlength="8"><br>

        <input type="submit" value="order authinfo1 ">
    </form>
</div>

</body>
</html>