<?php

namespace epicerie\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function estOccupe () {
        return $this->hasMany("\epicerie\models\AssurePermanence","id");
    }

}
