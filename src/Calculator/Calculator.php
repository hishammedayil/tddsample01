<?php
/**
 * Created by PhpStorm.
 * User: hisham
 * Date: 13/4/18
 * Time: 4:14 PM
 */

namespace App\Calculator;
/**
 * Class Calculator
 * @package App\Calculator
 */
class Calculator
{
    /**
     * @param string $operation
     * @param array|null $operands
     * @return float|int
     */
    public function calculate(string $operation, array $operands = null)
    {
        switch($operation) {
            case 'add':
                return $this->add($operands);
            case 'multiply':
                return $this->multiply($operands);
            default:
                throw new \InvalidArgumentException('Invalid Operation!');
        }
    }

    /**
     * @param array $numbers
     * @return float|int
     */
    private function add(array $numbers)
    {
        if(true == empty($numbers)) {
            return 0;
        }
        return array_sum($numbers);
    }

    /**
     * @param array $numbers
     * @return float|int
     */
    private function multiply(array $numbers)
    {
        if(true == empty($numbers)) {
            return 0;
        }
        return array_product($numbers);
    }
}