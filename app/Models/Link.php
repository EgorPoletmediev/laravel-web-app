<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Link extends Model
{
    /** @use HasFactory<\Database\Factories\LinkFactory> */
    use HasFactory;

    protected $fillable = [
        'link',
        'password',
        'used'
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }

    public function file(){
        return $this->belongsTo(File::class);
    }

    protected static function boot(){
        parent::boot();
        static::creating(function ($model){
            do {
                    $randomLink = Str::random(40);
                } while (self::where('link', $randomLink)->exists());
            $model->link = $randomLink;
        });

    }
}
