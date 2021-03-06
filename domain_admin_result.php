<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>edit domain</title>
</head>
<body>

<div class="_head">
    <!-- Customize navigation.inc to include your own navigation.-->
    <?php include('navigation.inc'); ?>
    <h2>edit domain</h2>
</div>

<div class="_body">
    <code>

    /* Check data of submitted form for validity. */
    <?php
    $valid_code = 'true';
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_action'])) {
        echo "No data or forbidden char in field action!<br>";
        $valid_code = 'false';
    }
    //if (!preg_match("=[A-Za-z0-9-\.]+$=i",$_POST[dm_domain]))
    //	{
    //    echo "No data or forbidden char in field domain!<br>";
    //	$valid_code='false';
    //	}
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_domain_ace']) && ($_POST['dm_domain_ace'] != "")) {
        echo "No data or forbidden char in field domain-ace!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_holder'])) {
        echo "No data or forbidden char in field holder!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_admin'])) {
        echo "No data or forbidden char in field admin-c!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_tech'])) {
        echo "No data or forbidden char in field tech-c!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_zone'])) {
        echo "No data or forbidden char in field zone-c!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_ns_0'])) {
        echo "No data or forbidden char in field nserver!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_ns_1'])) {
        echo "No data or forbidden char in field nserver!<br>";
        $valid_code = 'false';
    }
    if ($_POST['dm_ns_2'] != '' && !preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_ns_2'])) {
        echo "Forbidden char in field nserver!<br>";
        $valid_code = 'false';
    }
    if ($_POST['dm_ns_3'] != '' && !preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_ns_3'])) {
        echo "Forbidden char in field nserver!<br>";
        $valid_code = 'false';
    }

    /* When the data is valid submit it via denic RRI.*/
    if ($valid_code == 'true') {
        $ctid = time();

        /* Create an order string */
        $message = "Action: " . $_POST['dm_action'] . "\n";
        $message .= "Version: 2.0\n";
        $message .= "Ctid: " . $ctid . "\n";
        $message .= "Domain: " . $_POST['dm_domain'] . "\n";
        $message .= "Domain-ACE: " . $_POST['dm_domain_ace'] . "\n";
        $message .= "Holder: " . $_POST['dm_holder'] . "\n";
        $message .= "Admin-C: " . $_POST['dm_admin'] . "\n";
        $message .= "Tech-C: " . $_POST['dm_tech'] . "\n";
        $message .= "Zone-C: " . $_POST['dm_zone'] . "\n";
        $message .= "Nserver: " . $_POST['dm_ns_0'] . "\n";
        $message .= "Nserver: " . $_POST['dm_ns_1'] . "\n";
        $message .= "Nserver: " . $_POST['dm_ns_2'] . "\n";
        $message .= "Nserver: " . $_POST['dm_ns_3'] . "\n";
        $message .= "Dnskey: " . $_POST['dm_key'] . "\n";

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
            $mysqli = new mysqli($sqlhost, $sqluser, $sqlpass);
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
            }
            $domain_admin = "dm_action = \"" . $_POST['dm_action'] . "\", " .
                "dm_domain = \"" . $_POST['dm_domain'] . "\", " .
                "dm_holder = \"" . $_POST['dm_holder'] . "\", " .
                "dm_admin = \"" . $_POST['dm_admin'] . "\", " .
                "dm_tech = \"" . $_POST['dm_tech'] . "\", " .
                "dm_zone = \"" . $_POST['dm_zone'] . "\", " .
                "dm_ns_0 = \"" . $_POST['dm_ns_0'] . "\", " .
                "dm_ns_1 = \"" . $_POST['dm_ns_1'] . "\", " .
                "dm_ns_2 = \"" . $_POST['dm_ns_2'] . "\", " .
                "dm_ns_3 = \"" . $_POST['dm_ns_3'] . "\", " .
                "dm_key = \"" . $_POST['dm_key'] . "\"";

           $result = $mysqli->query("UPDATE denic.domain SET $domain_admin WHERE domain.dm_domain = '$_POST[dm_domain]'");
            if (!$result) {
                echo "<p>Could not retrieve data.</p>";
                echo $mysqli->error;
            }

            /* Send the result of the order via e-mail */
            $subject = "edit domain: " . $_POST['dm_domain'];
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