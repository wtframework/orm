<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships;

use WTFramework\ORM\Model;
use WTFramework\ORM\Query;

abstract class Relationship extends Query
{

  public const LOAD = null;
  protected bool $lazyLoaded = false;

  public function __construct(
    public readonly Model $local_table,
    public readonly array $local_key,
    public readonly string $foreign_table,
    public readonly array $foreign_key
  )
  {
    parent::__construct($foreign_table::select(), $foreign_table);
  }

  abstract public function lazyWhere(): static;

  public function load(): Model|array
  {
    return $this->lazyWhere()->{static::LOAD}();
  }

  public function __toString(): string
  {
    return (string) $this->lazyWhere()->stmt;
  }

}