<?php

namespace Bank\DataStore;

use Bank\Bank;

/**
 * Class Model
 * @package Bank\DataStore
 */
abstract class Model implements ModelInterface
{
    /**
     * @var string
     */
    protected $tableName = null;

    /**
     * @var array
     */
    protected $tableSchema = [];

    /**
     * @var array
     */
    protected $tableRowData = [];

    /**
     * @var string
     */
    protected $primaryKey = null;

    /**
     * @var string
     */
    protected $schema = null;

    public function __construct()
    {
        $this->injectionSchema();
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return string
     */
    public function getPrimaryCol(): string
    {
        return $this->primaryKey;
    }

    /**
     * @return int
     */
    public function getPrimaryKey(): int
    {
        $primaryKey = $this->primaryKey;
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
        if (array_search($name, $this->tableSchema) !== false) {
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

    protected function injectionSchema()
    {
        $schema = Bank::schema($this->schema);

        $this->tableName = $schema["table_name"] ?? null;
        $this->primaryKey = $schema["primary_key"] ?? null;
        $this->tableSchema = $schema["record"] ?? null;
    }
}