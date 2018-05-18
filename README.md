Двойная цифровая captcha для Yii 2
==================================

#yii2
#captcha

Суть метода защиты в том, что большинство автоматизированных 
спам-роботов распознает проверочный код, и вводит его в одно поле ввода, 
а мы создаем второе поле ввода с любым именем, и визуально оформляем 
поля так, что человеку будет понятно что надо ввести код в два поля, а 
роботу нет, и он пытается ввести код в одно поле. Чтобы упростить 
задачу распознавания кода для людей, капча теперь состоит только из цифр.

Такой метод защиты подойдет для мелких и средних сайтов, для которых 
никто не будет персонально разрабатывать спам-роботов. Криптостойкость 
проверочного кода относительно штатной капчи получается даже ниже, и 
если кто-то решит написать робота специально для вашего сайта, то ему 
это сделать будет даже проще чем с обычной капчей.

Проверочный код:
----------------

картинка [12-345] поле1[XX] - поле2[XXX]

Пример использования
--------------------

В форме выведите капчу:

```
<?php

use denis909\yii\captcha\Captcha;

echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
	'captchaAction' => '/site/captcha',
	'options' => [
		'class' => 'form-control'
	],					
	'attribute2' => 'verifyCode2',
	'attribute2Options' => [
		'class' => $model->hasErrors('verifyCode') 
			? 'form-control ' . $form->errorCssClass 
			: 'form-control'
	],				
	'containerTag' => 'div',
	'containerOptions' => [
		'class' => 'row gutters-xs'
	],					
	'imageContainerTag' => 'div',
	'imageContainerOptions' => [
		'class' => 'col-xs-3',
		'style' => 'min-width: 164px;'
	],
	'attributeContainerTag' => 'div',
	'attributeContainerOptions' => [
		'class' => 'col-xs-2',
		'style' => 'padding-right: 0px;'
	],
	'devider' => '&mdash;',
	'deviderTag' => 'div',
	'deviderOptions' => [
		'class' => 'col-xs-1',
		'style' => 'padding-top: 15px; text-align: center;'
	],
	'attribute2ContainerTag' => 'div',
	'attribute2ContainerOptions' => [
		'class' => 'col-xs-2',
		'style' => 'padding-left: 0px;'
	]
]);?>

```

Настройте капчу в контроллере:

```
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
```

Если включить resetValidCaptcha в false то надо вручную обнулять в 
контроллере после сабмита формы.

```
$captcha = $this->createAction('captcha');
	        
$captcha->reset();
```

Настройте поля в модели:

```
public $verifyCode;

public $verifyCode2;

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
```

Об авторе
---------
Здравствуйте, меня зовут Денис. Я занимаюсь разработкой веб-приложений 
на PHP около 10 лет. Сейчас работаю на Yii 2 фреймворке. Владею PHP,
MySQL, JavaScript(jQuery), HTML5(bootstrap). 

Мой сайт: [denis909.spb.ru](http://denis909.spb.ru)

Пишите в форме обратной связи на сайте, или на denis909@mail.ru, если 
у вас есть для меня предложения по работе.