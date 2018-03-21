<?php

namespace app\libraries\behaviors;

use yii\base\Behavior;
use yii\web\Response;

class JsonResponseBehavior extends Behavior
{
    public function createResponse($data = [])
    {
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_JSON;

        return $data;
    }
}