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

/* Retrieve handles from database.*/
$sql_handle = "SELECT hd_handle FROM denic.handle order by hd_handle";
$sql_holder_selected = "SELECT dm_holder FROM denic.domain WHERE dm_id = '$_POST[dm_domain]'";
$sql_admin_selected = "SELECT dm_admin FROM denic.domain WHERE dm_id = '$_POST[dm_domain]'";
$sql_tech_selected = "SELECT dm_tech  FROM denic.domain WHERE dm_id = '$_POST[dm_domain]'";
$sql_zone_selected = "SELECT dm_zone FROM denic.domain WHERE dm_id = '$_POST[dm_domain]'";;
$sql_fill = "SELECT * FROM denic.domain WHERE dm_id = '$_POST[dm_domain]'";

$result_holder = $mysqli->query($sql_handle);
$result_holder_selected = $mysqli->query($sql_holder_selected);
$result_admin_c = $mysqli->query($sql_handle);
$result_admin_c_selected = $mysqli->query($sql_admin_selected);
$result_tech_c = $mysqli->query($sql_handle);
$result_tech_c_selected = $mysqli->query($sql_tech_selected);
$result_zone_c = $mysqli->query($sql_handle);
$result_zone_c_selected = $mysqli->query($sql_zone_selected);

$result_fill = $mysqli->query($sql_fill);

if (!$result_fill) {
    echo "<p>Could not retrieve data.</p>";
} else {
    $row = $result_fill->fetch_array();
    $dm_action = $row["dm_action"];
    $dm_domain = $row["dm_domain"];
    $dm_domain_ace = $row["dm_domain_ace"];
    $dm_holder = $row["dm_holder"];
    $dm_admin = $row["dm_admin"];
    $dm_tech = $row["dm_tech"];
    $dm_zone = $row["dm_zone"];
    $dm_ns_0 = $row["dm_ns_0"];
    $dm_ns_1 = $row["dm_ns_1"];
    $dm_ns_2 = $row["dm_ns_2"];
    $dm_ns_3 = $row["dm_ns_3"];
    $dm_key = $row["dm_key"];
}
?>

<div class="_head">
    <!-- Customize navigation.inc to include your own navigation.-->
    <?php include('navigation.inc'); ?>
    <h2>edit domain</h2>
</div>

<div class="_body">
    <form action="domain_admin_result.php" method="POST">
        <label>
            <select name="dm_action" title="dm_action" size="1">
                <option>CHHOLDER</option>
                <option selected>UPDATE</option>
            </select>
        </label><br>

        Domain
        <label>
            <input name="dm_domain" title="dm_domain_ace" size="20" value="<?php echo "$dm_domain"; ?>">
        </label><br>
        Domain ACE
        <label>
            <input name="dm_domain_ace" title="dm_domain_ace" size="80" value="<?php echo "$dm_domain_ace"; ?>">
        </label><br>

        Holder
        <?php
        if ($result_holder) {
            echo "\t<select name=\"dm_holder\" title=\"dm_holder\">";
            while ($row5 = $result_holder->fetch_array()) {
                echo "\t<option value=\"$row5[0]\">" . $row5[0] . "</option>\n";
            }
        }
        if ($result_holder_selected) {
            $row1 = $result_holder_selected->fetch_array();
            echo "\t<option value=\"$row1[0]\" selected>" . $row1[0] . "</option>\n";
            echo "\t</select>\n";
        }
        echo "<br>";
        ?>

        Admin-C
        <?php
        if ($result_admin_c) {
            echo "<select name=\"dm_admin\" title=\"dm_admin\">";
            while ($row6 = $result_admin_c->fetch_array()) {
                echo "<option value=\"$row6[0]\">" . $row6[0] . "</option>\n";
            }
        }
        if ($result_admin_c_selected) {
            $row2 = $result_admin_c_selected->fetch_array();
            echo "<option value=\"$row2[0]\" selected>" . $row2[0] . "</option>\n";
            echo "</select>\n";
        }
        echo "<br>";
        ?>

        Tech-C
        <?php
        if ($result_tech_c) {
            echo "<select name=\"dm_tech\" title=\"dm_tech\">";
            while ($row7 = $result_tech_c->fetch_array()) {
                echo "<option value=\"$row7[0]\">" . $row7[0] . "</option>\n";
            }
        }
        if ($result_tech_c_selected) {
            $row3 = $result_tech_c_selected->fetch_array();
            echo "<option value=\"$row3[0]\" selected>" . $row3[0] . "</option>\n";
            echo "</select>\n";
        }
        echo "<br>";
        ?>

        Zone-C
        <?php
        if ($result_zone_c) {
            echo "<select name=\"dm_zone\" title=\"dm_zone\">";
            while ($row8 = $result_zone_c->fetch_array()) {
                echo "<option value=\"$row8[0]\">" . $row8[0] . "</option>\n";
            }
        }
        if ($result_zone_c_selected) {
            $row4 = $result_zone_c_selected->fetch_array();
            echo "<option value=\"$row4[0]\" selected>" . $row4[0] . "</option>\n";
            echo "</select>\n";
        }
        echo "<br>";
        ?>

        NServer
        <label>
            <input name="dm_ns_0" title="dm_ns_0" size="80" value="<?php echo "$dm_ns_0"; ?>">
        </label><br>

        NServer
        <label>
            <input name="dm_ns_1" title="dm_ns_1" size="80" value="<?php echo "$dm_ns_1"; ?>">
        </label><br>
        NServer
        <label>
            <input name="dm_ns_2" title="dm_ns_2" size="80" value="<?php echo "$dm_ns_2"; ?>">
        </label><br>

        NServer
        <label>
            <input name="dm_ns_3" title="dm_ns_3" size="80" value="<?php echo "$dm_ns_3"; ?>">
        </label><br>

        Dnskey
        <label>
            <input name="dm_key" title="dm_key" size="80" value="<?php echo "$dm_key"; ?>">
        </label><br>

        <input type="submit" value="edit domain">
    </form>

</body>
</html>
