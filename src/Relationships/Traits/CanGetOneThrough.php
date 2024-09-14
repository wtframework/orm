<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships\Traits;

trait CanGetOneThrough
{

  use CanGetManyThrough;

  protected function getOneThrough(): static
  {
    return $this->getManyThrough()->limit(1)->top(1);
  }

}