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

/* Retrieve the selected handle from the database.*/
$sql_handle = "SELECT hd_id, hd_handle, hd_action, hd_type, hd_name, hd_organisation, hd_address, hd_pcode, hd_city, hd_country, hd_phone, hd_fax, hd_email, hd_sip, hd_remarks_0, hd_remarks_1, hd_remarks_2, hd_remarks_3 FROM denic.handle WHERE denic.handle.hd_id = '$_POST[selected_record]'";
$result_handle = $mysqli->query($sql_handle);

if (!$result_handle) {
    echo "<p>Could not retrieve data.</p>";
} else {
    $row = $result_handle->fetch_array();
    $hd_id = $row["hd_id"];
    $hd_handle = $row["hd_handle"];
    $hd_action = $row["hd_action"];
    $hd_type = $row["hd_type"];
    $hd_name = $row["hd_name"];
    $hd_organisation = $row["hd_organisation"];
    $hd_address = $row["hd_address"];
    $hd_pcode = $row["hd_pcode"];
    $hd_city = $row["hd_city"];
    $hd_country = $row["hd_country"];
    $hd_phone = $row["hd_phone"];
    $hd_fax = $row["hd_fax"];
    $hd_email = $row["hd_email"];
    $hd_sip = $row["hd_sip"];
    $hd_remarks_0 = $row["hd_remarks_0"];
    $hd_remarks_1 = $row["hd_remarks_1"];
    $hd_remarks_2 = $row["hd_remarks_2"];
    $hd_remarks_3 = $row["hd_remarks_3"];
}

/* Retrieve the country codes from the database.*/
$sql_cc = "SELECT cc_id, cc_code, cc_value, cc_description FROM denic.country_code";
/* Retrieve the selected country code from the database.*/
$sql_cc_selected = "SELECT cc_id, cc_code, cc_value, cc_description FROM denic.country_code WHERE denic.country_code.cc_code = '$hd_country'";
$result_cc = $mysqli->query($sql_cc);
$result_cc_selected = $mysqli->query($sql_cc_selected);

?>

<div class="_head">
    <!-- Customize navigation.inc to include your own navigation.-->
    <?php include('navigation.inc'); ?>
    <h2>edit handle</h2>
</div>

<div class="_body">

    <form action="handle_admin_result.php" method="post">
        <?php
        echo "<input name=\"hd_id_2\" title=\"hd_id_2\" size=\"80\" maxlength=\"255\" value=\"$hd_id\" type=\"hidden\"><br>

              Handle
              <input name=\"hd_handle_2\" title=\"hd_handle_2\" size=\"80\" maxlength=\"255\" value=\"$hd_handle\" type=\"hidden\">$hd_handle<br>

              Type
              <input name=\"hd_type_2\" title=\"hd_type_2\" size=\"80\" maxlength=\"255\" value=\"$hd_type\" type=\"hidden\">$hd_type<br>

              Name
              <input name=\"hd_name_2\"  title=\"hd_name_2\" size=\"80\" maxlength=\"255\" value=\"$hd_name\" type=\"hidden\">$hd_name<br>

              Organisation
              <input name=\"hd_organisation_2\" title=\"hd_organisation_2\" size=\"80\" maxlength=\"255\" value=\"$hd_organisation\"><br>

              Address
              <input name=\"hd_address_2\" title=\"hd_address_2\" size=\"80\" maxlength=\"255\" value=\"$hd_address\"><br>

              PostalCode
              <input name=\"hd_pcode_2\" title=\"hd_pcode_2\" size=\"20\" value=\"$hd_pcode\"><br>

              City
              <input name=\"hd_city_2\" title=\"hd_city_2\" size=\"80\" value=\"$hd_city\"><br>

              CountryCode";

        if ($result_cc) {
            echo "<select name=\"hd_country_2\" title=\"hd_country_2\">";
            while ($row = $result_cc->fetch_row()) {
                echo "<option value=\"$row[2]\">$row[3]\n";
            }
        }
        if ($result_cc_selected) {
            while ($row2 = $result_cc_selected->fetch_row()) {
                echo "<option value=\"$hd_country\" selected>" . $row2[3] . "\n";
            }
        }
        echo "</select><br>

             Phone
             <input name=\"hd_phone_2\" title=\"hd_phone_2\" size=\"80\" value=\"$hd_phone\"><br>

             Fax
             <input name=\"hd_fax_2\" title=\"hd_fax_2\" size=\"80\" value=\"$hd_fax\"><br>

             Email
             <input name=\"hd_email_2\" type=\"email\" title=\"hd_email_2\" size=\"80\" value=\"$hd_email\"><br>

             Sip
             <input name=\"hd_sip_2\" title=\"hd_sip_2\" size=\"80\" value=\"$hd_sip\"><br>

             Remarks
             <input name=\"hd_remarks_0_2\" title=\"hd_remarks_0_2\" size=\"80\" value=\"$hd_remarks_0\"><br>

             Remarks
             <input name=\"hd_remarks_1_2\" title=\"hd_remarks_1_2\" size=\"80\" value=\"$hd_remarks_1\"><br>

             Remarks
             <input name=\"hd_remarks_2_2\" title=\"hd_remarks_2_2\" size=\"80\" value=\"$hd_remarks_2\"><br>

             Remarks
             <input name=\"hd_remarks_3_2\" title=\"hd_remarks_3_2\" size=\"80\" value=\"$hd_remarks_3\"><br>

             <input type=\"submit\" value=\"edit handle\">\n";
        ?>
    </form>
</div>

</body>
</html>