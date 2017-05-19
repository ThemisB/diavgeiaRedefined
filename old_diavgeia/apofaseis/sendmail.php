<?php
require_once './phpmailer/class.phpmailer.php';

function mail_alt_activation($email_from, $email_to, $email_tocc, $email_tobcc, $email_subject, $email_txt)//  ,$fileatt,$fileatt_name
{
   $ok = true;
   $mail = new PHPMailer(true);// the true param means it will throw exceptions on errors, which we need to catch

   $mail->IsSMTP();// telling the class to use SMTP

   try
   {

      $mail->SMTPDebug = 0;// enables SMTP debug information (for testing)
      $mail->SMTPAuth = false;// enable SMTP authentication
      $mail->SMTPSecure = 'tls';
      $mail->Host = "host.name";// sets the SMTP server
      $mail->Port = 25;// set the SMTP port for the GMAIL server
      $mail->Username = "email@account.domain";// SMTP account username
      $mail->Password = "password";// SMTP account password
      $mail->AddAddress($email_to);
      if(!($email_tocc == ''))
      {
         $mail->AddCC($email_tocc);
      }
      if(!($email_tobcc == ''))
      {
         $mail->AddBCC($email_tobcc);
      }
      //$mail->AddBCC($email_tobcc2);
      $mail->SetFrom($email_from, 'email@domain.name');
     
      $mail->Subject = mb_convert_encoding($email_subject, "ISO-8859-7", "UTF-8");
      $mail->CharSet = 'ISO-8859-7';
      //$mail->ContentType='';
      $mail->Encoding = 'base64';
      $mail->Body = mb_convert_encoding($email_txt, "ISO-8859-7", "UTF-8");
      $mail->Encoding = 'base64';
      $mail->AltBody = mb_convert_encoding($email_txt, "ISO-8859-7", "UTF-8");
      ;
      //$mail->AddAttachment($fileatt,$fileatt_name);      // attachment
      $mail->Send();
      //echo "Message Sent OK</p>\n";
   }
   catch(phpmailerException $e)
   {
      //echo $e->errorMessage(); //Pretty error messages from PHPMailer
      $ok = false;
   }
   catch(Exception $e)
   {
      //echo $e->getMessage(); //Boring error messages from anything else!
      $ok = false;
   }
   return $ok;
}

function mail_alt($email_from, $email_to, $email_subject, $email_txt)//  ,$fileatt,$fileatt_name
{
   $ok = true;
   $mail = new PHPMailer(true);// the true param means it will throw exceptions on errors, which we need to catch

   $mail->IsSMTP();// telling the class to use SMTP

   try
   {

      $mail->SMTPDebug = 0;// enables SMTP debug information (for testing)
      $mail->SMTPAuth = false;// enable SMTP authentication
      $mail->SMTPSecure = 'tls';
      $mail->Host = "host.name";// sets the SMTP server
      $mail->Port = 25;// set the SMTP port for the MAIL server
      $mail->Username = "support@domain.name";// SMTP account username
      $mail->Password = "password";// SMTP account password
      $mail->AddAddress($email_to);
      $mail->SetFrom($email_from, 'name@domain.name');
 
      $mail->Subject = mb_convert_encoding($email_subject, "ISO-8859-7", "UTF-8");
      $mail->CharSet = 'ISO-8859-7';
      //$mail->ContentType='';
      $mail->Encoding = 'base64';
      $mail->Body = mb_convert_encoding($email_txt, "ISO-8859-7", "UTF-8");
      $mail->Encoding = 'base64';
      $mail->AltBody = mb_convert_encoding($email_txt, "ISO-8859-7", "UTF-8");
      ;
      //$mail->AddAttachment($fileatt,$fileatt_name);      // attachment
      $mail->Send();
      //echo "Message Sent OK</p>\n";
   }
   catch(phpmailerException $e)
   {
      //echo $e->errorMessage(); //Pretty error messages from PHPMailer
      $ok = false;
   }
   catch(Exception $e)
   {
      //echo $e->getMessage(); //Boring error messages from anything else!
      $ok = false;
   }
   return $ok;
}

?>
