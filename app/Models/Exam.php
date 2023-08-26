<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model {
    use HasFactory;
    protected $table      = 'exams';
    protected $primaryKey = 'exam_id';
    protected $fillable   = [
        'exam_name',
        'exam_description',
        'exam_type',
        'exam_duration',
        'exam_status',
        'created_by',
    ];

}