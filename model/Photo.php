<?php

namespace model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    public $timestamps = false;
    protected $table = 'photo';
    protected $primaryKey = 'id_photo';

    public function annonce(): BelongsTo
    {
        return $this->belongsTo('model\Annonce', 'id_annonce');
    }
}

?>