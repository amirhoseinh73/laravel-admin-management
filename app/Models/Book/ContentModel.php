<?php

namespace App\Models\Book;

use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentModel extends ParentModel
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

    public function selectContentsWithGradeAndBookTitle( $book_model, $book_id ) {
        $selectContent = self::select( array(
                $this->getTable() . ".id",
                $this->getTable() . ".page",
                $this->getTable() . ".type",
                $this->getTable() . ".url",
                $this->getTable() . ".thumbnail",
                $this->getTable() . ".editor_url",
                $this->getTable() . ".title",
                $this->getTable() . ".description",
                $this->getTable() . ".publisher",
                $this->getTable() . ".width",
                $this->getTable() . ".height",
                $this->getTable() . ".status",
                $this->getTable() . ".book_id",
                $book_model->getTable() . ".title as book_title",
                $book_model->getTable() . ".grade",
            ) )
            ->join( $book_model->getTable(), $book_model->getTable() . ".id", "=", $this->getTable() . ".book_id" )
            ->where( "book_id", "=", $book_id )
            ->where( "user_id", "=", -1 )
            ->orderBy( "page", "ASC" )
            ->get();

        
        return json_decode( $selectContent->toJson() );
    }

    public function removeItemByID( $ID ) {
        return self::where( "id", "=", $ID )->delete();
    }

    public function selectContentByID( $ID ) {
        return self::where( "id", $ID )->first();
    }

    public function updateRowByID( $ID, $data ) {
        return self::where( "id", "=", $ID )->update( $data );
    }
}
