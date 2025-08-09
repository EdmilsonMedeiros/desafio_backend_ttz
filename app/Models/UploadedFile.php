<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $fillable = [
        'file_path',
        'name',
        'file_hash',
        "events_count",
        "status",
        "processed_at",
    ];
}
