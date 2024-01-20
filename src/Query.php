<?php

declare(strict_types=1);

namespace WTFramework\ORM;

use BadMethodCallException;
use Closure;
use WTFramework\DBAL\Statements\Select;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Services\Outfile;

/**
 * @method Query distinct()
 * @method Query explain()
 * @method Query explainQueryPlan()
 * @method Query explainExtended()
 * @method Query explainPartitions()
 * @method Query explainFormatJSON()
 * @method Query analyze()
 * @method Query analyzeFormatJSON()
 * @method Query column(string|int|HasBindings|array $column)
 * @method Query fetchRows(int|HasBindings $rows)
 * @method Query fetchRowsWithTies(int|HasBindings $rows)
 * @method Query forKeyShare(string|array $table = [])
 * @method Query forKeyShareNoWait(string|array $table = [])
 * @method Query forKeyShareSkipLocked(string|array $table = [])
 * @method Query forNoKeyUpdate(string|array $table = [])
 * @method Query forNoKeyUpdateNoWait(string|array $table = [])
 * @method Query forNoKeyUpdateSkipLocked(string|array $table = [])
 * @method Query forShare(string|array $table = [])
 * @method Query forShareNoWait(string|array $table = [])
 * @method Query forShareSkipLocked(string|array $table = [])
 * @method Query forUpdate(string|array $table = [])
 * @method Query forUpdateWait(int $wait)
 * @method Query forUpdateNoWait(string|array $table = [])
 * @method Query forUpdateSkipLocked(string|array $table = [])
 * @method Query from(string|HasBindings|array $table)
 * @method Query groupBy(string|HasBindings|array $column)
 * @method Query groupByDesc(string|HasBindings|array $column)
 * @method Query withRollup()
 * @method Query having(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query orHaving(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query havingNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query orHavingNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query havingExists(string|HasBindings $subquery)
 * @method Query orHavingExists(string|HasBindings $subquery)
 * @method Query havingNotExists(string|HasBindings $subquery)
 * @method Query orHavingNotExists(string|HasBindings $subquery)
 * @method Query highPriority()
 * @method Query into(string|HasBindings|array $table)
 * @method Query intoDumpfile(string $path)
 * @method Query intoOutfile(string|Outfile $path)
 * @method Query intoVar(string|array $into_vars)
 * @method Query join(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query leftJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query rightJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query fullJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query crossJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query straightJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query naturalJoin(string|HasBindings|array $table)
 * @method Query naturalLeftJoin(string|HasBindings|array $table)
 * @method Query naturalRightJoin(string|HasBindings|array $table)
 * @method Query naturalFullJoin(string|HasBindings|array $table)
 * @method Query limit(int|HasBindings $limit)
 * @method Query lockInShareMode()
 * @method Query lockInShareModeWait(int $wait)
 * @method Query lockInShareModeNoWait()
 * @method Query lockInShareModeSkipLocked()
 * @method Query offset(int|HasBindings $offset)
 * @method Query offsetRows(int|HasBindings $rows)
 * @method Query orderBy(string|HasBindings|array $column)
 * @method Query orderByDesc(string|HasBindings|array $column)
 * @method Query orderByUsing(string|HasBindings|array $column)
 * @method Query orderByNullsFirst(string|HasBindings|array $column)
 * @method Query orderByNullsLast(string|HasBindings|array $column)
 * @method Query orderByDescNullsFirst(string|HasBindings|array $column)
 * @method Query orderByDescNullsLast(string|HasBindings|array $column)
 * @method Query orderByUsingNullsFirst(string|HasBindings|array $column, string $operator)
 * @method Query orderByUsingNullsLast(string|HasBindings|array $column, string $operator)
 * @method Query procedureAnalyse(int $max_elements = null, int $max_memory = null)
 * @method Query rowsExamined(int|string|HasBindings $rows_examined)
 * @method Query union(string|HasBindings|array $stmt)
 * @method Query unionAll(string|HasBindings|array $stmt)
 * @method Query intersect(string|HasBindings|array $stmt)
 * @method Query intersectAll(string|HasBindings|array $stmt)
 * @method Query except(string|HasBindings|array $stmt)
 * @method Query exceptAll(string|HasBindings|array $stmt)
 * @method Query setStatement(string|array $variable, int|string $value = null)
 * @method Query sqlBigResult()
 * @method Query sqlBufferResult()
 * @method Query sqlCache()
 * @method Query sqlNoCache()
 * @method Query sqlCalcFoundRows()
 * @method Query sqlSmallResult()
 * @method Query straightJoinAll()
 * @method Query top(int|string|HasBindings $expression)
 * @method Query topPercent(int|string|HasBindings $expression)
 * @method Query topWithTies(int|string|HasBindings $expression)
 * @method Query topPercentWithTies(int|string|HasBindings $expression)
 * @method Query values(array $values)
 * @method Query when(mixed $condition, Closure $if_true, Closure $if_false = null)
 * @method Query where(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query orWhere(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query whereNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query orWhereNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method Query whereExists(string|HasBindings $subquery)
 * @method Query orWhereExists(string|HasBindings $subquery)
 * @method Query whereNotExists(string|HasBindings $subquery)
 * @method Query orWhereNotExists(string|HasBindings $subquery)
 * @method Query whereCurrentOf(string $cursor_name)
 * @method Query window(string|array $name, string|HasBindings $spec = null)
 * @method Query with(string|HasBindings|array $cte)
 * @method Query withRecursive(string|HasBindings|array $cte)
 */
class Query
{

  public function __construct(
    public readonly Select $stmt,
    public readonly string $model
  ) {}

  private function unprepared(): void {}
  private function prepare(): void {}
  private function execute(): void {}

  public function get(): Model
  {

    $row = new $this->model(
      data: ($exists = $this->stmt->get()) ?: [],
      exists: !!$exists
    );

    return $row;

  }

  public function all(): array
  {

    $rows = [];

    foreach ($this->stmt->all() as $data)
    {
      $rows[] = new $this->model($data, exists: true);
    }

    return $rows;

  }

  public function __call(
    string $name,
    array $arguments
  ): static
  {

    if (method_exists($this, $name))
    {
      throw new BadMethodCallException;
    }

    $this->stmt->$name(...$arguments);

    return $this;

  }

  public function __toString(): string
  {
    return (string) $this->stmt;
  }

}