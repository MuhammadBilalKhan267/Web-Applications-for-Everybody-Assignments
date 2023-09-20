<!DOCTYPE html>
<html>
<head>
    <title>Muhammad Bilal Khan - MD5 Cracker</title>
</head>
<body>
    <h1>MD5 cracker</h1>
    <p>This application takes an MD5 hash
    of a four digit pin and checks upto 10,000
    possible four digit PINs to determine the PIN.</p>
    <form>
        <input type="text" name="md5" size="40">
        <input type="submit" value="Crack"><p>
    </form>
    <pre><?php
    $time_before = microtime(true);
    if (isset($_GET['md5'])) {
        $md5 = $_GET['md5'];
        $cracked = false;

        for ($i = 0; $i <= 9999; $i++) {
            
            if ($i < 10) {
                $i = '000'.$i;
            } 
            else if ($i < 100) {
                $i = '00'.$i;
            }
            else if ($i<1000){
                $i = '0'.$i;
            }
            $check = hash('md5', $i);
            if ($i<15){
                echo "$check $i\n";
            }
                if ($check === $md5) {
                    $cracked = true;
                    $i = ($i+1).'';
                    break;
                }
        }
        
        $time_after = microtime(true);
        echo "Total Checks: $i\n";
        echo "Elapsed Time: ", $time_after-$time_before, "\n";
        if ($cracked){
            echo "<h3>PIN:", ($i-1).'', "</h3>";
        }
        if (!$cracked) {
            echo "<h3>PIN: Not Found!<h3>";
        }
    }
    ?>
    </pre>
    <select><option >tgrtgrt</option>
    <option selected>tgrtgyhtyrhrt</option></select>
    <ul>
    <li><a href="crack.php">Reset this page</a></li>
    <li><a href="makepin.php">Make an MD5 PIN</a></li>
    <li><a href="md5.php">MD5 Encoder</a></li>

</ul>
</body>
</html>

</body>
</html>

