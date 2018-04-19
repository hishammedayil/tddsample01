<?php
/**
 * Created by PhpStorm.
 * User: hisham
 * Date: 16/4/18
 * Time: 6:29 PM
 */

namespace App\Calculator\Parser;


/**
 * Class ArgumentParser
 * @package App\Calculator\Parser
 */
class ArgumentParser
{
    /**
     * @var array
     */
    static $allowedOperations = ['add', 'multiply'];

    /**
     * @param array $arguments
     * @return array
     */
    public static function parse(array $arguments)
    {
        $delimiter = '';

        $operation = $arguments[1] ?? null;
        if(false == in_array($operation, static::$allowedOperations)) {
            throw new \InvalidArgumentException('Invalid Operation!');
        }

        $operandString = $operandArgs = $arguments[2] ?? null;
        if('\\' == $operandArgs) {
            throw new \InvalidArgumentException('Invalid arguments. Inputs with custom delimiters must be in quotes. eg: php calculator.php add "\\\\;\\\\1;2;3"');
        }
        // Check if a custom delimiter is used
        if('\\' === substr($operandArgs, 0, 1)) {
            $operandsArr = explode('\\', $operandArgs);
            $delimiter = $operandsArr[1] ?? '';

            if(true == is_numeric($delimiter)) {
                throw new \InvalidArgumentException('Invalid arguments. Custom delimiter should be non-numeric.');
            }

            $operandString = $operandsArr[2] ?? '';
            preg_match_all("/[^0-9]/", $operandString, $matches);

            if([$delimiter] !== array_unique($matches[0])) {
                throw new \InvalidArgumentException('Invalid arguments. Selected delimiter must match the one used');
            }
        }
        $operandString = str_replace('\n', "\n", $operandString);
        $operands = preg_split("/[\\nn," . $delimiter . "]+/", $operandString);
        $numericOperands = array_filter($operands, 'is_numeric');
        if($numericOperands !== $operands) {
            throw new \InvalidArgumentException('Operands should be numeric!');
        }

        $negativeOperands = array_filter($numericOperands, function($val){
            return 0 > $val;
        });
        if(0 < count($negativeOperands)) {
            throw new \InvalidArgumentException('Invalid arguments. Negative numbers(' . implode(', ', $negativeOperands) . ') not allowed.');
        }

        $numericOperands = array_filter($numericOperands, function($val){
            return 1000 > $val;
        });

        $parsedOperands = array_map('intval', $numericOperands);
        return [$operation, $parsedOperands];
    }
}