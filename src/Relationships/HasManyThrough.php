<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships;

use WTFramework\ORM\Relationships\Traits\CanGetManyThrough;
use WTFramework\ORM\Relationships\Traits\UsesPivot;

class HasManyThrough extends Relationship
{

  public const LOAD = 'all';

  use UsesPivot;
  use CanGetManyThrough;

  public function lazyWhere(): static
  {
    return $this->getManyThrough();
  }

}