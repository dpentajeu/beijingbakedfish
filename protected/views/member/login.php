<!DOCTYPE html >
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Beijing Baked Fish</title>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/member-login.css" type="text/css" media="all" />
</head>
<body>
<div class="wrap">
	<div id="content">
		<div id="main">
			<div class="full_w">
                            <div class="form">
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                        'id'=>'login-form',
                                        'enableClientValidation'=>true,
                                        'clientOptions'=>array(
                                                'validateOnSubmit'=>true,
                                        ),
                                )); ?>
                                        <div class="row">
                                                <label for="login">Username:</label>
                                                <?php echo $form->textField($model,'username',array('class'=>'text')); ?>
                                                <?php echo $form->error($model,'username'); ?>
                                        </div>

                                        <div class="row">
                                                <label for="pass">Password:</label>
                                                <?php echo $form->passwordField($model,'password',array('class'=>'text')); ?>
                                                <?php echo $form->error($model,'password'); ?>
                                        </div>

                                        <div class="row buttons">
                                                <button type="submit" class="ok">Login</button> 
                                                <a class="button" href="">Forgotten password?</a>
                                                <a class="button" href="">First time login?</a>
                                        </div>

                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
			<div class="footer">&raquo; <a href="http://beijingbakedfish.com">beijingbakedfish.com</a></div>
		</div>
	</div>
</div>

</body>
</html>
