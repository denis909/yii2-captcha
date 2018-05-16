<?php

namespace denis909\yii\captcha;

use yii\helpers\Html;

class CaptchaImage extends \yii\captcha\Captcha
{

	public $template = '{image}';

	public $name = 'temp';

	public $model = 'temp';

	public $attribute = 'temp';

    public function run()
    {
        $this->registerClientScript();
        //$input = $this->renderInputHtml('text');
        $route = $this->captchaAction;
        if (is_array($route)) {
            $route['v'] = uniqid('', true);
        } else {
            $route = [$route, 'v' => uniqid('', true)];
        }
        $image = Html::img($route, $this->imageOptions);
        echo strtr($this->template, [
          //  '{input}' => $input,
            '{image}' => $image,
        ]);
    }

}