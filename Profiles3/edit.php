<?php 
    session_start();
    require_once "pdo.php";
    require_once "validatepos.php";
    $msg = false;
    $edu_msg = false;
    $j = 1;
    $edu_j = 1;
    $year;
    $desc;
    $edu_year;
    $edu_school;
    if ( !isset($_SESSION['name']) || !isset($_SESSION['user_id']) ) {
    die('ACCESS DENIED');
    }
            
    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }
    if (!isset($_GET['profile_id'])){
        $_SESSION['error'] = "<p style='color: red;'> Bad value for profile_id</p>";
        header ("Location: index.php");
        return;
    }
    $stmt2 = $pdo ->prepare("SELECT * FROM profile WHERE profile_id = :profile_id");
    $stmt2 -> execute(array(
        ":profile_id" => $_GET['profile_id']
    ));
    if (!($row = $stmt2->fetch(PDO::FETCH_ASSOC))){
        $_SESSION['error'] = "<p style='color: red;'> Bad value for profile_id</p>";
        header ("Location: index.php");
        return;
    }
    retrieveEdu();
    retrievepos();
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])){
        if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
            $_SESSION['error'] = "<p style = 'color:red'>All fields are Required</p>";
            header('Location: edit.php?profile_id='.$_POST['profile_id']);
            return;
        }
        else if (strpos($_POST['email'], "@") === false){
            $_SESSION['error'] = "<p style = 'color:red;'>Email must contain @</p>";
            header("Location: edit.php?profile_id=".$_POST['profile_id']);
            return;
        }
        else if (validatePos('Location: edit.php?profile_id='.$_POST['profile_id']) && validateEdu('Location: edit.php?profile_id='.$_POST['profile_id'])){
            $_SESSION['success'] = "<p style = 'color:green;'>Profile Updated.</p>";
            $stmt = $pdo->prepare('UPDATE profile SET 
            user_id = :uid, first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su WHERE profile_id = :profile_id');

            $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'],
                ':profile_id' => $_POST['profile_id'])
            );
            $profile_id = $_POST['profile_id'];
            $stmt = $pdo->prepare('DELETE FROM Position WHERE profile_id=:pid');
            $stmt->execute(array( ':pid' => $profile_id));
            $stmt = $pdo->prepare('DELETE FROM Education WHERE profile_id=:pid');
            $stmt->execute(array( ':pid' => $profile_id));
            addEdutoDB();
            addtoDB();
            header('Location: index.php');
            return;
        }
    }
?>
<html>
    <head>
        <title>Muhammad Bilal Khan - Resume Registry</title>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"> 
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
        <script src="addpos.js"></script>
        <script>$(document).ready(function(){$('.school').autocomplete({
            source: 'school.php'
        });});rank = "<?= $j?>";rank_edu = "<?= $edu_j?>";</script>
    </head>
    
    <body>

        <h1>Editing Profiles for <?php echo ($_SESSION['name'])?></h1>
        <?php echo (isset($_SESSION['error']) ? $_SESSION['error'] : '');
        unset($_SESSION['error']);
        ?>
        <form method="post">
        <p>First Name:
        <input type="text" name="first_name" value = "<?= $row['first_name']?>" size="60"/></p>
        <p>Last Name:
        <input type="text" name="last_name" value = "<?= $row['last_name']?>" size="60"/></p>
        <p>Email:
        <input type="text" name="email" value = "<?= $row['email']?>" size="30"/></p>
        <p>Headline:<br/>
        <input type="text" name="headline" value = "<?= $row['headline']?>" size="80"/></p>
        <p>Summary:<br/>
        <textarea name="summary" rows="8" cols="80">
        <?= $row['summary']?>
        </textarea>
        <p>
        <p>Education: <button onclick = "addedu();$('.school').autocomplete({
            source: 'school.php'
        });return false;">+</button></p>
        <div id  = "education"><?= $edu_msg?></div>
        <p>Position: <button onclick = "addpos();return false;">+</button></p>
        <div id  = "positions"><?= $msg?></div>
        
        <input type="hidden" name = "profile_id" <?php echo ("value=\"".$_GET['profile_id']."\"")?>>
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
        </form>
    
    </body>
</html>