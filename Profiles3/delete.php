<?php 
    session_start();
    require_once "pdo.php";
    
    if ( !isset($_SESSION['name']) || !isset($_SESSION['user_id']) ) {
    die('ACCESS DENIED');
    }
            
    if (!isset($_GET['profile_id'])){
        $_SESSION['error'] = "<p style='color: red'> Bad value for profile_id</p>";
        header ("Location: index.php");
        return;
    }
    $stmt2 = $pdo ->prepare("SELECT * FROM profile WHERE profile_id = :profile_id");
    $stmt2 -> execute(array(
        ":profile_id" => $_GET['profile_id']
    ));
    if (!($row = $stmt2->fetch(PDO::FETCH_ASSOC))){
        $_SESSION['error'] = "<p style='color: red'> Bad value for profile_id</p>";
        header ("Location: index.php");
        return;
    }
    if (isset($_POST['profile_id']) && isset($_POST['delete'])) {
            $_SESSION['success'] = "<p style = 'color:green'>Profile deleted</p>";
            $stmt = $pdo->prepare('DELETE FROM profile  WHERE profile_id = :profile_id');
            $stmt->execute(array(
                ':profile_id' => $_POST['profile_id'])
            );
            header('Location: index.php');
            return;
        }
?>
<html>
    <head>
        <title>Muhammad Bilal Khan - Resume Registry</title>
    </head>
    
    <body>

        <?php echo (isset($_SESSION['error']) ? $_SESSION['error'] : '');
        unset($_SESSION['error']);
        ?>
        <h1>Deleting Profile</h1>
        <p>First Name: <?= $row['first_name']?></p>
        <p>Last Name: <?= $row['last_name']?></p>
        <form method="post">
            <input type="hidden" name="profile_id" value="<?= $_GET['profile_id']?>"> 
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>
        </form>
 
    
    </body>
</html>