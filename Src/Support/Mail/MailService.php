<?php
namespace MvcCore\Rental\Support\Mail;

use phpDocumentor\Reflection\PseudoTypes\True_;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class MailService
{
    private $To;
    private $subject;
    private $body;

    function __construct($To , $subject , $body)
    {
        $this->To = $To;
        $this->subject = $subject;
        $this->body = $body;
    }


    function sendMail()
    {
        $mail = new PHPMailer(true);

        try {
            //settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                       
            $mail->SMTPAuth   =  true;                                   
            $mail->Username   = 'adeltecsee@gmail.com';                
            $mail->Password   = 'ppvhgtzhxuzcvwgg';                        
            $mail->SMTPSecure = "ssl";            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465; // 465-> no tls , // 587 -> tls
            $mail->SMTPAutoTLS = true; 

            //Recipients
            $mail->addAddress($this->To);     //Add a recipient

            //body
            $mail->isHTML(true);                                  //set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}