<?php

namespace Bank;

use Bank\DataStore\Adapter;
use Bank\DataStore\AdapterInterface;

/**
 * Class Bank
 * @package Bank
 */
class Bank
{
    const ADAPTER_DEFAULT_NAMESPACE = 'default';

    /**
     * @var array
     */
    private static $config = [];

    /**
     * @var array
     */
    private static $adapter = [];

    /**
     * @var array
     */
    private static $schema = [];

    /**
     * @param array $config
     */
    public static function setConfig(array $config)
    {
        self::$config = $config;
    }

    /**
     * @param string $adapterNamespace
     * @return AdapterInterface
     * @throws \Exception
     */
    public static function adapter($adapterNamespace = self::ADAPTER_DEFAULT_NAMESPACE): AdapterInterface
    {
        if (!isset(self::$config['adapter'][$adapterNamespace])) {
            throw new \Exception('not found adapter Query.config');
        }

        if (isset(self::$adapter[$adapterNamespace])) {
            return self::$adapter[$adapterNamespace];
        }

        $config = self::$config['adapter'][$adapterNamespace];

        $dns = $config['dns'] ?? null;
        $user = $config['user'] ?? null;
        $password = $config['password'] ?? null;

        if (is_null($dns) || is_null($user) || is_null($password)) {
            throw new \Exception('Parameter is invalid');
        }

        self::$adapter[$adapterNamespace] = new Adapter($dns, $user, $password);

        return self::$adapter[$adapterNamespace];
    }

    /**
     * @param $schemaName
     * @return mixed
     * @throws \Exception
     */
    public static function schema($schemaName)
    {
        if (!isset(self::$config['schema'])) {
            throw new \Exception('not found schema dir');
        }

        if (isset(self::$schema[$schemaName])) {
            return self::$schema[$schemaName];
        }

        $schemaDir = self::$config['schema'];
        self::$schema[$schemaName] = include $schemaDir . $schemaName;

        return self::$schema[$schemaName];
    }
}