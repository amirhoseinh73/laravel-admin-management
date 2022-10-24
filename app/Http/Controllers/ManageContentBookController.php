<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use App\Helpers\Grade;
use Exception;
use Illuminate\Http\Request;

class ManageContentBookController extends Controller
{
    /**
     * Summary.
     * show index page of contents
     */
    public function index( Request $request ) {
        $data_page = array(
            "head_title"    => "ویرا پلتفرم | مدیریت محتوا",
            "description"   => "مدیریت محتوای ویرابوک",
            'user_data'     => $this->userInfo( $request ),
        );

        return view( "dashboard.manage-content-book", $data_page );
    }

    public function listGrade() {
        return Alert::Success( 200, Grade::GRADE );
    }

    public function listBook( Request $request ) {
        
        $grade_id = $request->get( "grade_id" );
        if ( ! exists( $grade_id ) ) return Alert::Error( "wrong_inputs" );

        $book_model = $this->bookModel();
        $select_book = $book_model->selectListBookByGrade( $grade_id );

        return Alert::Success( 200, $select_book );
    }

    public function listAllBooks() {
        
        $book_model = $this->bookModel();
        $select_book = $book_model->selectAllBooksInArrayOfObject();

        $select_book = array_map( [ $this, "changeBookTitle" ], $select_book );

        return Alert::Success( 200, $select_book );
    }

    public function listContent( Request $request ) {
        $book_id    = $request->get( "book_id" );
        $offset     = intval( $request->get( "offset" ) ) ?: QUERY_OFFSET;
        $limit      = intval( $request->get( "limit" ) ) ?: QUERY_LIMIT;

        $offset = $limit * $offset;
        if ( ! exists( $book_id ) ) return Alert::Error( "wrong_inputs" );

        $content_model = $this->contentModel();
        $book_model = $this->bookModel();

        $select_content = $content_model->selectContentsWithGradeAndBookTitle( $book_model, $book_id );
            
        $select_content = array_map( [ $this, "changeBookTitle2" ], $select_content );
            
        return Alert::Success( 200, $select_content );
    }

    private function changeBookTitle( $book ) {
        $book->title = $book->title . " - " . Grade::GRADE[ +$book->grade ];

        return $book;
    }

    private function changeBookTitle2( $content ) {
        $content->book_title = $content->book_title . " - " . Grade::GRADE[ +$content->grade ];
        $content->url = env( "URL_DOWNLOADSERVER" ) . $content->url;

        foreach( $content as $idx => $item ) {
            if ( $item === null ) $content->$idx = "";
        }

        return $content;
    }

    public function contentRemove( Request $request ) {
        $content_id    = $request->post( "content_id" );
        if ( ! exists( $content_id ) ) return Alert::Error( "wrong_inputs" );

        $content_model = $this->contentModel();
        try {
            $content_model->removeItemByID( $content_id );

            return Alert::Success( 200 );
        } catch( Exception $e ) {
            return Alert::Error( -1 );
        }
    }

    public function contentUpdate( Request $request ) {
        $content_id     = $request->post( "content_id" );
        $title          = $request->post( "title" );
        $is_title       = $request->post( "is_title" ) === "true" ? TRUE : FALSE;
        $page           = $request->post( "page" );
        $is_page        = $request->post( "is_page" ) === "true" ? TRUE : FALSE;
        $description    = $request->post( "description" );
        $is_description = $request->post( "is_description" ) === "true" ? TRUE : FALSE;
        $status         = $request->post( "status" );
        $is_status      = $request->post( "is_status" ) === "true" ? TRUE : FALSE;

        $publisher    = $request->post( "publisher" );
        $is_publisher = $request->post( "is_publisher" ) === "true" ? TRUE : FALSE;

        $width        = $request->post( "width" );
        $is_width     = $request->post( "is_width" ) === "true" ? TRUE : FALSE;

        $height        = $request->post( "height" );
        $is_height     = $request->post( "is_height" ) === "true" ? TRUE : FALSE;

        $book_id        = $request->post( "book_id" );
        $is_book_id     = $request->post( "is_book_id" ) === "true" ? TRUE : FALSE;

        if ( ! exists( $content_id ) ) return Alert::Error( "wrong_inputs" );

        $content_model = $this->contentModel();
        $select_content = $content_model->selectContentByID( $content_id );

        if ( ! exists( $select_content ) ) return Alert::Error( -1 );

        try {
            $data = array(
                "title"       => ( $is_title          ? $title        : $select_content->title ),
                "page"        => ( $is_page           ? $page         : $select_content->page ),
                "description" => ( $is_description    ? $description  : $select_content->description ),
                "status"      => ( $is_status         ? $status       : $select_content->status ),
                "publisher"   => ( $is_publisher      ? $publisher    : $select_content->publisher ),
                "width"       => ( $is_width          ? $width        : $select_content->width ),
                "height"      => ( $is_height         ? $height       : $select_content->height ),
                "book_id"     => ( $is_book_id        ? $book_id      : $select_content->book_id ),
            );

            $content_model->updateRowByID( $content_id, $data );

            return Alert::Success( 200 );
        } catch( Exception $e ) {
            return Alert::Error( -1 );
        }
    }
}
