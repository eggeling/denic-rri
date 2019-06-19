<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>transfer domain</title>
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

/* Retrieve handles from database.*/
$sql = "SELECT hd_handle, hd_name FROM denic_handle.denic_handle order by hd_handle";
$result_holder = $mysqli->query($sql) or die ("Couldn't execute query.");
$result_admin_c = $mysqli->query($sql) or die ("Couldn't execute query.");
$result_tech_c = $mysqli->query($sql) or die ("Couldn't execute query.");
$result_zone_c = $mysqli->query($sql) or die ("Couldn't execute query.");

if (!$result_holder) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
    /* Customize navigation.inc to include your own navigation.*/
    <?php include('navigation.inc'); ?>
    <h2>transfer domain</h2>
</div>

<div class="_body">
    <form action="domain_chprov_result.php" method="POST">
        Domain
        <label>
            <input name="dm_domain" title="dm_domain" size="20">
            <br></label>
        Domain ACE
        <label>
            <input name="dm_domain_ace" title="dm_domain_ace" size="80">
        </label><br>
        Holder
        <?php
        if ($result_holder) {
            echo "<select name=\"dm_holder\" title=\"dm_holder\">";
            while ($row1 = $result_holder->fetch_array()) {
                echo "<option value=\"$row1[0]\">" . $row1[0] . $row1[1] . "\n";
            }
            echo "</select><br>";
        }
        ?>
        Admin-C
        <?php
        if ($result_admin_c) {
            echo "<select name=\"dm_admin\" title=\"dm_admin\">";
            while ($row2 = $result_admin_c->fetch_array()) {
                echo "<option value=\"$row2[0]\">" . $row2[0] . $row2[1] . "\n";
            }
            echo "</select><br>";
        }
        ?>
        Tech-C
        <?php
        if ($result_tech_c) {
            echo "<select name=\"dm_tech\" title=\"dm_tech\">";
            while ($row3 = $result_tech_c->fetch_array()) {
                echo "<option value=\"$row3[0]\">" . $row3[0] . $row3[1] . "\n";
            }
            echo "</select><br>";
        }
        ?>
        Zone-C
        <?php
        if ($result_zone_c) {
            echo "<select name=\"dm_zone\" title=\"dm_zone\">";
            while ($row4 = $result_zone_c->fetch_array()) {
                echo "<option value=\"$row4[0]\">" . $row4[0] . $row4[1] . "\n";
            }
            echo "</select><br>";
        }
        ?>
        NServer
        <label>
            <input name="dm_ns_0" title="dm_ns_0" size="80" value="hostname.domain.tld">
        </label><br>
        NServer
        <label>
            <input name="dm_ns_1" title="dm_ns_1" size="80">
        </label><br>
        NServer
        <label>
            <input name="dm_ns_2" title="dm_ns_2" size="80">
        </label><br>
        NServer
        <label>
            <input name="dm_ns_3" title="dm_ns_3" size="80">
        </label><br>
        AuthInfo
        <label>
            <input name="dm_key" title="dm_key" size="80">
        </label><br>

        <input type="submit" value="transfer domain">
    </form>
</div>

</body>
</html>
