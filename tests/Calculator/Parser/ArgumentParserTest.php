<?php
/**
 * Created by PhpStorm.
 * User: hisham
 * Date: 16/4/18
 * Time: 6:32 PM
 */


use \PHPUnit\Framework\TestCase;
use \App\Calculator\Parser\ArgumentParser;

/**
 * Class ArgumentParserTest
 */
class ArgumentParserTest extends TestCase
{

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid Operation!
     */
    public function testParseInvalidOperationThrowsException()
    {
        ArgumentParser::parse(['calculator.php', 'non-existing-operation', '1,2']);
    }

    /**
     * @param array $arguments
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Operands should be numeric!
     * @dataProvider nonNumericOperandsProvider
     */
    public function testParseNonNumericOperandsThrowsException(array $arguments)
    {
        ArgumentParser::parse($arguments);
    }

    /**
     * @param array $arguments
     * @param array $expectedArguments
     * @dataProvider validArgumentsProvider
     */
    public function testValidOperationParseSuccess(array $arguments, array $expectedArguments)
    {
        $parsedArguments = ArgumentParser::parse($arguments);
        $this->assertSame($expectedArguments[0], $parsedArguments[0]);
    }

    /**
     * @param array $arguments
     * @param array $expectedArguments
     * @dataProvider validArgumentsProvider
     */
    public function testValidOperandsParseSuccess(array $arguments, array $expectedArguments)
    {
        $parsedArguments = ArgumentParser::parse($arguments);
        $this->assertSame($expectedArguments[1], $parsedArguments[1]);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid arguments. Inputs with custom delimiters must be in quotes. eg: php calculator.php add "\\;\\1;2;3"
     */
    public function testCustomDelimiterWithoutQuotesThrowsException()
    {
        ArgumentParser::parse(['calculator.php', 'add', '\\']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid arguments. Selected delimiter must match the one used
     */
    public function testSelectedCustomDelimiterDoesNotMatchesUsedDelimiterThrowsException()
    {
        ArgumentParser::parse(['calculator.php', 'add', '\\;\\1:2:3']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid arguments. Custom delimiter should be non-numeric.
     */
    public function testNumericCustomDelimiterThrowsException()
    {
        ArgumentParser::parse(['calculator.php', 'add', '\\3\\13233']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid arguments. Negative numbers(-2, -3) not allowed.
     */
    public function testNegativeOperandsNotAllowed()
    {
        ArgumentParser::parse(['calculator.php', 'add', '1,-2,-3']);
    }

    public function testCanParseCustomDelimiters()
    {
        $expectedResult = ['add', [1, 2, 3]];
        $arguments = ['calculator.php', 'add', '\\;\\1;2;3'];
        $parsedArguments = ArgumentParser::parse($arguments);
        $this->assertSame($expectedResult, $parsedArguments);
    }

    /**
     * @return array
     */
    public function nonNumericOperandsProvider()
    {
        return [
            [['calculator.php', 'add', 'a1,b2'], ''],
            [['calculator.php', 'add', 'abc2,qwe3'], '']
        ];
    }

    /**
     * @return array
     */
    public function validArgumentsProvider()
    {
        return [
            [['calculator.php', 'add', '1,2'], ['add', [1, 2]]],
            [['calculator.php', 'add', '5,6,7,8'], ['add', [5, 6, 7, 8]]],
            [['calculator.php', 'add', '2n5'], ['add', [2, 5]]],
            [['calculator.php', 'add', '2\n7'], ['add', [2, 7]]],
            [['calculator.php', 'add', '2,5,1030'], ['add', [2, 5]]]
        ];
    }
}