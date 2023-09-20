<?php 
    session_start();
    require_once ("pdo.php");
    if ( !isset($_SESSION['name']) ) {
    die('Not logged in');
    }
    
?>

<html>
    <head>
        <title>Muhammad Bilal Khan - Autos Database</title>
        <link type = "text/css" rel= "stylesheet" href = "table.css"/>
    </head>
    
    <body>

        <h1>Tracking autos for <?php echo ($_SESSION['name'])?></h1>
        <?php echo (isset($_SESSION['success']) ? $_SESSION['success'] : '');
        unset($_SESSION['success']);
        ?>
        <h1>Autombiles</h1>
    <table>
        <tr><th>Year</th><th><b>Make</b></th><th>Mileage</th></tr>
        <?php
        $stmt2 = $pdo ->query("SELECT make, year, mileage FROM autos");
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            echo "<tr><td>".htmlentities($row['year'])."</td><td><b>".htmlentities($row['make'])."</b></td><td>".htmlentities($row['mileage'])."</td></tr>";
        }
        ?>
    </table>
        <p>
        <a href="add.php">Add New</a> |
        <a href="logout.php">Logout</a>
        </p>
    </body>
</html>