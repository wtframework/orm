<?php

declare(strict_types=1);

use Test\Test;
use WTFramework\DBAL\Connection;
use WTFramework\DBAL\DB;
use WTFramework\DBAL\Statements\Delete;
use WTFramework\DBAL\Statements\Insert;
use WTFramework\DBAL\Statements\Replace;
use WTFramework\DBAL\Statements\Select;
use WTFramework\DBAL\Statements\Truncate;
use WTFramework\DBAL\Statements\Update;
use WTFramework\ORM\Model;
use WTFramework\ORM\ModelNotFoundException;

it('can instantiate new model', function ()
{

  $test = new Test($data = (object) ['test_id' => 1]);

  expect($test)
  ->toBeInstanceOf(Model::class);

  expect($test->data())
  ->toEqual($data);

});

it('can get column value', function ()
{

  $test = new Test($data = (object) ['test_id' => 1]);

  expect($test->test_id)
  ->toBe($data->test_id);

});

it('can set column value', function ()
{

  $test = new Test;

  $test->test_id = 1;

  expect($test->data()->test_id)
  ->toBe($test->test_id);

});

it('can get record', function ()
{

  create('tests', 'test_id');

  insert('tests', [1]);

  $test = Test::get(1);

  expect($test->exists())
  ->toBeTrue();

  expect($test->test_id)
  ->toBe(1);

});

it('can fail to get record', function ()
{

  create('tests', 'test_id');

  $test = Test::get(1);

  expect($test->exists())
  ->toBeFalse();

});

it('can require record', function ()
{

  create('tests', 'test_id');

  insert('tests', [1]);

  $test = Test::require(1);

  expect($test->exists())
  ->toBeTrue();

  expect($test->test_id)
  ->toBe(1);

});

it('can fail to require record', function ()
{

  create('tests', 'test_id');

  Test::require(1);

})
->throws(ModelNotFoundException::class);

it('can get connection', function ()
{

  expect(Test::connection())
  ->toBeInstanceOf(Connection::class);

});

it('can get delete statement', function ()
{

  $stmt = Test::delete();

  expect($stmt)
  ->toBeInstanceOf(Delete::class);

  expect((string) $stmt)
  ->toBe("DELETE FROM tests");

});

it('can get insert statement', function ()
{

  $stmt = Test::insert();

  expect($stmt)
  ->toBeInstanceOf(Insert::class);

  expect((string) $stmt)
  ->toBe("INSERT INTO tests DEFAULT VALUES");

});

it('can get replace statement', function ()
{

  $stmt = Test::replace();

  expect($stmt)
  ->toBeInstanceOf(Replace::class);

  expect((string) $stmt)
  ->toBe("REPLACE INTO tests DEFAULT VALUES");

});

it('can get select statement', function ()
{

  $stmt = Test::select();

  expect($stmt)
  ->toBeInstanceOf(Select::class);

  expect((string) $stmt)
  ->toBe("SELECT * FROM tests");

});

it('can get truncate statement', function ()
{

  $stmt = Test::truncate();

  expect($stmt)
  ->toBeInstanceOf(Truncate::class);

  expect((string) $stmt)
  ->toBe("TRUNCATE TABLE tests");

});

it('can get update statement', function ()
{

  $stmt = Test::update();

  expect($stmt)
  ->toBeInstanceOf(Update::class);

  expect((string) $stmt)
  ->toBe("UPDATE tests");

});

it('can create record', function ()
{

  create('tests', 'test_id');

  $test = Test::create(['test_id' => 1]);

  expect($test)
  ->toBeInstanceOf(Test::class);

  expect($test->test_id)
  ->toBe(1);

  $test = DB::select()
  ->from('tests')
  ->where('test_id', 1)
  ->get();

  expect($test)
  ->toEqual((object) [
    'test_id' => 1,
  ]);

});

it('can save record', function ()
{

  createWithName('tests', 'test_id');

  insert('tests', [1, '']);

  $test = Test::get(1);

  $test->save(['name' => 'test1']);

  expect(DB::select()->from('tests')->all())
  ->toEqual([(object) [
    'test_id' => 1,
    'name' => 'test1',
  ]]);

  $test->name = 'test2';

  $test->save();

  expect(DB::select()->from('tests')->all())
  ->toEqual([(object) [
    'test_id' => 1,
    'name' => 'test2',
  ]]);


});

it('can get fresh record', function ()
{

  createWithName('tests', 'test_id');

  insert('tests', [1, '']);

  $test = Test::get(1);

  $test->name = 'test';

  $fresh = $test->fresh();

  expect($fresh)
  ->toBeInstanceOf(Test::class);

  expect($test->name)
  ->toBe('test');

  expect($fresh->name)
  ->toBe('');

});

it('can require fresh record', function ()
{

  createWithName('tests', 'test_id');

  insert('tests', [1, '']);

  $test = Test::get(1);

  $test->name = 'test';

  $fresh = $test->fresh(require: true);

  expect($fresh)
  ->toBeInstanceOf(Test::class);

  expect($test->name)
  ->toBe('test');

  expect($fresh->name)
  ->toBe('');

});

it('can fail to require fresh record', function ()
{

  createWithName('tests', 'test_id');

  insert('tests', [1, '']);

  $test = Test::get(1);

  $test->test_id = 2;

  $test->fresh(require: true);

})
->throws(ModelNotFoundException::class);

it('can refresh record', function ()
{

  createWithName('tests', 'test_id');

  insert('tests', [1, '']);

  $test = Test::get(1);

  $test->name = 'test';

  $test->refresh();

  expect($test->name)
  ->toBe('');

});

it('can require refreshed record', function ()
{

  createWithName('tests', 'test_id');

  insert('tests', [1, '']);

  $test = Test::get(1);

  $test->name = 'test';

  $test->refresh(require: true);

  expect($test->name)
  ->toBe('');

});

it('can fail to require refreshed record', function ()
{

  createWithName('tests', 'test_id');

  insert('tests', [1, '']);

  $test = Test::get(1);

  $test->test_id = 2;

  $test->refresh(require: true);

})
->throws(ModelNotFoundException::class);