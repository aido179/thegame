<?php
  require '../vendor/autoload.php';
  //connect to DB
  include_once 'connect.php';

  $original_email = $_POST['email'];
  $original_email = str_replace(' ', '', $original_email);
  $clean_email = filter_var($original_email,FILTER_SANITIZE_EMAIL);
  if ($original_email == $clean_email && filter_var($original_email,FILTER_VALIDATE_EMAIL)){
    // now we know the original email was safe to use.
    $sql = "SELECT * FROM theGame WHERE email = '{$clean_email}'";
    $data = mysql_query($sql) or die('{"status":"Error","message":"query 4 failed:'.$sql.'"}');
    $rowCount = mysql_num_rows($data);
    if($rowCount>0){
      $sendgrid = new SendGrid("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");
      $email    = new SendGrid\Email();
      $randomNumber = mt_rand(1000, 9999);
      $sql = "UPDATE theGame SET code = '{$randomNumber}' WHERE email = '{$clean_email}'";
      mysql_query($sql) or die('{"status":"Error","message":"query 5 failed"}');
      $email->addTo($clean_email)
          ->setFrom("bot@game.poo.today")
          ->setSubject("{$randomNumber} : Your verification code")
          ->setHtml("Your verification code is: {$randomNumber}");
      $sendgrid->send($email);
      echo '{"status":"Success"}';
    }else{
      $clean_timestamp = filter_var($_POST['timestamp'],FILTER_SANITIZE_NUMBER_INT);
      $sql = "INSERT INTO theGame (email, timestamp) VALUES ('{$clean_email}', '{$clean_timestamp}')";
      $data = mysql_query($sql) or die('{"status":"Error","message":"query 3 failed"}');
      echo '{"status":"Error","message":"The email was not found."}';
    }
  }else{
    echo '{"status":"Error","message":"Email invalid."}';
  }
?>
