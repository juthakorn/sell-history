<?php

require '../PHPMailer-5.2.22/class.phpmailer.php';
require '../PHPMailer-5.2.22/class.smtp.php';
include('../lib.php');
try {
    // iconv_set_encoding("internal_encoding", "UTF-8");
     $mail = new PHPMailer(true); //New instance, with exceptions enabled
     $mail->CharSet = 'utf-8';
     $body = 'test<br><br> tom ';
     $mail->SMTPDebug = 2;

     $mail->IsSMTP();                           // tell the class to use SMTP
     $mail->SMTPAuth = true;                  // enable SMTP authentication
     $mail->Port = 25;                    // set the SMTP server port
     $mail->Host = "smtp.pixalione.com"; // SMTP server
     $mail->Username = "art@pixalione.com";     // SMTP server username
     $mail->Password = "MDP010715At";            // SMTP server password
     
     $mail->setFrom('juthakorn@hotmail.com', 'System');
//     $mail->setLanguage('th');
//     $mail->IsSendmail();  // tell the class to use Sendmail

//     $mail->AddReplyTo('tommai0809@gmail.com', 'จุฑากรณ์ เกิดพิทักษ์');

     $mail->From = "public@pixalione.com";  
     $mail->FromName   = 'Pixalione';
     $to = "tommai0809@gmail.com";
     $mail->AddAddress($to);
     //$mail->AddCC('louise@pixalione.com', 'Louise');
//     $mail->AddBCC('louise@pixalione.com', 'Louise');
     
     $mail->Subject = "งานราชการ วันที่ ".date("d/m/Y");

     // $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
     $mail->WordWrap = 80; // set word wrap
     $mail->Body = $body;

     // $mail->MsgHTML($body);
     $mail->ContentType = 'text/plain';
     $mail->IsHTML(TRUE);

     
     if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
     $result =  'OK Send mail Success !!';
    // echo 'Votre message a été envoyé avec succès.';
 } catch (phpmailerException $e) {
     $result = $e->errorMessage();
 }
 
 pr($result);