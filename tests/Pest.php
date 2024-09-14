<?php

declare(strict_types=1);

use WTFramework\Config\Config;
use WTFramework\DBAL\DB;

Config::set([
  'database' => [
    'default' => 'sqlite',
    'connections' => [
      'sqlite' => []
    ]
  ]
]);

function create(
  string $table,
  string $primary_key = 'id'
): void
{

  DB::drop($table)->ifExists()();

  $table = DB::create($table);

  $table->integer($primary_key)
  ->primaryKey()
  ->autoIncrement();

  $table();

}

function createWithName(
  string $table,
  string $primary_key = 'id'
): void
{

  DB::drop($table)->ifExists()();

  $table = DB::create($table);

  $table->integer($primary_key)
  ->primaryKey()
  ->autoIncrement();

  $table->varchar('name');

  $table();

}

function createPivot(
  string $table,
  array $primary_key
): void
{

  DB::drop($table)->ifExists()();

  $table = DB::create($table)
  ->primaryKey($primary_key);

  foreach ($primary_key as $column)
  {
    $table->integer($column);
  }

  $table();

}

function insert(
  string $table,
  array $values
): void
{
  DB::insert($table)->values($values)();
}