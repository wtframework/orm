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
use WTFramework\ORM\Model;

class User extends Model {}
```
\
By default the table name will be a pluralized form of the class name in snake case. For example, `class UserRole` will have a table name of `user_roles`. If you wish to specify the table name then include a `public const TABLE`.
```php
class User extends Model
{
  public const TABLE = 'x_users';
}
```
\
By default the primary key will be the class name in snake case with a suffix of `_id`. For example, `class UserRole` will have a primary key of `user_role_id`. If you wish to specify the primary key then include a `public const PRIMARY_KEY`. This may be a string or an array (if a composite primary key).
```php
class User extends Model
{
  public const PRIMARY_KEY = 'id';
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
Use the `require` static method to select a record and throw a `WTFramework\ORM\ModelNotFoundException` if the record was not found.
```php
$user = User::require(1);

$user = User::require([
  'id1' => 1,
  'id2' => 2,
]);
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

### Relationships
The ORM allows for creating `belongs to`, `has one`, and `has many` relationships.
```php
use WTFramework\ORM\Model;
use WTFramework\ORM\Relationships\BelongsTo;
use WTFramework\ORM\Relationships\Has;
use WTFramework\ORM\Relationships\HasMany;

class User extends Model
{

  public function role(): BelongsTo
  {
    return $this->belongsTo(UserRole::class);
  }

  public function profile(): Has
  {
    return $this->has(Profile::class);
  }

  public function revisions(): HasMany
  {
    return $this->hasMany(UserRevision::class);
  }

}
```
\
By default the records will be retrieved using the models' primary keys. If you require the relationships to use different column names then you can pass them as additional parameters.
```php
class User extends Model
{

  public const PRIMARY_KEY = 'id';

  public function role(): BelongsTo
  {
    return $this->belongsTo(UserRole::class, local_key: "role_id");
  }

  public function profile(): Has
  {
    return $this->has(Profile::class, foreign_key: "user_id");
  }

  public function revisions(): HasMany
  {
    return $this->hasMany(UserRevision::class, foreign_key: "user_id");
  }

}
```
\
Use the relationship method name as a property to return the result of the relationship.
```php
$role = $user->role->name;
```
\
When relationships are retrieved this way they will be cached. Use the `clearCache` method to clear the cache.
```php
$user->clearCache();
```
\
If you call the relationship method directly then it will return an instance of `WTFramework\ORM\Query` allowing you to manipulate the results further.
```php
$revisions = $user->revisions()->orderBy('created')->all();
```
\
By default relationships will be lazy loaded. This can lead to an N+1 query problem. To eager load the relationship you can call the `eager` method, passing in a string or an array of relationship names to eager load.
```php
User::eager('revisions')->all();
```
\
You may also eager load by default by setting the `public const EAGER` array.
```php
class User extends Model
{

  public const EAGER = ['revisions'];

  public function revisions(): HasMany
  {
    return $this->hasMany(UserRevision::class);
  }

}
```
\
When a relationship is eager loaded by default you can override this by calling the `lazy` method.
```php
User::lazy('revisions')->where('user_id', 1)->get();
```