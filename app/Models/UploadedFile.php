<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    use HasFactory;
    use HasUuids;
    public $timestamps = false;

    protected $fillable = [
        'original_name',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'extension'
    ];

}
