# Laravel-Alidayu

## Usage

* `composer require sliverwing/alidayu`
* add `Sliverwing\Alidayu\AlidayuServiceProvider::class,` to your `config/app.php` file
* `php artisan vendor:publish --provider="Sliverwing\Alidayu\AlidayuServiceProvider"`
* edit `config/alidayu.php` put your appkey & secretKey
* put your sms config in `sms` array
* edit your `.env` file and make sure you have proper `QUEUE_DRIVER` configuration
* add `ALIDAYU_APPKEY` and `ALIDAYU_SECRET` in your `.env` file
* `php artisan queue:work`
* edit your controller where you need to send sms

```
use Sliverwing\Alidayu\Jobs\AlidayuMessageJob;

//... in some action
$this->dispatch(new AlidayuMessageJob($phoneNumber, $paramInYourTemplate, $configNameInAlidayuConfig));

```

* then you will see result in console
## example
* I have my `config/alidayu.php` like this:
```
<?php

return [
    'appkey' => env('ALIDAYU_APPKEY'),
    'secretKey' => env('ALIDAYU_SECRET'),

    'sms' => [
        'numsend' => [
            'SmsFreeSignName' => '医*',
            'SmsTemplateCode' => 'SMS_3*******',
        ],
    ],
];
```
* My template is `您的注册码为 ${code}`
* I can send my verification code via 
```
    $this->dispatch(new AlidayuMessageJob($phoneNumber, ['code'=>$code], "numsend"));
```

> Thanks to [https://github.com/flc1125/alidayu](https://github.com/flc1125/alidayu)
