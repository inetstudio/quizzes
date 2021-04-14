<?php

namespace InetStudio\QuizzesPackage\Tags\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract;

class TagModel extends Model implements TagModelContract
{
    use SoftDeletes;

    const ENTITY_TYPE = 'quizzes_tag';

    protected $table = 'quizzes_tags';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($result) {
            $result->{$result->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    public function parent(): HasOne
    {
        $tagModel = resolve('InetStudio\QuizzesPackage\Tags\Contracts\Models\TagModelContract');

        return $this->hasOne(
            get_class($tagModel),
            'id',
            'parent_id'
        );
    }

    public function results(): HasMany
    {
        $resultModel = resolve('InetStudio\QuizzesPackage\Results\Contracts\Models\ResultModelContract');

        return $this->hasMany(
            get_class($resultModel),
            'tag_id',
            'id'
        );
    }
}
