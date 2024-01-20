<?php

declare(strict_types=1);

namespace WTFramework\ORM\Traits;

trait IsTable
{

  public const TABLE = null;
  public const PRIMARY_KEY = null;

  public static function toSnakeCase(): string
  {

    return ltrim(strtolower(preg_replace('/[A-Z]/', '_\0', basename(
      str_replace('\\', '/', static::class)
    ))), '_');

  }

  public static function table(): string
  {

    if (null !== static::TABLE)
    {
      return static::TABLE;
    }

    $table = static::toSnakeCase();

    if ('s' != substr($table, -1, 1))
    {
      $table .= 's';
    }

    return $table;

  }

  public static function primaryKey(): string|array
  {
    return static::PRIMARY_KEY ?? static::toSnakeCase() . '_id';
  }

}