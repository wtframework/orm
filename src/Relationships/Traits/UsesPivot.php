<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships\Traits;

use WTFramework\ORM\Model;

trait UsesPivot
{

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

}