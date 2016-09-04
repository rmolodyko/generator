<?php declare(strict_types = 1);
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 04.09.16 at 10:49
 */
namespace tests;

use PHPUnit\Framework\TestCase;
use samsonphp\generator\ClassGenerator;

/**
 * Class ClassGeneratorTest
 *
 * @author Vitaly Egorov <egorov@samsonos.com>
 */
class ClassGeneratorTest extends TestCase
{
    /** @var ClassGenerator */
    protected $classGenerator;

    public function setUp()
    {
        $this->classGenerator = new ClassGenerator('testClass');
    }

    public function testDefNamespace()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->code();

        $expected = <<<'PHP'
namespace testname\space;

class testClass
{
}
PHP;

        static::assertEquals($expected, $generated);
    }

    public function testDefFinal()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->defFinal()
            ->code();

        $expected = <<<'PHP'
namespace testname\space;

final class testClass
{
}
PHP;

        static::assertEquals($expected, $generated);
    }

    public function testDefAbstract()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->defAbstract()
            ->code();

        $expected = <<<'PHP'
namespace testname\space;

abstract class testClass
{
}
PHP;

        static::assertEquals($expected, $generated);
    }

    public function testDefAbstractFinal()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->classGenerator
            ->defNamespace('testname\space')
            ->defAbstract()
            ->defFinal();
    }

    public function testDefFinalAbstract()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->classGenerator
            ->defNamespace('testname\space')
            ->defFinal()
            ->defAbstract();
    }

    public function testDefUse()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->defUse('\testclass\scope\TestClass')
            ->defUse('\testclass\scope2\TestClass')
            ->code();

        $expected = <<<'PHP'
namespace testname\space;

use \testclass\scope\TestClass;
use \testclass\scope2\TestClass;

class testClass
{
}
PHP;

        static::assertEquals($expected, $generated);
    }

    public function testDefComment()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->defComment()
            ->defLine('Test comment')
            ->defMethod('testMethod', 'TestType')
            ->end()
            ->code();

        $expected = <<<'PHP'
namespace testname\space;

/**
 * Test comment
 * @method TestType testMethod()
 */
class testClass
{
}
PHP;

        static::assertEquals($expected, $generated);
    }

    public function testDefDescription()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->defDescription(['File description'])
            ->code();

        $expected = <<<'PHP'
/** File description */
namespace testname\space;

class testClass
{
}
PHP;

        static::assertEquals($expected, $generated);
    }

    public function testDefProperty()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->defProperty('testProperty', 'TestType', '')->end()
            ->code();

        $expected = <<<'PHP'
namespace testname\space;

class testClass
{
    /** @var TestType */
    public $testProperty;
}
PHP;

        static::assertEquals($expected, $generated);
    }

    public function testDefPropertyWithDescription()
    {
        $generated = $this->classGenerator
            ->defNamespace('testname\space')
            ->defProperty('testProperty', 'TestType', '', 'Property description')->end()
            ->code();

        $expected = <<<'PHP'
namespace testname\space;

class testClass
{
    /** @var TestType Property description */
    public $testProperty;
}
PHP;

        static::assertEquals($expected, $generated);
    }
}
