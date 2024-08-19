<?php

namespace EbanxChallenge\Controller {

    use \EbanxChallenge\Core\InputValidator;
    use \EbanxChallenge\Core\Web\ControllerBase;
    use \EbanxChallenge\Core\Web\Response\ServiceResponse;
    use \EbanxChallenge\Core\Web\Context;
    use \EbanxChallenge\Model\AccountModel;
    use \EbanxChallenge\Core\Web\Response\ErrorResponse;
    use \EbanxChallenge\Core\Exception\AccountNotFoundException;

    class BalanceController extends ControllerBase
    {
        public $methodsAllowed = "GET";

        /**
         * Handle de GET request to get the balance of an account.
         *
         * @return ServiceResponse The service response containing the balance.
         */
        public function get() : ServiceResponse
        {
            $model = new AccountModel();
            $account_id = InputValidator::int($_GET["account_id"]);
            $accounts = $model->select("id", $account_id);
            if(count($accounts) == 0)
            {
                return new ServiceResponse(0, 404);
            } 
            else 
            {
                return new ServiceResponse($accounts[0]["balance"]);
            }
        }

    }
}