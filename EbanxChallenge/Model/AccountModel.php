<?php

namespace EbanxChallenge\Model {

    use EbanxChallenge\Core\ModelBase;
    
    class AccountModel extends ModelBase
    {         
        public function getTableName() : string
        {
            return 'balance';
        }

        public function deposit(int $account, int $value) : object | false
        {
            $index = $this->indexOf('id', $account);
            if($index === false) {
                return false;
            }
            $this->data[$index]['balance'] += $value;
            $this->persist();

            $return = new \stdClass();
            $return->destination = (object)$this->data[$index];

            return $return;
        }

        public function withdraw(int $account, int $value) : object | false
        {
            $index = $this->indexOf('id', $account);
            if($index === false) {
                return false;
            }
            $this->data[$index]['balance'] -= $value;
            $this->persist();

            $return = new \stdClass();
            $return->origin = (object)$this->data[$index];

            return $return;
        }

        public function transfer(int $from, int $to, int $value) : object | false
        {
            $fromIndex = $this->indexOf('id', $from);
            $toIndex = $this->indexOf('id', $to);
            if($fromIndex === false || $toIndex === false) {
                return false;
            }
            $this->data[$fromIndex]['balance'] -= $value;
            $this->data[$toIndex]['balance'] += $value;
            $this->persist();

            $return = new \stdClass();
            $return->origin = (object)$this->data[$fromIndex];
            $return->destination = (object)$this->data[$toIndex];

            return $return;
        }
    }
}