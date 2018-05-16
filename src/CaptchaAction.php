<?php

/*

public function actions()
{
    return [
        'captcha' => [
            'class' => 'denis909\yii\captcha\CaptchaAction',
            'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            'testLimit' => 10,
            'width' => 150,
            'height' => 49,
            'offset' => 10,
            'minLength' => 5,
            'maxLength' => 5,
            'padding' => 0,
            'foreColor' => 0x4a4949,
            //'resetValidCaptcha' => false                
        ]
    ];
}

Если включить resetValidCaptcha в false то надо вручную обнулять в контроллере после сабмита формы.

$captcha = $this->createAction('captcha');
	        
$captcha->reset();

*/

namespace denis909\yii\captcha;

use Yii;

class CaptchaAction extends \yii\captcha\CaptchaAction
{

	public $resetValidCaptcha = true;

	public function reset()
	{
		$this->getVerifyCode(true);
	}
	
	protected function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength)
        {
            $this->maxLength = $this->minLength;
        }
        
        if ($this->minLength < 3)
        {
            $this->minLength = 3;
        }
        
        if ($this->maxLength > 20)
        {
            $this->maxLength = 20;
        }
        
        $length = mt_rand($this->minLength, $this->maxLength);
        
        $letters = '123456789012345678901';
        
        $vowels = '12345';

        $code = '';
        
        for ($i = 0; $i < $length; ++$i)
        {
            if ($i % 2 && mt_rand(0, 10) > 2 || !($i % 2) && mt_rand(0, 10) > 9)
            {
                $code .= $vowels[mt_rand(0, 4)];
            }
            else
            {
                $code .= $letters[mt_rand(0, 20)];
            }
        }

        $length = strlen($code);

        $pos = floor($length / 2);

        $code = substr($code, 0, $pos) . '-' . substr($code, $pos);
        
        return $code;
    }

    public function validate($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();

        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;

        $session = Yii::$app->getSession();

        $session->open();

        $name = $this->getSessionKey() . 'count';

        $session[$name] = $session[$name] + 1;

        if ($valid && $this->resetValidCaptcha)
        {
        	$this->reset();	
        }

		if ($session[$name] > $this->testLimit && $this->testLimit > 0)
		{
			$this->reset();
		}
        
        return $valid;
    }
    
}