<?php

namespace app\commands\controllers;

use app\core\repositories\readModels\Forms\FieldGroupReadRepository;
use app\models\ActiveRecord\Companies\Company;
use app\models\ActiveRecord\Forms\ElementType;
use app\models\ActiveRecord\Forms\FieldGroup;
use app\models\ActiveRecord\Forms\FormType;
use app\models\ActiveRecord\Users\User;
use app\models\ActiveRecord\Users\UserType;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\ActiveRecord;
use yii\db\QueryTrait;
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
        
        $users = User::find()->all();
        
        foreach ($users as $user)
        {
        /**
         * User $user
         */
            switch ($user->user_type_id) {
                case UserType::ROOT_USER_ID:
                    Console::output("Установлена роль 'Администратор' для пользователя {$user->login}");
                    $auth->assign($adminRole, $user->id);
                    break;
                case UserType::MEMBER_USER_ID:
                    $auth->assign($memberRole, $user->id);
                     Console::output("Установлена роль 'Участник' для пользователя {$user->login}");
                    break;
            }
        }
        return ExitCode::OK;
        
    }

    /**
     * Добавление данных
     */
    public function actionAddData()
    {
        
  /*    $this->loadFixtureFromCSV(new Country(), 'country.csv', [
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
        */
        //$this->addData(PostalAddress::class, './../fixtures/company/postal.address.php');
        //$this->addData(LegalAddress::class, './../fixtures/company/legal.address.php');
        //$this->addData(BankDetail::class, './../fixtures/company/bank.detail.php');
     //   $this->addData(Contact::class, './../fixtures/company/contacts.php');
//        $this->addData(Company::class, './../fixtures/company/company.php');
        
        $this->addData(UserType::class, './../fixtures/user/user.types.php');
        $user = new User();
        $user->login = 'admin';
       // $user->
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
        $sql = 'DELETE FROM '.$prefix.'element_type;'  .
               'DELETE FROM '.$prefix.'form_types;';  
        $this->query($sql);
        $this->addData(ElementType::class, './../fixtures/directory/form-elements.php');
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
       //$db = Yii::$app->db;
     //   $obj::deleteAll();
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
}
