<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Inventory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // getter make sure title is always in uppercase
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    // setter masukkan dalam database, huruf besar
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}
