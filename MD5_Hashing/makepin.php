<!DOCTYPE html>
<html>
<head>
    <title>Muhammad Bilal Khan PIN Code</title>
</head>
<body style="font-family: sans-serif">
    <h1>MD5 PIN Maker</h1>
    <span></span>
    <form>
        <input type="text" name="pin" value=""/>
        <input type="submit" value="Compute MD5 for PIN"/>
    </form>

    <pre><?php
    if (isset($_GET['pin'])) {
        $pin = $_GET['pin'];
        if (strlen($pin) !== 4) {
            echo "<span style='color: red;'>PIN must be exactly 4 digits</span>\n";
        }
        else if (!is_numeric($pin)){
            echo "<span style='color: red;'>PIN must be Numeric</span>\n";
        }
        else {
            $check = hash('md5', $pin);
            echo "<span>MD5 Value: $check</span>\n";
        }
    }
    ?>
    </pre>

    <ul>
        <li><a href="makepin.php">Reset this page</a></li>
        <li><a href="crack.php">Back to Cracking</a></li>
    </ul>
</body>
</html>
