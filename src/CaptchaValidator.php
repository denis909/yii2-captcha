<?php

/*

public function rules()
{
	return [
		[
			'verifyCode', 
			\denis909\yii\captcha\CaptchaValidator::className(), 
			'attribute2' => 'verifyCode2',
			'captchaAction' => '/site/captcha'
		]
	];
}

*/

namespace denis909\yii\captcha;

class CaptchaValidator extends \yii\captcha\CaptchaValidator
{

	public $attribute2;

    public function validateAttribute($model, $attribute)
    {
    	$attribute2 = $this->attribute2;

        $result = $this->validateValue($model->$attribute . '-' . $model->$attribute2);

        if (!empty($result))
        {
            $this->addError($model, $attribute, $result[0], $result[1]);
     
            $this->addError($model, $attribute2, $result[0], $result[1]);
        }
    }

}