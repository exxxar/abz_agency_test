<?php

namespace App\Http\Controllers;

use App\Personal;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class PersonalController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showPersonal(){
        return view("personal.show");
    }

    public function showPersonalTree(){
        return view("personal.showTree");
    }


    public function getAllDataByPages($page=0,$count=20,$field="id",$order="asc",$text=""){
        //выводим по странично пользователей, где $page - номер страницы, а $count - число записей на странице
        $maxPageCount = (int)(DB::table('personal')->count()/($count<=0?1:$count));

        $min = $page*$count;
        $max = $min+$count;

        $personal = [];

        if ($text=="") {
            $personal = DB::table('personal')
                ->whereBetween('id', [$min, $max])
                ->orderBy($field, $order)
                ->get();

        }
        else
        {
            $personal = DB::table('personal')
                ->where('id', '=', $text)
                ->orWhere('name','=',$text)
                ->orWhere('post','=',$text)
                ->orderBy($field, $order)
                ->get();
        }
        return  response()->json(["count"=>$maxPageCount,"list"=>$personal]);
    }

    public function getOne($id){
        $person = DB::table('personal')
            ->where('id', $id)
            ->get();
        return $person;
    }

    public function delPersonal($id){
        DB::table('personal')->where('id', '=', $id)->delete();
    }

    public function updatePersonal(Request $request){
        DB::table('personal')
            ->where('id', $request->get("id"))
            ->update([
                'name' => $request->get("name"),
                'post' => $request->get("post"),
                'lvl' => $request->get("lvl")
            ]);
    }

    public function addPersonal(Request $request){
        DB::table('personal')->insert(
            [
                'name' => $request->get("name"),
                'post' => $request->get("post"),
                'lvl' => $request->get("lvl"),
                'masterId' => 0,
            ]
        );

        return DB::table('personal')->max('id');
    }

    private function appendNode(&$node,$lvl,$item){

            $index = count($node);
            while($index!=0) {
                $index--;
                if (array_key_exists("lvl", $node[$index])) {
                    if ($node[$index]["lvl"]==$lvl)
                        array_push($node[$index]["nodes"], $item);
                    else
                        $this->appendNode($node[$index]["nodes"], $lvl, $item);
                }
            }

            return;
    }

    public function getTreeNode($id=0) {

        $testArray = array();

        $next =  DB::table("personal")->where("masterId","=",$id)->get();




        foreach ($next as $a) {
            $add = [
                'id' => $a->id,
                'name' => $a->name,
                'title' => $a->name,
                'isWork' => $a->isWork,
                'lvl' => $a->lvl,
                'post' => $a->post,
                'masterId' => $a->masterId,
                'price' => $a->price,
                'startAt' => $a->startAt,
                'nodes' => array()
            ];

            array_push($testArray,$add );

        }


            return response()->json( $testArray);
    }


    public function getTree(){

        //получаем полное дерево, не сильно здоровская идея, но пусть будет и это тоже

        $maxMasters = DB::table("personal")->max('masterId');

        $mainMaster = DB::table("personal")->where("id","=",DB::table("personal")->min('masterId')+1)->get();

        $testArray = array([
            'id' =>$mainMaster[0]->id,
            'name' => $mainMaster[0]->name,
            'title'=> $mainMaster[0]->name,
            'isWork' => $mainMaster[0]->isWork,
            'lvl' => $mainMaster[0]->lvl,
            'post' => $mainMaster[0]->post,
            'masterId' => $mainMaster[0]->masterId,
            'price'=>$mainMaster[0]->price,
            'startAt'=>$mainMaster[0]->startAt,
            'nodes' => array()
        ]);


            for ($i=1;$i<10;$i++) {

                $next =  DB::table("personal")->where("masterId","=",$i)->get();

                foreach ($next as $a) {
                    $add = [
                        'id' => $a->id,
                        'name' => $a->name,
                        'title'=> $a->name,
                        'isWork' => $a->isWork,
                        'lvl' => $a->lvl,
                        'post' => $a->post,
                        'masterId' => $a->masterId,
                        'price' => $a->price,
                        'startAt' => $a->startAt,
                        'nodes' => array()
                    ];

                    $this->appendNode($testArray, $i-1, $add);
                }

            }

        return response()->json( $testArray );
    }



}
