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

    const FIELDS_TYPE_STRING = 'string';
    const FIELDS_TYPE_BOOLEAN = 'boolean';
    const FIELDS_TYPE_DECIMAL = 'decimal';
    const FIELDS_TYPE_INTEGER = 'integer';
    const FIELDS_TYPE_SINGLE_CHOICE = 'single_choice';
    const FIELDS_TYPE_MULTI_CHOICE = 'multi_choice';

    public static $fieldsTypesList = [
        self::FIELDS_TYPE_STRING,
        self::FIELDS_TYPE_BOOLEAN,
        self::FIELDS_TYPE_DECIMAL,
        self::FIELDS_TYPE_INTEGER,
        self::FIELDS_TYPE_SINGLE_CHOICE,
        self::FIELDS_TYPE_MULTI_CHOICE,
    ];

    protected $casts = [
        'fields' => 'array',
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'fields',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // TODO move this to a trait
        static::saving(function ($model) {
            $user = auth()->user();

            $model->uuid = Uuid::uuid4()->toString();
            $model->created_by = $user->id ?? 1; //TODO find a better solution
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
