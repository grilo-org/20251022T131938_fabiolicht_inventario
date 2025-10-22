<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = "blog";  
    protected  $primaryKey = 'id';  
    protected $fillable = [
        'id',
        'titulo',
        'descricao',
        'slug',
        'created_at',
        'updated_at'
    ];
}
