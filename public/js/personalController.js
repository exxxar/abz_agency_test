/**
 * Created by Aleks on 23.09.2016.
 */


var app = angular.module('testApp', []);
app.controller('personalCtrl', function($scope, $http,$timeout) {

    $scope.count = 20;
    $scope.index = 0;
    $scope.field = "id";
    $scope.order = "asc";
    $scope.search = "";
    $scope.error = "";


    $scope.setSettings = function(id){
        $http.get("../personal/getOne/"+id).then(function(response) {
            $scope.oneperson = response.data[0];
        });
    }

    $scope.delPersonal = function(){
        $http.get("../personal/del/"+$scope.oneperson.id).then(function(response) {
            $scope.getAllDataByPages();
            document.getElementsByClassName("close-settings")[0].click();
        });
    }

    $scope.updatePersonal = function(){
        var _csrf = document.getElementsByName("csrf-token")[0];

        $http({
            method:'POST',
            url:'../personal/update',
            data: {
                _token:_csrf,
                id:$scope.oneperson.id,
                name:$scope.oneperson.name,
                post:$scope.oneperson.post,
                lvl:$scope.oneperson.lvl
            }
        }).then(function(response){
            console.log(response);
            $scope.setSettings($scope.oneperson.id);
            $scope.getAllDataByPages();
        });
    }

    $scope.addPersonal = function(){
        var _csrf = document.getElementsByName("csrf-token")[0];

        $http({
            method:'POST',
            url:'../personal/add',
            data: {
                _token:_csrf,
                name:$scope.addperson.name,
                post:$scope.addperson.post,
                lvl:$scope.addperson.lvl
            }
        }).then(function(response){
            console.log(response);
            $scope.addresult = "Добавлено под индексом ["+response.data+"]";
            $scope.getAllDataByPages();

            $timeout(function(){
                $scope.addresult = "";
                $scope.addperson = "";
            },2000);
        });
    }

    $scope.getAllDataByPages = function(pageIndex){

        $scope.index = pageIndex===undefined?$scope.index:pageIndex;
        
        $http.get("../personal/all/page"+$scope.index+"_"+$scope.count+"/sort"+$scope.field+"_"+$scope.order+"/search"+$scope.search).then(function(response) {
            $scope.personalList = response.data.list;
            $scope.pageCount = response.data.count;
            $scope.pageList = [];

            console.log( ($scope.index-9>=0?$scope.index:0)+" "+Math.min($scope.index+10,$scope.pageCount));
            for (var i = $scope.index-9>=0?$scope.index:0;i<Math.min($scope.index+10,$scope.pageCount);i++)
                $scope.pageList.push(i);

            console.log($scope.pageList);
            if ($scope.personalList.length===0)
                $scope.error = "Данные отсутствуют";
            else
                $scope.clearError();
        });


    }

    $scope.clearError = function(){
        $scope.error = "";
    }

    $scope.sort = function(index){
        $scope.order=$scope.order==="asc"?"desc":"asc";

        switch(index){

            case 1: $scope.field = "name"; break;
            case 2: $scope.field = "post"; break;
            case 3: $scope.field = "lvl"; break;
            case 4: $scope.field = "masterId"; break;
            case 0:
            default:
                $scope.field = "id"; break;

        }
        $scope.getAllDataByPages();
    }

    $scope.toSearch = function(some,param){
        switch(param){
            default:
            case 1: $scope.search = some.person.id; break;
            case 2: $scope.search = some.person.name; break;
            case 3: $scope.search = some.person.post; break;
        }
    }

});