/* Simple navigation to be included in php files

The boolean value from the authentication.php file is used to display the current environment.

*/

<ul>
    <li><a href="handle_add.php">create handle</a></li>
    <li><a href="handle_admin.php">edit handle</a></li>
</ul>
<ul>
    <li><a href="domain_add.php">add domain</a></li>
    <li><a href="domain_delete.php">delete domain</a></li>
    <li><a href="domain_admin.php">edit domain</a></li>
</ul>
<ul>
    <li><a href="domain_kk.php">start transfer</a></li>
    <li><a href="create-authinfo1.php">create authinfo</a></li>
    <li><a href="create-authinfo2.php">create authinfo2</a></li>
    <li><a href="delete-authinfo.php">delete authinfo</a></li>
    <li><a href="transit.php">transit domain</a></li>
</ul>

<?php

include_once "authentication.php";

if ($productive == 'true') {
    echo "<div class=\"_productive\">productive environment </div>";
} else {
    echo "<div class=\"_productive\">test environment</div>";
}
?>
