<?php

class MemberController extends Controller
{
        public $layout = "main3";
	/**
	 * Declares class-based actions.
	 */
        public $name ='';
        
        public function filters()
	{
		return array(
			'accessControl',
			);
	}
        
        public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array(
                                        'login','logout'
					),
				'users'=>array('*'),
				),
                        array('allow',
				'actions'=>array('index','editmember','changepassword','setpin','approve','test','test2'),
				'users'=>array('@'),
				),
//			array('allow',
//				'actions'=>array('approve','test','test2'),
//				'roles'=>array('admin'),
//				),
			array('deny'),
			);
	}
        
        protected final function beforeAction($action)
        {              
            if(!is_null(Yii::app()->user->id))
            {
                $model = User::getUser(Yii::app()->user->id);
                $this->name = $model->name;  
            }
		
            return true;
        }
                    
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            if(Yii::app()->user->id == 1) $model = User::getAllUser();
            else $model = User::getUser(Yii::app()->user->id);
           
            $this->render('index',array('model'=>$model));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = 'login';
                $model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect('index');
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('login');
	}
        
        public function actionEditmember($id = null)
	{
                if(Yii::app()->user->isGuest)
                    $this->redirect('login');
                
                if(Yii::app()->user->id != 1)
                {
                    if($id != null) $this->redirect('editmember');
                    
                    $id = Yii::app()->user->id;
                }
            
                $model = User::getUser($id);
		$packages = Package::getAllPackages();
		$CMessage = '';

		if(isset($_POST['User']))
		{
                    $model->attributes = $_POST['User'];
                    
                    try
                    {
                            if (!$model->validate())
                                    throw new Exception("Please fill in all fields in the forms correctly.");
                            $model->editUser($id);
                            $CMessage = 'Member has been updated succesfully.';
                            
                            $this->redirect('index');
                    }
                    catch (Exception $e)
                    {
                            $CMessage = $e->getMessage();
                    }
		}

		$this->render('editmember', array('model'=>$model, 'packages'=>$packages, 'CMessage'=>$CMessage));
	}
        
        public function actionApprove($id = null)
	{            
                if (Yii::app()->user->id != 1) $this->redirect('login');
            
                $model = User::getUser($id);
		$CMessage = '';

                try
                {
                        $model->approveUser($id);
                        $CMessage = 'Member has approved.';

                        $this->redirect('index');
                }
                catch (Exception $e)
                {
                        $CMessage = $e->getMessage();
                }

		$this->redirect('index');
	}
        
        public function actionChangepassword()
        {
                $model = new User;
		$CMessage = '';
                $notice = '';

		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			try
			{
                                $model->changePassword();
				$notice = 'Password changed successfully!';
				$model = new User;
			}
			catch (Exception $e)
			{
				$CMessage = $e->getMessage();
			}		
		}

		$this->render('changepassword',array('model'=>$model, 'CMessage'=>$CMessage,'notice'=>$notice));
        }
        
        public function actionSetpin()
        {
                $model = new User;
		$CMessage = '';
                $notice = '';
                
                if(isset($_POST['setTac']))
                {
                    try
                    {
                            $model->setTac();
                            $notice = 'TAC is requested, please wait.';
                    }
                    catch (Exception $e)
                    {
                            $CMessage = $e->getMessage();
                    }
                }                
		else if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			try
			{
                                $model->setPin();
				$notice = 'New PIN is set successfully!';
				$model = new User;
			}
			catch (Exception $e)
			{
				$CMessage = $e->getMessage();
			}		
		}

		$this->render('setpin',array('model'=>$model, 'CMessage'=>$CMessage,'notice'=>$notice));
        }
        
        public function actionNetwork()
        {
            $this->render('network');
        }
        
        public function actionTest()
        {
            if (Yii::app()->user->id != 1) $this->redirect('login');
            
            $user = User::model()->findAll();            
            
            foreach($user as $u)
            {
                if($u->id != 1)
                {
                    if($u->packageId == 1) $foodpoint = 600;
                    if($u->packageId == 2) $foodpoint = 1650;
                    if($u->packageId == 3) $foodpoint = 3850;
                    
                    $wallet = new Wallet;
                    $wallet->attributes = array(
                        'foodPoint'=>$foodpoint,
                        'modifiedDate' => date('Y-m-d H:i:s'),
                        'userId'=>$u->id,
                    );
                    
                    if (!$wallet->save())
                    {
                            $error = '';
                            foreach ($user->getErrors() as $key) {
                                    $error .= $key[0];
                            }
                            throw new Exception($user->getErrors());
                    }
                }             
            }         
                        
            $this->redirect('login');
        }
        
        public function actionTest2()
        {
            if (Yii::app()->user->id != 1) $this->redirect('login');
            
            $user = User::model()->findAll();
            
            foreach($user as $u)
            {
                if($u->id != 1)
                {
                    $u->password = md5($u->contact);
                }
                else
                {
                    $u->password = md5('admin321');
                }
                
                if (!$u->save())
                {
                        $error = '';
                        foreach ($user->getErrors() as $key) {
                                $error .= $key[0];
                        }
                        throw new Exception($user->getErrors());
                }
            }    
            
            $this->redirect('login');
        }
}