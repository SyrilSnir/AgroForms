<?php

use app\core\helpers\Utils\StringHelper;
use Codeception\PHPUnit\TestCase;
/**
 * Description of StringHelperTest
 *
 * @author kotov
 */
class StringHelperTest extends TestCase
{
    public function testExtractNumberFromString()
    {
        
        $testStr1 = 'id111';
        $testStr2 = '111id111';
        $this->assertEquals(StringHelper::extractNumberFromString($testStr1), 111);
        $this->assertEquals(StringHelper::extractNumberFromString($testStr2), 111111);
 

    }
}
