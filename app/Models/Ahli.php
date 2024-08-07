<?php

namespace App\Models;

use App\Traits\Metrics\Chartable_mod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Ahli extends Model
{
    use HasFactory;
    use AsSource, Filterable;
    use Chartable_mod;

    protected $fillable = [
        'kelas_id',
        'nama',
        'nokp',
        'email',
        'katalaluan',
    ];

    protected $hidden = [
        'katalaluan',
    ];

    protected $allowedFilters = [
        'id'            => Where::class,
        'kelas_id'      => Where::class,
        'nama'          => Like::class,
        'nokp'          => Like::class,
        'email'          => Like::class,
        'updated_at'    => WhereDateStartEnd::class,
        'created_at'    => WhereDateStartEnd::class,
    ];

    protected $allowedSorts = [
        'id',
        'kelas_id',
        'nama',
        'nokp',
        'email',
        'updated_at',
        'created_at',
    ];

    // ===================== ORM Definition START ===================== //

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // /**
    //  * @return BelongsTo
    //  */
    // public function updatedBy() {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }

    // ===================== ORM Definition END ===================== //

    public function getFullAttribute(): string
    {
        return sprintf('%s (%s)', $this->nama, $this->nokp);
    }
}
