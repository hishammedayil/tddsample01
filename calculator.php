#!/usr/bin/php
<?php
/**
 * Created by PhpStorm.
 * User: hisham
 * Date: 13/4/18
 * Time: 4:06 PM
 */

use \App\Calculator\Calculator;
use App\Calculator\Parser\ArgumentParser;

require_once(__DIR__ . '/vendor/autoload.php');
try {
    list($operation, $operands) = ArgumentParser::parse($argv);
    $calculator = new Calculator();
    $result = $calculator->calculate($operation, $operands);
    print $result . PHP_EOL;
} catch (Exception $e) {
    print 'Error: ' . $e->getMessage() . PHP_EOL;
}