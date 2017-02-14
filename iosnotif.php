<?php

//database details
$servername = "";
$username = "";
$password = "";
$dbname = "";

$conn = mysql_connect($servername, $username, $password);
if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
$con_result = mysql_select_db($dbname, $conn);
if(!$con_result)
{
	die('Could not connect to specific database: ' . mysql_error());	
}

//Private key passphrase:
$passphrase = '';

//Message to be shown on notification:
$message = 'New Posts!';

//badge
$badge = 1;

// $ctx = stream_context_create();

$argument = array(
        'ssl' => array(
            'verify_peer'      => true,
            'verify_peer_name' => true,
            'cafile'           => 'location of your .cer file',
        )
);

$ctx = stream_context_create($argument);

stream_context_set_option($ctx, 'ssl', 'local_cert', 'location of your .pem file');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
stream_context_set_option($ctx, 'ssl', 'cafile', 'location of your .cer file');


// Open a connection to the APNS server
$fp = stream_socket_client(
    'ssl://gateway.push.apple.com:2195', $err,
    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

//Creating the payload body
$body['aps'] = array(
    'alert' => $message,
    'badge' => $badge,
    'sound' => 'newMessage.wav'
);

$mysqlresult = mysql_query("SELECT `token` FROM `iosfinal`");
$tokenArray = Array();

//this will store all the token ids in an array $tokenArray
while ($row = mysql_fetch_array($mysqlresult, MYSQL_ASSOC)) {

$tokenArray[] = $row['token'];

}

$length = count($tokenArray);

// Encode the payload as JSON
$payload = json_encode($body);


for($i = 0; $i < $length; $i++) {
// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $tokenArray[$i]) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
    echo 'Error, notification not sent' . PHP_EOL;
else
    echo 'notification sent!' . PHP_EOL;
}
// Close the connection to the server
fclose($fp);