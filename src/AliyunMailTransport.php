<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Jacksunny\AliyunMailer;

use Illuminate\Mail\Transport\Transport;
use GuzzleHttp\ClientInterface;
use Swift_Mime_Message;
use Rainwsy\Aliyunmail\Send\Single;
use Rainwsy\Aliyunmail\Auth;

/**
 * Description of AliyunMailTransport
 * 为了整合基于阿里云的邮件发送到框架的邮件发送框架中，实现具体的阿里云邮件发送功能
 * 使用该组件前提:阿里云邮件推送已经设置好发件域名比如 xx.com 以及发件邮箱帐号比如 info@xx.com
 * 然后就可以用 info@xx.com 作为发件邮箱来发送邮件了 
 *
 * @author 施朝阳
 * @date 2017-5-3 13:53:34
 */
class AliyunMailTransport extends Transport {

    /**
     * Guzzle HTTP client.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * The Mailjet "API key" which can be found at https://app.mailjet.com/transactional
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The Mailjet "Secret key" which can be found at https://app.mailjet.com/transactional
     *
     * @var string
     */
    protected $secretKey;

    /**
     * The Mailjet end point we're using to send the message.
     *
     * @var string
     */
    protected $endPoint = 'https://api.mailjet.com/v3/send';
    protected $region;

    /**
     * Create a new Mailjet transport instance.
     *
     * @param  \GuzzleHttp\ClientInterface $client
     * @param $apiKey
     * @param $secretKey
     */
    public function __construct($region, $apiKey, $secretKey) {
        //$this->client = $client;
        $this->region = $region;
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
    }

    /**
     * Send the given Message.
     *
     * Recipient/sender data will be retrieved from the Message API.
     * The return value is the number of recipients who were accepted for delivery.
     *
     * @param Swift_Mime_Message $message
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null) {
        $this->beforeSendPerformed($message);

        $auth = Auth::config($this->apiKey, $this->secretKey);
        $mail = new Single();
        $from = $message->getFrom();
        $fromAddress = key($from);
        $fromName = $from[$fromAddress] ?: null;
        $subject = $message->getSubject();
        $body = $message->getBody();
        $to = $message->getTo();
        $toAddress = key($to);
        $mail->setAccountName($fromAddress);
        $mail->setFromAlias($fromName);
        $mail->setReplyToAddress('false');
        $mail->setAddressType('1');
        $mail->setToAddress($toAddress);
        $mail->setSubject($subject);
        $mail->setHtmlBody($body);

        $send = null;
        $send = $mail->send();
        return $send;
    }

}
