<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

class Aktiviti extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    protected $fillable = [
        'nama_aktiviti',
        'tarikh',
        'masa_mula',
    ];

    protected $allowedFilters = [
        'id'            => Where::class,
        'nama_aktiviti' => Like::class,
        'masa_mula'     => Like::class,
        'tarikh'        => WhereDateStartEnd::class,
        'updated_at'    => WhereDateStartEnd::class,
        'created_at'    => WhereDateStartEnd::class,
    ];

    protected $allowedSorts = [
        'id',
        'nama_aktiviti',
        'masa_mula',
        'tarikh',
        'updated_at',
        'created_at',
    ];
    //
}
