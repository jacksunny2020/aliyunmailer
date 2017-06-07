<?php

namespace Jacksunny\AliyunMailer;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use App\Services\ExtendedTransportManager;

/**
 * Description of ExtendedTransportManager
 * 为了整合基于阿里云的邮件发送到框架的邮件发送框架中，实现具体的阿里云邮件发送功能
 * 使用该组件前提:阿里云邮件推送已经设置好发件域名比如 xx.com 以及发件邮箱帐号比如 info@xx.com
 * 然后就可以用 info@xx.com 作为发件邮箱来发送邮件了 
 * @author 施朝阳
 * @date 2017-5-3 13:51:52
 */
class ExtendedMailServiceProvider extends MailServiceProvider {

    /**
     * Register any mail services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    public function registerSwiftTransport() {
        /**
         * 发送邮件使用自定义的发送管理器，可以创建阿里云邮件服务类,继承自默认的发送管理器
         */
        $this->app->singleton('swift.transport', function ($app) {
            return new ExtendedTransportManager($app);
        });
    }

}
