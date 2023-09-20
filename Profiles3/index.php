<!DOCTYPE html>
<?php 
    session_start();
    require_once "pdo.php";
    $msg = false;
    $rows = false;
    $msg2 = false;
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])){
        $msg = "<p>
        <a href=\"login.php\">Please log in</a>
        </p>
        ";
        $stmt2 = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM profile");
        if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            $rows = "<table> <tr><th>Name</th><th><b>Headline</b></th></tr>";
            $rows .= "<tr><td><a href = \"view.php?profile_id=".$row['profile_id']."\">".htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a></td><td>".htmlentities($row['headline'])."</td></tr>";
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $rows .= "<tr><td><a href = \"view.php?profile_id=".$row['profile_id']."\">".htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a></td><td>".htmlentities($row['headline'])."</td></tr>";
            }
            $rows .= "</table>";
        }
        else {
            $rows = false;
        }
    }
    else {
        if (isset($_SESSION['success'])){
        $msg2 = $_SESSION['success'];
        unset($_SESSION['success']);
        }
        else if (isset($_SESSION['error'])){
            $msg2 = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        $stmt2 = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM profile");
        if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            $rows = "<table> <tr><th>Name</th><th><b>Headline</b></th><th>Action</th></tr>";
            $rows .= "<tr><td><a href = \"view.php?profile_id=".$row['profile_id']."\">".htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a></td><td>".htmlentities($row['headline'])."</td><td><a href=\"edit.php?profile_id=".$row['profile_id']."\">Edit</a>/<a href=\"delete.php?profile_id=".$row['profile_id']."\">Delete</a></td></tr>";
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $rows .= "<tr><td><a href = \"view.php?profile_id=".$row['profile_id']."\">".htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a></td><td>".htmlentities($row['headline'])."</td><td><a href=\"edit.php?profile_id=".$row['profile_id']."\">Edit</a>/<a href=\"delete.php?profile_id=".$row['profile_id']."\">Delete</a></td></tr>";
            }
            $rows .= "</table>";
        }
        else {
            $rows = false;
        }
        $rows .= "<p><a href=\"add.php\">Add New Entry</a></p>";
        $msg = "<p><a href=\"logout.php\">Logout</a></p>";
    }

?>
<html>
    <head>
        <title>Muhammad Bilal Khan - Resume Registry</title>
        <link rel = "stylesheet" type = "text/css" href = "table.css"/>
    </head>

    <body>
        <div class="container">
        <h1>Muhammad Bilal Khan - Resume Registry</h1>
        <?= $msg2 ?>
        <?= $msg ?>
        <?= $rows ?>
        
        </div>
    </body>
</html>