<?php
//Senden von Daten:
function RRI_Send($conn, $order)
{
    $len = strlen($order);
    $nlen = RRI_Pack($len);                       // Convert Bytes of len to Network-Byte-Order
    $bytes = fwrite($conn, $nlen, 4);               // send length of order to server
    $bytes_sent = fwrite($conn, $order, $len);      // send order
    echo "Number of sent bytes: " . $bytes_sent;
    return $bytes_sent;
}

function RRI_Pack($len)
{
    $pack = pack("N", $len); // format type Long (4 bytes) -> pack len into binary string
    return $pack;
}

//Lesen von Daten:
function RRI_Read($conn)
{
    $nlen = fread($conn, 4);       // read 4-Byte length of answer
    $bytes = RRI_Unpack($nlen);   // convert bytes to local order
    echo "\nNumber of expected bytes: " . $bytes;
    $answer = "";
    $a = fread($conn, $bytes);  // read answer
    $answer .= $a;
    $gelesen = strlen($a);
    echo "\nNumber of received bytes: " . $gelesen;
    return $answer;
}

function RRI_Unpack($len)
{
    $unpack = unpack("N", $len); // unpack binary string into Long (4 bytes)
    return $unpack[1];
}

function handle_RRI_orders($conn, $orders)
{
    $splitted_orders = explode("=-=\n", $orders);

    foreach ($splitted_orders as $single_order) {
        echo "\nOrder:\n" . $single_order;
        RRI_Send($conn, $single_order);
        $answer = RRI_Read($conn);
        echo "\nAnswer:\n" . $answer;
    }
    return $answer;
}
