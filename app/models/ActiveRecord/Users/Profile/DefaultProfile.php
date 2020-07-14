<?php

namespace app\models\ActiveRecord\Users\Profile;

/**
 * Description of DefaultProfile
 *
 * @author kotov
 */
class DefaultProfile implements UserProfileInterface
{
    
    public function info(): string
    {
        return 'Администратор';
    }

}
