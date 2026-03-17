<?php

namespace App\Modules\QualityAssessment\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class MilestoneEvidence extends Model
{
    protected $table = 'milestones_evidences';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['evidence_id', 'milestone_id'];
    public $timestamps = false;
}