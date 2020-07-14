<?php

namespace app\models\Forms\Manage\Users\Profiles;

use app\models\ActiveRecord\Users\Profile\MemberProfile;
use yii\base\Model;

/**
 * Description of MemberProfileForm
 *
 * @author kotov
 */
class MemberProfileForm extends Model
{
    public $position;
    public $activities;
    public $proposalSignaturePost;
    public $proposalSignatureName;
    
    public function __construct(MemberProfile $profile = null,$config = array())
    {
        parent::__construct($config);
        if ($profile) {
            $this->position = $profile->position;
            $this->activities = $profile->activities;
            $this->proposalSignatureName = $profile->proposal_signature_name;
            $this->proposalSignaturePost = $profile->proposal_signature_post;
        }
    }

    public function rules(): array
    {
        return [
                [['position','activities','proposalSignaturePost','proposalSignatureName'],'string', 'max' => 255]
            ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'position' => 'Должность',
            'activities' => 'Сфера деятельности компании',
            'proposalSignaturePost' => 'Должность подписанта',
            'proposalSignatureName' => 'ФИО подписанта',
        ];
    }    
}
