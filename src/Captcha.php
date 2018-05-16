<?php

/*

	<?= $form->field($model, 'verifyCode')->widget(denis909\yii\captcha\Captcha::className(), [
		'captchaAction' => '/site/captcha',
		'options' => [
			'class' => 'form-control'
		],					
		'attribute2' => 'verifyCode2',
		'attribute2Options' => [
			'class' => $model->hasErrors('verifyCode') ? 'form-control ' . $form->errorCssClass : 'form-control'
		],				
		'containerTag' => 'div',
		'containerOptions' => [
			'class' => 'row gutters-xs'
		],					
		'imageContainerTag' => 'div',
		'imageContainerOptions' => [
			'class' => 'col-3',
			'style' => 'min-width: 164px;'
		],
		'devider' => '&mdash;',
		'deviderTag' => 'div',
		'deviderOptions' => [
			'class' => 'col-xs',
			'style' => 'padding-top: 8px;'
		],
		'attributeContainerTag' => 'div',
		'attributeContainerOptions' => [
			'class' => 'col-2'
		],
		'attribute2ContainerTag' => 'div',
		'attribute2ContainerOptions' => [
			'class' => 'col-2'
		]
	]);?>

*/

namespace denis909\yii\captcha;

use yii\helpers\Html;
use yii\base\InvalidConfigException;

class Captcha extends \yii\widgets\InputWidget
{

	public $captchaImageClass = 'denis909\yii\captcha\CaptchaImage';

	public $captchaAction;

	public $containerTag;

	public $containerOptions = [];

	public $imageContainerTag;

	public $imageContainerOptions = [];

	public $devider = '-';

	public $deviderTag;

	public $deviderOptions = [];

	public $template = '{image} {input} {devider} {input2}';

	public $attribute2;

	public $attribute2Name;

	public $attribute2Value;

	public $attribute2Options = [];

	public $attributeContainerTag;

	public $attributeContainerOptions = [];

	public $attribute2ContainerTag;

	public $attribute2ContainerOptions = [];

    public function init()
    {
        if (!$this->attribute2Name && !$this->attribute2) {
            throw new InvalidConfigException("Either 'attribute2Name' or 'attribute2' properties must be specified.");
        }

        if (!isset($this->attribute2Options['id']))
        {
            $this->attribute2Options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute2) : $this->getId() . '2';
        }       
     
        parent::init();
    }	

	public function run()
	{
		$captchaImageClass = $this->captchaImageClass;

		$image = $captchaImageClass::widget([
			'captchaAction' => $this->captchaAction,
			'template' => '{image}'
		]);

		if ($this->imageContainerTag)
		{
			$image = Html::tag($this->imageContainerTag, $image, $this->imageContainerOptions);
		}

		$devider = $this->devider;

		if ($this->deviderTag)
		{
			$devider = Html::tag($this->deviderTag, $devider, $this->deviderOptions);
		}

		$input = $this->renderInputHtml('text');

		if ($this->attributeContainerTag)
		{
			$input = Html::tag($this->attributeContainerTag, $input, $this->attributeContainerOptions);
		}

		$input2 = $this->renderInput2Html('text');

		if ($this->attribute2ContainerTag)
		{
			$input2 = Html::tag($this->attribute2ContainerTag, $input2, $this->attribute2ContainerOptions);
		}

		$return = strtr($this->template, [
			'{image}' => $image,
			'{devider}' => $devider,
			'{input}' => $input,
			'{input2}' => $input2
		]);

		if ($this->containerTag)
		{
			$return = Html::tag($this->containerTag, $return, $this->containerOptions);
		}

		return $return;
	}

    protected function renderInput2Html($type)
    {
    	$options = $this->attribute2Options;

        if ($this->hasModel())
        {
            return Html::activeInput($type, $this->model, $this->attribute2, $options);
        }

        return Html::input($type, $this->attribute2Name, $this->attribute2Value, $options);
    }

}