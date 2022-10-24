<?php

namespace App\Models\Book;

use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookModel extends ParentModel
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "book";
    protected $table = 'book';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        "title",
        "code",
        "grade",
        "gender",
        "start_page",
        "count_page",
        "religion",
    ];

    public function selectListBookByGrade( $gradeID ) {
        return self::where( "grade", "=", $gradeID )->get();
    }

    public function selectAllBooksInArrayOfObject() {
        return json_decode( self::all()->toJson() );
    }
}
