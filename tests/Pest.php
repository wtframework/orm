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

  DB::drop()->table($table)->ifExists()();

  DB::create()
  ->table($table)
  ->column(
    DB::column($primary_key)
    ->integer()
    ->primaryKey()
    ->autoIncrement()
  )();

}

function createWithName(
  string $table,
  string $primary_key = 'id'
): void
{

  DB::drop()->table($table)->ifExists()();

  DB::create()
  ->table($table)
  ->column(
    DB::column($primary_key)
    ->integer()
    ->primaryKey()
    ->autoIncrement()
  )
  ->column(
    DB::column('name')
    ->varchar()
  )();

}

function createPivot(
  string $table,
  array $primary_key
): void
{

  DB::drop()->table($table)->ifExists()();

  $stmt = DB::create()
  ->table($table)
  ->primaryKey($primary_key);

  foreach ($primary_key as $column)
  {
    $stmt->column(DB::column($column)->integer());
  }

  $stmt();

}

function insert(
  string $table,
  array $values
): void
{
  DB::insert()->into($table)->values($values)();
}