<?php

declare(strict_types=1);

namespace WTFramework\ORM\Traits;

use WTFramework\ORM\Query;
use WTFramework\SQL\Interfaces\HasBindings;
use WTFramework\SQL\Services\Outfile;

/**
 * @method static Query distinct()
 * @method static Query explain()
 * @method static Query explainQueryPlan()
 * @method static Query explainExtended()
 * @method static Query explainPartitions()
 * @method static Query explainFormatJSON()
 * @method static Query analyze()
 * @method static Query analyzeFormatJSON()
 * @method static Query column(string|int|HasBindings|array $column)
 * @method static Query fetchRows(int|HasBindings $rows)
 * @method static Query fetchRowsWithTies(int|HasBindings $rows)
 * @method static Query forKeyShare(string|array $table = [])
 * @method static Query forKeyShareNoWait(string|array $table = [])
 * @method static Query forKeyShareSkipLocked(string|array $table = [])
 * @method static Query forNoKeyUpdate(string|array $table = [])
 * @method static Query forNoKeyUpdateNoWait(string|array $table = [])
 * @method static Query forNoKeyUpdateSkipLocked(string|array $table = [])
 * @method static Query forShare(string|array $table = [])
 * @method static Query forShareNoWait(string|array $table = [])
 * @method static Query forShareSkipLocked(string|array $table = [])
 * @method static Query forUpdate(string|array $table = [])
 * @method static Query forUpdateWait(int $wait)
 * @method static Query forUpdateNoWait(string|array $table = [])
 * @method static Query forUpdateSkipLocked(string|array $table = [])
 * @method static Query from(string|HasBindings|array $table)
 * @method static Query groupBy(string|HasBindings|array $column)
 * @method static Query groupByDesc(string|HasBindings|array $column)
 * @method static Query withRollup()
 * @method static Query having(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query orHaving(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query havingNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query orHavingNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query havingExists(string|HasBindings $subquery)
 * @method static Query orHavingExists(string|HasBindings $subquery)
 * @method static Query havingNotExists(string|HasBindings $subquery)
 * @method static Query orHavingNotExists(string|HasBindings $subquery)
 * @method static Query havingRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query orHavingRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query havingNotRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query orHavingNotRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query highPriority()
 * @method static Query into(string|HasBindings|array $table)
 * @method static Query intoDumpfile(string $path)
 * @method static Query intoOutfile(string|Outfile $path)
 * @method static Query intoVar(string|array $into_vars)
 * @method static Query join(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query leftJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query rightJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query fullJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query crossJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query straightJoin(string|HasBindings|array $table, string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query naturalJoin(string|HasBindings|array $table)
 * @method static Query naturalLeftJoin(string|HasBindings|array $table)
 * @method static Query naturalRightJoin(string|HasBindings|array $table)
 * @method static Query naturalFullJoin(string|HasBindings|array $table)
 * @method static Query limit(int|HasBindings $limit)
 * @method static Query lockInShareMode()
 * @method static Query lockInShareModeWait(int $wait)
 * @method static Query lockInShareModeNoWait()
 * @method static Query lockInShareModeSkipLocked()
 * @method static Query offset(int|HasBindings $offset)
 * @method static Query offsetRows(int|HasBindings $rows)
 * @method static Query orderBy(string|HasBindings|array $column)
 * @method static Query orderByDesc(string|HasBindings|array $column)
 * @method static Query orderByUsing(string|HasBindings|array $column)
 * @method static Query orderByNullsFirst(string|HasBindings|array $column)
 * @method static Query orderByNullsLast(string|HasBindings|array $column)
 * @method static Query orderByDescNullsFirst(string|HasBindings|array $column)
 * @method static Query orderByDescNullsLast(string|HasBindings|array $column)
 * @method static Query orderByUsingNullsFirst(string|HasBindings|array $column, string $operator)
 * @method static Query orderByUsingNullsLast(string|HasBindings|array $column, string $operator)
 * @method static Query procedureAnalyse(int $max_elements = null, int $max_memory = null)
 * @method static Query rowsExamined(int|string|HasBindings $rows_examined)
 * @method static Query union(string|HasBindings|array $stmt)
 * @method static Query unionAll(string|HasBindings|array $stmt)
 * @method static Query intersect(string|HasBindings|array $stmt)
 * @method static Query intersectAll(string|HasBindings|array $stmt)
 * @method static Query except(string|HasBindings|array $stmt)
 * @method static Query exceptAll(string|HasBindings|array $stmt)
 * @method static Query setStatement(string|array $variable, int|string $value = null)
 * @method static Query sqlBigResult()
 * @method static Query sqlBufferResult()
 * @method static Query sqlCache()
 * @method static Query sqlNoCache()
 * @method static Query sqlCalcFoundRows()
 * @method static Query sqlSmallResult()
 * @method static Query straightJoinAll()
 * @method static Query top(int|string|HasBindings $expression)
 * @method static Query topPercent(int|string|HasBindings $expression)
 * @method static Query topWithTies(int|string|HasBindings $expression)
 * @method static Query topPercentWithTies(int|string|HasBindings $expression)
 * @method static Query values(array $values)
 * @method static Query when(mixed $condition, Closure $if_true, Closure $if_false = null)
 * @method static Query where(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query orWhere(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query whereNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query orWhereNot(string|int|HasBindings|Closure|array $column = null, string|int|array|HasBindings $operator = null, string|int|array|HasBindings $value = null)
 * @method static Query whereExists(string|HasBindings $subquery)
 * @method static Query orWhereExists(string|HasBindings $subquery)
 * @method static Query whereNotExists(string|HasBindings $subquery)
 * @method static Query orWhereNotExists(string|HasBindings $subquery)
 * @method static Query whereRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query orWhereRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query whereNotRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query orWhereNotRaw(string $condition, string|int|float|array $bindings = [])
 * @method static Query whereCurrentOf(string $cursor_name)
 * @method static Query window(string|array $name, string|HasBindings $spec = null)
 * @method static Query with(string|HasBindings|array $cte)
 * @method static Query withRecursive(string|HasBindings|array $cte)
 * @method static array all()
 */
trait CanQuery
{

  use ExtendsDB;

  public static function query(): Query
  {
    return new Query(static::select(), static::class);
  }

  public static function __callStatic(
    string $name,
    array $arguments
  ): mixed
  {
    return static::query()->$name(...$arguments);
  }

}