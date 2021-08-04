# JSONPLACEHOLDER Posts resume by Email

This tool allows you to receive a report of each user's posts by email.


## Usage

``` php
use paolodinotte\Tool\Tool;

// Define SMPT credentials and configuration
$emailConfiguration = array(
    "host" => "smpthost",
    "username" => "your smpt username",
    "password" => "your smpt password",
    "port" => smpt service port
);

// Define sender mail and name
$sender = "sender@mail.it";
$senderName = "Sender Name";

// Define subject of the email
$subject = "Email subject";

// Define the limit number of posts for each user
$postsUpperLimit = 3;

// Define the recients mails which have to receive the resume
$recipients = array(
	"recipient1@mail.com",
	"recipient2@mail.com",
);

// Create the Tool instance
// IMPORTANT if the SMTP connection fails an exception is thrown
$phpTool = new Tool($emailConfiguration);

// Send the resume mail according to the previous params
$phpTool->sendUsersPostsEmail(
    $sender,
    $senderName,
    $recipients,
    $subject,
    $postsUpperLimit
    );
```
