<?php
namespace app\wx\controller;

use think\Controller;

class Wx extends Controller
{
  public function index()
    {
        $access_token = $this->getToken();
        echo $access_token;
    }
  public function createmenu(){
      $data='{
       "button":[
       {
            "type":"click",
            "name":"今日歌曲2",
            "key":"V1001_TODAY_MUSIC"
        },
        {
             "name":"菜单",
             "sub_button":[
             {
                 "type":"view",
                 "name":"搜索",
                 "url":"http://www.baidu.com/"
              },
              {
                 "type":"click",
                 "name":"赞一下我们",
                 "key":"V1001_GOOD"
              }]
         }]
      }';
      $access_token=$this->getToken();
      $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;  // . 这个点是用来进行连接字符串
      var_dump($url);
      var_dump($data);
      $result= $this->postcurl($url,$data);
      var_dump($result);
    }


    public function getuser(){
    	 $access_token=$this->getToken();
   		 $url_get='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token;
         $user_json= $this->https_request($url_get);
         //var_dump($json);
    	 $url_get='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$user_json['data']['openid'][0].'&lang=zh_CN';
    	 $user_info= $this->https_request($url_get);
         var_dump($user_info);
  }



    function getToken(){
        return $this->checkAccessToken("wx37f5e013b004fd69","0becb83fa03ada7845050c1696ca61cc");
    }



    function checkAccessToken($appid,$appsecret){
        $condition = array('appid'=>$appid,'appsecret'=>$appsecret);
        $access_token_set=DB('wxtoken')->where($condition)->find();//获取数据

        if($access_token_set){
            //检查是否超时，超时了重新获取
            if($access_token_set['AccessExpires']>time()){
                //未超时，直接返回access_token
                return $access_token_set['access_token'];
            }else{
                //已超时，重新获取
                $url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
                $json= $this->https_request($url_get);
                var_dump($json);
                $access_token=$json['access_token'];
                $AccessExpires=time()+intval($json['expires_in']);
                $data['access_token']=$access_token;
                $data['AccessExpires']=$AccessExpires;
                $result = DB('wxtoken')->where($condition)->update($data);//更新数据
                if($result){
                    return $access_token;
                }else{
                    return $access_token;
                }
            }
        }else{
          	echo "appid或appsecret不正确";
            return false;
        }
    }


    function https_request ($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $out = curl_exec($ch);
        curl_close($ch);
        return  json_decode($out,true);
    }
  
      

    function postcurl($url,$data = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return 	$output=json_decode($output,true);
    }

}
?>