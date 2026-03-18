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

    public function milestone()
    {
        return $this->belongsTo(Milestone::class, 'milestone_id');
    }

    public function milestones()
    {
        return $this->belongsToMany(
            Milestone::class,
            'milestones_evidences',
            'evidence_id',
            'milestone_id'
        );
    }
}