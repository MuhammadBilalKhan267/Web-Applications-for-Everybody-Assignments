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

    if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
        if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1){
            $_SESSION['error'] = "<p style = 'color:red'>All fields are Required</p>";
            header('Location: add.php');
            return;
        }
        else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
            $_SESSION['error'] = "<p style = 'color:red'>Mileage and year must be numeric</p>";
            header('Location: add.php');
            return;
        }
        else {
            $_SESSION['success'] = "<p style = 'color:green'>Record added.</p>";
            $stmt = $pdo->prepare('INSERT INTO autos
            (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
            $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'])
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

        <h1>Tracking autos for <?php echo ($_SESSION['name'])?></h1>
        <?php echo (isset($_SESSION['error']) ? $_SESSION['error'] : '');
        unset($_SESSION['error']);
        ?>
        <h1>Autombiles</h1>
        <form method="post">
            <p>Make:
            <input type="text" name="make" size="40"/></p>
            <p>Model:
            <input type="text" name="model" size="40"/></p>
            <p>Year:
            <input type="text" name="year" size="10"/></p>
            <p>Mileage:
            <input type="text" name="mileage" size="10"/></p>
            <input type="submit" name='add' value="Add">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    
    </body>
</html>