<?php
// Handle POST request, if not set, set as empty string or 0.
$name  = isset($_POST['name']) ? $_POST['name'] : "";

$apples  = isset($_POST['apples']) ? $_POST['apples'] : 0;
$oranges = isset($_POST['oranges']) ? $_POST['oranges'] : 0;
$bananas = isset($_POST['bananas']) ? $_POST['bananas'] : 0;

$payment = isset($_POST['payment']) ? $_POST['payment'] : "";

// opens order.txt
$filename = "order.txt";
$handle = fopen($filename, "c+"); // c+: read & write; create if not exist
$contents = "";

// initialize quantity
$old_apples = $old_oranges = $old_bananas = 0;

if (file_exists($filename)) {
    // read from file until end of file
    $contents = fread($handle, filesize($filename) + 1);
    preg_match("/Total number of apples: (\d+)/", $contents, $pm_apple);
    preg_match("/Total number of oranges: (\d+)/", $contents, $pm_orange);
    preg_match("/Total number of bananas: (\d+)/", $contents, $pm_banana);

    // get integer value
    $old_apples = intval($pm_apple[1]);
    $old_oranges = intval($pm_orange[1]);
    $old_bananas = intval($pm_banana[1]);

}
// update value
$new_apples = $old_apples + $apples;
$new_oranges = $old_oranges + $oranges;
$new_bananas = $old_bananas + $bananas;

// new string to print
$msg = "Total number of apples: $new_apples\n";
$msg .= "Total number of oranges: $new_oranges\n";
$msg .= "Total number of bananas: $new_bananas\n";

// seek to head of file, cause file buffer has reached end of file
fseek($handle, 0);
fwrite($handle, $msg);

// don't forget to close the file
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
                        <td colspan="2">Name: <?php echo $name; ?></td>
                    </tr>
                    <tr>
                        <td>Apples<br>&emsp; <?php echo $apples; ?>&times; &cent;69</td>
                        <td style="vertical-align: top;">$<?php echo $apples * .69; ?></td>
                    </tr>
                    <tr>
                        <td>Oranges<br>&emsp; <?php echo $oranges; ?> &times; &cent;59</td>
                        <td style="vertical-align: top;">$<?php echo $oranges * .59; ?></td>
                    </tr>
                    <tr>
                        <td>Bananas<br>&emsp; <?php echo $bananas; ?> &times; &cent;39</td>
                        <td style="vertical-align: top;">$<?php echo $bananas * .39; ?></td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td style="border-top: 1px solid #000;">$<?php echo $apples * .69 + $oranges * .59 + $bananas * .39; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Payment method: <?php echo $payment; ?>
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
