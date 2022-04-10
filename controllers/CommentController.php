<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\entities\comment\Comment;
use app\models\entities\comment\form\CommentForm;
use app\services\CommentService;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Class CommentController
 * @package app\controllers
 */
class CommentController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $commentForm = new CommentForm();
        $commentForm->authorId = 1;
        $commentForm->postId = 1;

        return $this->render('index', [
            'form' => $commentForm,
            'comments' => Comment::find()->getAllWithAuthor()->all(),
        ]);
    }

    /**
     * @return string
     */
    public function actionSave(): string
    {
        $model = new CommentForm();
        $errors = [];

        try {
            if (!$model->load(\Yii::$app->request->post()) || !$model->validate()) {
                $errors = $model->getErrors();
                throw new BadRequestHttpException('Bad request');
            }

            $comment = CommentService::save($model);

            if ($comment->errors) {
                $errors = $comment->errors;
                throw new BadRequestHttpException('Comment save error');
            }
        } catch (\Exception $exception) {
            $errors['modelErrors'] = $errors;
            $errors['message'] = $exception->getMessage();
        }

        return $this->render('index', [
            'form' => $model,
            'errors' => $errors,
            'comments' => Comment::find()->getAllWithAuthor()->all(),
        ]);
    }
}