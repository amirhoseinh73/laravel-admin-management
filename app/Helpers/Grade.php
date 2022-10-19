<?php

namespace App\Helpers;

interface gradeInterface {
    /**
     * @param int $grade_id is array index for key
     * @return array `title` && `segment` && `field`
     */
    public static function getGradeData( int $grade_id );

}

class Grade implements gradeInterface {

    const SEGMENT = array(
        1 => "مقطع ابتدایی اول",
        2 => "مقطع ابتدایی دوم",
        3 => "مقطع متوسطه اول",
        4 => "مقطع متوسطه دوم",
    );

    const FIELD = array(
        1 => "ریاضی و فیزیک",
        2 => "علوم تجربی",
        3 => "علوم انسانی",
        4 => "علوم و معارف اسلامی",
    );

    const GRADE = array(
        1 => "پایه اول",
        2 => "پایه دوم",
        3 => "پایه سوم",
        4 => "پایه چهارم",
        5 => "پایه پنجم",
        6 => "پایه ششم",
        7 => "پایه هفتم",
        8 => "پایه هشتم",
        9 => "پایه نهم",

        101 => "پایه دهم " . self::FIELD[ 1 ],
        102 => "پایه دهم " . self::FIELD[ 2 ],
        103 => "پایه دهم " . self::FIELD[ 3 ],
        104 => "پایه دهم " . self::FIELD[ 4 ],

        111 => "پایه یازدهم " . self::FIELD[ 1 ],
        112 => "پایه یازدهم " . self::FIELD[ 2 ],
        113 => "پایه یازدهم " . self::FIELD[ 3 ],
        114 => "پایه یازدهم " . self::FIELD[ 4 ],

        121 => "پایه دوازدهم " . self::FIELD[ 1 ],
        122 => "پایه دوازدهم " . self::FIELD[ 2 ],
        123 => "پایه دوازدهم " . self::FIELD[ 3 ],
        124 => "پایه دوازدهم " . self::FIELD[ 4 ],
    );

    /**
     * @param int $grade_id from 1 to 9 | 10 - 12 : 1 - 4
     */
    public static function getGradeData( int $grade_id ) {

        $segment_title = self::getSegmentByGradeId( $grade_id );
        if ( ! $segment_title ) return FALSE;

        $field_id = self::getFieldByGradeId( $grade_id );
        if ( $field_id === NULL ) return FALSE;

        return array(
            "title" => self::GRADE[ $grade_id ],
            "segment" => $segment_title,
            "field_id" => $field_id,
        );
    }

    public static function getSegmentByGradeId( int $grade_id ) {
        switch ( $grade_id ) {
            case 1:
            case 2:
            case 3:
                return self::SEGMENT[ 1 ];
            case 4:
            case 5:
            case 6:
                return self::SEGMENT[ 2 ];
            case 7:
            case 8:
            case 9:
                return self::SEGMENT[ 3 ];
            case 10:
            case 11:
            case 12:
                return self::SEGMENT[ 4 ];
            default:
                return NULL;
        }
    }

    public static function getFieldByGradeId( int $grade_id ) {
        switch ( $grade_id ) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
            case 10:
            case 11:
                return false;
            case 12:
                return self::FIELD[ 1 ];
            case 13:
                return self::FIELD[ 2 ];
            case 14:
                return self::FIELD[ 3 ];
            case 15:
                return self::FIELD[ 4 ];
            default:
                return NULL;
        }
    }

}