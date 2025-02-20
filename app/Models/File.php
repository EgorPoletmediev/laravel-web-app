<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //use HasFactory<\Database\Factories\FileFactory>
    use HasFactory;

    protected $fillable = [
        'name',
        'path'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function links(){
        return $this->hasMany(Link::class);
    }
}
