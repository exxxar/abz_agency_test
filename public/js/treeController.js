(function(){

    //angular module
    var myApp = angular.module('treeApp', ['angularTreeview']);

    //test controller
    myApp.controller('myTreeController', function($scope,$http){

        $http.get("./getTree").then(function(response) {
            $scope.roleList1 = response.data;
            console.log("дерево="+response.data)
        });

        //roleList1 to treeview
        $scope.roleList = $scope.roleList1;

    });

})();

