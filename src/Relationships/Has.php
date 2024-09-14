<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships;

use WTFramework\ORM\Relationships\Traits\CanGetOne;

class Has extends Relationship
{

  public const LOAD = 'get';

  use CanGetOne;

  public function lazyWhere(): static
  {
    return $this->getOne();
  }

}