<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInfo extends Model
{
    use HasFactory;
    protected $table = 'project_infos';
    protected $primaryKey = 'pi_id';
    protected $fillable = [
        'pi_name',
        'pi_description',
        'pi_logo',
        'user_id'
    ];
}
