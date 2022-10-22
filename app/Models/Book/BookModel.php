<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookModel extends Model
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
}
