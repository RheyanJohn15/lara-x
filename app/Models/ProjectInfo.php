<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInfo extends Model
{
    use HasFactory;
    public $incrementing = false; // Disable auto-incrementing as we use UUIDs
    protected $keyType = 'string'; // Define the key type as 'string' for UUIDs

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
