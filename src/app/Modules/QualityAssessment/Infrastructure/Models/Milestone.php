<?php

namespace App\Modules\QualityAssessment\Infrastructure\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['id', 'criteria_id', 'code', 'order', 'name'];
    public $timestamps = false;

    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class);
    }

    public function evidences()
    {
        return $this->belongsToMany(
            Evidence::class,
            'milestones_evidences',
            'milestone_id',
            'evidence_id'
        );
    }
}