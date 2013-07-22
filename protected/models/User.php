<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $acc_num
 * @property string $name
 * @property string $email
 * @property string $contact
 * @property string $address
 * @property string $dateOfBirth
 * @property integer $country
 * @property string $created
 * @property string $updated
 * @property integer $referral
 * @property integer $packageId
 * @property string $password
 * @property string $bankAcc
 * @property string $bankName
 * @property integer $pin
 * @property integer $tac
 * @property integer $isApproved
 *
 * The followings are the available model relations:
 * @property Wallet[] $wallets
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
         public $packageName ='';
         public $referralName ='';
         public $foodpoint;
         public $bonusAmount;
         
         public $newPassword;
         public $newPassword2;
         public $oldPassword;
         
         public $newPin;
         public $newPin2;
         public $oldPin;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, contact, packageId', 'required'),
                        array('email','email'),
			array('country, referral, packageId, pin, tac, isApproved, newPin, newPin2,oldPin', 'numerical', 'integerOnly'=>true),
			array('acc_num, name, email, contact', 'length', 'max'=>45),
                        array('pin, newPin, newPin2, oldPin, tac', 'length', 'max'=>6),
			array('address', 'length', 'max'=>255),
                    	array('password', 'length', 'max'=>512),
                        array('bankAcc', 'length', 'max'=>100),
			array('bankName', 'length', 'max'=>50),
                        array('created, updated, dateOfBirth, password, oldPassword, newPassword, newPassword2','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, acc_num, name, email, contact, address, dateOfBirth, country, created, updated, referral, packageId, password, bankAcc, bankName, pin, tac, isApproved', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'wallet' => array(self::HAS_ONE, 'Wallet', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'acc_num' => 'Acc Num',
			'name' => 'Name',
			'email' => 'Email',
			'contact' => 'Contact',
			'address' => 'Address',
			'dateOfBirth' => 'Date Of Birth',
			'country' => 'Country',
			'created' => 'Created',
			'updated' => 'Updated',
			'referral' => 'Referral',
			'packageId' => 'Package',
                        'password' => 'Password',
			'bankAcc' => 'Bank Acc',
			'bankName' => 'Bank Name',
			'pin' => 'Pin',
                        'tac' => 'Tac',
                        'isApproved' => 'Is Approved',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('acc_num',$this->acc_num,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('dateOfBirth',$this->dateOfBirth,true);
		$criteria->compare('country',$this->country);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('referral',$this->referral);
		$criteria->compare('packageId',$this->packageId);
                $criteria->compare('password',$this->password,true);
		$criteria->compare('bankAcc',$this->bankAcc,true);
		$criteria->compare('bankName',$this->bankName,true);
		$criteria->compare('pin',$this->pin);
                $criteria->compare('tac',$this->tac);
                $criteria->compare('isApproved',$this->isApproved);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function findEmail($email)
	{
		$user = User::model()->findByAttributes(array('email'=>$email));
		if (!is_null($user))
			throw new Exception("This e-mail {$email} is registered.");
		return $email;
	}

	public static function findReferral($referral)
	{
		$user = User::model()->findByAttributes(array('contact'=>$referral));
		if(is_null($user))
			throw new Exception("Referral is not valid.");
		return $user->id;
	}
        
        public static function findContact($contact)
	{
		$user = User::model()->findByAttributes(array('contact'=>$contact));
		if(!is_null($user))
			throw new Exception("This phone number is registered.");
		return $contact;
	}
        
        public function createUser()
	{
		$this->email = User::findEmail($this->email);
		$this->referral = User::findReferral($this->referral);                
                $this->contact = User::findContact($this->contact);

		$user = new User;
		$user->attributes = array(
			'name'=>$this->name,
			'email'=>$this->email,
			'contact'=>$this->contact,
			'packageId'=>$this->packageId,
			'referral'=>$this->referral,
                        'dateOfBirth'=>date('Y-m-d', strtotime($this->dateOfBirth)),
			'created'=>date('Y-m-d H:i:s'),
                        'password' => md5($this->contact),
                        'isApproved' => 0,
			);                                    
                
		if (!$user->save())
		{
			$error = '';
			foreach ($user->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($user->getErrors());
		}
                
                if($user->packageId == 1) $foodpoint = 600;
                if($user->packageId == 2) $foodpoint = 1650;
                if($user->packageId == 3) $foodpoint = 3850;
                    
                $wallet = new Wallet;
                $wallet->attributes = array(
                    'foodPoint'=>$foodpoint,
                    'bonusAmout'=> 0,
                    'modifiedDate' => date('Y-m-d H:i:s'),
                    'userId'=>$user->id,
                );
                
                if (!$wallet->save())
		{
			$error = '';
			foreach ($wallet->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($wallet->getErrors());
		}
	}
        
        public function changePassword()
	{
		$user = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                
                if(empty($this->oldPassword)) 
                    throw new Exception("Please fill in old password.");
                if(empty($this->newPassword)) 
                    throw new Exception("Please fill in new password.");
                if(empty($this->newPassword2)) 
                    throw new Exception("Please fill in confirm new password.");
                
		if($user->password == md5($this->oldPassword))
		{
			if(strlen($this->newPassword) >= 6)
			{
				if($this->newPassword == $this->newPassword2)
                                {
                                    $user->password = md5($this->newPassword);
                                    if ($user->save())
                                            return $user;
                                }
                                else 
                                {
                                    throw new Exception('New password does not match!');
                                }
			}
		}
		throw new Exception('Old password is incorrect or new password length is less than 6!');
	}
        
        public function setPin()
	{
		$user = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));

                if(empty($this->tac)) 
                    throw new Exception("TAC is mandatory.");
                if(empty($this->newPin)) 
                    throw new Exception("Please fill in new PIN.");
                if(empty($this->newPin2)) 
                    throw new Exception("Please fill in confirm new PIN.");
                
		if($this->tac==$user->tac)
                {
                    if(strlen($this->newPin) == 6)
                    {
                            if($this->newPin == $this->newPin2)
                            {
                                    $user->pin = $this->newPin;
                                    if ($user->save())
                                            return $user;
                            }
                            else
                            {
                               throw new Exception('New PIN does not match!'); 
                            }
                    }
                    else 
                    {                        
                        throw new Exception('New PIN length is less than 6 numbers!');
                    }
                }
                throw new Exception('TAC is empty or invalid!');
	}
        
        public function editUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));
            
                if($user->email != $this->email)
                {
                    $this->email = User::findEmail($this->email);   
                }  
                
                $this->contact = User::findContact($this->contact);
                                
		$user->attributes = array(
			'name'=>$this->name,
			'email'=>$this->email,
			'contact'=>$this->contact,
                        'bankAcc'=> $this->bankAcc,
                        'bankName'=> $this->bankName,
                        'dateOfBirth'=>date('Y-m-d', strtotime($this->dateOfBirth)),
			);
                
		if (!$user->save())
		{
			$error = '';
			foreach ($user->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($user->getErrors());
		}
	}
        
        public function approveUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));
                                            
		$user->isApproved = true;
                
		if (!$user->save())
		{
			$error = '';
			foreach ($user->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($user->getErrors());
		}
	}
        
        public function setTac()
        {
            $user = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
            
            $tac = $this->randomWithLength(6);
                        
            $user->tac = $tac;
            
            if (!$user->save())
            {
                    $error = '';
                    foreach ($user->getErrors() as $key) {
                            $error .= $key[0];
                    }
                    throw new Exception($user->getErrors());
            }
            
            $msg = 'From Beijing Baked Fish Restaurant: Set PIN. TAC requested is '.$tac.'.';
            
            User::send_sms('6'.$user->contact, $msg);
        }
        
        public function getSponsorNetwork()
        {
            $user = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
            
            $child = User::model()->findAllByAttributes(array('referrel'=>$user->id));
            
            return $child;
        }
        
        public static function getUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));
                
                $user->packageName = Package::getPackageName($user->packageId);                
                $user->referralName = User::getReferralName($user->referral);
                                
                $wallet = Wallet::model()->findByAttributes(array('userId'=>$id));
                if(!is_null($wallet))
                    {
                        $user->foodpoint = $wallet->foodPoint;
                        $user->bonusAmount = $wallet->bonusAmount;
                    }
                
		return $user;
	}
        
        public static function getAllUser()
	{
                $user = User::model()->findAll();

                foreach($user as $u)
                {
                    $u->packageName = Package::getPackageName($u->packageId);                    
                    $u->referralName = User::getReferralName($u->referral);

                    $wallet = Wallet::model()->findByAttributes(array('userId'=>$u->id));
                    if(!is_null($wallet))
                    {
                        $u->foodpoint = $wallet->foodPoint;
                        $u->bonusAmount = $wallet->bonusAmount;
                    }
                }
                
		return $user;
	}
        
        public static function getReferralName($id)
        {                       
            if ($id==0)
            {
                return '0';
            }
            else
            {
                $user = User::model()->findByAttributes(array('id'=>$id));
                return $user->name;
            }       
        }
        
       
        public static function send_sms($sms_to,$sms_msg)  
        {           
                    $query_string = 'api.aspx?apiusername='.'API5Y6NCVIFEQ'.'&apipassword='.'API5Y6NCVIFEQ5Y6NC';
                    $query_string .= "&senderid=".rawurlencode('INFO')."&mobileno=".rawurlencode($sms_to);
                    $query_string .= "&message=".rawurlencode(stripslashes($sms_msg)) . "&languagetype=1";        
                    $url = "http://gateway.onewaysms.com.au:10001/".$query_string;       
                    $fd = @implode ('', file ($url));      
                    if ($fd)  
                    {                       
                                if ($fd > 0) {
//                                    Print("MT ID : " . $fd);
                                    $ok = "success";
                                }        
                                else {
//                                    print("Please refer to API on Error : " . $fd);
                                    $ok = "fail";
                                    throw new Exception('Fail to send TAC! Error : ' . $fd);
                                }
                    }           
                    else      
                    {                        
                                throw new Exception('Fail to send TAC!');       
                    }           
                    return $ok;  
        }
        
        private function randomWithLength($length)
        {
            $number = '';
            for ($i = 0; $i < $length; $i++){
                $number .= rand(0,9);
            }

            return (int)$number;
        }
}