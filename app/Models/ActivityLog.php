<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'activity_logs';
    protected $primaryKey = 'act_id';
    protected $fillable = [
        'act_header',
        'act_action',
        'act_model',
        'act_models',
        'act_model_id',
        'access_token_id'
    ];
}
