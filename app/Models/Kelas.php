<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

class Kelas extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    protected $fillable = [
        'ting',
        'nama_kelas',
    ];

    protected $allowedFilters = [
        'id'         => Where::class,
        'ting'       => Like::class,
        'nama_kelas' => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    protected $allowedSorts = [
        'id',
        'ting',
        'nama_kelas',
        'updated_at',
        'created_at',
    ];

    public function getFullAttribute(): string
    {
        return sprintf('%s (%s)', $this->ting, $this->nama_kelas);
    }
}
