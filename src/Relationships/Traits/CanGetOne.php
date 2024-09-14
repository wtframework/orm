<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships\Traits;

trait CanGetOne
{

  use CanGetMany;

  protected function getOne(): static
  {
    return $this->getMany()->limit(1)->top(1);
  }

}