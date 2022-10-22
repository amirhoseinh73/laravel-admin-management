<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "book";
    protected $table = 'content';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        "book_id",
        "user_id",
        "page",
        "type",
        "url",
        "thumbnail",
        "editor_url",
        "title",
        "description",
        "publisher",
        "status",
        "storage",
        "position",
        "scale",
        "width",
        "height",
    ];
}
