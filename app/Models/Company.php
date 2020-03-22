<?php

namespace App\Models;

use App\Classes\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_company_id',
        'name',
    ];

    /**
     * Load all required relationships with only necessary content.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLoadRelations($query)
    {
        return $query->with(['stations', 'parent'])
            ->withCount(['stations']);
    }

    /**
     * Get the user that owns the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations()
    {
        return $this->HasMany(Station::class);
    }

    /**
     * Get the parent company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent() {
        return $this->belongsTo(Company::class, 'parent_company_id', 'id');
    }

    /**
     * Get the company's children
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany(Company::class, 'parent_company_id', 'id')->latest();
    }

}
