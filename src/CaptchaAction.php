<?php

/**
 * Модифицированная версия капчи, теперь не надо её постоянно вводить 
 * при заполнении формы, но требуется ручной ресет после успешного 
 * сабмита формы.
 *
 * $captcha = $this->createAction('captcha');
 *	        
 * $captcha->reset();
**/

namespace denis909\yii;

use Yii;

class CaptchaAction extends \yii\captcha\CaptchaAction
{

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
        
        //$letters = 'bcdfghjklmnpqrstvwxyz';
        
        $letters = '123456789012345678901';
        
        //$vowels = 'aeiou';
        
        $vowels = '12345';
        
        //vowels = 'йцшщъфыджэюбья';

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

		if (/*$valid ||*/$session[$name] > $this->testLimit && $this->testLimit > 0)
		{
			$this->getVerifyCode(true);
		}
        
        return $valid;
    }
    
}