<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UITech extends Model
{
    use HasFactory;
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $table = 'u_i_teches';
    protected $primaryKey = 'ui_id';
    protected $fillable = [
        'type',
        'value',
        'pi_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->ui_id)) {
                $model->ui_id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
