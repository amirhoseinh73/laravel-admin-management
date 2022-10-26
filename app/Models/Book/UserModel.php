<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "book";
    protected $table = 'user';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        "platform_id",
        "grade",
        "is_admin",
        "complete_signup",
        "storage",
        "class_id",
        "school_id",
    ];

    public function removeItemByPlatformID( $ID ) {
        return $this->where( "platform_id", "=", $ID )->delete();
    }

    public function updateItemByPlatformID( $ID, array $data ) {
        return $this->where( "platform_id", "=", $ID )->update( $data );
    }
}
