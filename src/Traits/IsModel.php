<?php

declare(strict_types=1);

namespace WTFramework\ORM\Traits;

use stdClass;
use WTFramework\ORM\ModelNotFoundException;
use WTFramework\ORM\Relationships\Relationship;

trait IsModel
{

  use ExtendsDB;
  use HasRelationships;

  public const SEQUENCE_NAME = null;

  protected stdClass $data;
  protected array $cache = [];

  public function __construct(
    stdClass|array $data = [],
    protected bool $exists = false
  )
  {
    $this->data = (object) $data;
  }

  public function exists(): bool
  {
    return $this->exists;
  }

  public function data(): stdClass
  {
    return $this->data;
  }

  public static function get(int|string|array $primary_key): static
  {

    $record = static::select()->where(array_combine(
      (array) static::primaryKey(),
      (array) $primary_key
    ))->get();

    return new static($record ?: [], !!$record);

  }

  public static function require(int|string|array $primary_key): static
  {

    $model = static::get(primary_key: $primary_key);

    if (!$model->exists)
    {
      throw new ModelNotFoundException;
    }

    return $model;

  }

  public static function create(stdClass|array $data = []): static
  {

    $model = new static;

    foreach ((array) $data as $column => $value)
    {
      $model->$column = $value;
    }

    return $model->saveInsert();

  }

  public function save(stdClass|array $data = []): static
  {

    foreach ((array) $data as $column => $value)
    {
      $this->$column = $value;
    }

    return $this->exists ? $this->saveUpdate() : $this->saveInsert();

  }

  protected function saveInsert(): static
  {

    $stmt = static::insert();

    if ($data = (array) $this->data)
    {

      $stmt->column(array_keys($data));

      $stmt->values($data);

    }

    $stmt->execute();

    if (
      is_string($primary_key = static::primaryKey())
      &&
      !isset($this->data->$primary_key)
    )
    {

      $this->data->$primary_key = static::connection()
      ->insertID(static::SEQUENCE_NAME);

    }

    return $this->refresh(require: true);

  }

  protected function saveUpdate(): static
  {

    $stmt = static::update();

    $primary_key = (array) static::primaryKey();

    foreach ($this->data as $column => $value)
    {

      if (in_array($column, $primary_key))
      {
        $stmt->where($column, $value);
      }

      else
      {
        $stmt->set($column, $value);
      }

    }

    $stmt->execute();

    return $this;

  }

  public function fresh(bool $require = false): static
  {

    $primary_key = [];

    foreach ((array) static::primaryKey() as $column)
    {
      $primary_key[$column] = $this->data->$column ?? null;
    }

    return static::{$require ? 'require' : 'get'}($primary_key);

  }

  public function refresh(bool $require = false): static
  {

    foreach ($this->fresh($require)->data as $column => $value)
    {
      $this->data->$column = $value;
    }

    return $this;

  }

  public function clearCache(): static
  {

    $this->cache = [];

    return $this;

  }

  protected function methodName(string $name): string
  {

    return lcfirst(
      str_replace(' ', '', ucwords(
        str_replace('_', ' ', $name)
      ))
    );

  }

  public function __set(
    string $name,
    mixed $value
  ): void
  {

    $method_name = $this->methodName($name);

    if (!is_callable([$this, $method_name]))
    {
      $this->data->$name = $value;
    }

  }

  public function __get(string $name): mixed
  {

    $method_name = $this->methodName($name);

    if (!is_callable([$this, $method_name]))
    {
      return $this->data->$name ?? null;
    }

    if (!isset($this->cache[$method_name]))
    {
      $response = $this->$method_name();
    }

    return $this->cache[$method_name] ??= match (true)
    {

      $response instanceof Relationship,
        => $this->relationships[$method_name] ?? $response->load(),

      default
        => $response,

    };

  }

}