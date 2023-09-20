<?php
  require_once "pdo.php";
function validatePos($header) {
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_POST['year'.$i]) ) continue;
      if ( ! isset($_POST['desc'.$i]) ) continue;
      global $year;
      global $desc;
      $year = $_POST['year'.$i];
      $desc = $_POST['desc'.$i];
      if ( strlen($year) == 0 || strlen($desc) == 0 ) {
        $_SESSION['error'] = "<p style = 'color:red;'>All fields are required</p>";
        header($header);
        exit;    
      }  
      if ( ! is_numeric($year) ) { 
        $_SESSION['error'] = "<p style = 'color:red;'>Position year must be numeric</p>";
        header($header);
        exit;
      }
    }
    return true;
  }
  
function validateEdu($header) {
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['edu_year'.$i]) ) continue;
    if ( ! isset($_POST['edu_school'.$i]) ) continue;
    global $edu_year;
    global $edu_school;
    $edu_year = $_POST['edu_year'.$i];
    $edu_school = $_POST['edu_school'.$i];
    if ( strlen($edu_year) == 0 || strlen($edu_school) == 0 ) {
      $_SESSION['error'] = "<p style = 'color:red;'>All fields are required</p>";
      header($header);
      exit;    
    }  
    if ( ! is_numeric($edu_year) ) { 
      $_SESSION['error'] = "<p style = 'color:red;'>Education year must be numeric</p>";
      header($header);
      exit;
    }
  }
  return true;
}
  function addtoDB() {
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_POST['year'.$i]) ) continue;
      if ( ! isset($_POST['desc'.$i]) ) continue;
      global $pdo;
      global $profile_id;
      global $year;
      global $desc;
      $year = $_POST['year'.$i];
      $desc = $_POST['desc'.$i];
      $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :desc)');
            $stmt->execute(array(
            ':pid' => $profile_id,
            ':rank' => $i,
            ':year' => $year,
            ':desc' => $desc)
            );
    }
  }
  function addEdutoDB() {
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_POST['edu_year'.$i]) ) continue;
      if ( ! isset($_POST['edu_school'.$i]) ) continue;
      global $pdo;
      global $profile_id;
      global $edu_year;
      global $edu_school;
      $edu_year = $_POST['edu_year'.$i];
      $edu_school = $_POST['edu_school'.$i];

      $stmt2 = $pdo ->prepare("SELECT * FROM Institution WHERE name = :name");
      $stmt2 -> execute(array(
        ":name" => $edu_school
      ));
      if ($row = $stmt2->fetch(PDO::FETCH_ASSOC) ){
        $edu_id = $row['institution_id'];
      }
      else {
        $stmt2 = $pdo->prepare('INSERT INTO Institution (name) VALUES (:name);');
            $stmt2->execute(array(
            ':name' => $edu_school
            )
            );
            $edu_id = $pdo->lastInsertId();
      }
      
      $stmt = $pdo->prepare('INSERT INTO Education (profile_id, institution_id, rank, year) VALUES ( :pid, :instid, :rank, :year)');
            $stmt->execute(array(
            ':pid' => $profile_id,
            ':instid' => $edu_id,
            ':rank' => $i,
            ':year' => $edu_year
            )
            );
    }
  }
  function retrievepos(){
    global $pdo;
    global $msg;
    $stmt2 = $pdo ->prepare("SELECT * FROM Position WHERE profile_id = :profile_id");
    $stmt2 -> execute(array(
        ":profile_id" => $_GET['profile_id']
    ));
    global $j;
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
      $msg .= <<<HTML
    <div id="position{$j}">
        <p>Year: <input type="text" name="year{$j}" value="{$row['year']}">
        <input type="button" value="-" onclick="\$('#position{$j}').remove();return false;"></p>
        <textarea name="desc{$j}" rows="8" cols="80">{$row['description']}</textarea>
    </div>
HTML;

      $j++;
  }
  }
  function retrieveEdu(){
    global $pdo;
    global $edu_msg;
    $stmt2 = $pdo ->prepare("SELECT * FROM education JOIN institution WHERE profile_id = :profile_id AND education.institution_id = institution.institution_id");
    $stmt2 -> execute(array(
        ":profile_id" => $_GET['profile_id']
    ));
    global $edu_j;
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
    
      $edu_msg .= <<<HTML
    <div id="education{$edu_j}">
        <p>Year: <input type="text" name="edu_year{$edu_j}" value="{$row['year']}">
        <input type="button" value="-" onclick="\$('#education{$edu_j}').remove();return false;"></p>
        <p>School: <input type="text" size="80" name="edu_school{$edu_j}" value="{$row['name']}" class="school" ></p>
    </div>
HTML;

      $edu_j++;
  }
  }
?>


