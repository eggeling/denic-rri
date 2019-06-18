<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>transit domain</title>
</head>
<body>

<?php
require("database.inc");
$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass, $database);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

$sql = "SELECT dm_id, dm_domain, dm_domain_ace FROM denic_handle.denic_domain group by dm_domain order by dm_domain";
$result = $mysqli->query($sql);
if (!$result) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
    <?php include('navi.inc');?>
    <h2>transit domain</h2>
</div>
<div class="_body">

    <form action="transit2.php" method="POST">
        <?php
        echo "<select name=\"dm_domain\">\n";
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $dm_id = $row[0];
            $dm_domain = $row[1];
            $dm_domain_ace = $row[2];
            echo "\t\t\t\t\t\t\t<option value=\"$dm_domain\">$dm_domain $dm_domain_ace</option>\n";
        }
        echo "\t\t\t\t\t\t</select>\n";
        ?>
        <input type="submit" value="transit domain">
    </form>
</div>

</body>
</html>
