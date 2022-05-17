<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BookComment extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'ip',
        'status',
        'name',
        'policy',
        'content',
    ];

    protected $attributes = [
        'status' => 'pending',
        'policy' => 'anonymous',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = self::generateUuid();
        });
    }

    public static function generateUuid()
    {
        return 'book_comment_' . Str::uuid();
    }
}
