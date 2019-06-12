<?php
require_once('config.php');
require_once('vendor/autoload.php');

use Particle\Validator\Validator;

# Required start and end date to be passed for script to run
$options = getopt('', [
    "start_date::",
    "end_date::",
]);

# Validate that start and end date exist
if (!isset($options['start_date'])) {
    print 'ERROR: start_date cannot be empty' . "\n";
    exit;
}
if (!isset($options['end_date'])) {
    print 'ERROR: end_date cannot be empty' . "\n";
    exit;
}
# Validate the start and end date formats
$v = new Validator;
$v->required('datetime')->datetime('Y-m-d');
$sd_format  = $v->validate(['datetime' => $options['start_date']])->isValid();
$ed_format = $v->validate(['datetime' => $options['end_date']])->isValid();

# If start and end dates passed validation set the variables
if ($sd_format === false || $ed_format === false) {
    print 'ERROR: start_date and end_date must be in the date format date(\'Y-m-d\')' . "\n";
    exit;
} else {
    $start_date = $options['start_date'];
    $end_date = $options['end_date'];
}

$today = date("Y-m-d");

$tday = new DateTime($today);

$s_date = new DateTime($start_date);
$s_diff = $tday->diff($s_date);

$e_date = new DateTime($end_date);
$e_diff = $tday->diff($e_date);

$start_days_back = $s_diff->days;
$end_days_back = $e_diff->days;

while ($start_days_back >= $end_days_back) {
    $minus_days = '-' . $start_days_back . ' days';
    print date("Y-m-d", strtotime($minus_days)) . "\n";
    $start_days_back --;
}
