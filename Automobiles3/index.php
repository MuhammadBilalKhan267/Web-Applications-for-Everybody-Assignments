<!DOCTYPE html>
<?php 
    session_start();
    require_once "pdo.php";
    $msg = false;
    $rows = false;
    if (!isset($_SESSION['name'])){
        $msg = "<p>
        <a href=\"login.php\">Please log in</a>
        </p>
        <p>
        Attempt to 
        <a href=\"add.php\">add data</a> without logging in - it will fail with an error message.
        </p>";
        
    }
    else {
        if (isset($_SESSION['success'])){
        $msg = $_SESSION['success'];
        unset($_SESSION['success']);
        }
        else if (isset($_SESSION['error'])){
            $msg = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        $stmt2 = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
        if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            $rows = "<table> <tr><th>Make</th><th><b>Model</b></th><th>Year</th><th>Mileage</th><th>Action</th></tr>";
            $rows .= "<tr><td><b>".htmlentities($row['make'])."</b></td><td>".htmlentities($row['model'])."</td><td>".htmlentities($row['year'])."</td><td>".htmlentities($row['mileage'])."</td><td><a href=\"edit.php?autos_id=".$row['autos_id']."\">Edit</a>/<a href=\"delete.php?autos_id=".$row['autos_id']."\">Delete</a></td></tr>";
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $rows .= "<tr><td><b>".htmlentities($row['make'])."</b></td><td>".htmlentities($row['model'])."</td><td>".htmlentities($row['year'])."</td><td>".htmlentities($row['mileage'])."</td><td><a href=\"edit.php?autos_id=".$row['autos_id']."\">Edit</a>/<a href=\"delete.php?autos_id=".$row['autos_id']."\">Delete</a></td></tr>";
            }
            $rows .= "</table>";
        }
        else {
            $rows = "<p>No rows found</p>";
        }
        $rows .= "<p><a href=\"add.php\">Add New Entry</a></p>
        <p><a href=\"logout.php\">Logout</a></p>";
    }

?>
<html>
    <head>
        <title>Muhammad Bilal Khan - Autos Database</title>
    </head>

    <body>
        <div class="container">
        <h1>Welcome to Autos Database</h1>
        <?= $msg ?>
        <?= $rows ?>
        
        </div>
    </body>
</html>