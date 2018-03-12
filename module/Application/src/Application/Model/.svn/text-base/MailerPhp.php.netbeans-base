<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use PHPMailer;

class MailerPhp {

    function __construct() {
        
    }

    function sendMail($emailDetails) {
        //PHPMailer Object
        $mail = new PHPMailer();  
//        
        //From email address and name
//        $mail->From = "sshekhar@radiancesystems.com";
//        $mail->FromName = "Shashi Shekhar";        
        $mail->From = $emailDetails->From;
        $mail->FromName = $emailDetails->FromName;

        //To address and name
//        $mail->addAddress("dbaruah@radiancesystems.com", "Dishi baruah");
        foreach ($emailDetails->Recipients as $recipients) {
            $mail->addAddress($recipients->email, $recipients->name);
        }
        //$mail->addAddress("recepient1@example.com"); //Recipient name is optional
        //Address to which recipient will reply
        //$mail->addReplyTo("reply@yourdomain.com", "Reply");
        //CC and BCC
        //$mail->addCC("cc@example.com");
        //$mail->addBCC("bcc@example.com");
        //Send HTML or Plain Text email
        $mail->isHTML(true);

//        $mail->Subject = "Testing Php Mailer";
//        $mail->Body = "<i>Mail body in HTML</i>";
//        $mail->AltBody = "This is the plain text version of the email content";
        $mail->Subject = $emailDetails->Subject;
        $mail->Body = $emailDetails->Body;
        $mail->AltBody = $emailDetails->AltBody;

        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
//            echo "Message has been sent successfully";
            echo "";
        }
    }
    
 }
?>