<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phoneNo = trim($_POST["phoneNo"]);
        $message = trim($_POST["contactMsg"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($phoneNo) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "themeextra15@gmail.com";    // Replace the email address with your email where you want to send message.

        // Set the email subject.
        $subject = "New message from $name";

        // Build the email content.
        $email_content = "$name sent you an email from";
        $email_content .= "$email\n\n";
        $email_content .= "The Phone number is: $phoneNo\n\n";
        $email_content .= "Message from $name: $message\n";

        // Build the email headers.
        $email_headers = "From: YourWebsiteName <noreply@yourwebsite.com>\r\n";
        $email_headers = "Reply-To: ".$name." <".$email.">\r\n";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>