<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Base;
use DB;

class IndexModel extends Base
{
    public function add($param)
    {
        if (empty($param['day']))
            return $this->bad('error:day');
        if (empty($param['time']))
            return $this->bad('error:time');
        if ($param['out'] >= 0)
            return $this->bad('error:out');
        if ($param['cate'] <= 0)
            return $this->bad('error:cate');
        $data['date'] = $param['day'] . ' ' . $param['time'];
        $data['out'] = $param['out'];
        $data['cate'] = $param['cate'];
        $data['remark'] = $param['remark'];
        $data['time'] = strtotime($data['date']);
        $data['year'] = date('Y', $data['time']);
        $data['month'] = date('n', $data['time']);
        $id = DB::table('test')->insertGetId($data);
        if ($id)
            return $this->ok($id);
        else
            return $this->bad('error:sql');
    }

    public function getList($param)
    {
        $sql = 'select * from test order by id desc limit 20';
        $res = DB::select($sql);
        $data = [];
        if (!$res)
            return $data;
        foreach ($res as $k => $v) {
            $data[] = [
                'id' => $v->id,
                'year' => date('Y', $v->time),
                'month' => date('n', $v->time),
                'date' => $v->date,
                'out' => $v->pay,
                'cate' => $v->cate,
                'remark' => $v->remark,
            ];
        }
        return $data;
    }

    public function login($param)
    {
        session()->forget('isLogin');
        $code = $param['code'];
        if (empty($code))
            return redirect('/');
        $appid = env('DDAPPID', 'dingoauw1dz6n9i3l37wis');
        $secret = env('DDSECRET', 'pKy2MnFWMp4sF3sPBTgwGOujWI6rT5QOxS_0pIKyZWREyTSaW2SmyziJgEQ8Dxs0');
        $url = 'https://oapi.dingtalk.com/sns/gettoken?appid=';
        $url .= $appid . '&appsecret=' . $secret;
        $result = json_decode($this->httpGet($url), 1);
        $access_token = $result['access_token'];
        $url = 'https://oapi.dingtalk.com/sns/get_persistent_code?access_token=' . $access_token;
        $data = json_encode(['tmp_auth_code' => $code]);
        $result = json_decode($this->httpPost($url, $data), 1);
        if ($result['errmsg'] !== 'ok')
            return redirect('/');
        $openid = $result['openid'];
        if ($openid !== '08gEVqd59DHiidV5s9iPK57AiEiE')
            return $this->bad('error:用户未授权');
        session()->put('isLogin', true);
        return redirect('/');
    }

    public function getReport($param)
    {
        $data = [];
        $sql = 'select sum(pay) total from test where pay<0';
        $res = DB::select($sql);
        if($res)
            $data[] = ['name'=>'累计','data'=>$res['0']->total];
        $sql = "select sum(pay)/count(distinct(DATE_FORMAT(date,'%Y-%m-%d'))) result from test";

        $res = DB::select($sql);
        if($res)
            $data[] = ['name'=>'平均','data'=>$res['0']->result]; 
        $sql = "select count(distinct(DATE_FORMAT(date,'%Y-%m-%d'))) result from test"; 
        $res = DB::select($sql);
        if($res)
            $data[] = ['name'=>'天数','data'=>$res['0']->result]; 
        $date = date('Y-m-01 00:00:00',time()); 
        $sql = "select sum(pay)/count(distinct(DATE_FORMAT(date,'%Y-%m-%d'))) result from test
                where date>=?";
        return $res = DB::select($sql, [$date]);
        if($res)
            $data[] = ['name'=>'当月平均','data'=>$res['0']->result];                              
        return $data;
    }
  
    public function chart($param)
    {        
        $sql = "select DATE_FORMAT(date,'%Y-%m-%d') name,sum(-pay) data 
                from test where pay<0 group by name order by name desc limit 30";                
        $res = DB::select($sql);
        $data = [];
        if($res)
            $data = $res;
        return $data;
    }    
}