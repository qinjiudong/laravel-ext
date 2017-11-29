<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\IndexModel;

class Index extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function report()
    {
        return view('report');
    }

    public function add(Request $request)
    {
        $param['day'] = trim($request->input('day'));
        $param['time'] = trim($request->input('time'));
        $param['out'] = (float)$request->input('out');
        $param['cate'] = (int)$request->input('cate');
        $param['remark'] = trim($request->input('remark'));
        return (new IndexModel)->add($param);
    }

    public function cate()
    {
        $data = [
            ['id' => 1, 'name' => '饮食'],
            ['id' => 2, 'name' => '交通'],
            ['id' => 3, 'name' => '话费'],
            ['id' => 4, 'name' => '网购'],
        ];
        return $data;
    }

    public function getList()
    {
        $param = [];
        return (new IndexModel)->getList($param);
    }

    public function login(Request $request)
    {
        $param['code'] = trim($request->input('code'));
        return (new IndexModel)->login($param);
    }

    public function getReport()
    {
        $param = [];
        return (new IndexModel)->getReport($param);
    }

    public function chart()
    {
        $param = [];
        return (new IndexModel)->chart($param);        
    }
}