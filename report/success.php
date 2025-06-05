<?php
$url = "";
$thankyou = "";
$thankstitle = "";
$ipblocklist = [""];
$ip_address = $_SERVER["REMOTE_ADDR"];
if (in_array($ip_address, $ipblocklist)) {
    die("Sorry, you are blocked from using this tool due to abuse.");
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $url = filter_var($_POST["url"], FILTER_VALIDATE_URL);
    if (strpos(strtolower($url), "http://archive.soyjaks.party") === false && strpos(strtolower($url), "https://archive.soyjaks.party") === false) {
        $thankyou = "Sorry. The URL you entered is invalid.";
        $thankstitle = "ERROR";
    } else {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $thankyou = "Sorry. The URL you entered is invalid.";
            $thankstitle = "ERROR";
        } else {
            mail('soyjakreports@yahoo.com', "Possible illegal content on the 'chive", "Hello, the following URL may contain illegal content, or it may be a troll:\n $url.\nThe IP address of the person filling out this report is: $ip_address.\nThank you.", "From:reports@screamer.wiki");
            $thankyou = "Thank you. Your report has been submitted.";
            $thankstitle = "Thank You";
        }
    }
}
?>
<html>
    <head>
        <title><?=$thankstitle?></title>
        <link rel="stylesheet" type="text/css" href="/styles/illegalreport.css" />
    </head>
    <body>
        <center>
            <h1><?=$thankstitle?></h1>
            <p><?=$thankyou?></p>
        </center>
    </body>
</html>