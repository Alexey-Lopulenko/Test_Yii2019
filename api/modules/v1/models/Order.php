<?php

namespace api\modules\v1\models;

use yii\db\ActiveRecord;


class Order extends ActiveRecord
{
    /**
     * Define rules for validation
     */
    public function fields()
    {
        return [
            'id',
            'user_id',
            'date_id',
            'session_id',
            'ticket_id',
        ];
    }

    public function extractFields()
    {
        return [];
    }

}