## Adapter


```php
$adapter = \Bank\Bank::adapter({ADAPTER_NAME});
```

interface

```
/**
 * @return ConnectionInterface
*/
public function getConnection(): ConnectionInterface;

/**
 * @return QueryBuilderInterface
 */
public function getQueryBuilder(): QueryBuilderInterface;

/**
 * @return GatewayInterface
 */
public function getGateway(): GatewayInterface;

```
