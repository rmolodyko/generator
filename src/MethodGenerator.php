<?php declare(strict_types = 1);
/**
 * Created by Vitaly Iegorov <egorov@samsonos.com>.
 * on 03.09.16 at 11:30
 */
namespace samsonphp\generator;

/**
 * Class method generation class.
 *
 * @author Vitaly Egorov <egorov@samsonos.com>
 */
class MethodGenerator extends FunctionGenerator
{
    /** @var bool Flag that method is static */
    protected $isStatic = false;

    /** @var bool Flag that method is abstract */
    protected $isAbstract = false;

    /** @var bool Flag that method is final */
    protected $isFinal = false;

    /** @var string Method visibility */
    protected $visibility = ClassGenerator::VISIBILITY_PUBLIC;

    /**
     * Build function definition.
     *
     * @return string Function definition
     */
    protected function buildDefinition()
    {
        return ($this->isFinal ? 'final ' : '').
            ($this->isAbstract ? 'abstract ' : '').
            ($this->isStatic ? 'static ' : '').
            'function '.$this->name.'()';
    }

    /**
     * Set method to be static.
     *
     * @return MethodGenerator
     */
    public function defStatic() : MethodGenerator
    {
        $this->isStatic = true;

        return $this;
    }

    /**
     * Set method to be final.
     *
     * @return MethodGenerator
     */
    public function defFinal() : MethodGenerator
    {
        if ($this->isAbstract) {
            throw new \InvalidArgumentException('Method cannot be final as it is already abstract');
        }

        $this->isFinal = true;

        return $this;
    }

    /**
     * Set method to be abstract.
     *
     * @return MethodGenerator
     */
    public function defAbstract() : MethodGenerator
    {
        if ($this->isFinal) {
            throw new \InvalidArgumentException('Method cannot be abstract as it is already final');
        }

        $this->isAbstract = true;

        return $this;
    }
}