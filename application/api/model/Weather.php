<?php 
namespace app\api\model;

use think\Model;
use think\Db;

class Weather extends Model
{
    public function getWeather($code = 101010100)
    {
        $res = Db::name('weather')->where('code', $code)->value('val');
        return $res;
    }

    public function getNewsList()
    {
        $res = Db::name('news')->select();
        return $res;
    }
}

?>