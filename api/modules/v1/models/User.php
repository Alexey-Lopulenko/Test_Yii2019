<?php


namespace api\modules\v1\models;


use yii\db\ActiveRecord;

class User extends \common\models\User
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


    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
}