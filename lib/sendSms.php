<?php
/**
 * Created by PhpStorm.
 * User: sage
 * Date: 2018/9/26
 * Time: 14:59
 */

namespace Sms;


use AlibabaCloud\Client\AlibabaCloud;

/**
 * 调用接口
 * Class Login
 * @package Common\Logic
 */


class sendSms
{

    private $config;

    /**
     * 配置初始化
     * sendSms constructor.
     * @param $config
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    function __construct($config) {

        AlibabaCloud::accessKeyClient($config['key'],$config['secret'])
            ->regionId($config['region_id'])
            ->asDefaultClient();
        $this->config = $config;


    }

    /**
     * 调用API的公共接口
     * @param $data
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function callApi($data){

        $result = AlibabaCloud::rpc()
            ->product($this->config['product'])
            ->version($this->config['version'])
            ->action($data['action'])
            ->options($data['options'])
            ->method('POST')
            ->host($this->config['host'])
            ->request();

        return $result['Regions'];

    }

    //<--短信-->
    /**
     * 发送短信
     * @param $info
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function SendSms($info){

        $data['action'] = 'SendSms';
        $data['options'] = [
            'query' => [
                'RegionId'=>$info['region_id']?$info['region_id']:'',
                'PhoneNumbers' => $info['phone'],
                'SignName' => $info['sign_name']?$info['sign_name']:$this->config['sign_name'],
                'TemplateCode' => $info['template_code']?$info['template_code']:$this->config['template_code'],
                'TemplateParam'=>json_encode($info['template_param'])?json_encode($info['template_param']):'',
                'SmsUpExtendCode'=>$info['sms_up_extend_code']?$info['sms_up_extend_code']:'',
                'OutId'=>$info['out_id']?$info['out_id']:time().'_'.$info['phone'],
            ],
        ];

        $result = $this->callApi($data);
        return $result;

    }

    /**
     * 批量发送短信
     * @param $info
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function SendBatchSms($info){

        $data['action'] = 'SendBatchSms';
        $data['options'] = [
            'query' => [
                'RegionId'=>$info['region_id']?$info['region_id']:'',
                'PhoneNumberJson' => json_encode($info['phoneJson']),
                'SignNameJson' => json_encode($info['signNameJson']),//JSON数组格式。
                'TemplateCode' => $info['template_code']?$info['template_code']:$this->config['template_code']
            ],
        ];

        $result = $this->callApi($data);
        return $result;
    }

    /**
     * 短信查询接口
     * @param $info
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function QuerySendDetails($info){

        $data['action'] = 'QuerySendDetails';
        $data['options'] = [
            'query' => [
                'RegionId'=>$info['region_id']?$info['region_id']:'',
                'CurrentPage' => $info['page']?$info['page']:1,
                'PageSize' => $info['size']?$info['size']:10,
                'PhoneNumber' => $info['phone'],
                'SendDate' => $info['time']? $info['time']:date("yyyyMMdd")
            ],
        ];

        $result = $this->callApi($data);
        return $result;
    }

    /**
     * 添加签名
     * @param $info
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function AddSmsSign($info){

        $data['action'] = 'AddSmsSign';
        $data['options'] = [
            'query' => [
                'RegionId'=>$info['region_id']?$info['region_id']:'',
                'SignName'=>$info['signName'],
                'SignSource' => $info['SignSource']?$info['SignSource']:1,
                'Remark' => $info['Remark']
            ],
        ];

        $result = $this->callApi($data);
        return $result;
    }

    /**
     * 添加短信模板
     * @param $info
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function AddSmsTemplate($info){

        $data['action'] = 'AddSmsTemplate';
        $data['options'] = [
            'query' => [
                'RegionId'=>$info['region_id']?$info['region_id']:'',
                'TemplateType'=>$info['TemplateType']?$info['TemplateType']:0,
                'TemplateName' => $info['TemplateName'],
                'TemplateContent' => $info['TemplateContent'],
                'Remark' => $info['Remark']
            ],
        ];

        $result = $this->callApi($data);
        return $result;

    }

    //<--APP 推送-->

    /**
     * android推送
     * @param $info
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function Push($info){

        $data['action'] = 'Push';
        $data['options'] = [
            'query' => [
                'RegionId'=>$info['region_id']?$info['region_id']:'',
                'AppKey'=>$info['app_key']?$info['app_key']:$this->config['app_key'],
                'Action'=>'Push',
                'DeviceType'=>$info['device'],
                'PushType'=>$info['type'],
                'Body' => $info['body'],
                'Target' => $info['target']?$info['target']:'DEVICE',
                'TargetValue' => $info['target_value'],
                'Title' => $info['title'],
            ],
        ];

        $result = $this->callApi($data);
        return $result;
    }
}
