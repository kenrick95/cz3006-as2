<?php
/*
2)	Write a server-side PHP program that receives the user’s order when the
Submit button on the above HTML document is clicked. On receiving the order,
 the server-side PHP program computes the total cost of the user’s order and
 returns an HTML document to the user as a receipt. The receipt should specify
 the user’s name, what are ordered and the payment method in the form of a
 table. In addition, the server-side PHP program must also update a file named
 “order.txt” stored on the web server to reflect the new order. The file
 records the total numbers of apples, oranges and bananas ordered by all
 users so far in the following format:

Total number of apples: 12
Total number of oranges: 23
Total number of bananas: 35

*/
$name  = isset($_POST['name']) ? $_POST['name'] : "";

$apples  = isset($_POST['apples']) ? $_POST['apples'] : 0;
$oranges = isset($_POST['oranges']) ? $_POST['oranges'] : 0;
$bananas = isset($_POST['bananas']) ? $_POST['bananas'] : 0;

$payment = isset($_POST['payment']) ? $_POST['payment'] : "";

$filename = "order.txt";
$handle = fopen($filename, "c+");
$contents = "";

$old_apples = $old_oranges = $old_bananas = 0;

if (file_exists($filename)) {
    $contents = fread($handle, filesize($filename) + 1);
    preg_match("/Total number of apples: (\d+)/", $contents, $pm_apple);
    preg_match("/Total number of oranges: (\d+)/", $contents, $pm_orange);
    preg_match("/Total number of bananas: (\d+)/", $contents, $pm_banana);

    $old_apples = intval($pm_apple[1]);
    $old_oranges = intval($pm_orange[1]);
    $old_bananas = intval($pm_banana[1]);

}
$new_apples = $old_apples + $apples;
$new_oranges = $old_oranges + $oranges;
$new_bananas = $old_bananas + $bananas;

$msg = "Total number of apples: $new_apples\n";
$msg .= "Total number of oranges: $new_oranges\n";
$msg .= "Total number of bananas: $new_bananas\n";

fseek($handle, 0);
fwrite($handle, $msg);

fclose($handle);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CZ3006 Assignment 2</title>
    </head>
    <body>
            <h1>Receipt</h1>
            <table>
                <tbody>
                    <tr>
                        <td colspan="2">Name: <?= $name ?></td>
                    </tr>
                    <tr>
                        <td>Apples<br>&emsp; <?= $apples ?>&times; &cent;69</td>
                        <td style="vertical-align: top;">$<?= $apples * .69 ?></td>
                    </tr>
                    <tr>
                        <td>Oranges<br>&emsp; <?= $oranges ?> &times; &cent;59</td>
                        <td style="vertical-align: top;">$<?= $oranges * .59 ?></td>
                    </tr>
                    <tr>
                        <td>Bananas<br>&emsp; <?= $bananas ?> &times; &cent;39</td>
                        <td style="vertical-align: top;">$<?= $bananas * .39 ?></td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td style="border-top: 1px solid #000;">$<?= $apples * .69 + $oranges * .59 + $bananas * .39 ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Payment method: <?= $payment ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Thank you for shopping with us.
                        </td>
                    </tr>
                </tbody>
            </table>
    </body>
</html>
