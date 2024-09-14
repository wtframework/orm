<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships;

use WTFramework\ORM\Relationships\Traits\CanGetOneThrough;
use WTFramework\ORM\Relationships\Traits\UsesPivot;

class HasThrough extends Relationship
{

  public const LOAD = 'get';

  use UsesPivot;
  use CanGetOneThrough;

  public function lazyWhere(): static
  {
    return $this->getOneThrough();
  }

}