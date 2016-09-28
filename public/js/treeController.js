'use strict';

var myAppModule = angular.module('treeApp', ['ui.tree']);

myAppModule.controller('myTreeController', ['$scope','$http', function ($scope,$http) {


     $scope.data = [ ];

    $scope.treeOptions = {
        beforeDrop: function (e) {

            console.log("test 1");

        },
        accept: function(sourceNodeScope, destNodesScope, destIndex) {
            console.log("test 2");
            return true;
        },
    }

    $scope.remove = function (scope) {
        scope.remove();
    };

    $scope.toggle = function (scope) {
        scope.toggle();

    };

    $scope.clickMe = function(scope){
        console.log(scope.node.id);
        $scope.newSubItemS(scope,scope.node.id);
    }

    $scope.moveLastToTheBeginning = function () {
        var a = $scope.data.pop();
        $scope.data.splice(0, 0, a);
    };

    $scope.newSubItem = function (scope) {
        var nodeData = scope.$modelValue;
        nodeData.nodes.push({
            id: nodeData.id * 10 + nodeData.nodes.length,
            title: nodeData.title + '.' + (nodeData.nodes.length + 1),
            nodes: []
        });
    };

    $scope.newSubItemS = function (scope,index) {
        var nodeData = scope.$modelValue;
        $http.get("./getTree/"+index).then(function(response) {
            response.data.forEach(function(item, i, arr) {
                nodeData.nodes.push(item);
            });
        });


    };

    $scope.collapseAll = function () {
        $scope.$broadcast('angular-ui-tree:collapse-all');
    };

    $scope.expandAll = function () {
        $scope.$broadcast('angular-ui-tree:expand-all');
    };



    $http.get("./getTree/1").then(function(response) {
        $scope.data = response.data;
        console.log("дерево="+response.data)
    });


    /* $http.get("./getTree/0").then(function(response) {
     $scope.roleList1 = response.data;
     console.log("дерево="+response.data)
     });*/

    /*$scope.tryClick = function(i){
        console.log("111["+i+"]");
        $scope.createTree(i);
    }

    $scope.appendNode  = function($node,$lvl,$item){

        if ($node==undefined)
            return;

        var $index = $node.length;
        while($index!=0) {
            $index--;

            if ($node==undefined)
                return;


            if ($node[$index]["lvl"]!=undefined) {
                if ($node[$index]["lvl"]==$lvl) {
                    console.log($node[$index]["lvl"]+" "+$node[$index]["slaves"]);
                    $node[$index]["slaves"].push($item);
                }
                else
                    $scope.appendNode($node[$index]["slaves"], $lvl, $item);
            }
        }

        return;
    }

    $scope.createTree = function(index){
        $http.get("./getTree/"+index).then(function(response) {
            //$scope.roleList1 = response.data;
            $scope.appendNode($scope.roleList1,0,response.data);
            console.log("дерево="+response.data)
        });
    }
    //roleList1 to treeview
    $scope.roleList = $scope.roleList1;*/

}]);