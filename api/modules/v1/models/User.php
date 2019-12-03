<?php


namespace api\modules\v1\models;


use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    /**
     * Define rules for validation
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
        ];
    }
}