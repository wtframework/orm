<?php

declare(strict_types=1);

use Test\Test;
use WTFramework\ORM\Query;

it('can query model', function ()
{

  $query = Test::distinct();

  expect($query)
  ->toBeInstanceOf(Query::class);

  expect((string) $query)
  ->toBe("SELECT DISTINCT * FROM tests");

});

it('can query model and chain methods', function ()
{

  $query = Test::distinct()
  ->column('test_id');

  expect((string) $query)
  ->toBe("SELECT DISTINCT test_id FROM tests");

});

it('can query model and get result', function ()
{

  create('tests', 'test_id');

  insert('tests', [1]);

  create('t3s', 'test_id');

  $test = Test::where('test_id', 1)->get();

  expect($test)
  ->toBeInstanceOf(Test::class);

  expect($test->test_id)
  ->toEqual(1);

});

it('can query model and get array of results', function ()
{

  create('tests', 'test_id');

  insert('tests', [[1], [2]]);

  create('t3s', 'test_id');

  $tests = Test::orderBy('test_id')->all();

  expect($tests)
  ->toBeArray();

  foreach ($tests as $i => $test)
  {

    expect($test)
    ->toBeInstanceOf(Test::class);

    expect($test->test_id)
    ->toEqual($i + 1);

  }

});