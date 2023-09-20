<?php 
    session_start();
    require_once "pdo.php";
    
    if ( !isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
    }
            
    if (!isset($_GET['autos_id'])){
        $_SESSION['error'] = "<p style='color: red'> Bad value for autos_id</p>";
        header ("Location: index.php");
        return;
    }
    $stmt2 = $pdo ->prepare("SELECT make, model, year, mileage FROM autos WHERE autos_id = :autos_id");
    $stmt2 -> execute(array(
        ":autos_id" => $_GET['autos_id']
    ));
    if (!($row = $stmt2->fetch(PDO::FETCH_ASSOC))){
        $_SESSION['error'] = "<p style='color: red'> Bad value for autos_id</p>";
        header ("Location: index.php");
        return;
    }
    if (isset($_POST['autos_id']) && isset($_POST['delete'])) {
            $_SESSION['success'] = "<p style = 'color:green'>Record deleted</p>";
            $stmt = $pdo->prepare('DELETE FROM autos  WHERE autos_id = :autos_id');
            $stmt->execute(array(
                ':autos_id' => $_POST['autos_id'])
            );
            header('Location: index.php');
            return;
        }
?>
<html>
    <head>
        <title>Muhammad Bilal Khan - Autos Database</title>
    </head>
    
    <body>

        <?php echo (isset($_SESSION['error']) ? $_SESSION['error'] : '');
        unset($_SESSION['error']);
        ?>
        <p>Confirm: Deleting <?= $row['make']?></p>
        <form method="post">
            <input type="hidden" name="autos_id" value="<?= $_GET['autos_id']?>"> 
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>
        </form>
 
    
    </body>
</html>