<?php

namespace EbanxChallenge\Controller {

    use EbanxChallenge\Core\InputValidator;
    use EbanxChallenge\Core\Web\ControllerBase;
    use EbanxChallenge\Core\Web\Response\OptionsResponse;
    use EbanxChallenge\Core\Web\Response\ServiceResponse;
    use EbanxChallenge\Core\Web\Context;
    use \EbanxChallenge\Model\AccountModel;

    class ResetController extends ControllerBase
    {
        public $methodsAllowed = "POST";

        public function post() : ServiceResponse
        {
            $model = new AccountModel();
            $model->reset();

            return new ServiceResponse();
        }

    }
}