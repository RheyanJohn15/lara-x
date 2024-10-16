<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInfo extends Model
{
    use HasFactory;
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $table = 'project_infos';
    protected $primaryKey = 'pi_id';
    protected $fillable = [
        'pi_name',
        'pi_description',
        'pi_logo',
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->pi_id)) {
                $model->pi_id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
