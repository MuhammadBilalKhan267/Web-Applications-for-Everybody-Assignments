<!DOCTYPE html>
<html>
<head>
    <title>Muhammad Bilal Khan MD5 Enoder</title>
</head>
<body style="font-family: sans-serif">
    <h1>MD5 Maker</h1>
    <form>
        <input type="text" name="pin" value=""/>
        <input type="submit" value="Compute MD5 for PIN"/>
    </form>

    <pre><?php
    if (isset($_GET['pin'])) {
        $pin = $_GET['pin'];
        $check = hash('md5', $pin);
        echo "MD5 Value: $check\n";
    }
    ?>
    </pre>

    <ul>
        <li><a href="md5.php">Reset this page</a></li>
        <li><a href="crack.php">Back to Cracking</a></li>
    </ul>
</body>
</html>
