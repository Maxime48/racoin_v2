<?php

namespace model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{
    public $timestamps = false;
    public $links = null;
    protected $table = 'annonce';
    protected $primaryKey = 'id_annonce';

    public function annonceur(): BelongsTo
    {
        return $this->belongsTo('model\Annonceur', 'id_annonceur');
    }

    public function photo(): HasMany
    {
        return $this->hasMany('model\Photo', 'id_photo');
    }

}

?>
