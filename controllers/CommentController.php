<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\entities\comment\Comment;
use app\models\entities\comment\form\CommentForm;
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
        $comment = new CommentForm();
        $comment->authorId = 1;
        $comment->postId = 1;

        return $this->render('index', [
            'comment' => $comment,
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
                throw new BadRequestHttpException('bad request');
            }

            $comment = new Comment();
            $comment->setAttributes([
                'author_id' => $model->authorId,
                'post_id' => $model->postId,
                'parent_id' => $model->parentId,
                'text' => $model->text,
            ]);

            if (!$comment->save()) {
                $errors = $comment->getErrors();
                throw new BadRequestHttpException('validation error');
            }
        } catch (\Exception $exception) {
            $errors['modelErrors'] = $errors;
            $errors['message'] = $exception->getMessage();
        }

        return $this->render('index', [
            'comment' => $model,
            'errors' => $errors,
        ]);
    }
}