<!DOCTYPE html>
<html>
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>purge domain</title>
</head>
<body>

<div class="_head">
    <?php include('navi.inc'); ?>
    <h2>transit domain</h2>
</div>

<div class="_body">
    <?php
    $valid_code = 'true';
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_domain'])) {
        echo "No data or forbidden char in field  domain!<br>";
        $valid_code = 'false';
    }
    if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_domain_ace']) && ($_POST['dm_domain_ace'] != "")) {
        echo "No data or forbidden char in field domain-ace!<br>";
        $valid_code = 'false';
    }

    if ($valid_code == 'true') {
        $ctid = time();

        // create order string
        $message = "Action: TRANSIT\n";
        $message .= "Version: 2.0\n";
        $message .= "Ctid: " . $ctid . "\n";
        $message .= "Domain: " . $_POST['dm_domain'] . "\n";
        $message .= "Domain-ace: " . $_POST['dm_domain_ace'] . "\n";

        echo $message;

        // include authentification
        include_once "authentication.php";

        // include denic functions from GitHub
        include_once "functions.php";

        // create connection string
        if ($productive == 'true') {
            $rri_socket_address = "ssl://rri.denic.de:51131";
            $login_rri = "Version: 2.0\nAction: LOGIN\nUser: $user\nPassword: $password_real\n";
        } else {
            $rri_socket_address = "ssl://rri.test.denic.de:51131";
            $login_rri = "Version: 2.0\nAction: LOGIN\nUser: $user\nPassword: $password_test\n";
        }
        $conn = stream_socket_client($rri_socket_address, $errno, $errstr);

        // create logout string
        $logout_rri = "Version: 2.0\naction: LOGOUT\n";

        // connect to RRI
        $connect_rri = handle_RRI_orders($conn, $login_rri);

        // send order to RRI
        $place_order = handle_RRI_orders($conn, $message);

        // close connection
        $close_order = handle_RRI_orders($conn, $logout_rri);

        // close connection
        fclose($conn);

        // check status of order
        if (!preg_match("/RESULT: success/", $place_order)) {
            echo "error placing order!<br>";
        } else {
            require("database.inc");
            $mysqli = new mysqli($sqlhost, $sqluser, $sqlpass, $database);
            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
            }
            $result = $mysqli->query("DELETE FROM denic.domain WHERE dm_domain = '$_POST[dm_domain]';");
            if (!$result) {
                echo "<p>Could not insert data.!</p>";
            }

            // send result via e-mail
            $subject = "transit: " . $_POST['dm_domain'];
            $mailtext = "Connection to: " . $connect_rri;
            $mailtext .= "RRI answer: " . $place_order;
            $mailtext .= "original message: " . $message;
            $mailtext .= "closing connection: " . $close_order;
            mail($mailto, $subject, $mailtext, $from);
        }
    }
    ?>
</div>

</body>
</html>