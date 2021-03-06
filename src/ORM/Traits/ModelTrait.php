<?php

namespace Bank\ORM\Traits;

use Bank\Bank;

/**
 * Class ModelTrait
 * @package Bank\ORM\Traits
 */
trait ModelTrait
{
    /**
     * @var string
     */
    protected static $tableName = null;

    /**
     * @var string
     */
    protected static $primaryKey = null;

    /**
     * @var array
     */
    protected static $tableSchema = [];

    /**
     * @var array
     */
    protected $tableRowData = [];

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return static::$tableName;
    }

    /**
     * @return string
     */
    public function getPrimaryCol(): string
    {
        return static::$primaryKey;
    }

    /**
     * @return int
     */
    public function getPrimaryKey(): int
    {
        $primaryKey = static::$primaryKey;
        return (int)$this->{$primaryKey};
    }

    /**
     * @return array
     */
    public function getTableRowData(): array
    {
        return $this->tableRowData;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (array_search($name, static::$tableSchema) !== false) {
            $this->tableRowData[$name] = $value;
        }
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (isset($this->tableRowData[$name])) {
            return $this->tableRowData[$name];
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    protected static function injectionSchema()
    {
        $schema = Bank::schema(static::$tableName . ".php");

        static::$primaryKey = $schema["primary_key"] ?? null;
        static::$tableSchema = $schema["record"] ?? null;

        if (is_null(static::$primaryKey) || is_null(static::$tableSchema)) {
            throw new \Exception('Parameter is invalid');
        }
    }
}