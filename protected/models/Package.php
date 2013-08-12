<?php

/**
 * This is the model class for table "package".
 *
 * The followings are the available columns in table 'package':
 * @property string $id
 * @property string $packageName
 * @property double $value
 * @property integer $level
 */
class Package extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Package the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'package';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('packageName, value', 'required'),
                        array('level', 'numerical', 'integerOnly'=>true),
			array('value', 'numerical'),
			array('packageName', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, packageName, value, level', 'safe', 'on'=>'search'),
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
			'users' => array(self::HAS_MANY, 'User', 'packageId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'packageName' => 'Package Name',
			'value' => 'Value',
                        'level' => 'Level',
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
		$criteria->compare('packageName',$this->packageName,true);
		$criteria->compare('value',$this->value);
                $criteria->compare('level',$this->level);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getAllPackages()
	{
		$packages = Package::model()->findAll();
		$result = array();

		foreach ($packages as $p) {
			$result[$p->id] = $p->packageName.' - RM'.$p->value;
		}

		return $result;
	}

	public static function getPackageName($packageId)
	{		                
            if ($packageId==0)
            {
                return '0';
            }
            else
            {
                $package = Package::model()->findByAttributes(array('id'=>$packageId));
		return $package->packageName.' - RM'.$package->value;
            }
	}
}