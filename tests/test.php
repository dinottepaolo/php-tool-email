<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use paolodinotte\Tool\Tool;

$emailConfiguration = array(
    "host" => "smtp.mailtrap.io",
    "username" => "adbf55fb9fd823",
    "password" => "f35a4965599436",
    "port" => 2525
);

$sender = "test@mail.it";
$senderName = "Tester";

$subject = "Users' posts listing";

$postsUpperLimit = 3;

$recipients = array(
	"dinotte.paolo@gmail.com",
	"paolo2988@gmail.com"
);

$phpTool = new Tool($emailConfiguration);

$phpTool->sendUsersPostsEmail($sender, $senderName, $recipients, $subject, $postsUpperLimit);