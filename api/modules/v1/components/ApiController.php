<?php

namespace api\modules\v1\components;

use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    /**
     * @var array
     */

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function checkAccess($action, $model = null, $params = [])
    {
        return true;
    }


    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/xml' => \yii\web\Response::FORMAT_XML,
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ]
            ]
        ];
    }
}