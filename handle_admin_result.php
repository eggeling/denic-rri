<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>edit handle</title>
</head>
<body>

<div class="_head">
    /* Customize navigation.inc to include your own navigation.*/
    <?php include('navi.inc'); ?>
    <h2>edit handle</h2>
</div>

<div class="_body">
    <code>

    /* Check data of submitted form for validity. */

    <?php
    $valid_code = 'true';
    if (!preg_match("=^DENIC-[1-9][0-9]*[A-Za-z0-9-\.\-]+$=i", $_POST['hd_handle_2'])) {
        echo "No data or forbidden char in field  handle!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_name_2']) && ($_POST['hd_name_2'] != "")) {
        echo "No data or forbidden char in field name!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_organisation_2']) && ($_POST['hd_organisation_2'] != "")) {
        echo "No data or forbidden char in field organisation!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_address_2'])) {
        echo "No data or forbidden char in field address!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_pcode_2'])) {
        echo "No data or forbidden char in field pcode!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_city_2'])) {
        echo "No data or forbidden char in field city!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_phone_2']) && ($_POST['hd_phone_2'] != "")) {
        echo "No data or forbidden char in field phone!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_fax_2']) && ($_POST['hd_fax_2'] != "")) {
        echo "No data or forbidden char in field fax!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_email_2']) && ($_POST['hd_email_2'] != "")) {
        echo "No data or forbidden char in field e-mail!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_sip_2']) && ($_POST['hd_sip_2'] != "")) {
        echo "No data or forbidden char in field SIP!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_0_2']) && ($_POST['hd_remarks_0_2'] != "")) {
        echo "No data or forbidden char in field comment!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_1_2']) && ($_POST['hd_remarks_1_2'] != "")) {
        echo "No data or forbidden char in field comment!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_2_2']) && ($_POST['hd_remarks_2_2'] != "")) {
        echo "No data or forbidden char in field comment!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_3_2']) && ($_POST['hd_remarks_3_2'] != "")) {
        echo "No data or forbidden char in field comment!<br>";
        $valid_code = 'false';
    }

    /* When the data is valid submit it via denic RRI.*/
    if ($valid_code == 'true') {
        $ctid = time();

        /* Create an order string */
        $message = "Action: UPDATE\n";
        $message .= "Version: 2.0" . "\n";
        $message .= "Handle: " . $_POST['hd_handle_2'] . "\n";
        $message .= "Type: " . $_POST['hd_type_2'] . "\n";
        $message .= "Name: " . $_POST['hd_name_2'] . "\n";
        $message .= "Organisation: " . $_POST['hd_organisation_2'] . "\n";
        $message .= "Address: " . $_POST['hd_address_2'] . "\n";
        $message .= "PostalCode: " . $_POST['hd_pcode_2'] . "\n";
        $message .= "City: " . $_POST['hd_city_2'] . "\n";
        $message .= "CountryCode: " . $_POST['hd_country_2'] . "\n";
        $message .= "Phone: " . $_POST['hd_phone_2'] . "\n";
        $message .= "Fax: " . $_POST['hd_fax_2'] . "\n";
        $message .= "Email: " . $_POST['hd_email_2'] . "\n";
        $message .= "Sip: " . $_POST['hd_sip_2'] . "\n";
        $message .= "Remarks: " . $_POST['hd_remarks_0_2'] . "\n";
        $message .= "Remarks: " . $_POST['hd_remarks_1_2'] . "\n";
        $message .= "Remarks: " . $_POST['hd_remarks_2_2'] . "\n";
        $message .= "Remarks: " . $_POST['hd_remarks_3_2'] . "\n";

        /* Include credentials for authentication against denic RRI */
        include_once "authentication.php";

        /* include denic functions from GitHub: https://github.com/DENICeG/phprri */
        include_once "functions.php";

        /* Create a connection string */
        if ($productive == 'true') {
            $rri_socket_address = "ssl://rri.denic.de:51131";
            $login_rri = "Version: 2.0\nAction: LOGIN\nUser: $user\nPassword: $password_real\n";
        } else {
            $rri_socket_address = "ssl://rri.test.denic.de:51131";
            $login_rri = "Version: 2.0\nAction: LOGIN\nUser: $user\nPassword: $password_test\n";
        }
        $conn = stream_socket_client($rri_socket_address, $errno, $errstr);

        /* Create a logout string */
        $logout_rri = "Version: 2.0\naction: LOGOUT\n";

        /* Connect to denic RRI */
        $connect_rri = handle_RRI_orders($conn, $login_rri);

        /* Send order to denic RRI */
        $place_order = handle_RRI_orders($conn, $message);

         /* Close order */
        $close_order = handle_RRI_orders($conn, $logout_rri);

        /* Close connection */
        fclose($conn);

        /* Check status of order and when successful insert data into database */
        if (!preg_match("/RESULT: success/", $place_order)) {
            echo "error placing order!<br>";
        } else {

            /* Include the variables for your database connection by editing database-default.inc and renaming it to database.inc.*/
            require 'database.inc';
            $mysqli = new mysqli($sqlhost, $sqluser, $sqlpass, $database);
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }
            $hd_action_2 = "UPDATE";
            $fields = "hd_handle, hd_action, hd_type, hd_name, hd_organisation, hd_address, hd_pcode, hd_city, hd_country, hd_phone, hd_fax, hd_email, hd_sip, hd_remarks_0, hd_remarks_1, hd_remarks_2, hd_remarks_3";
            $handle_admin = "hd_handle = \"" . $_POST['hd_handle_2'] . "\", " .
                            "hd_action = \"" . $hd_action_2  . "\", " .
                            "hd_type = \"" . $_POST['hd_type_2']  . "\", " .
                            "hd_name = \"" . $_POST['hd_name_2']  . "\", " .
                            "hd_organisation = \"" . $_POST['hd_organisation_2']  . "\", " .
                            "hd_address = \"" . $_POST['hd_address_2']  . "\", " .
                            "hd_pcode = \"" . $_POST['hd_pcode_2']  . "\", " .
                            "hd_city = \"" . $_POST['hd_city_2']  . "\", " .
                            "hd_country = \"" . $_POST['hd_country_2']  . "\", " .
                            "hd_phone = \"" . $_POST['hd_phone_2']  . "\", " .
                            "hd_fax = \"" . $_POST['hd_fax_2']  . "\", " .
                            "hd_email = \"" . $_POST['hd_email_2']  . "\", " .
                            "hd_sip = \"" . $_POST['hd_sip_2']  . "\", " .
                            "hd_remarks_0 = \"" . $_POST['hd_remarks_0_2']  . "\", " .
                            "hd_remarks_1 = \"" . $_POST['hd_remarks_1_2']  . "\", " .
                            "hd_remarks_2 = \"" . $_POST['hd_remarks_2_2']  . "\", " .
                            "hd_remarks_3 = \"" . $_POST['hd_remarks_3_2'] . "\"";

            $result = $mysqli->query("UPDATE denic.denic_handle SET $handle_admin WHERE hd_id = '$_POST[hd_id_2]';");
            echo $result;
            if (!$result) {
                echo "<p>Could not insert data.!</p>";
            }

            // Send the result of the order via e-mail
            $subject = "edit handle: " . $_POST['hd_handle_2'];
            $mailtext = "Connection to: " . $connect_rri;
            $mailtext .= "RRI answer: " . $place_order;
            $mailtext .= "original message: " . $message;
            $mailtext .= "closing connection: " . $close_order;
            mail($mailto, $subject, $mailtext, $from);
        }
    }
    ?>
    </code>
</div>

</body>
</html>