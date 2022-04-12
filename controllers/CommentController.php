<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\entities\comment\Comment;
use app\models\form\CommentForm;
use app\models\response\ModelJsonResponse;
use app\services\CommentService;
use yii\db\StaleObjectException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class CommentController
 * @package app\controllers
 */
class CommentController extends Controller
{
    /**
     * Render comment page
     * @return string
     */
    public function actionIndex(): string
    {
        $commentForm = new CommentForm();
        $commentForm->authorId = 1;
        $commentForm->postId = 1;

        $topIds = Comment::find()->getTop()->select('id')->column();
        $relations = CommentService::getRelations($topIds);
        $allIds = array_keys($relations);

        foreach ($relations as $items) {
            $allIds = array_merge($allIds, array_keys($items));
        }

        /** @var Comment[] $comments */
        $comments = Comment::find()->byIds(array_unique($allIds))->all();
        $commentsData = [];

        foreach ($comments as $comment) {
            $commentsData[$comment->id] = $comment;
        }

        return $this->render('index', [
            'form' => $commentForm,
            'relations' => $relations,
            'commentsData' => $commentsData,
            'topIds' => $topIds,
        ]);
    }

    /**
     * Save comment
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

    /**
     * Delete comment
     * @return bool
     * @throws StaleObjectException
     */
    public function actionDelete()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $commentId = \Yii::$app->request->post('commentId');

        return CommentService::delete((int)$commentId);
    }

    /**
     * Update comment
     * @return ModelJsonResponse
     */
    public function actionUpdate(): ModelJsonResponse
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new CommentForm();
        $response = new ModelJsonResponse();

        try {
            $request = \Yii::$app->request->post();

            if (!$model->load($request) || !$model->validate()) {
                throw new BadRequestHttpException('Bad request');
            }
            $comment = CommentService::update($model);
            $response->model = $comment;
        } catch (\Exception $e) {
            $response->modelErrors = $model->getErrors();
            $response->error = $e->getMessage();
        }

        return $response;
    }

    /**
     * Reply comment
     * @return ModelJsonResponse
     */
    public function actionReply(): ModelJsonResponse
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new CommentForm();
        $response = new ModelJsonResponse();

        try {
            $request = \Yii::$app->request->post();

            if (!$model->load($request) || !$model->validate()) {
                throw new BadRequestHttpException('Bad request');
            }

            $comment = CommentService::save($model);
            $response->model = $comment;
        } catch (\Exception $e) {
            $response->modelErrors = $model->getErrors();
            $response->error = $e->getMessage();
        }

        return $response;
    }
}