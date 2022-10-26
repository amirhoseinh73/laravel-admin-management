<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute( $value ) {
        $date = new Carbon( $value );
        return $date->format( "Y-m-d H:i:s" );
    }

    public function getUpdatedAtAttribute( $value ) {
        $date = new Carbon( $value );
        return $date->format( "Y-m-d H:i:s" );
    }

    public function updateBatchWithKey( array $dataToUpdate, string $key ) {
        $valueOfKey = array_column( $dataToUpdate, $key );
        _dump(
            $dataToUpdate,
            $key,
            $valueOfKey
        );
        return $this->whereIn( $key, $valueOfKey )->update( $dataToUpdate );
    }

    public function removeItemByID( $ID ) {
        return self::where( "id", "=", $ID )->delete();
    }

    public function selectItemByID( $ID ) {
        return self::where( "id", $ID )->first();
    }

    public function updateRowByID( $ID, $data ) {
        return self::where( "id", "=", $ID )->update( $data );
    }

    /***
     * $data = $data->map(function ($user) {
            return collect($user->toArray())
                // ->only(['id', 'name', 'email'])
                ->all();
        })->toArray();
     */
}