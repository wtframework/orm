# What the Framework?! ORM

This library extends the [DBAL](https://github.com/wtframework/dbal) library to provide object–relational mapping.

## Installation
```bash
composer require wtframework/orm
```

## Documentation

### Create a new model

Create a new model by extending the `WTFramework\ORM\Model` class.
```php
use WTFramework\ORM\Model

class User extends Model {}
```
\
By default the table name will be a pluralized form of the class name in snake case. For example, `class User` will have a table name of `users` and `class UserRole` will have a table name of `user_roles`. If you wish to specify the table name then include a `public const TABLE`.
```php
class User extends Model
{
  public const TABLE = 'users';
}
```
\
By default the primary key will be the class name in snake case with a suffix of `_id`. For example, `class User` will have a primary key of `user_id` and `class UserRole` will have a primary key of `user_role_id`. If you wish to specify the primary key then include a `public const PRIMARY_KEY`. This may be a string or an array (if a composite primary key).
```php
class User extends Model
{
  public const PRIMARY_KEY = 'user_id';
}
```
\
By default the model will use the default database connection as defined in the [DBAL](https://github.com/wtframework/dbal) configuration settings. If you wish to specify the connection name then include a `public const CONNECTION`.
```php
class User extends Model
{
  public const CONNECTION = 'mirror';
}
```

### Insert a record

Use the `create` static method to create a new record passing its data as either a stdClass object or an array. This will return a new instance of the model.
```php
$user = User::create(['user_id' => 1]);
```

### Select a record

Use the `get` static method to a select a record passing its primary key as a string, an integer, or an array (if a composite primary key).
```php
$user = User::get(1);

$user = User::get([
  'id1' => 1,
  'id2' => 2,
]);
```
\
Use the `exists` method to determine if the record was found.
```php
$user->exists();
```
\
Use the `require` static method to select a record and throw a `WTFramework\ORM\ModelNotFound` exception if the record was not found.
```php
$user = User::require(1);
```

### Update a record

Use the `save` method to update a record. You may set the data either by manually setting the model's properties or by passing its data as either a stdClass object or an array.
```php
$user->name = 'Michael';

$user->save(['user_role_id' => 1]);
```

### Refresh a record

Use the `refresh` method to undo any changes that have not been saved to the database.
```php
$user->name = 'Michael';

$user->refresh();
```
\
Use the `fresh` method to return a new instance of the record.
```php
$user->name = 'Michael';

$fresh = $user->fresh();
```

### Querying the model

You can query the model using any of the methods defined by the `SELECT` grammar of the [SQL](https://github.com/wtframework/sql) library. The results are then retrieved using either `get` for a single model or `all` for an array of models.
```php
$users = User::where('user_role_id', 1)->all();
```
\
Models also provide a quick way to insert, update, delete, etc. Each of these methods return a fluent interface from the [DBAL](https://github.com/wtframework/dbal) library for generating SQL statements, automatically using the defined table.
```php
User::select();
User::insert();
User::replace();
User::update();
User::delete();
User::truncate();
```