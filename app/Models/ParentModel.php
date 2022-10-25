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

    /***
     * $data = $data->map(function ($user) {
            return collect($user->toArray())
                // ->only(['id', 'name', 'email'])
                ->all();
        })->toArray();
     */
}