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
 * @property integer $isActivated
 * @property string $remark
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
	public $foodPoint;
	public $cashPoint;
	public $bonusAmount;
	
	public $newPassword;
	public $newPassword2;
	public $oldPassword;
	
	public $newPin;
	public $newPin2;
	public $oldPin;

	public $total_sales;

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
			array('country, referral, packageId, pin, tac, isApproved, isActivated, newPin, newPin2,oldPin', 'numerical', 'integerOnly'=>true),
			array('acc_num, name, email, contact', 'length', 'max'=>45),
			array('pin, newPin, newPin2, oldPin, tac', 'length', 'max'=>6),
			array('address', 'length', 'max'=>255),
			array('password', 'length', 'max'=>512),
			array('bankAcc', 'length', 'max'=>100),
			array('bankName', 'length', 'max'=>50),
			array('id, created, updated, dateOfBirth, password, oldPassword, newPassword, newPassword2, remark','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, acc_num, name, email, contact, address, dateOfBirth, country, created, updated, referral, packageId, password, bankAcc, bankName, pin, tac, isApproved, isActivated', 'safe', 'on'=>'search'),
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
			'package' => array(self::BELONGS_TO, 'Package', 'packageId'),
			'binary' => array(self::HAS_ONE, 'Binary', 'userId', 'order'=>'id ASC'),
			'binaryNodes' => array(self::HAS_MANY, 'Binary', 'userId'),
			'referredUsers' => array(self::HAS_MANY, 'User', 'referral'),
			'sponsor' => array(self::BELONGS_TO, 'User', 'referral', 'with'=>'package'),
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
			'isActivated' => 'Is Activated',
			'remark' => 'Remark',
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
		$criteria->compare('isActivated',$this->isActivated);
		$criteria->compare('remark',$this->remark,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function scopes()
	{
		return array(
			'activated' => array(
				'condition' => 'isActivated = 1',
				),
			);
	}

	public function between($start, $end)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'created BETWEEN :start AND :end',
			'params' => array(':start' => $start, ':end' => $end),
			));
		return $this;
	}

	public function sales()
	{
		$this->getDbCriteria()->mergeWith(array(
			'with' => 'package',
			'select' => 'IFNULL(0,SUM(package.value)) as total_sales'
			));
		return $this;
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
			'password' => md5('abc123'),
			'isApproved' => 0,
			'isActivated'=>0,
			);

		if (!$user->save())
		{
			$error = '';
			foreach ($user->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($user->getErrors());
		}

		if($user->packageId == 1) $foodPoint = 600;
		if($user->packageId == 2) $foodPoint = 1650;
		if($user->packageId == 3) $foodPoint = 3850;

		$wallet = new Wallet;
		$wallet->attributes = array(
			'foodPoint'=>$foodPoint,
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

	public function resetPassword()
	{
		if(empty($this->contact)) 
			throw new Exception("Please fill in phone number.");

		$user = User::model()->findByAttributes(array('contact'=>$this->contact));

		if(is_null($user))
			throw new Exception('This phone number is not a member.');

		$password = $this->random_code(6);

		$msg = 'From Beijing Baked Fish Restaurant: Reset Password. New password requested is '.$password.'.';

		$sms = User::send_sms('6'.$this->contact, $msg);

		if($sms!='success')
			throw new Exception('This phone number is invalid.');

		$user->password = md5($password);

		if (!$user->save())
		{
			$error = '';
			foreach ($user->getErrors() as $key)
				$error .= $key[0];
			throw new Exception($user->getErrors());
		}
	}

	public function editUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));

		if($user->email != $this->email)
			$this->email = User::findEmail($this->email);   

		if($user->contact != $this->contact)
			$this->contact = User::findContact($this->contact);

		$user->attributes = array(
			'name'=>$this->name,
			'email'=>$this->email,
			'contact'=>$this->contact,
			'bankAcc'=> $this->bankAcc,
			'bankName'=> $this->bankName,
			'dateOfBirth'=>date('Y-m-d', strtotime($this->dateOfBirth)),
			);

		if (!$user->update())
			throw new Exception("Fail to update user info.");
	}

	public function approveUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));
		if(empty($user))
			throw new Exception("User is not found!", 1);
			
		$first_time_activate = $user->isActivated;

		$user->isApproved = true;
		if (!$first_time_activate)
			$user->isActivated = 1;

		if (!$user->save()) {
			$error = '';
			foreach ($user->getErrors() as $key)
				$error .= $key[0];
			throw new Exception($user->getErrors());
		}

		if (!$first_time_activate) {
			Binary::create($user);
			$msg = 'Your account is activated, login via www.beijingbakedfish.com/member, with phone number and default password is abc123, thanks.';
			$this->send_sms($user->contact, $msg);
		}
	}

	public function disapproveUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));
		$user->isApproved = 0;

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

	public function deductFP($amount,$tranType)
	{
		$user = User::model()->findByAttributes(array('id'=>$this->id));

		if(!empty($this->pin) && $this->pin == $user->pin)
		{
			if($tranType=='CREDIT')
			{
				Transaction::transferFP($user, array(
					'amount'=>$amount,
					'type'=>'CREDIT', 
					'description'=>'Deduct Redemption Point: '.$user->name.'.',
					));
			}
			else
			{
				Transaction::transferFP($user, array(
					'amount'=>$amount,
					'type'=>'DEBIT',
					'description'=>'Transfer Redemption Point from '.$user->name.'.',
					));
			}
		}
		else 
			throw new Exception('This PIN is invalid!');
	}

	public function deductCP($amount,$tranType)
	{
		$user = User::model()->findByAttributes(array('id'=>$this->id));

		if($this->pin == $user->pin)
		{
			if($tranType=='CREDIT')
			{
				Transaction::create($user, array(
					'amount'=>$amount,
					'point'=>Transaction::TRAN_CP,
					'type'=>'CREDIT',
					'description'=>'Deduct Cash Point: '.$user->name.'.',
					));
			}
		}
		else 
			throw new Exception('This PIN is invalid!');
	}

	public function manualCreateBill($id, $amountCP, $amountRP, $date)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));

		Transaction::create($user, array(
			'amount'=>$amountRP,
			'point'=>Transaction::TRAN_FP,
			'type'=>'CREDIT',
			'date'=>$date,
			'description'=>'Deduct Redemption Point: '.$user->name.'.',
			));

		Transaction::create($user, array(
					'amount'=>$amountCP,
					'point'=>Transaction::TRAN_CP,
					'type'=>'CREDIT',
					'date'=>$date,
					'description'=>'Deduct Cash Point: '.$user->name.'.',
					));
	}

	public static function transferCP($member, $curUser, $amount)
	{
		Transaction::create($curUser, array(
			'amount'=>$amount,
			'point'=>Transaction::TRAN_CP,
			'type'=>'CREDIT', 
			'description'=>'Transfer Cash Point to '.$member->name.'.',
			));

		Transaction::create($member, array(
			'amount'=>$amount,
			'point'=>Transaction::TRAN_CP,
			'type'=>'DEBIT',
			'description'=>'Transfer Cash Point from '.$curUser->name.'.',
			));
	}

	public static function transferRP($member, $curUser, $amount)
	{
		Transaction::create($curUser, array(
			'amount'=>$amount,
			'point'=>Transaction::TRAN_CP,
			'type'=>'CREDIT', 
			'description'=>'Transfer Redemption Point to '.$member->name.'.',
			));

		Transaction::create($member, array(
			'amount'=>$amount,
			'point'=>Transaction::TRAN_FP,
			'type'=>'DEBIT',
			'description'=>'Transfer Redemption Point from '.$curUser->name.'.',
			));
	}
        
    public static function transferCPtoFP($member, $amount)
	{
		Transaction::create($member, array(
			'amount'=>$amount,
			'point'=>Transaction::TRAN_CP,
			'type'=>'CREDIT', 
			'description'=>'Transfer Cash Point to '.$member->name.'.',
			));

		Transaction::create($member, array(
			'amount'=>$amount,
			'point'=>Transaction::TRAN_FP,
			'type'=>'DEBIT',
			'description'=>'Transfer Food Point from '.$member->name.'.',
			));
	}
        
	public static function smsToAll($msg)
	{
		$user = User::model()->findAll();

		foreach($user as $u)
		{
			if ($u->id != 1) User::send_sms('6'.$u->contact,$msg);
		}
	}
        
    public function referMember()
	{
		$this->email = User::findEmail($this->email);
		$this->contact = User::findContact($this->contact);
		$this->referral = User::findReferral($this->referral);

        if($this->packageId == 1) $amount = 500;
		if($this->packageId == 2) $amount = 1500;
		if($this->packageId == 3) $amount = 3500;
                
        
        if($this->referral != 1)
        {
	        Transaction::create(User::getUser(Yii::app()->user->id), array(
				'amount'=>$amount,
				'point'=>Transaction::TRAN_CP,
				'type'=>'CREDIT',
				'description'=>'Transfer Cash Point to refer a member : '.$this->name.', Package : '.Package::getPackageName($this->packageId),
				));
    	}
                
		$user = new User;
		$user->attributes = array(
			'name'=>$this->name,
			'email'=>$this->email,
			'contact'=>$this->contact,
			'packageId'=>$this->packageId,
			'referral'=>$this->referral,
			'dateOfBirth'=>date('Y-m-d', strtotime($this->dateOfBirth)),
			'created'=>date('Y-m-d H:i:s'),
			'password' => md5('abc123'),
			'isApproved' => 0,
			'isActivated'=>0,
			);

		if (!$user->save())
		{
			$error = '';
			foreach ($user->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($user->getErrors());
		}

		if($user->packageId == 1) $foodPoint = 600;
		if($user->packageId == 2) $foodPoint = 1650;
		if($user->packageId == 3) $foodPoint = 3850;

		$wallet = new Wallet;
		$wallet->attributes = array(
			'foodPoint'=>$foodPoint,
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

	public static function smsTo($id,$msg)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));

		if ($user->id != 1) User::send_sms('6'.$user->contact,$msg);
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

		$wallet = $user->wallet;
		if(!is_null($wallet))
		{
			$user->foodPoint = $wallet->foodPoint;
			$user->cashPoint = $wallet->cashPoint;
			$user->bonusAmount = $wallet->bonusAmount;
		}

		return $user;
	}

	public static function getUserByPhone($ph)
	{
		$user = User::model()->findByAttributes(array('contact'=>$ph));

		if(is_null($user))
			throw new Exception("User is not found!", 1);			

		$user->packageName = Package::getPackageName($user->packageId);
		$user->referralName = User::getReferralName($user->referral);

		$wallet = $user->wallet;
		if(!is_null($wallet))
		{
			$user->foodPoint = $wallet->foodPoint;
			$user->cashPoint = $wallet->cashPoint;
			$user->bonusAmount = $wallet->bonusAmount;
		}

		return $user;
	}

	public static function getAllUser()
	{
		$user = User::model()->findAll(array('order'=>'name'));

		foreach($user as $u)
		{
			$u->packageName = Package::getPackageName($u->packageId);                    
			$u->referralName = User::getReferralName($u->referral);

			$wallet = $u->wallet;
			if(!is_null($wallet))
			{
				$u->foodPoint = $wallet->foodPoint;
				$u->cashPoint = $wallet->cashPoint;
				$u->bonusAmount = $wallet->bonusAmount;
			}
		}

		return $user;
	}

	public static function getUserDropDownList()
	{
		$user = User::getAllUser();
		$result = array();

		foreach ($user as $u) {
			if($u->id != Yii::app()->user->id && $u->id != 1) $result[$u->id] = $u->name.' ('.$u->contact.') - [CP: '.number_format($u->cashPoint, 2).' | RP:'.number_format($u->foodPoint, 2).']';
		}

		return $result;
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
		if(preg_match("/\p{Han}+/u", $sms_msg))
		{
			$query_string = 'apichinese.aspx?apiusername='.'API5Y6NCVIFEQ'.'&apipassword='.'API5Y6NCVIFEQ5Y6NC';
			$query_string .= "&senderid=".rawurlencode('INFO')."&languagetype=2&mobileno=".rawurlencode($sms_to);
			$query_string .= "&message=".rawurlencode(stripslashes($sms_msg));
			$url = "http://gateway80.onewaysms.com.my/".$query_string;
		}
		else
		{
			$query_string = 'api.aspx?apiusername='.'API5Y6NCVIFEQ'.'&apipassword='.'API5Y6NCVIFEQ5Y6NC';
			$query_string .= "&senderid=".rawurlencode('INFO')."&mobileno=".rawurlencode($sms_to);
			$query_string .= "&message=".rawurlencode(stripslashes($sms_msg)) . "&languagetype=1";
			$url = "http://gateway.onewaysms.com.au:10001/".$query_string;
		}
		$fd = @implode ('', file ($url));
		if ($fd)
		{
			if ($fd > 0) {
				// Print("MT ID : " . $fd);
				$ok = "success";
			}
			else {
				// print("Please refer to API on Error : " . $fd);
				$ok = "fail";
				throw new Exception('Fail to send! Error : ' . $fd);
			}
		}
		else
		{
			throw new Exception('Fail to send!');
		}
		return $ok;
	}

	public function checkSMSCredit()
	{
		$query_string = 'http://gateway.onewaysms.com.my:10001/bulkcredit.aspx'.'?apiusername='.'API5Y6NCVIFEQ'.'&apipassword='.'API5Y6NCVIFEQ5Y6NC';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $query_string);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		return $ch;
	}

	public function topup($id)
	{
		$user = User::findByAttributes(array('id'=>$id));
		
		$packageTo = Package::model()->findByAttributes(array('id'=>$this->packageId));
		$packageFrom = Package::model()->findByAttributes(array('id'=>$user->packageId));

		if(is_null($packageTo) || is_null($packageTo)) throw new Exception("Error to get package");

		$user->remark = $user->remark.'Topup '.Package::getPackageName($packageTo->id).';';
		
		if($packageTo->value > $packageFrom->value)
			$user->packageId = $this->packageId;

		if (!$user->save())
		{
			$error = '';
			foreach ($user->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($user->getErrors());
		}

		if($user->packageId == 1) $foodPoint = 600;
		if($user->packageId == 2) $foodPoint = 1650;
		if($user->packageId == 3) $foodPoint = 3850;

		$wallet = $user->wallet;
		$wallet->attributes = array(
			'foodPoint'=>$wallet->foodPoint+$foodPoint,
			'modifiedDate' => date('Y-m-d H:i:s'),
			);

		if (!$wallet->save())
		{
			$error = '';
			foreach ($wallet->getErrors() as $key) {
				$error .= $key[0];
			}
			throw new Exception($wallet->getErrors());
		}

		Binary::create($user);
		network::setSponsorBonus($user->id);
	}

	private function randomWithLength($length)
	{
		$number = '';
		for ($i = 0; $i < $length; $i++){
			$number .= rand(0,9);
		}

		return (int)$number;
	}

	public function random_code($length) 
	{
		$key = '';
		$keys = array_merge(range(0, 9), range('a', 'z'));

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $key;
	}
}