<?php 
require_once __DIR__ . '/../vendor/autoload.php';

use paolodinotte\Tool\Tool;

$emailConfiguration = array(
    "host" => "smtp.mailtrap.io",
    "username" => "USERNAME",
    "password" => "PASSWORD",
    "port" => 2525
);

$sender = "sender@mail.tester";
$senderName = "Tester";

$subject = "Users' posts listing";

$postsUpperLimit = 3;

$recipients = array(
	"recipient1@mail.test",
	"recipient2@mail.test"
);

$phpTool = new Tool($emailConfiguration);

$phpTool->sendUsersPostsEmail($sender, $senderName, $recipients, $subject, $postsUpperLimit);
