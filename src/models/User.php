<?php

namespace epicerie\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function participe () {
        return $this->belongsTo("\epicerie\models\AssurePermanence","id");
    }

}
