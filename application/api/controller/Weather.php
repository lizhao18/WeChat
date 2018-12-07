<?php
namespace app\api\controller;

use think\Controller;

class Weather extends Controller
{
  public function read()
  {
    $code = input('code');
    $model = model('Weather');
    $data = $model->getWeather($code);
    if($data){
    	$code = 200;
    } else {
      $code = 404;
    }
    $data = [
      'code' => $code,
      'data' => $data
    ];
    return json($data); 
  }
}

?>