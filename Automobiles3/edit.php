<?php 
    session_start();
    require_once "pdo.php";
    
    if ( !isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
    }
            
    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }
    if (!isset($_GET['autos_id'])){
        $_SESSION['error'] = "<p style='color: red;'> Bad value for autos_id</p>";
        header ("Location: index.php");
        return;
    }
    $stmt2 = $pdo ->prepare("SELECT make, model, year, mileage FROM autos WHERE autos_id = :autos_id");
    $stmt2 -> execute(array(
        ":autos_id" => $_GET['autos_id']
    ));
    if (!($row = $stmt2->fetch(PDO::FETCH_ASSOC))){
        $_SESSION['error'] = "<p style='color: red;'> Bad value for autos_id</p>";
        header ("Location: index.php");
        return;
    }
    if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id'])){
        if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
            $_SESSION['error'] = "<p style = 'color:red'>All fields are Required</p>";
            header('Location: edit.php?autos_id='.$_POST['autos_id']);
            return;
        }
        else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
            $_SESSION['error'] = "<p style = 'color:red'>Mileage and year must be numeric</p>";
            header('Location: edit.php?autos_id='.$_POST['autos_id']);
            return;
        }
        else {
            $_SESSION['success'] = "<p style = 'color:green'>Record edited</p>";
            $stmt = $pdo->prepare('UPDATE autos SET
            make = :mk, model = :md, year = :yr, mileage = :mi WHERE autos_id = :autos_id');
            $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'],
                ':autos_id' => $_POST['autos_id'])
            );
            header('Location: index.php');
            return;
        }
    }
?>
<html>
    <head>
        <title>Muhammad Bilal Khan - Autos Database</title>
    </head>
    
    <body>

        <h1>Editing Autombiles</h1>
        <?php echo (isset($_SESSION['error']) ? $_SESSION['error'] : '');
        unset($_SESSION['error']);
        ?>
        
        <form method="post">
            <p>Make:
            <input type="text" name="make" value = "<?= $row['make']?>" size="40"/></p>
            <p>Model:
            <input type="text" name="model" value = "<?= $row['model']?>" size="40"/></p>
            <p>Year:
            <input type="text" name="year" value = "<?= $row['year']?>" size="10"/></p>
            <p>Mileage:
            <input type="text" name="mileage" value = "<?= $row['mileage']?>" size="10"/></p>
            <input type="hidden" name="autos_id" value = "<?= $_GET['autos_id']?>">
            <input type="submit" name='edit' value="Save">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    
    </body>
</html>