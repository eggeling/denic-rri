<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>add handle</title>
</head>
<body>

<div class="_head">
    /* Customize navigation.inc to include your own navigation.*/
    <?php include('navigation.inc'); ?>
    <h2>add handle</h2>
</div>

<div class="_body">
    <code>
        <?php

        /* Check data of submitted form for validity. */

        $valid_code = 'true';
        if (!preg_match("=^DENIC-[1-9][0-9]*[A-Za-z0-9-\.\-]+$=i", $_POST['hd_handle'])) {
            echo "No data or forbidden char in field handle!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_name']) && ($_POST['hd_name'] != "")) {
            echo "No data or forbidden char in field name!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_organisation']) && ($_POST['hd_organisation'] != "")) {
            echo "Forbidden char in field organisation!<br>";
            $valid_code = 'false';
        }
        if (($_POST['hd_name'] == "") && ($_POST['hd_organisation'] == "")) {
            echo "No data in fields name and organisation!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_address'])) {
            echo "No data or forbidden char in field address!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_pcode'])) {
            echo "No data or forbidden char in field pcode!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_city'])) {
            echo "No data or forbidden char in field town!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_phone'])) {
            echo "No data or forbidden char in field phone!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_fax']) && ($_POST['hd_fax'] != "")) {
            echo "Forbidden char in field fax!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_email'])) {
            echo "No data or forbidden char in field e-mail!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_sip']) && ($_POST['hd_sip'] != "")) {
            echo "Forbidden char in field SIP!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_0']) && ($_POST['hd_remarks_0'] != "")) {
            echo "Forbidden char in field comments!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_1']) && ($_POST['hd_remarks_1'] != "")) {
            echo "Forbidden char in field comments!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_2']) && ($_POST['hd_remarks_2'] != "")) {
            echo "Forbidden char in field comments!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['hd_remarks_3']) && ($_POST['hd_remarks_3'] != "")) {
            echo "Forbidden char in field comments!<br>";
            $valid_code = 'false';
        }

        /* When the data is valid submit it via denic RRI.*/
        if ($valid_code == 'true') {
            $ctid = time();

            /* Create an order string */
            $message = "Action: CREATE\n";
            $message .= "Version: 2.0" . "\n";
            $message .= "Ctid: " . $ctid . "\n";
            $message .= "Handle: " . $_POST['hd_handle'] . "\n";
            $message .= "Type: " . $_POST['hd_type'] . "\n";
            $message .= "Name: " . $_POST['hd_name'] . "\n";
            $message .= "Organisation: " . $_POST['hd_organisation'] . "\n";
            $message .= "Address: " . $_POST['hd_address'] . "\n";
            $message .= "PostalCode: " . $_POST['hd_pcode'] . "\n";
            $message .= "City: " . $_POST['hd_city'] . "\n";
            $message .= "CountryCode: " . $_POST['hd_country'] . "\n";
            $message .= "Phone: " . $_POST['hd_phone'] . "\n";
            $message .= "Fax: " . $_POST['hd_fax'] . "\n";
            $message .= "Email: " . $_POST['hd_email'] . "\n";
            $message .= "Sip: " . $_POST['hd_sip'] . "\n";
            $message .= "Disclose: " . $_POST['hd_disclose'] . "\n";
            $message .= "Remarks: " . $_POST['hd_remarks_0'] . "\n";
            $message .= "Remarks: " . $_POST['hd_remarks_1'] . "\n";

            /* Include credentials for authentication against denic RRI */
            include_once "authentication.php";

            /* Include denic functions from GitHub: https://github.com/DENICeG/phprri */
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
                require("database.inc");
                $mysqli = new mysqli($sqlhost, $sqluser, $sqlpass, $database);
                if ($mysqli->connect_error) {
                    die('Connect Error (' . $mysqli->connect_errno . ') '
                        . $mysqli->connect_error);
                }
                $hd_action = "CREATE";
                $fields = "hd_handle, hd_action, hd_type, hd_name, hd_organisation, hd_address, hd_pcode, hd_city, hd_country, hd_phone, hd_fax, hd_email, hd_sip, hd_disclose, hd_remarks_0, hd_remarks_1, hd_remarks_2, hd_remarks_3";
                $values = "\"" . $_POST['hd_handle'] . "\", " . "\"" . $hd_action . "\", " . "\"" . $_POST['hd_type'] . "\", " . "\"" . $_POST['hd_name'] . "\", " . "\"" . $_POST['hd_organisation'] . "\", " . "\"" . $_POST['hd_address'] . "\", " . "\"" . $_POST['hd_pcode'] . "\", " . "\"" . $_POST['hd_city'] . "\", " . "\"" . $_POST['hd_country'] . "\", " . "\"" . $_POST['hd_phone'] . "\", " . "\"" . $_POST['hd_fax'] . "\", " . "\"" . $_POST['hd_email'] . "\", " . "\"" . $_POST['hd_sip'] . "\", " . "\"" . $_POST['hd_disclose'] . "\", " . "\"" . $_POST['hd_remarks_0'] . "\", " . "\"" . $_POST['hd_remarks_1'] . "\", " . "\"" . $_POST['hd_remarks_2'] . "\", " . "\"" . $_POST['hd_remarks_3'] . "\"";
                $result = $mysqli->query("INSERT INTO denic.handle ( $fields ) VALUES ( $values )");

                if (!$result) {
                    echo "<p>Could not insert data.!</p>";
                }

                /* Send the result of the order via e-mail */
                $subject = "create handle: " . $_POST['hd_handle'];
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