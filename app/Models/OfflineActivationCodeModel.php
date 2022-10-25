<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfflineActivationCodeModel extends ParentModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'offline_activation_code';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        "grade",
        "index_code",
        "windows_code",
        "user_code",
        "generated_code",
        "limit_usage",
        "mobile",
    ];

    public function selectCodeByIndex( $indexCode ) {
        return $this->where( "index_code", "=", $indexCode )->first();
    }

    public function updateDataByID( $ID, $data ) {
        return $this->where( "id", "=", $ID )->update( $data );
    }
}
