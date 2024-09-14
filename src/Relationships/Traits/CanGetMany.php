<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships\Traits;

trait CanGetMany
{

  protected function getMany(): static
  {

    if ($this->lazyLoaded)
    {
      return $this;
    }

    $this->lazyLoaded = true;

    foreach ($this->foreign_key as $i => $column)
    {
      $this->where($column, $this->local_table->{$this->local_key[$i]});
    }

    return $this;

  }

}