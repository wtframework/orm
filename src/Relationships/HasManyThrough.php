<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships;

use WTFramework\ORM\Model;
use WTFramework\SQL\Services\On;

class HasManyThrough extends Relationship
{

  public const LOAD = 'all';

  public function __construct(
    Model $local_table,
    array $local_key,
    string $foreign_table,
    array $foreign_key,
    public readonly string $pivot_table,
    public readonly array $pivot_local_key,
    public readonly array $pivot_foreign_key
  )
  {
    parent::__construct($local_table, $local_key, $foreign_table, $foreign_key);
  }

  public function lazyWhere(): static
  {

    if ($this->lazyLoaded)
    {
      return $this;
    }

    $this->lazyLoaded = true;

    $foreign_table = $this->foreign_table::table();
    $pivot_table = $this->pivot_table::table();

    $this->column("$foreign_table.*");

    $this->join($pivot_table, function (On $on) use ($foreign_table, $pivot_table)
    {

      foreach ($this->foreign_key as $i => $column)
      {
        $on->on("$foreign_table.$column", "$pivot_table.{$this->pivot_foreign_key[$i]}");
      }

    });

    foreach ($this->pivot_local_key as $i => $column)
    {
      $this->where("$pivot_table.$column", $this->local_table->{$this->local_key[$i]});
    }

    return $this;

  }

}