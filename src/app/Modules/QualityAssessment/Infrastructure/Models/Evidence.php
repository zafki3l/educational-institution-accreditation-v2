<?php

namespace App\Modules\QualityAssessment\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    protected $table = 'evidences';
    protected $primaryKey = 'id';

    public $incrementing = false;
    
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'milestone_id',
        'document_number',
        'issued_date',
        'issuing_authority',
        'file_url'
    ];

    public $timestamps = true;
}