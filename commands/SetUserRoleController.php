<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class SetUserRoleController extends Controller
{
    public $role;
    public $description;

    public function actionIndex($userID, $role)
    {
        $userRole = \Yii::$app->authManager->getRole($role);
        \Yii::$app->authManager->assign($userRole, $userID);

        return ExitCode::OK;
    }
}
