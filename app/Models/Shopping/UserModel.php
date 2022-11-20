<?php

namespace App\Models\Shopping;

use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends ParentModel
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'user';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "CRM_CONTACT_ID",
        "CRM_LEAD_ID",
        "mobile",
        "firstname",
        "lastname",
        "type",
        "national_code",
        "birthdate",
        "email",
        "colleague_id",
        "count_login",
        "otp",
        "registered_at",
        "last_login_at",
        "cookie",
        "legal_national_code",
        "legal_economic_code",
    ];
}
