<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $primaryKey = 'codigo';
    protected $table = 'cursos';
    public $incrementing = false;
}

