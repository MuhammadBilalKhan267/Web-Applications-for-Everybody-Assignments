<?php 
    session_start();
    require_once "pdo.php";
    require_once "validatepos.php";
    $year;
    $desc;
    $edu_year;
    $edu_school;
    if ( !isset($_SESSION['name']) || !isset($_SESSION['user_id'])) {
    die('ACCESS DENIED');
    }
            
    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }

    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])){
        if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
            $_SESSION['error'] = "<p style = 'color:red'>All fields are Required</p>";
            header('Location: add.php');
            return;
        }
        else if (strpos($_POST['email'], "@") === false){
            $_SESSION['error'] = "<p style = 'color:red;'>Email must contain @</p>";
            header("Location: add.php");
            return;
        }
        else if (validatePos('Location: add.php') && validateEdu('Location: add.php')) {
            $_SESSION['success'] = "<p style = 'color:green'>Profile added.</p>";
            $stmt = $pdo->prepare('INSERT INTO Profile
                (user_id, first_name, last_name, email, headline, summary)
                VALUES ( :uid, :fn, :ln, :em, :he, :su)');

            $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'])
            );
            $profile_id = $pdo->lastInsertId();
            addtoDB();
            addEdutoDB();
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
        <script>rank = 1;rank_edu = 1;</script>
        
    </head>
    
    <body>

        <h1>Adding Profiles for <?php echo ($_SESSION['name'])?></h1>
        <?php echo (isset($_SESSION['error']) ? $_SESSION['error'] : '');
        unset($_SESSION['error']);
        ?>
        <form method="post">
        <p>First Name:
        <input type="text" name="first_name" size="60"/></p>
        <p>Last Name:
        <input type="text" name="last_name" size="60"/></p>
        <p>Email:
        <input type="text" name="email" size="30"/></p>
        <p>Headline:<br/>
        <input type="text" name="headline" size="80"/></p>
        <p>Summary:<br/>
        <textarea name="summary" rows="8" cols="80">
        </textarea>
        <p>
        <p>Education: <button onclick = "addedu();$('.school').autocomplete({
            source: 'school.php'
        });return false;">+</button></p>
        <div id  = "education"></div>
        <p>Position: <button onclick = "addpos();return false;">+</button></p>
        <div id  = "positions"></div>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>