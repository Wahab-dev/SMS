<?php
/*SendGrid Library*/
require_once ('vendor/autoload.php');

/*Post Data*/
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

/*Content*/
$from = new SendGrid\Email("Goku", "gokuash.ananya@gmail.com");
$subject = "Check Mail";
$to = new SendGrid\Email("Ashika", "ashi.jahir@gmail.com");
$content = new SendGrid\Content("text/html", "CONTENT_GOES_HERE");

/*Send the mail*/
$mail = new SendGrid\Mail($from, $subject, $to, $content);
$apiKey = ('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');
$sg = new \SendGrid($apiKey);

/*Response*/
$response = $sg->client->mail()->send()->post($mail);
?>

<!--Print the response-->
<pre>
    <?php
    var_dump($response);
    ?>
</pre>
