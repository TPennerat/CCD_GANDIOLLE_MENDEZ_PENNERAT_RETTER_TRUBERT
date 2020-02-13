<?php

namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    public $timestamps = false;

}