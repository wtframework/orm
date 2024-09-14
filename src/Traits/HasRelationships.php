<?php

declare(strict_types=1);

namespace WTFramework\ORM\Traits;

use WTFramework\ORM\Model;
use WTFramework\ORM\Relationships\BelongsTo;
use WTFramework\ORM\Relationships\Has;
use WTFramework\ORM\Relationships\HasMany;
use WTFramework\ORM\Relationships\HasManyThrough;
use WTFramework\ORM\Relationships\HasThrough;

trait HasRelationships
{

  public const EAGER = [];

  protected array $relationships = [];

  protected function belongsTo(
    string $foreign_table,
    string|array $local_key = null,
    string|array $foreign_key = null
  ): BelongsTo
  {

    return new BelongsTo(
      local_table: $this,
      local_key: (array) ($local_key ?? $foreign_table::primaryKey()),
      foreign_table: $foreign_table,
      foreign_key: (array) ($foreign_key ?? $foreign_table::primaryKey())
    );

  }

  protected function has(
    string $foreign_table,
    string|array $foreign_key = null,
    string|array $local_key = null
  ): Has
  {

    return new Has(
      local_table: $this,
      local_key: (array) ($local_key ?? $this::primaryKey()),
      foreign_table: $foreign_table,
      foreign_key: (array) ($foreign_key ?? $this::primaryKey())
    );

  }

  protected function hasMany(
    string $foreign_table,
    string|array $foreign_key = null,
    string|array $local_key = null
  ): HasMany
  {

    return new HasMany(
      local_table: $this,
      local_key: (array) ($local_key ?? $this::primaryKey()),
      foreign_table: $foreign_table,
      foreign_key: (array) ($foreign_key ?? $this::primaryKey())
    );

  }

  protected function hasThrough(
    string $foreign_table,
    string $pivot_table,
    string|array $foreign_key = null,
    string|array $local_key = null,
    string|array $pivot_foreign_key = null,
    string|array $pivot_local_key = null
  ): HasThrough
  {

    return new HasThrough(
      local_table: $this,
      local_key: (array) ($local_key ??= $this::primaryKey()),
      foreign_table: $foreign_table,
      foreign_key: (array) ($foreign_key ??= $foreign_table::primaryKey()),
      pivot_table: $pivot_table,
      pivot_local_key: (array) ($pivot_local_key ?? $local_key),
      pivot_foreign_key: (array) ($pivot_foreign_key ?? $foreign_key)
    );

  }

  protected function hasManyThrough(
    string $foreign_table,
    string $pivot_table,
    string|array $foreign_key = null,
    string|array $local_key = null,
    string|array $pivot_foreign_key = null,
    string|array $pivot_local_key = null
  ): HasManyThrough
  {

    return new HasManyThrough(
      local_table: $this,
      local_key: (array) ($local_key ??= $this::primaryKey()),
      foreign_table: $foreign_table,
      foreign_key: (array) ($foreign_key ??= $foreign_table::primaryKey()),
      pivot_table: $pivot_table,
      pivot_local_key: (array) ($pivot_local_key ?? $local_key),
      pivot_foreign_key: (array) ($pivot_foreign_key ?? $foreign_key)
    );

  }

  public function addRelationship(
    string $name,
    Model|array $rows = null
  ): void
  {
    $this->relationships[$name] = $rows;
  }

}