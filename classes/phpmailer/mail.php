<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/Exception.php';
require __DIR__.'/PHPMailer.php';
require __DIR__.'/SMTP.php';

class Mail extends PHPMailer
{
    // Set default variables for all new objects
    public $From     = 'noreply@domain.com';
    public $FromName = 'SITETITLE';
    public $Host     = 'smtp.mailtrap.io';
    public $Mailer   = 'smtp';
    public $SMTPAuth = true;
    public $Username = '97023999dfbb4d';
    public $Password = '26ce9492a0c544';//if using Gmail use an app password more details here https://support.google.com/accounts/answer/185833?hl=en
    //public $SMTPSecure = 'tls';
    public $WordWrap = 75;

    public function subject($subject)
    {
        $this->Subject = $subject;
    }

    public function body($body)
    {
        $this->Body = $body;
    }

    public function send()
    {
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);
        return parent::send();
    }
}
