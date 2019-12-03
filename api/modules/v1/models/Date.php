<?php


namespace api\modules\v1\models;

use yii\db\ActiveRecord;

class Date extends ActiveRecord
{
    public function fields()
    {
        return [
            'date_session'
        ];
    }

    public function rules()
    {
        return [];
    }


}