<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\AliyunMailer;

use Illuminate\Mail\TransportManager;
use Config;

/**
 * Description of ExtendedTransportManager
 * 为了整合基于阿里云的邮件发送到框架的邮件发送框架中，实现具体的阿里云邮件发送功能
 * 使用该组件前提:阿里云邮件推送已经设置好发件域名比如 xx.com 以及发件邮箱帐号比如 info@xx.com
 * 然后就可以用 info@xx.com 作为发件邮箱来发送邮件了 
 * 
 * @author 施朝阳
 * @date 2017-5-3 13:51:52
 */
class ExtendedTransportManager extends TransportManager {

    protected function createAliyunMailDriver() {
        /**
         * 需要修改配置文件 config/mail.php 增加配置项
         *  'aliyunmail' => [
         *   'region' => 'cn-hangzhou',
         *   'key' => 'APPKEYAPPKEY',
         *   'secret' => 'APPSECRETAPPSECRETAPPSECRETAPPSECRET',
         *],
         */
        $config = Config::get('mail.aliyunmail');
        $region = $config['region'];
        $key = $config['key'];
        $secret = $config['secret'];

        return new AliyunMailTransport(
                $region, $key, $secret
        );
    }

}
