<?php

namespace app\common\library;

use think\Hook;

/**
 * 短信验证码类
 */
class Sms
{

    /**
     * 验证码有效时长
     * @var int
     */
    protected static $expire = 120;

    /**
     * 最大允许检测的次数
     * @var int
     */
    protected static $maxCheckNums = 10;

    /**
     * 获取最后一次手机发送的数据
     *
     * @param   int    $mobile 手机号
     * @param   string $event  事件
     * @return  Sms
     */
    public static function get($mobile, $event = 'default')
    {
        $sms = \app\common\model\Sms::
        where(['mobile' => $mobile, 'event' => $event])
            ->order('id', 'DESC')
            ->find();
        Hook::listen('sms_get', $sms, null, true);
        return $sms ? $sms : null;
    }

    /**
     * 发送验证码
     *
     * @param   int    $mobile 手机号
     * @param   int    $code   验证码,为空时将自动生成4位数字
     * @param   string $event  事件
     * @return  boolean
     */
    public static function send($mobile, $code = null, $event = 'default')
    {
        $code = is_null($code) ? mt_rand(1000, 9999) : $code;
        $time = time();
        $ip = request()->ip();
        $sms = \app\common\model\Sms::create(['event' => $event, 'mobile' => $mobile, 'code' => $code, 'ip' => $ip, 'createtime' => $time]);
        $result  = Hook::listen('sms_send', $sms, null, true);
       $content = '您的HIPPOO注冊验证码为：'.$code.'。【HIPPOO】';

       $url = 'http://api.sms.cn/sms/?ac=sendint&uid=&pwd=&mobile='.$mobile.'&content='.$content;
        $mobile1 = $mobile;
        $mobile2 = substr($mobile1,1);
        //str_replace ("0", "", $mobile1);
        //var_dump($url);exit;
        //$url = urlencode($url);
       
        //1$url = 'http://api.sms677.com/http_send.aspx?uid=13110606189&pwd2=0e89683e133f&tel='.$mobile.'&message='.'【HIPPOO】您的HIPPOO注冊验证码为：'.$code;您的HIPPOO注冊验证码为：{**}。【HIPPOO】
        //http://api.sms.cn/sms/?ac=sendint&uid=shopapptw&pwd=key:2f5d11bd8c2e0911ca2e14cef4b12194&mobile=填写要发送的手机号&content=您的HIPPOO注冊验证码为：{**}。【HIPPOO】
    	$curl = curl_init();
    	curl_setopt($curl,CURLOPT_TIMEOUT,5000);
    	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
    	curl_setopt($curl,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    	curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    	
    	$res = curl_exec($curl);
    	
    	$ret = json_decode($res,true);
    	
    	//var_dump($url);exit;
    	if($ret['code']=='00000'){
    		curl_close($curl);
    		return $res;
    	}else {
    		$error = curl_errno($curl);
    		curl_close($curl);
    		$sms->delete();
            return $res;
    	}
    	
        /*if (!$result) {
            $sms->delete();
            return false;
        }
        return true;*/
    }

    /**
     * 发送通知
     *
     * @param   mixed  $mobile   手机号,多个以,分隔
     * @param   string $msg      消息内容
     * @param   string $template 消息模板
     * @return  boolean
     */
    public static function notice($mobile, $msg = '', $template = null)
    {
        $params = [
            'mobile'   => $mobile,
            'msg'      => $msg,
            'template' => $template
        ];
        $result = Hook::listen('sms_notice', $params, null, true);
        return $result ? true : false;
    }

    /**
     * 校验验证码
     *
     * @param   int    $mobile 手机号
     * @param   int    $code   验证码
     * @param   string $event  事件
     * @return  boolean
     */
    public static function check($mobile, $code, $event = 'default')
    {
        $time = time() - self::$expire;
        $sms = \app\common\model\Sms::where(['mobile' => $mobile, 'event' => $event])
            ->order('id', 'DESC')
            ->find();
        if ($sms) {
            if ($sms['createtime'] > $time && $sms['times'] <= self::$maxCheckNums) {
                $correct = $code == $sms['code'];
                if (!$correct) {
                    $sms->times = $sms->times + 1;
                    $sms->save();
                    return false;
                } else {
                    $result = Hook::listen('sms_check', $sms, null, true);
                    return $result;
                }
            } else {
                // 过期则清空该手机验证码
                self::flush($mobile, $event);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 清空指定手机号验证码
     *
     * @param   int    $mobile 手机号
     * @param   string $event  事件
     * @return  boolean
     */
    public static function flush($mobile, $event = 'default')
    {
        \app\common\model\Sms::
        where(['mobile' => $mobile, 'event' => $event])
            ->delete();
        Hook::listen('sms_flush');
        return true;
    }
}
