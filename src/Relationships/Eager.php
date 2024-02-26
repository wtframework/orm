<?php

declare(strict_types=1);

namespace WTFramework\ORM\Relationships;

use WTFramework\ORM\Model;

class Eager
{

  protected array $eager = [];
  protected array $lazy = [];
  protected array $relationships = [];

  public function __construct(string $model)
  {
    $this->add($model::EAGER);
  }

  public function add(string|array $relationship): void
  {

    foreach ((array) $relationship as $name)
    {
      $this->eager[] = $name;
    }

  }

  public function lazy(string|array $relationship): void
  {

    foreach ((array) $relationship as $name)
    {
      $this->lazy[] = $name;
    }

  }

  public function load(array $rows): void
  {

    if (empty($rows))
    {
      return;
    }

    foreach (array_unique(array_diff($this->eager, $this->lazy)) as $name)
    {

      $name = strtok($name, '.');

      if (!isset($this->relationships[$name]))
      {
        $this->loadRelationship($name, $rows);
      }

    }

  }

  protected function loadRelationship(
    string $name,
    array $rows
  ): void
  {

    $relationship = $rows[0]->$name();

    $local_keys = $this->localKeys($relationship, $rows);

    foreach ($this->all($relationship, $local_keys) as $row)
    {
      $this->store($name, $relationship, $row);
    }

    foreach ($rows as $row)
    {
      $this->addRelationship($name, $relationship, $row);
    }

  }

  protected function localKeys(
    Relationship $relationship,
    array $rows
  ): array
  {

    foreach ($rows as $i => $row)
    {

      if (1 == count($relationship->local_key))
      {
        $local_keys[] = $row->{$relationship->local_key[0]};
      }

      else
      {

        foreach ($relationship->local_key as $key)
        {
          $local_keys[$i][] = $row->$key;
        }

      }

    }

    return $local_keys;

  }

  protected function all(
    Relationship $relationship,
    array $local_keys
  ): array
  {

    if ($eager = strtok(''))
    {
      $relationship->eager($eager);
    }

    if (1 == count($relationship->foreign_key))
    {
      $relationship->where($relationship->eagerKey(), $local_keys);
    }

    else
    {

      foreach ($local_keys as $keys)
      {

        $relationship->orWhere(function ($stmt) use ($keys, $relationship)
        {

          foreach ($keys as $i => $key)
          {
            $stmt->where($relationship->eagerKey($i), $key);
          }

        });

      }

    }

    return $relationship->all();

  }

  protected function store(
    string $name,
    Relationship $relationship,
    Model $row
  ): void
  {

    foreach ($relationship->foreign_key as $foreign_key)
    {
      $key[] = $row->{$foreign_key};
    }

    $key = implode('-', $key);

    if ($relationship instanceof HasMany)
    {
      $this->relationships[$name][$key][] = $row;
    }

    else
    {
      $this->relationships[$name][$key] = $row;
    }

  }

  public function addRelationship(
    string $name,
    Relationship $relationship,
    Model $row
  ): void
  {

    foreach ($relationship->local_key as $local_key)
    {
      $key[] = $row->{$local_key};
    }

    $default = $relationship instanceof HasMany ? [] : new $relationship->foreign_table;

    $row->addRelationship(
      $name,
      $this->relationships[$name][implode('-', $key)] ?? $default
    );

  }

}