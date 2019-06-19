<!DOCTYPE html>
<html lang="en">
<head>
    <link href="denic.css" rel="stylesheet" type="text/css"/>
    <title>create authinfo version 2</title>
</head>
<body>

<div class="_head">
    /* Customize navigation.inc to include your own navigation.*/
    <?php include('navigation.inc'); ?>
    <h2>create authinfo version 2</h2>
</div>

<div class="_body">
    <code>

        /* Check data of submitted form for validity. */
        <?php
        $valid_code = 'true';
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_domain'])) {
            echo "No data or forbidden char in field domain!<br>";
            $valid_code = 'false';
        }
        if (!preg_match("=[A-Za-z0-9-\.]+$=i", $_POST['dm_domain_ace']) && ($_POST['dm_domain_ace'] != "")) {
            echo "No data or forbidden char in field domain-aceE!<br>";
            $valid_code = 'false';
        }

        if ($valid_code == 'true') {
            $ctid = time();

            /* Create an order string */
            $message .= "Action: CREATE-AUTHINFO2" . "\n";
            $message .= "Version: 2.0" . "\n";
            $message .= "Ctid: " . $ctid . "\n";
            $message .= "Domain: " . $_POST['dm_domain'] . "\n";

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
                $result = $mysqli->query("DELETE FROM denic_rri.denic-domain WHERE dm_domain = '$_POST[dm_domain]';");
                if (!$result) {
                    echo "<p>Could not insert data.!</p>";
                }
                /* Send the result of the order via e-mail */
                $subject = "create authinfo1: " . $_POST['dm_domain'];
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