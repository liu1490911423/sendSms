# sendSms

安装 composer require hong/sms @dev

aliyun send sms

use Sms\sendSms;

class Message{

    private $send;

    function __construct(){
    
        //短信配置
        $config=[
            'key'=>'',
            'secret'=>'',
            'region_id'=>'cn-hangzhou',
            'sign_name'=>'',
            'template_code'=>'',
            'product'=>'Dysmsapi',
            'version'=>'2017-05-25',
            'host'=>'dysmsapi.aliyuncs.com',
        ];
        
        //App推送配置
        $config1=[
            'key'=>'',
            'secret'=>'',
            'region_id'=>'cn-hangzhou',
            'product'=>'Push',
            'version'=>'2016-08-01',
            'host'=>'cloudpush.aliyuncs.com',
            'app_key'=>'',
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
