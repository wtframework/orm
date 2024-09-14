<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships;

use WTFramework\ORM\Relationships\Traits\CanGetMany;

class HasMany extends Relationship
{

  public const LOAD = 'all';

  use CanGetMany;

  public function lazyWhere(): static
  {
    return $this->getMany();
  }

}