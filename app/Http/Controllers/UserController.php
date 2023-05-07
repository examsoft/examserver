<?php


namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Examcore\Exam;

class UserController extends  BaseController
{
    public function user($id){
        //$results = app('db')->select("SELECT * FROM user where id=$id");
        $results = app('db')->table("user")->whereRaw('id=?',[$id])->get();
        return $results;
    }

    public function users(){
        $obj = new Exam();
        $obj->test();
        $results = app('db')->select("SELECT * FROM user order by id desc limit 10");
        return $results;
    }

    public function add(Request $request){
        $name = $request->input('name');
        if(!$name){
            return "name不能为空";
        }
        $results = app('db')->table("user")->insert(
            ['name' => $name]
        );
        return $results;
    }
}
