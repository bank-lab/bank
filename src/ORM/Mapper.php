<?php

namespace Bank\ORM;

use Bank\DataStore\AdapterInterface;
use Bank\ORM\Traits\MapperTrait;
use Bank\Query\Delete;
use Bank\Query\Select;

/**
 * Class Mapper
 * @package Bank\ORM
 *
 * @property  string adapterName
 */
abstract class Mapper implements MapperInterface
{
    use MapperTrait;

    /**
     * @var ModelInterface
     */
    protected $model;

    /**
     * Mapper constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->gateway = $this->adapter->getGateway();
    }

    /**
     * @param ModelInterface $model
     * @return int
     */
    public function save(ModelInterface $model): int
    {
        if ($model->getPrimaryKey()) {
            return $this->update($model);
        }

        return $this->insert($model);
    }

    /**
     * @param ModelInterface $model
     * @return int
     */
    public function delete(ModelInterface $model): int
    {
        if (!$model->getPrimaryKey()) {
            return 0;
        }

        $delete = new Delete($model::getTableName());
        $delete->where->equalTo($model->getPrimaryCol(), $model->getPrimaryKey());

        return $this->gateway()->delete($delete);
    }

    /**
     * @return Select
     */
    public function select(): Select
    {
        $model = $this->model;
        return new Select($model::getTableName());
    }

    /**
     * @param Select $query
     * @return ModelInterface
     */
    public function load(Select $query)
    {
        return $this->gateway()->find($query, $this->model);
    }

    /**
     * @param Select $query
     * @return array
     */
    public function loadAll(Select $query): array
    {
        return $this->gateway()->findAll($query, $this->model);
    }

}