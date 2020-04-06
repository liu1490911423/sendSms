# sendSms
aliyun send sms

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
