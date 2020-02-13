<?php

namespace epicerie\models;

use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    protected $table = 'creneau';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function estAssure () {
        return $this->hasMany("AssurePermanence","id");
    }



}
