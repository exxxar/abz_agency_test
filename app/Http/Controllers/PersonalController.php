<?php

namespace App\Http\Controllers;

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
                if (array_key_exists("roleId", $node[$index])) {

                    if ($node[$index]["roleId"]==$lvl)
                        array_push($node[$index]["children"], $item);

                    else
                        $this->appendNode($node[$index]["children"], $lvl, $item);
                }

            }

            return;
    }

    public function getTree(){

        $testArray =   array(["roleName" => "Акакий Семенович Дерикозлы", "roleId" => "role1", "children" => array()]);
        array_push($testArray[0]["children"], [ "roleName" => "Guest2", "roleId" => "role12", "children" => array()]);
        array_push($testArray[0]["children"], [ "roleName" => "Guest3", "roleId" => "role13", "children" => array()]);


        $this->appendNode( $testArray,"role13",[ "roleName" => "Guest4", "roleId" => "role14", "children" => array()]);
        $this->appendNode( $testArray,"role1",[ "roleName" => "Guest4", "roleId" => "role14", "children" => array()]);
        $this->appendNode( $testArray,"role14",[ "roleName" => "Guest4", "roleId" => "role15", "children" => array()]);
        $this->appendNode( $testArray,"role15",[ "roleName" => "Guest4", "roleId" => "role16", "children" => array()]);
        $this->appendNode( $testArray,"role16",[ "roleName" => "Guest4", "roleId" => "role17", "children" => array()]);
        $this->appendNode( $testArray,"role16",[ "roleName" => "Guest4", "roleId" => "role17", "children" => array()]);
        $this->appendNode( $testArray,"role16",[ "roleName" => "Guest4", "roleId" => "role17", "children" => array()]);
        return response()->json($testArray);

          /*  response()->json(array(
            ["roleName" => "Акакий Семенович Дерикозлы", "roleId" => "role1", "children" => array(
            [ "roleName" => "Guest", "roleId" => "role12", "children" => array()],
            [ "roleName" => "Guest", "roleId" => "role12", "children" => array()],
            [ "roleName" => "Guest", "roleId" => "role12", "children" => array()],
            [ "roleName" => "Guest", "roleId" => "role12", "children" => array()],
            [ "roleName" => "Guest", "roleId" => "role12", "children" => array()]
            )]
        ));*/
    }
    public function search($text=""){
        //будем искать в 2а этапа: 1 sql выборка через or 2 получим все данные и пройдем по ним циклом и будем выбирать через поиск вхождения

       $personal = DB::table('personal')
            ->where('id', '=', $text)
            ->orWhere('name','=',$text)
            ->orWhere('post','=',$text)
            ->get();

        return  response()->json(["count"=>$personal->count(),"data"=>$personal]);

        /*return response()->json([
            "count"=>1,"data"=>array([
                "id"=>1,
                "name"=>"test",
                "isWork"=>1,
                "lvl"=>4,
                "post"=>"test post",
                "masterId"=>0,
                "created_at"=>null,
                "updated_at"=>null
            ])
        ]);*/
    }


}
