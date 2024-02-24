<?php

declare(strict_types=1);

namespace Test;

use WTFramework\ORM\Model;
use WTFramework\ORM\Relationships\BelongsTo;
use WTFramework\ORM\Relationships\Has;
use WTFramework\ORM\Relationships\HasMany;

class Test extends Model
{

  public function t1(
    string|array $local_key = null,
    string|array $foreign_key = null
  ): BelongsTo
  {
    return $this->belongsTo(T1::class, $local_key, $foreign_key);
  }

  public function t2(
    string|array $foreign_key = null,
    string|array $local_key = null
  ): Has
  {
    return $this->has(T2::class, $foreign_key, $local_key);
  }

  public function t3(
    string|array $foreign_key = null,
    string|array $local_key = null
  ): HasMany
  {
    return $this->hasMany(T3::class, $foreign_key, $local_key);
  }

}