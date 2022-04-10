<?php

declare(strict_types=1);

namespace app\models\response;

use yii\db\ActiveRecord;

/**
 * Class JsonResponse
 * @package app\models\response
 */
class ModelJsonResponse
{
    /** @var string */
    public $error;

    /** @var ActiveRecord */
    public $model;

    /** @var array */
    public $modelErrors = [];
    /** @var array */
    public $data = [];
}