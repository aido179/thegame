<?php
  //connect to DB
  include_once 'connect.php';
  connectToRelativeDB();


  $original_email = $_POST['email'];
  $clean_email = filter_var($original_email,FILTER_SANITIZE_EMAIL);
  if ($original_email == $clean_email && filter_var($original_email,FILTER_VALIDATE_EMAIL)){
    // now we know the original email was safe to insert.
    $sql = "SELECT * FROM theGame WHERE email = '{$clean_email}'";
    $data = mysql_query($sql) or die("Error - query 1 failed: {$sql}");
    $rowCount = mysql_num_rows($data);
    if($rowCount>0){
      $info = mysql_fetch_array($data);
      $clean_timestamp = filter_var($_POST['timestamp'],FILTER_SANITIZE_NUMBER_INT);
      $sql = "UPDATE theGame SET timestamp = '{$clean_timestamp}' WHERE email = {$clean_email}";
      mysql_query($sql) or die("Error - query 2 failed: {$sql}");
      echo $info['timestamp'];
    }else{
      echo "Not found";
    }


  }else{
    echo "Error - Email invalid.";
  }


?>
