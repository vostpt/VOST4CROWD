<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Project extends Model
{
    use HasSlug;

    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = [
        'title',
        'description',
        'logo',
        'options',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            $model->uuid = Uuid::uuid4()->toString();
            $model->created_by = auth()->user()->id;
        });
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
