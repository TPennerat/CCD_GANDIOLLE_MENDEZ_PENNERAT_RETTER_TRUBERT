<?php

namespace epicerie\models;

use Illuminate\Database\Eloquent\Model;

class AssurePermanence extends Model
{
    protected $table = "assurePermanence";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function user () {
      return $this->hasOne("epicerie\models\User","id");
    }

    public function creneau () {
      return $this->hasOne("epicerie\models\Creneau","id");
    }

    public function role () {
      return $this->hasOne("epicerie\models\Role","id");
    }
    

}
