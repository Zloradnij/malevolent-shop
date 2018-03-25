<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class CreateRolesController extends Controller
{
    public $role;
    public $description;

    public function actionIndex($role, $description = '')
    {
        $role = \Yii::$app->authManager->createRole($role);
        $role->description = $description ? $description : $role;
        \Yii::$app->authManager->add($role);

        return ExitCode::OK;
    }
}
