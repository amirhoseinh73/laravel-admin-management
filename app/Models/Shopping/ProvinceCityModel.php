<?php

namespace App\Models\Shopping;

use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvinceCityModel extends ParentModel
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'province_city';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "parent",
        "title",
    ];
}
