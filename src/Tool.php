<?php

namespace paolodinotte\Tool;

use paolodinotte\Tool\Utils\Endpoints;
use paolodinotte\Tool\Utils\Email;

class Tool
{
    private array $emailConfiguration;

    /**
     * Tool instance checking valid SMTP credentials
     *
     * @param array $emailConfiguration composed by SMPT values ['host', 'username', 'password', 'port']
     *
     * @return Tool
     *
     * @throws InvalidArgumentException if SMPT credentials are not valid
     *
     */
    public function __construct(array $emailConfiguration)
    {
        if (!Email::validateSmtpConfiguration($emailConfiguration))
            throw new \InvalidArgumentException('Invalid email credentials');

        $this->emailConfiguration = $emailConfiguration;
    }

    /**
     * Fetch users' posts according to an upper bound limit in order to send an email to each recipients
     *
     * @param string $senderMail
     * @param string $senderName
     * @param array $recipients
     * @param string $subject
     * @param int $postsUpperLimit
     *
     * @return bool true if emails are correctly sent
     *
     * @throws InvalidArgumentException if one among sender or recipients is not a valid email
     *
     */
    public function sendUsersPostsEmail(string $senderMail, string $senderName, array $recipients, string $subject = "Posts extraction", int $postsUpperLimit = null): bool
    {
        // Checking emails used for sender and recipients
        if (!filter_var($senderMail, FILTER_VALIDATE_EMAIL))
            throw new \InvalidArgumentException("Invalid email sender: {$senderMail}");

        foreach ($recipients as $email)
            if (!filter_var($senderMail, FILTER_VALIDATE_EMAIL))
                throw new \InvalidArgumentException("Invalid email recipient: {$email}");


        // Getting users list
        $users = Endpoints::getUsers();
        $body = "";

        // Iterate users to fetch posts (according to the upper limit argument) and composing its section into the mail
        foreach ($users as $user) {
            $posts = Endpoints::getPosts(userId: $user["id"], end: $postsUpperLimit);
            $userPostsText = $this->formatUserPosts($user["name"], array_column($posts, "title"));
            $body .= "<br>{$userPostsText}";
        }


        // Sending the email to each recipient
        return Email::sendEmail(
            host: $this->emailConfiguration["host"],
            username: $this->emailConfiguration["username"],
            password: $this->emailConfiguration["password"],
            port: $this->emailConfiguration["port"],
            senderMail: $senderMail,
            senderName: $senderName,
            recipients: $recipients,
            subject: $subject,
            isHtml: true,
            body: $body
        );
    }

    /**
     * Utility private method to generate an HTML body to send
     *
     * @param string $user
     * @param array $posts
     *
     * @return string formatted html which contains user information and its posts
     *
     */
    private function formatUserPosts(string $user, array $posts): string
    {
        $message = "<b>$user</b> has written:<ul>";

        foreach ($posts as $post)
            $message .=  "<li><i>$post</i></li>";

        $message .= "</ul>";

        return $message;
    }
}
