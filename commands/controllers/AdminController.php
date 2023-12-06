<?php

namespace app\commands\controllers;

use app\core\helpers\View\Form\FormHelper;
use app\core\repositories\readModels\Forms\FieldGroupReadRepository;
use app\core\traits\Db\QueryTrait;
use app\models\ActiveRecord\Common\Valute;
use app\models\ActiveRecord\Companies\BankDetail;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Companies\Contact;
use app\models\ActiveRecord\Companies\LegalAddress;
use app\models\ActiveRecord\Companies\PostalAddress;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\FieldGroup;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Geography\City;
use app\models\ActiveRecord\Geography\Country;
use app\models\ActiveRecord\Geography\Region;
use app\models\ActiveRecord\Requests\Application;
use app\models\ActiveRecord\Requests\Request;
use app\models\ActiveRecord\Requests\RequestStand;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use app\models\Data\Languages;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\ActiveRecord;
use yii\helpers\Console;



/**
 * Команды для обслуживания портала
 *
 * @author kotov
 */
class AdminController extends Controller
{
    use QueryTrait;
    /**
     * Первоначаьная установка ролей для пользователей
     */
    public function actionSetUserRoles()
    {

        $auth = Yii::$app->authManager;
        $auth->removeAllAssignments();
        $adminRole = $auth->getRole(UserType::ROOT_USER_TYPE);
        $memberRole = $auth->getRole(UserType::MEMBER_USER_TYPE);
        $managerRole = $auth->getRole(UserType::MANAGER_USER_TYPE);
        $accountantRole = $auth->getRole(UserType::ACCOUNTANT_USER_TYPE);
        $organizerRole = $auth->getRole(UserType::ORGANIZER_USER_TYPE);
        $superAdminRole = $auth->getRole(UserType::SUPER_ADMIN);
        $adminList = Yii::$app->params['rootUsers'] ?? [];        
        $users = User::find()->all();
        
        foreach ($users as $user)
        {
            /* @var $user User */
            switch ($user->user_type_id) {
                case UserType::ROOT_USER_ID:
                    Console::output("Установлена роль 'Администратор' для пользователя {$user->login}");
                    $auth->assign($adminRole, $user->id);
                    if (in_array($user->login, $adminList)) {
                        Console::output("Установлена роль 'СуперАдмин' для пользователя {$user->login}");
                        $auth->assign($superAdminRole, $user->id);
                    }                    
                    break;
                case UserType::MEMBER_USER_ID:
                    $auth->assign($memberRole, $user->id);
                     Console::output("Установлена роль 'Участник' для пользователя {$user->login}");
                    break;
                case UserType::MANAGER_USER_ID:
                    $auth->assign($managerRole, $user->id);
                     Console::output("Установлена роль 'Менеджер' для пользователя {$user->login}");                    
                    break;
                case UserType::ACCOUNTANT_USER_ID:
                    $auth->assign($accountantRole, $user->id);
                     Console::output("Установлена роль 'Бухгалтер' для пользователя {$user->login}");
                     break;
                case UserType::ORGANIZER_USER_ID:
                    $auth->assign($organizerRole, $user->id);
                     Console::output("Установлена роль 'Организатор' для пользователя {$user->login}");  
                     break;
            }
        }
        return ExitCode::OK;
        
    }
/**
 * Обновление ролей
 */
    public function actionRenewUserTypes() 
    {
        chdir(__DIR__);
        $items = require './../fixtures/user/user.types.php';
        foreach ($items as $item) {
            $currentModel = UserType::findOne(['id' => $item['id']]);
            if (!$currentModel) {
                $model = new UserType();
                $model->setAttributes($item,false);
                $model->save(false);
                unset($model);
            }
        }         
    }
    /**
     * Добавление данных
     */
    public function actionAddData()
    {
        City::deleteAll();
        Country::deleteAll();
        Region::deleteAll();
        PostalAddress::deleteAll();
        LegalAddress::deleteAll();
        BankDetail::deleteAll();
        Contact::deleteAll();
        Company::deleteAll();
        UserType::deleteAll();
                      
        $this->loadFixtureFromCSV(new Country(), 'country.csv', [
            0 => 'id',
            2 => 'name'
        ]);
        $this->loadFixtureFromCSV(new Region(), 'region.csv', [
            0 => 'id',
            1 => 'country_id',
            3 => 'name'
        ]);
        $this->loadFixtureFromCSV(new City(), 'city.csv', [
            0 => 'id',
            2 => 'region_id',
            3 => 'name'
            
        ]);
          $this->addData(PostalAddress::class, './../fixtures/company/postal.address.php');
          $this->addData(LegalAddress::class, './../fixtures/company/legal.address.php');
          $this->addData(BankDetail::class, './../fixtures/company/bank.detail.php');
          $this->addData(Contact::class, './../fixtures/company/contacts.php');
          $this->addData(Company::class, './../fixtures/company/company.php');        
          $this->addData(UserType::class, './../fixtures/user/user.types.php');        
          $user = new User();
          $user->login = 'admin';
        $user->user_type_id = UserType::ROOT_USER_ID;  
        $user->company_id = Company::BASE_COMPANY;
        $user->setPassword('123')
                ->setAuthKey()
                ->save(false);        
    }
    /**
     * Заполнение справочников
     */
    public function actionSetDirectory()
    {
       // $this->addData(FormType::class, './../fixtures/form/forms.php');
        $prefix = Yii::$app->db->tablePrefix;
        $sql = 'DELETE FROM '.$prefix.'element_type;' .
               'DELETE FROM '.$prefix.'valutes;' .
               'DELETE FROM '.$prefix.'form_types;';  
        $this->query($sql);
        $this->addData(ElementType::class, './../fixtures/directory/form-elements.php');
        $this->addData(Valute::class, './../fixtures/directory/valutes.php');
        $this->addData(FormType::class, './../fixtures/directory/form-types.php');
        $defaultGroup = FieldGroupReadRepository::findById(0);
        if (!$defaultGroup) {
            $defaultGroup = FieldGroup::create('Не задана', '', 'Undefined', '');
            $defaultGroup->id = 0;
            $defaultGroup->save();
        }
        Console::output('Data added');
        return ExitCode::OK;        
    }

    protected function loadFixtureFromCSV(ActiveRecord $obj, string $csvFile, array $fieldNames)
    {
        $fixture = Yii::getAlias('@fixtures') . DIRECTORY_SEPARATOR . $csvFile;
        $lines = file($fixture);
        foreach ($lines as $line)
        {
            $model = clone $obj;
            $arr = str_getcsv($line,';');
            foreach ($fieldNames as $idx => $fieldName) {
                $model->setAttribute($fieldName, $arr[$idx]);

            }
            $model->save(false);
            unset($model);
        }
        echo "Add data to ". $obj::tableName() ." table\n";
    }    
    
    protected function addData($className,$fixture)
    {
        chdir(__DIR__);
        $items = require $fixture;
        foreach ($items as $item) {
            $model = new $className();
            $model->setAttributes($item,false);
            $model->save(false);
            unset($model);
        }                    
    }
    
    public function actionFillFormIds()
    {
        $requests = Request::find()->all();
        foreach ($requests as $request)
        {
            /** @var Request $request */
            /** @var RequestStand $stand */
            if (!$request->form_id) {
                if ($request->formType->id === FormType::SPECIAL_STAND_FORM) {
                    $stand = RequestStand::findOne(['request_id' => $request->id]);
                    $request->form_id = $stand->form_id;
                } else {
                    $app = Application::findOne(['request_id' => $request->id]);
                    $request->form_id = $app->form_id;                    
                }
                $request->save();
            }
        }
    }
    
    public function actionFixPrice()
    {
        /** @var Request $request */
        $requests = Request::find()->all();
        $admin = User::findOne(['login' => 'admin']);
        foreach ($requests as $request) {
            if ($request->form->form_type_id !== FormType::DYNAMIC_ORDER_FORM) {
                continue;
            }
            $formHelper = FormHelper::createViaRequest($admin,$request->contract, Languages::RUSSIAN, $request);
            $realPrice = $formHelper->getFormPrice();
            /** @var Application $application */
            $application = $request->requestForm;
            $currentPrice = $application->amount;
            if ($currentPrice != $realPrice) {
                $application->amount = $realPrice;
                $application->save();
                Console::output("Некорректное значение стоимости в заявке №{$request->id} $currentPrice заменено на $realPrice!");

            }                        
        }
        return ExitCode::OK;         
    }
}
