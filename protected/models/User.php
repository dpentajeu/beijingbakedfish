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
			array('country, referral, packageId', 'numerical', 'integerOnly'=>true),
			array('acc_num, name, email, contact', 'length', 'max'=>45),
			array('address', 'length', 'max'=>255),
                        array('created, updated, dateOfBirth','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, acc_num, name, email, contact, address, dateOfBirth, country, created, updated, referral, packageId', 'safe', 'on'=>'search'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function findEmail($email, $throw = true)
	{
		$model = User::model()->findByAttributes(array('email'=>$email));
		if ($throw && is_null($model))
			throw new Exception("E-mail {$email} not found.");
		return $model;
	}

	public static function findReferral($referral)
	{
		$user = User::model()->findByAttributes(array('contact'=>$referral));
		if(is_null($user))
			throw new Exception("Referral is not valid.");
		return $user->id;
	}
        
        public function createUser()
	{
		if (!is_null(User::findEmail($this->email, false)))
			throw new Exception("This e-mail {$this->email} is registered.");

		$this->referral = User::findReferral($this->referral);

		$user = new User;
		$user->attributes = array(
			'name'=>$this->name,
			'email'=>$this->email,
			'contact'=>$this->contact,
			'packageId'=>$this->packageId,
			'referral'=>$this->referral,
                        'dateOfBirth'=>date('Y-m-d', strtotime($this->dateOfBirth)),
			'created'=>date('Y-m-d H:i:s'),
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
        
        public function editUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));
            
                if($user->email != $this->email)
                {
                    if (!is_null(User::findEmail($this->email, false)))
			throw new Exception("This e-mail {$this->email} is registered.");    
                }
                                
		$user->attributes = array(
			'name'=>$this->name,
			'email'=>$this->email,
			'contact'=>$this->contact,
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
        
        public static function getUser($id)
	{
		$user = User::model()->findByAttributes(array('id'=>$id));
                
                $user->packageName = Package::getPackageName($user->packageId);                
                $user->referralName = User::getReferralName($user->referral);
                
		return $user;
	}
        
        public static function getAllUser()
	{
                if (Yii::app()->user->id==1)
                {
                    $user = User::model()->findAll();
                
                    foreach($user as $u)
                    {
                        $u->packageName = Package::getPackageName($u->packageId);                    
                        $u->referralName = User::getReferralName($u->referral);
                    }
                    
                }
                else
                {
                    $user = User::model()->findByAttributes(array('id'=>Yii::app()->user->id));
                    $user->packageName = Package::getPackageName($user->packageId);                    
                    $user->referralName = User::getReferralName($user->referral);
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
}