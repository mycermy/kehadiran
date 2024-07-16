<?php

namespace App\Traits\Metrics;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait Chartable_mod
{
    private $oldval;
    /**
     * Counts the values for model at the range and previous range.
     *
     * @param Builder $builder
     * @param string  $groupColumn
     *
     * @return GroupCollection
     */
    public function scopeCountForGroup(Builder $builder, string $groupColumn, string $prefixLabel = ''): GroupCollection
    {
        $group = $builder->select("$groupColumn as label", DB::raw("count(*) as val"))
            ->groupBy($groupColumn)
            ->orderBy('val', 'desc')
            ->get()
            ->map(function (Model $model) use($prefixLabel) {
                return $model->forceFill([
                    'label' => (string) $prefixLabel . $model->label,
                    'value' => (int) $model->val,
                ]);
            });

        return new GroupCollection($group);
    }
    public function scopeSumForGroup(Builder $builder, string $groupColumn, string $value): GroupCollection
    {
        $group = $builder->select("$groupColumn as label", DB::raw("sum($value) as val"))
            ->groupBy('label')
            ->orderBy('val', 'desc')
            ->get()
            ->map(function (Model $model) {
                return $model->forceFill([
                    'label' => (string) $model->label,
                    'value' => (int) $model->val,
                ]);
            });

        return new GroupCollection($group);
    }
    public function scopeChartForGroup(Builder $builder, string $value, string $rawFormat = 'M-Y'): GroupCollection
    {
        $group = $builder->selectRaw("$value as val")
            // ->groupBy('label')
            // ->orderBy('val', 'desc')
            ->get()
            ->map(function (Model $model) use($rawFormat) {
                return $model->forceFill([
                    'label' => (string) Carbon::parse($model->label)->rawFormat($rawFormat),
                    'value' => (int) $model->val,
                ]);
            });

        return new GroupCollection($group);
    }

    /**
     * @param Builder    $builder
     * @param string     $value
     * @param mixed|null $startDate
     * @param mixed|null $stopDate
     * @param string     $dateColumn
     *
     * @return TimeCollection
     */
    private function groupByMonths_salescat(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        $dateColumn = $dateColumn ?? 'prodout.created_at';
        $dayOneSales = $builder->getModel()->selectraw('DATE(created_at) as dayone')->orderBy('dayone')->first(); 
        $dayOneSalesDate = empty($dayOneSales) 
            ? Carbon::now()->firstOfQuarter()
            : Carbon::parse($dayOneSales->dayone)->firstOfMonth(); 
        // dd($dayOneSalesDate);

        $startDate = empty($startDate)
            ? $dayOneSalesDate
            : Carbon::parse($startDate);
            
        $startDate = $startDate->greaterThan($dayOneSalesDate)
            ? $startDate
            : $dayOneSalesDate;
        // dd($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()->endOfMonth()
            : Carbon::parse($stopDate);

        $query = $builder
            ->select(DB::raw("$value as val, DATE_FORMAT($dateColumn,'%Y-%m') as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $days = $startDate->diffInMonths($stopDate->firstOfMonth()) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->rawFormat('Y-m')
            );

            $result = [
                'value' => ($found ? $found->val : 0),
                // 'label' => $startDate->shortMonthName,
                'label' => $startDate->rawFormat('M-y'),
            ];

            $startDate->addMonth();

            return $result;
        });
    }

    private function groupByMonths(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        $dateColumn = $dateColumn ?? $builder->getModel()->getCreatedAtColumn();
        $dayOneSales = $builder->getModel()->selectraw('DATE(created_at) as dayone')->orderBy('dayone')->first(); 
        // dd($dayOneSales);
        $dayOneSalesDate = empty($dayOneSales) 
            ? Carbon::now()->firstOfQuarter() 
            : Carbon::parse($dayOneSales->dayone)->firstOfMonth(); 
        // dd($dayOneSalesDate);

        $startDate = empty($startDate)
            ? $dayOneSalesDate
            : Carbon::parse($startDate);
            // dd($startDate);
            
        $startDate = $startDate->greaterThan($dayOneSalesDate)
            ? $startDate
            : $dayOneSalesDate;
        // dd($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()->endOfMonth()
            : Carbon::parse($stopDate);
            // dd($stopDate);

        $query = $builder
            ->select(DB::raw("$value as val, DATE_FORMAT($dateColumn,'%Y-%m') as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $days = $startDate->diffInMonths($stopDate->firstOfMonth()) + 1;
        // dd([$startDate, $stopDate, $days, $query]);

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->rawFormat('Y-m')
            );

            $result = [
                'value' => ($found ? $found->val : 0),
                // 'label' => $startDate->shortMonthName,
                'label' => $startDate->rawFormat('M-y'),
                // 'label' => $startDate->rawFormat('Y-m'),
            ];

            $startDate->addMonth();

            return $result;
        });
    }

    private function groupByYears(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        $dateColumn = $dateColumn ?? $builder->getModel()->getCreatedAtColumn();
        $dayOneSales = $builder->getModel()->selectraw('DATE(created_at) as dayone')->orderBy('dayone')->first(); 
        $dayOneSalesDate = empty($dayOneSales) 
            ? Carbon::now()->firstOfYear() 
            : Carbon::parse($dayOneSales->dayone)->firstOfYear(); 
        // dd($dayOneSalesDate);

        $startDate = empty($startDate)
            ? $dayOneSalesDate
            : Carbon::parse($startDate);
            
        $startDate = $startDate->greaterThan($dayOneSalesDate)
            ? $startDate
            : $dayOneSalesDate;
        // dd($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()->endOfYear()
            : Carbon::parse($stopDate);
        // dd([$startDate,$stopDate]);

        $query = $builder
            ->select(DB::raw("$value as val, YEAR($dateColumn) as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $days = $startDate->diffInYears($stopDate->firstOfYear()) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->rawFormat('Y')
            );

            $result = [
                'value' => ($found ? $found->val : 0),
                // 'label' => $startDate->shortMonthName,
                'label' => $startDate->rawFormat('Y'),
            ];

            $startDate->addYear();

            return $result;
        });
    }

    /**
     * https://www.w3schools.com/sql/func_mysql_date_format.asp
     * Format 	Description
     *      %a 	Abbreviated weekday name (Sun to Sat)
     *      %b 	Abbreviated month name (Jan to Dec)
     *      %c 	Numeric month name (0 to 12)
     *      %D 	Day of the month as a numeric value, followed by suffix (1st, 2nd, 3rd, ...)
     *      %d 	Day of the month as a numeric value (01 to 31)
     *      %e 	Day of the month as a numeric value (0 to 31)
     *      %f 	Microseconds (000000 to 999999)
     *      %H 	Hour (00 to 23)
     *      %h 	Hour (00 to 12)
     *      %I 	Hour (00 to 12)
     *      %i 	Minutes (00 to 59)
     *      %j 	Day of the year (001 to 366)
     *      %k 	Hour (0 to 23)
     *      %l 	Hour (1 to 12)
     *      %M 	Month name in full (January to December)
     *      %m 	Month name as a numeric value (00 to 12)
     *      %p 	AM or PM
     *      %r 	Time in 12 hour AM or PM format (hh:mm:ss AM/PM)
     *      %S 	Seconds (00 to 59)
     *      %s 	Seconds (00 to 59)
     *      %T 	Time in 24 hour format (hh:mm:ss)
     *      %U 	Week where Sunday is the first day of the week (00 to 53)
     *      %u 	Week where Monday is the first day of the week (00 to 53)
     *      %V 	Week where Sunday is the first day of the week (01 to 53). Used with %X
     *      %v 	Week where Monday is the first day of the week (01 to 53). Used with %x
     *      %W 	Weekday name in full (Sunday to Saturday)
     *      %w 	Day of the week where Sunday=0 and Saturday=6
     *      %X 	Year for the week where Sunday is the first day of the week. Used with %V
     *      %x 	Year for the week where Monday is the first day of the week. Used with %v
     *      %Y 	Year as a numeric, 4-digit value
     *      %y 	Year as a numeric, 2-digit value
     * 
     * https://www.w3schools.com/php/func_date_date_format.asp
     * format 	Required. Specifies the format for the date. The following characters can be used:
     *
     *          d - The day of the month (from 01 to 31)
     *          D - A textual representation of a day (three letters)
     *          j - The day of the month without leading zeros (1 to 31)
     *          l (lowercase 'L') - A full textual representation of a day
     *          N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)
     *          S - The English ordinal suffix for the day of the month (2 characters st, nd, rd or th. Works well with j)
     *          w - A numeric representation of the day (0 for Sunday, 6 for Saturday)
     *          z - The day of the year (from 0 through 365)
     *          W - The ISO-8601 week number of year (weeks starting on Monday)
     *          F - A full textual representation of a month (January through December)
     *          m - A numeric representation of a month (from 01 to 12)
     *          M - A short textual representation of a month (three letters)
     *          n - A numeric representation of a month, without leading zeros (1 to 12)
     *          t - The number of days in the given month
     *          L - Whether it's a leap year (1 if it is a leap year, 0 otherwise)
     *          o - The ISO-8601 year number
     *          Y - A four digit representation of a year
     *          y - A two digit representation of a year
     *          a - Lowercase am or pm
     *          A - Uppercase AM or PM
     *          B - Swatch Internet time (000 to 999)
     *          g - 12-hour format of an hour (1 to 12)
     *          G - 24-hour format of an hour (0 to 23)
     *          h - 12-hour format of an hour (01 to 12)
     *          H - 24-hour format of an hour (00 to 23)
     *          i - Minutes with leading zeros (00 to 59)
     *          s - Seconds, with leading zeros (00 to 59)
     *          u - Microseconds (added in PHP 5.2.2)
     *          e - The timezone identifier (Examples: UTC, GMT, Atlantic/Azores)
     *          I (capital i) - Whether the date is in daylights savings time (1 if Daylight Savings Time, 0 otherwise)
     *          O - Difference to Greenwich time (GMT) in hours (Example: +0100)
     *          P - Difference to Greenwich time (GMT) in hours:minutes (added in PHP 5.1.3)
     *          T - Timezone abbreviations (Examples: EST, MDT)
     *          Z - Timezone offset in seconds. The offset for timezones west of UTC is negative (-43200 to 50400)
     *          c - The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
     *          r - The RFC 2822 formatted date (e.g. Fri, 12 Apr 2013 12:01:05 +0200)
     *          U - The seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)
     *
     *      and the following predefined constants can also be used (available since PHP 5.1.0):
     *
     *          DATE_ATOM - Atom (example: 2013-04-12T15:52:01+00:00)
     *          DATE_COOKIE - HTTP Cookies (example: Friday, 12-Apr-13 15:52:01 UTC)
     *          DATE_ISO8601 - ISO-8601 (example: 2013-04-12T15:52:01+0000)
     *          DATE_RFC822 - RFC 822 (example: Fri, 12 Apr 13 15:52:01 +0000)
     *          DATE_RFC850 - RFC 850 (example: Friday, 12-Apr-13 15:52:01 UTC)
     *          DATE_RFC1036 - RFC 1036 (example: Fri, 12 Apr 13 15:52:01 +0000)
     *          DATE_RFC1123 - RFC 1123 (example: Fri, 12 Apr 2013 15:52:01 +0000)
     *          DATE_RFC2822 - RFC 2822 (Fri, 12 Apr 2013 15:52:01 +0000)
     *          DATE_RFC3339 - Same as DATE_ATOM (since PHP 5.1.3)
     *          DATE_RSS - RSS (Fri, 12 Aug 2013 15:52:01 +0000)
     *          DATE_W3C - World Wide Web Consortium (example: 2013-04-12T15:52:01+00:00)
     *
     */
    private function groupByWeeks(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        $dateColumn = $dateColumn ?? $builder->getModel()->getCreatedAtColumn();
        $dayOneSales = $builder->getModel()->selectraw('DATE(created_at) as dayone')->orderBy('dayone')->first(); 
        $dayOneSalesDate = empty($dayOneSales) 
            ? Carbon::now()->firstOfYear()->startOfWeek() 
            : Carbon::parse($dayOneSales->dayone)->startOfWeek(); 
        // dd($dayOneSalesDate);

        $startDate = empty($startDate)
            ? $dayOneSalesDate
            : Carbon::parse($startDate);
            
        $startDate = $startDate->greaterThan($dayOneSalesDate)
            ? $startDate
            : $dayOneSalesDate;
        // dd($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()->endOfMonth()->endOfWeek()
            : Carbon::parse($stopDate);
        // dd([$startDate,$stopDate]);

        $query = $builder
            ->select(DB::raw("$value as val, DATE_FORMAT($dateColumn,'%Y-%u') as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $days = floor($startDate->diffInWeeks($stopDate)) + 1;
        // dd([$days,$startDate,$stopDate]);

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->rawFormat('Y-W')
            );

            $result = [
                'value' => ($found ? $found->val : 0),
                // 'label' => $startDate->shortMonthName,
                'label' => 'ww' . $startDate->rawFormat('W\'y'),
            ];

            $startDate->addWeek();

            return $result;
        });
    }

    /**
     * @param Builder    $builder
     * @param string     $value
     * @param mixed|null $startDate
     * @param mixed|null $stopDate
     * @param string     $dateColumn
     *
     * @return TimeCollection
     */
    private function groupByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        $dateColumn = $dateColumn ?? $builder->getModel()->getCreatedAtColumn();

        $startDate = empty($startDate)
            ? Carbon::now()->subMonth()->startOfDay()
            : Carbon::parse($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()->endOfDay()
            : Carbon::parse($stopDate);

        $query = $builder
            ->select(DB::raw("$value as value, DATE($dateColumn) as label"))
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $days = floor($startDate->diffInDays($stopDate)) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->toDateString()
            );

            $result = [
                'value' => ($found ? $found->value : 0),
                // 'label' => $startDate->minDayName,
                // 'label' => $startDate->minDayName .','. $startDate->day,
                // 'label' => $startDate->rawFormat('dD'),
                'label' => $startDate->rawFormat('D, d M Y'),
                // 'label' => $startDate->toDateString(),
            ];

            $startDate->addDay();

            return $result;
        });
    }

    private function balBefore(Builder $builder, string $startDate,$dateColumn)
    {
        $balBefore = $builder->whereDate($dateColumn,'<=',$startDate)->latest()->first();
        return $this->oldval=$balBefore->qtybal;
    }

    private function groupByDays_bal(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        $dateColumn = $dateColumn ?? $builder->getModel()->getCreatedAtColumn();
        $tableName = $builder->getModel()->getTable();
        // dd($tableName);

        $startDate = empty($startDate)
            ? Carbon::now()->subMonth()->startOfDay()
            : Carbon::parse($startDate);

        $stopDate = empty($stopDate)
            ? Carbon::now()->endOfDay()
            : Carbon::parse($stopDate);

        // $this->balBefore($builder->clone(),$startDate,$dateColumn);
        $balBefore = $builder->clone()
        ->whereDate($dateColumn,'<=',$startDate)->latest()->first();
        // dd($balBefore);
        $this->oldval = isset($balBefore)?$balBefore->qtybal:0;
        // dd($this->oldval);

        $query = $builder
            ->select(DB::raw("$value as val, DATE($dateColumn) as label"))
            ->whereIn('id',function(QueryBuilder $query)use($dateColumn){
                return $query->from(static::getTable())
                            ->selectRaw('MAX(`id`)')
                            ->groupByRaw("DATE($dateColumn),code");
            })
            ->whereBetween($dateColumn, [$startDate, $stopDate])
            ->groupBy('label','val')
            // ->groupBy('label')
            ->orderBy('label')
            // ->orderBy('id','desc')
            ->get();
        // dd($query);
        
        $days = floor($startDate->diffInDays($stopDate)) + 1;

        return TimeCollection::times($days, function () use ($startDate, $query) {
            $found = $query->firstWhere(
                'label',
                $startDate->startOfDay()->toDateString()
            );

            if ($found) {
                $this->oldval = $found->val;
            }

            $result = [
                'value' => ($found ? $found->val : $this->oldval),
                'label' => $startDate->rawFormat('D, d M Y'),
                // 'label' => $startDate->toDateString(),
            ];

            $startDate->addDay();

            return $result;
        });
    }

    /**
     * Get total models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string                        $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeCountByDays(Builder $builder, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, 'count(*)', $startDate, $stopDate, $dateColumn);
    }

    public function scopeDistinctCountByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "count(distinct $value)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeCountByMonths(Builder $builder, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths($builder, "count(*)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeDistinctCountByMonths(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths($builder, "count(distinct $value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get average models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string                        $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string|null                   $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeAverageByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "avg($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string                        $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string|null                   $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeSumByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByWeeks(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByWeeks($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByDaysAsCredit(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "sum($value * -1)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByMonths(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByMonthsAsCredit(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths($builder, "sum($value * -1)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByMonths_salescat(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths_salescat($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByMonths_dayOneCheck(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByMonths_dayOneCheck($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    public function scopeSumByYears(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByYears($builder, "sum($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get sum models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string                        $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string|null                   $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeMaxByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "max($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * Get min models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string                        $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string|null                   $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeMinByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = null): TimeCollection
    {
        return $this->groupByDays($builder, "min($value)", $startDate, $stopDate, $dateColumn);
    }

    /**
     * @deprecated usage maxByDays or minByDays
     *
     * Get values models grouped by `created_at` day.
     *
     * @param Builder                       $builder
     * @param string                        $value
     * @param string|DateTimeInterface|null $startDate
     * @param string|DateTimeInterface|null $stopDate
     * @param string                        $dateColumn
     *
     * @return TimeCollection
     */
    public function scopeValuesByDays(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        return $this->groupByDays($builder, $value, $startDate, $stopDate, $dateColumn);
    }

    public function scopeValuesByDays_bal(Builder $builder, string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at'): TimeCollection
    {
        // return $this->groupByDays_bal($builder, "min($value)", $startDate, $stopDate, $dateColumn);
        return $this->groupByDays_bal($builder, $value, $startDate, $stopDate, $dateColumn);
    }
}
