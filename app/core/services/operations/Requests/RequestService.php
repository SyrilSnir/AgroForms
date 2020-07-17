<?php

namespace app\core\services\operations\Requests;

use app\core\repositories\manage\Requests\RequestRepository;
use app\models\ActiveRecord\Requests\Request;

/**
 * Description of RequestService
 *
 * @author kotov
 */
class RequestService
{
    /**
     *
     * @var RequestRepository
     */
    protected $requests;
    
    public function __construct(RequestRepository $requests)
    {
        $this->requests = $requests;
    }

    public function remove ($id) 
    { 
        /** @var Request $request */
        $request = $this->requests->get($id);
        $form = $request->requestForm;
        if ($form) {
            $form->delete();
        }
        $this->requests->remove($request);
    }
}
