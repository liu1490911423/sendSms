# sendSms
aliyun send sms
<?php

/**
 * Created by PhpStorm.
 * User: lhx
 * Date: 2019/12/16
 * Time: 17:17
 */

use Sms\sendSms;

class Message{

    private $send;

    function __construct(){

        $config=[
            'key'=>'',
            'secret'=>'',
            'region_id'=>'cn-hangzhou',
            'sign_name'=>'',
            'template_code'=>'',
        ];

        $this->init($config);
    }

    private function init($config){

       $this->send = new sendSms($config);

    }

    public function send($info){

        $result = $this->send->sendSms($info);
        return $result;
    }


}
