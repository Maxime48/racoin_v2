<?php

namespace model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonceur extends Model
{
    public $timestamps = false;
    protected $table = 'annonceur';
    protected $primaryKey = 'id_annonceur';

    public function annonce(): HasMany
    {
        return $this->hasMany('model\Annonce', 'id_annonceur');
    }
}
