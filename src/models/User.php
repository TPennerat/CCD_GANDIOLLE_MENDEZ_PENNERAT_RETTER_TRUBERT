<?php

namespace epicerie\models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function permRole()
    {
        return $this->hasManyThrough(
            '\epicerie\models\Creneau',
            '\epicerie\models\Role',
            'id', // Foreign key on users table...
            'id', // Foreign key on history table...
            'id', // Local key on suppliers table...
            'id' // Local key on users table...
        );
    }

}