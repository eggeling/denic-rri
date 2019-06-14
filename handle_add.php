<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>add handle</title>
</head>
<body>

<?php

/* Include the variables for your database connection by editing database-default.inc and renaming it to database.inc.*/
require("database.inc");

$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass, $database);
if ($mysqli->connect_error) {
    die('Connection error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

/* Retrieve the country codes from he database..*/
$result_cc = $mysqli->query('SELECT cc_id, cc_code, cc_value, cc_description FROM denic.country_code');
if (!$result_cc) {
    echo "<p>Could not retrieve data.</p>";
}
?>

<div class="_head">
/* Customize navigation.inc to include your own navigation.*/
    <?php include('navigation.inc'); ?>
    <h2>add handle</h2>
</div>

<div class="_body">
    <form action="handle_add_result.php" method="POST">
        Handle
        <input type="text" title="hd_handle" name="hd_handle" size="32" maxlength="32"><br>

        Type
        <select title="hd_type" name="hd_type">
            <option value="PERSON">PERSON</option>
            <option value="ROLE">ROLE</option>
            <option value="ORG">ORG</option>
        </select><br>

        Name<input title="hd_name" name="hd_name" size="80" maxlength="255" pattern="[a-zA-Z0-9 ]+"><br>

        Organisation
        <input title="hd_organisation" name="hd_organisation" size="80" maxlength="255"><br>

        Address
        <input title="hd_address" name="hd_address" size="80" maxlength="255"><br>

        PostalCode
        <input title="hd_pcode" name="hd_pcode" size="20"><br>

        City
        <input title="hd_city" name="hd_city" size="80"><br>

        CountryCode
        <?php
        if ($result_cc) {
            echo "<select title=\"hd_country\" name=\"hd_country\">\n";
            while ($row = $result_cc->fetch_array(MYSQLI_NUM)) {
                echo "\t\t\t\t\t\t\t\t\t\t<option value=\"$row[2]\">" . $row[3] . "</option>\n";
            }
            echo "</select></br>";
        }
        ?>

        Phone
        <input title="hd_phone" name="hd_phone" size="80"><br>

        Fax
        <input title="hd_fax" name="hd_fax" size="80"><br>

        E-Mail
        <input title="hd_email" type="email" name="hd_email" size="80"><br>

        SIP
        <input title="hd_sip" name="hd_sip" size="80"><br>

        Disclose
        <input title="hd_disclose" name="hd_disclose" size="80"><br>

        Remarks
        <input title="hd_remarks_0" name="hd_remarks_0" size="80"><br>

        Remarks
        <input title="hd_remarks_1" name="hd_remarks_1" size="80"><br>

        Remarks
        <input title="hd_remarks_2" name="hd_remarks_2" size="80"><br>

        Remarks
        <input title="hd_remarks_3" name="hd_remarks_3" size="80"><br>

        <input type="submit" value="add handle">
    </form>
</div>

</body>
</html>