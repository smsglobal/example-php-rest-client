#!/usr/bin/php
<?php
require 'vendor/autoload.php';
require_once('config.php');
require_once('SMSGlobalAPIWrapper.php');
use Ulrichsg\Getopt;

$getopt = new Getopt(array(
    array('v', 'verbose', Getopt::NO_ARGUMENT, 'Enable detailed information for debugging'),
    array('s', 'ssl', Getopt::NO_ARGUMENT, 'Enable HTTP over SSL'),
    array('k', 'key', Getopt::REQUIRED_ARGUMENT, 'API Key'),
    array('e', 'secret', Getopt::REQUIRED_ARGUMENT, 'Secret String')
));
$getopt->parse();
$options = $getopt->getOptions();
if(!isset($options['key']) || !isset($options['secret'])) {
    $getopt->showHelp(5);
    exit();
}


$verbose = isset($options['verbose']) ? true : false;
$ssl = isset($options['ssl']) ? true : false;
$key = $options['key'];
$secret = $options['secret'];

# Open the gate :)
$apiProtocol = $ssl ? $configs['api_ssl_protocol'] : $configs['api_protocol'];
$apiPort = $ssl ? $configs['api_ssl_port'] : $configs['api_port'];

$wrapper = new SMSGlobalAPIWrapper($key, $secret, $apiProtocol, $configs['api_host'], $apiPort, $configs['api_version'], '', $verbose);

# Get Balance

    echo "\nGetting Balance ..\n";
    $balance = $wrapper->get("balance");
    printf("\nYour balance is: %s", $balance->balance);
    printf("\nCountry code: %s", $balance->countryCode);
    printf("\nCost per SMS: %s", $balance->costPerSms);
    printf("\nCost per MMS: %s", $balance->costPerMms);
    printf("\nSMS available: %s", $balance->smsAvailable);
    printf("\nMMS available: %s", $balance->mmsAvailable);


?>