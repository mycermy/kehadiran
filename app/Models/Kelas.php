<?php

namespace App\Models;

use App\Traits\HasCompositeKey;
use App\Traits\Metrics\Chartable_mod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Kelas extends Model
{
    use HasFactory;
    use AsSource, Filterable;
    use Chartable_mod;
    // use HasCompositeKey;

    // protected $primary = ['ting', 'nama_kelas'];

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

    // ===================== ORM Definition START ===================== //

    public function ahlis()
    {
        return $this->hasMany(Ahli::class);
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // ===================== ORM Definition END ===================== //

    public function getKelasFullNameAttribute(): string
    {
        return sprintf('%s %s', $this->ting, $this->nama_kelas);
        // return sprintf('%s (%s)', $this->ting, $this->nama_kelas);
    }
}
