<?php

namespace EbanxChallenge\Controller {

    use EbanxChallenge\Core\InputValidator;
    use EbanxChallenge\Core\Web\ControllerBase;
    use EbanxChallenge\Core\Web\Response\OptionsResponse;
    use EbanxChallenge\Core\Web\Response\ServiceResponse;
    use EbanxChallenge\Core\Web\Context;
    use EbanxChallenge\Model\AccountModel;

    class EventController extends ControllerBase
    {
        public $methodsAllowed = "POST";

        public function post() : ServiceResponse
        {
            $eventData = Context::$request->inputData;

            $model = new AccountModel();
            $actionResult = null;
            switch($eventData->type) {
                case 'deposit':
                    $actionResult = $model->deposit($eventData->destination, $eventData->amount);
                    break;
                case 'withdraw':
                    $actionResult = $model->withdraw($eventData->origin, $eventData->amount);
                    break;
                case 'transfer':
                    $actionResult = $model->transfer($eventData->origin, $eventData->destination, $eventData->amount);
                    break;
            }
            if($actionResult === false) {
                return new ServiceResponse(0, 404);
            }
            else {
                return new ServiceResponse($actionResult, 201);
            }
        }

    }
}