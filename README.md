# aliyunmailer
laravel framework mailer plugin which based on  AliyunMail
# pre-condition
completed setting from user domain dns manage(like MX record),and,completed creating from user account(like service@xx.com) under Aliyun Controller Panel

# How to install and configurate package

1. install the laravel package 
  composer require "jacksunny/aliyunmailer":"dev-master"
  
  please check exist line "minimum-stability": "dev" in composer.json if failed

2. set default mailer to aliyunmail in file config/mail.php

  'driver' => env('MAIL_DRIVER', 'aliyunmail'),
   'aliyunmail' => [
        'region' => 'cn-hangzhou',
        'key' => 'APPKEYAPPKEY',
        'secret' => 'APPSECRETAPPSECRETAPPSECRET',
    ],
  

3. set default mailer to aliyunmail in file .env
  
   MAIL_DRIVER=aliyunmail
 
4. append new service provider file line in the section providers of file app.config
  after appended,it should looks like
   'providers' => [
        Illuminate\Auth\AuthServiceProvider::class,
        ......
        Jacksunny\AliyunMailer\ExtendedMailServiceProvider::class,
    ],
4.  add route to test if it works,run http://localhost/sendalimail after route defined below

    Route::get("/sendalimail", function() {
        $result = Mail::raw('这里填写邮件的内容', function ($message) {
                    // 发件人（你自己的邮箱和名称）
                    $message->from('service@xxx.com', 'laravel');
                    // 收件人的邮箱地址
                    $message->to('dest@yyy.com');
                    // 邮件主题
                    $message->subject('test at 20170608');
                });
        return $result;
    });
  
5. please notify me if you got any problem or error on it,thank you!
