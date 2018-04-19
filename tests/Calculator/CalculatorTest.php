<?php
/**
 * Created by PhpStorm.
 * User: hisham
 * Date: 13/4/18
 * Time: 4:37 PM
 */

use PHPUnit\Framework\TestCase;
use App\Calculator\Calculator;

class CalculatorTest extends TestCase
{
    private $calculator;

    public function setUp()
    {
        $this->calculator = new Calculator();
    }

    public function tearDown()
    {
        $this->calculator = null;
    }

    /**
     * @param array $arguments
     * @param int $expectedResult
     * @dataProvider validCalculationProvider
     */
    public function testValidCalculations(array $arguments, int $expectedResult)
    {
        $this->assertSame($this->calculator->calculate($arguments[0], $arguments[1]), $expectedResult);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid Operation!
     */
    public function testInvalidOperationThrowsException()
    {
        $this->calculator->calculate('invalidOperation');
    }

    public function validCalculationProvider()
    {
        return [
            [['add', []], 0],
            [['add', [5]], 5],
            [['add', [1, 2, 3, 4]], 10],
            [['multiply', [1, 2, 3, 4]], 24],
            [['multiply', [5]], 5],
            [['multiply', []], 0]
        ];
    }
}
