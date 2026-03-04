<?php

namespace App\Modules\DepartmentManagement\Infrastructure\Models;

use App\Modules\QualityAssessment\Infrastructure\Models\Standard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'name'];   
    public $timestamps = false;

    public function standards(): HasMany
    {
        return $this->hasMany(Standard::class);
    }
}