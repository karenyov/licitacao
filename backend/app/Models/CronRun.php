<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronRun extends Model
{
    /** @use HasFactory<\Database\Factories\CronRunFactory> */
    use HasFactory;
    protected $table = 'cron_runs';

    protected $fillable = [
        'job_name',
        'started_at',
        'finished_at',
        'status',
        'message',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
