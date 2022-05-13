<?php

namespace app\controllers\actions;

use app\core\manage\Auth\UserIdentity;
use app\core\services\Summary\SummaryInformationService;
use Yii;
use yii\base\Action;

/**
 * Description of MemberMainAction
 *
 * @author kotov
 */
class MemberMainAction extends Action
{
    
    public function run()
    {
        /** @var UserIdentity $userIdentity */
        $userIdentity = Yii::$app->user->getIdentity();
        $company = $userIdentity->getCompany();
        $summaryService = new SummaryInformationService($company);
        return $this->controller->render('index-member',[
            'summaryInformation' => $summaryService->getSummaryInformation(),
            'company' => $company
        ]);
    }
}
