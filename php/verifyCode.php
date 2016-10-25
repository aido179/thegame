<?php
  //connect to DB
  include_once 'connect.php';

  $original_code = $_POST['code'];
  $clean_code = filter_var($_POST['code'],FILTER_SANITIZE_NUMBER_INT);
  $original_email = $_POST['email'];
  $original_email = str_replace(' ', '', $original_email);
  $clean_email = filter_var($original_email,FILTER_SANITIZE_EMAIL);

  if ($original_code == $clean_code && $clean_code < 10000 && $clean_code > 999){
    if ($original_email == $clean_email && filter_var($original_email,FILTER_VALIDATE_EMAIL)){
      // now we know the original email was safe to insert.
      $sql = "SELECT * FROM theGame WHERE email = '{$clean_email}'";
      $data = mysql_query($sql) or die('{"status":"Error","message":"query 1 failed"}');
      $rowCount = mysql_num_rows($data);
      if($rowCount>0){
        $info = mysql_fetch_array($data);
        if($clean_code == $info['code']){
          // verified!
          $clean_timestamp = filter_var($_POST['timestamp'],FILTER_SANITIZE_NUMBER_INT);
          $sql = "UPDATE theGame SET timestamp = '{$clean_timestamp}' WHERE email = '{$clean_email}'";
          mysql_query($sql) or die('{"status":"Error","message":"query 2 failed"}');
          $t = $info['timestamp'];
          echo '{"status":"Success","timestamp":"'.$t.'"}';
        }else{
          echo '{"status":"Error","message":"Code not verified."}';
        }
      }else{
        //Email not found, so store it fo future use.
        $clean_timestamp = filter_var($_POST['timestamp'],FILTER_SANITIZE_NUMBER_INT);
        $sql = "INSERT INTO theGame (email, timestamp) VALUES ('{$clean_email}', '{$clean_timestamp}')";
        $data = mysql_query($sql) or die('{"status":"Error","message":"query 3 failed"}');
        echo '{"status":"Error","message":"The email was not found."}';
      }
    }else{
      echo '{"status":"Error","message":"Email invalid."}';
    }
  }else{
    echo '{"status":"Error","message":"Code invalid."}';
  }
?>
