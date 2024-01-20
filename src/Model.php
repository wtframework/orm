<?php

declare(strict_types=1);

namespace WTFramework\ORM;

use WTFramework\ORM\Traits\CanQuery;
use WTFramework\ORM\Traits\IsModel;

abstract class Model
{
  use IsModel, CanQuery;
}