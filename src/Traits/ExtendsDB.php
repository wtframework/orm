<?php

declare(strict_types=1);

namespace WTFramework\ORM\Traits;

use WTFramework\DBAL\Connection;
use WTFramework\DBAL\DB;
use WTFramework\DBAL\Statements\Delete;
use WTFramework\DBAL\Statements\Insert;
use WTFramework\DBAL\Statements\Replace;
use WTFramework\DBAL\Statements\Select;
use WTFramework\DBAL\Statements\Truncate;
use WTFramework\DBAL\Statements\Update;

trait ExtendsDB
{

  use IsTable;

  public const CONNECTION = null;

  public static function connection(): Connection
  {
    return DB::connection(static::CONNECTION);
  }

  public static function delete(): Delete
  {
    return static::connection()->delete(static::table());
  }

  public static function insert(): Insert
  {
    return static::connection()->insert(static::table());
  }

  public static function replace(): Replace
  {
    return static::connection()->replace(static::table());
  }

  public static function select(): Select
  {
    return static::connection()->select(static::table());
  }

  public static function truncate(): Truncate
  {
    return static::connection()->truncate(static::table());
  }

  public static function update(): Update
  {
    return static::connection()->update(static::table());
  }

}