<?php
    require_once "pdo.php";
    $pos = false;
    $edu = false;
    $stmt2 = $pdo ->prepare("SELECT * FROM profile WHERE profile_id = :profile_id");
    $stmt2->execute(array( ':profile_id' => $_GET['profile_id']));
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $stmt2 = $pdo ->prepare("SELECT * FROM position WHERE profile_id = :profile_id");
    $stmt2->execute(array( ':profile_id' => $_GET['profile_id']));
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        $pos .= "<li>".$row2['year'].": ".$row2['description']."</li>";
    }
    $stmt2 = $pdo ->prepare("SELECT * FROM education JOIN institution WHERE profile_id = :profile_id AND education.institution_id = institution.institution_id");
    $stmt2->execute(array( ':profile_id' => $_GET['profile_id']));
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
        
        $edu .= "<li>".$row2['year'].": ".$row2['name']."</li>";
    }
?>

<html>
    <head>
        <title>Muhammad Bilal Khan - Resume Registry</title>
        <link type = "text/css" rel= "stylesheet" href = "table.css"/>
    </head>
    
    <body>

        <h1>Profile Information</h1>
        
        <p>First Name:
        <?= htmlentities($row['first_name'])?>
        </p>
        <p>Last Name:
        <?= htmlentities($row['last_name'])?></p>
        <p>Email:
        <?= htmlentities($row['email'])?></p>
        <p>Headline:<br/>
        <?= htmlentities($row['headline'])?></p>
        <p>Summary:<br/>
        <?= htmlentities($row['summary'])?><p>
        </p>
        <p>Position<br/>
        <?php
        if ($pos){
            echo "<ul>".$pos."</ul>";
        }
        ?></p>
        <p>Education<br/>
        <?php
        if ($edu){
            echo "<ul>".$edu."</ul>";
        }
        ?></p>
        <a href="index.php">Done</a>
    </body>
</html>