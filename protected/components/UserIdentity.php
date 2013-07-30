<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
        const ERROR_ACCOUNT_NOT_APPROVED=67;	
        protected $_id;
        /**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array('email'=>$this->username));
		if(is_null($user))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($user->password != md5($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
                else if($user->isApproved != true)
			$this->errorCode=self::ERROR_ACCOUNT_NOT_APPROVED;
		else
                {
			$this->errorCode=self::ERROR_NONE;
                        $this->_id = $user->id;
                        
                        if($this->_id == 1)
                        {
                            $this->setState('roles','admin');
                        }
                }
		return !$this->errorCode;
	}
        
        public function getId()
        {
            return $this->_id;
        }
        
        public function getErrorMessageX()
        {
            switch ($this->errorCode)
            {
                case self::ERROR_USERNAME_INVALID:
                    return 'User does not exists';

                case self::ERROR_PASSWORD_INVALID:
                    return 'Password does not match';

                case self::ERROR_ACCOUNT_NOT_APPROVED:
                    return 'This Account has not approved';
            }
        }
}