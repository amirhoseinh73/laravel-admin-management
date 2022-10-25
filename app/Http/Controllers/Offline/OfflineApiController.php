<?php

namespace App\Http\Controllers\Offline;

use App\Helpers\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OfflineApiController extends Controller
{
    public function getVersion() {
        $data = array(
            "version" => "1.0.1",
            "url" => env( "URL_DOWNLOADSERVER" ) . "virabook/updates/update.zip"
        );
        return jsonEncodeUnicodeDie( $data );
    }

    public function getListBooks( Request $request ) {
        $grade = intval( $request->get( "grade" ) );
        if ( ! exists( $grade ) || $grade < 1 || $grade > 6 ) return Alert::Error( -1 );

        $contentModel = $this->contentModel();
        $selectContents = $contentModel->selectBookIDWhereContentTypeVideo();

        $bookIDsHasVideo = array_column( $selectContents, "book_id" );

        $bookModel = $this->bookModel();
        $selectBooks = $bookModel->selectListBookByIDAndTypeAndGrade( $bookIDsHasVideo, $grade );

        array_map( array( $this, "handleBookList" ), $selectBooks );

        return jsonEncodeUnicodeDie( $selectBooks );
    }

    private static function handleBookList( $data ) {
        $data->book_code = $data->code;
        unset( $data->code );
        return $data;
    }

    public function getListVideos( Request $request ) {
        $bookCodes = $request->get( "book_code" );
        if ( ! exists( $bookCodes ) ) return Alert::Error( -1 );

        $bookCodes = explode( ",", $bookCodes );

        $bookModel = $this->bookModel();
        $selectBooks = $bookModel->selectBookIDByBookCodeAndType( $bookCodes );
        if ( ! exists( $selectBooks ) ) return Alert::Error( "no_data" );

        $bookIDs = array_column( $selectBooks, "id" );

        $contentModel = $this->contentModel();
        $selectContents = $contentModel->selectListVideosByBookID( $bookIDs );

        foreach( $selectContents as $content ) {
            $bookCode = array_values( array_filter( $selectBooks, function( $key ) use( $content ) {
                return $key->id === $content->book_id;
            } ) )[ 0 ]->code;

            $content->book_code = $bookCode;
        }

        array_map( array( $this, "handleContentList" ), $selectContents );

        return jsonEncodeUnicodeDie( $selectContents );
    }

    private static function handleContentList( $data ) {
        $fileName = array_reverse( explode( "/", $data->url ) )[ 0 ];

        $data->file_name = $fileName;
        $data->url = env( "URL_DOWNLOADSERVER" ) . $data->url;
        unset( $data->book_id );

        return $data;
    }
}
