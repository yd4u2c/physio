<?php

namespace Faker\ORM\CakePHP;

class Populator
{

    protected $generator;
    protected $entities = [];
    protected $quantities = [];
    protected $guessers = [];

    /**
     * @param \Faker\Generator $generator
     */
    public function __construct(\Faker\Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @return \Faker\Generator
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @return array
     */
    public function getGuessers()
    {
        return $this->guessers;
    }

    /**
     * @return $this
     */
    public function removeGuesser($name)
    {
        if ($this->guessers[$name]) {
            unset($this->guessers[$name]);
        }
        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function addGuesser($class)
    {
        if (!is_object($class)) {
            $class = new $class($this->generator);
        }

        if (!method_exists($class, 'guessFormat')) {
            throw new \Exception('Missing required custom guesser method: ' . get_class($class) . '::guessFormat()');
        }

        $this->guessers[get_class($class)] = $class;
        return $this;
    }

    /**
     * @param array $customColumnFormatters
     * @param array $customModifiers
     * @return $this
     */
    public function addEntity($entity, $number, $customColumnFormatters = [], $customModifiers = [])
    {
        if (!$entity instanceof EntityPopulator) {
            $entity = new EntityPopulator($entity);
        }

        $entity->columnFormatters = $entity->guessColumnFormatters($this);
        if ($customColumnFormatters) {
            $entity->mergeColumnFormattersWith($customColumnFormatters);
        }

        $entity->modifiers = $entity->guessModifiers($this);
        if ($customModifiers) {
            $entity->mergeModifiersWith($customModifiers);
        }

        $class = $entity->class;
        $this->entities[$class] = $entity;
        $this->quantities[$class] = $number;
        return $this;
    }

    /**
     * @param array $options
     * @return array
     */
    public function execute($options = [])
    {
        $insertedEntities = [];

        foreach ($this->quantities as $class => $number) {
            for ($i = 0; $i < $number; $i++) {
                $insertedEntities[$class][] = $this->entities[$class]->execute($class, $insertedEntities, $options);
            }
        }

        return $insertedEntities;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Faker\ORM\Doctrine;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;

class ColumnTypeGuesser
{
    protected $generator;

    /**
     * @param \Faker\Generator $generator
     */
    public function __construct(\Faker\Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param ClassMetadata $class
     * @return \Closure|null
     */
    public function guessFormat($fieldName, ClassMetadata $class)
    {
        $generator = $this->generator;
        $type = $class->getTypeOfField($fieldName);
        switch ($type) {
            case 'boolean':
                return function () use ($generator) {
                    return $generator->boolean;
                };
            case 'decimal':
                $size = isset($class->fieldMappings[$fieldName]['precision']) ? $class->fieldMappings[$fieldName]['precision'] : 2;

                return function () use ($generator, $size) {
                    return $generator->randomNumber($size + 2) / 100;
                };
            case 'smallint':
                return function () {
                    return mt_rand(0, 65535);
                };
            case 'integer':
                return function () {
                    return mt_rand(0, intval('2147483647'));
                };
            case 'bigint':
                return function () {
                    return mt_rand(0, intval('18446744073709551615'));
                };
            case 'float':
                return function () {
                    return mt_rand(0, intval('4294967295'))/mt_rand(1, intval('4294967295'));
                };
            case 'string':
                $size = isset($class->fieldMappings[$fieldName]['length']) ? $class->fieldMappings[$fieldName]['length'] : 255;

                return function () use ($generator, $size) {
                    return $generator->text($size);
                };
            case 'text':
                return function () use ($generator) {
                    return $generator->text;
                };
            case 'datetime':
            case 'date':
            case 'time':
                return function () use ($generator) {
                    return $generator->datetime;
                };
            default:
                // no smart way to guess what the user expects here
                return null;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Faker\ORM\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;

/**
 * Service class for populating a table through a Doctrine Entity class.
 */
class EntityPopulator
{
    /**
     * @var ClassMetadata
     */
    protected $class;
    /**
     * @var array
     */
    protected $columnFormatters = array();
    /**
     * @var array
     */
    protected $modifiers = array();

    /**
     * Class constructor.
     *
     * @param ClassMetadata $class
     */
    public function __construct(ClassMetadata $class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class->getName();
    }

    /**
     * @param $columnFormatters
     */
    public function setColumnFormatters($columnFormatters)
    {
        $this->columnFormatters = $columnFormatters;
    }

    /**
     * @return array
     */
    public function getColumnFormatters()
    {
        return $this->columnFormatters;
    }

    public function mergeColumnFormattersWith($columnFormatters)
    {
        $this->columnFormatters = array_merge($this->columnFormatters, $columnFormatters);
    }

    /**
     * @param array $modifiers
     */
    public function setModifiers(array $modifiers)
    {
        $this->modifi