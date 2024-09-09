<?php

declare(strict_types=1);

use Test\T1;
use Test\T2;
use Test\T3;
use Test\Test;
use WTFramework\DBAL\DB;
use WTFramework\ORM\Relationships\BelongsTo;
use WTFramework\ORM\Relationships\Has;
use WTFramework\ORM\Relationships\HasMany;
use WTFramework\ORM\Relationships\HasManyThrough;

it('can get belongs to relationship', function ()
{

  $test = Test::require(1);

  $test->t1_id = 2;

  $belongs_to = $test->t1();

  expect($belongs_to)
  ->toBeInstanceOf(BelongsTo::class);

  expect((string) $belongs_to)
  ->toBe("SELECT * FROM t1s WHERE t1_id = 2 LIMIT 1");

});

it('can get belongs to relationship overriding local key', function ()
{

  $test = Test::require(1);

  $test->id = 2;

  $belongs_to = $test->t1(local_key: 'id');

  expect($belongs_to)
  ->toBeInstanceOf(BelongsTo::class);

  expect((string) $belongs_to)
  ->toBe("SELECT * FROM t1s WHERE t1_id = 2 LIMIT 1");

});

it('can get belongs to relationship overriding foreign key', function ()
{

  $test = Test::require(1);

  $test->t1_id = 2;

  $belongs_to = $test->t1(foreign_key: 'id');

  expect($belongs_to)
  ->toBeInstanceOf(BelongsTo::class);

  expect((string) $belongs_to)
  ->toBe("SELECT * FROM t1s WHERE id = 2 LIMIT 1");

});

it('can get belongs to relationship result', function ()
{

  create('t1s', 't1_id');

  insert('t1s', [2]);

  $test = Test::require(1);

  $test->t1_id = 2;

  expect($t1 = $test->t1)
  ->toBeInstanceOf(T1::class);

  expect($t1->t1_id)
  ->toBe(2);

});

it('can get has relationship', function ()
{

  $test = Test::require(1);

  $has = $test->t2();

  expect($has)
  ->toBeInstanceOf(Has::class);

  expect((string) $has)
  ->toBe("SELECT * FROM t2s WHERE test_id = 1 LIMIT 1");

});

it('can get has relationship overriding local key', function ()
{

  $test = Test::require(1);

  $test->id = 2;

  $has = $test->t2(local_key: 'id');

  expect($has)
  ->toBeInstanceOf(Has::class);

  expect((string) $has)
  ->toBe("SELECT * FROM t2s WHERE test_id = 2 LIMIT 1");

});

it('can get has relationship overriding foreign key', function ()
{

  $test = Test::require(1);

  $has = $test->t2(foreign_key: 'id');

  expect($has)
  ->toBeInstanceOf(Has::class);

  expect((string) $has)
  ->toBe("SELECT * FROM t2s WHERE id = 1 LIMIT 1");

});

it('can get has relationship result', function ()
{

  create('t2s', 'test_id');

  insert('t2s', [1]);

  $test = Test::require(1);

  expect($t2 = $test->t2)
  ->toBeInstanceOf(T2::class);

  expect($t2->test_id)
  ->toBe(1);

});

it('can get has many relationship', function ()
{

  $test = Test::require(1);

  $has_many = $test->t3();

  expect($has_many)
  ->toBeInstanceOf(HasMany::class);

  expect((string) $has_many)
  ->toBe("SELECT * FROM t3s WHERE test_id = 1");

});

it('can get has many relationship overriding local key', function ()
{

  $test = Test::require(1);

  $test->id = 2;

  $has_many = $test->t3(local_key: 'id');

  expect($has_many)
  ->toBeInstanceOf(HasMany::class);

  expect((string) $has_many)
  ->toBe("SELECT * FROM t3s WHERE test_id = 2");

});

it('can get has many relationship overriding foreign key', function ()
{

  $test = Test::require(1);

  $has_many = $test->t3(foreign_key: 'id');

  expect($has_many)
  ->toBeInstanceOf(HasMany::class);

  expect((string) $has_many)
  ->toBe("SELECT * FROM t3s WHERE id = 1");

});

it('can get has many relationship result', function ()
{

  create('t3s', 'test_id');

  insert('t3s', [1]);

  $test = Test::require(1);

  expect($t3s = $test->t3)
  ->toBeArray();

  expect(count($t3s))
  ->toBe(1);

  expect($t3 = $t3s[0])
  ->toBeInstanceOf(T3::class);

  expect($t3->test_id)
  ->toBe(1);

});

it('can get has many through relationship', function ()
{

  $test = Test::require(1);

  $has_many_through = $test->pivot();

  expect($has_many_through)
  ->toBeInstanceOf(HasManyThrough::class);

  expect((string) $has_many_through)
  ->toBe("SELECT t3s.* FROM t3s JOIN pivots ON t3s.t3_id = pivots.t3_id WHERE pivots.test_id = 1");

});

it('can get has many through relationship overriding foreign key', function ()
{

  $test = Test::require(1);

  $has_many_through = $test->pivot(foreign_key: "id");

  expect($has_many_through)
  ->toBeInstanceOf(HasManyThrough::class);

  expect((string) $has_many_through)
  ->toBe("SELECT t3s.* FROM t3s JOIN pivots ON t3s.id = pivots.id WHERE pivots.test_id = 1");

});

it('can get has many through relationship overriding local key', function ()
{

  $test = Test::require(1);

  $test->id = 2;

  $has_many_through = $test->pivot(local_key: "id");

  expect($has_many_through)
  ->toBeInstanceOf(HasManyThrough::class);

  expect((string) $has_many_through)
  ->toBe("SELECT t3s.* FROM t3s JOIN pivots ON t3s.t3_id = pivots.t3_id WHERE pivots.id = 2");

});

it('can get has many through relationship overriding pivot foreign key', function ()
{

  $test = Test::require(1);

  $has_many_through = $test->pivot(pivot_foreign_key: "id");

  expect($has_many_through)
  ->toBeInstanceOf(HasManyThrough::class);

  expect((string) $has_many_through)
  ->toBe("SELECT t3s.* FROM t3s JOIN pivots ON t3s.t3_id = pivots.id WHERE pivots.test_id = 1");

});

it('can get has many through relationship overriding pivot local key', function ()
{

  $test = Test::require(1);

  $has_many_through = $test->pivot(pivot_local_key: "id");

  expect($has_many_through)
  ->toBeInstanceOf(HasManyThrough::class);

  expect((string) $has_many_through)
  ->toBe("SELECT t3s.* FROM t3s JOIN pivots ON t3s.t3_id = pivots.t3_id WHERE pivots.id = 1");

});

it('can get has many through relationship result', function ()
{

  create('t3s', 't3_id');

  insert('t3s', [[1], [2]]);

  createPivot('pivots', ['test_id', 't3_id']);

  insert('pivots', [[1, 1], [1, 2]]);

  $test = Test::require(1);

  expect($t3s = $test->pivot)
  ->toBeArray();

  expect(count($t3s))
  ->toBe(2);

  expect($t3 = $t3s[0])
  ->toBeInstanceOf(T3::class);

  expect($t3->t3_id)
  ->toBe(1);

  expect($t3 = $t3s[1])
  ->toBeInstanceOf(T3::class);

  expect($t3->t3_id)
  ->toBe(2);

});

it('can cache relationship result', function ()
{

  create('t3s', 'test_id');

  insert('t3s', [1]);

  $test = Test::require(1);

  $test->t3;

  create('t3s', 'test_id');

  $t3s = $test->t3;

  expect(count($t3s))
  ->toBe(1);

});

it('can clear cache', function ()
{

  create('t3s', 'test_id');

  insert('t3s', [1]);

  $test = Test::require(1);

  $test->t3;

  create('t3s', 'test_id');

  $test->clearCache();

  $t3s = $test->t3;

  expect(count($t3s))
  ->toBe(0);

});

it('can eager load relationships', function ()
{

  create('tests', 'test_id');

  insert('tests', [[1], [2]]);

  create('t2s', 'test_id');

  insert('t2s',  [[1], [2]]);

  create('t3s', 'test_id');

  insert('t3s',  [[1], [2]]);

  DB::clearLogs();

  foreach (Test::eager('t2')->all() as $test)
  {

    expect($test->t2->test_id)
    ->toBe($test->test_id);

  }

  expect(DB::logs())
  ->toBe([
    ["SELECT * FROM tests", []],
    ["SELECT * FROM t3s WHERE t3s.test_id IN (1, 2)", []],
    ["SELECT * FROM t2s WHERE t2s.test_id IN (1, 2)", []],
  ]);

});

it('can lazy load relationships', function ()
{

  create('tests', 'test_id');

  insert('tests', [[1], [2]]);

  create('t2s', 'test_id');

  insert('t2s',  [[1], [2]]);

  DB::clearLogs();

  foreach (Test::lazy('t3')->all() as $test)
  {

    expect($test->t2->test_id)
    ->toBe($test->test_id);

  }

  expect(DB::logs())
  ->toBe([
    ["SELECT * FROM tests", []],
    ["SELECT * FROM t2s WHERE test_id = 1 LIMIT 1", []],
    ["SELECT * FROM t2s WHERE test_id = 2 LIMIT 1", []],
  ]);

});