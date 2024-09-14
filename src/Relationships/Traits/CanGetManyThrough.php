<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships\Traits;

use WTFramework\SQL\Services\On;

trait CanGetManyThrough
{

  protected function getManyThrough(): static
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