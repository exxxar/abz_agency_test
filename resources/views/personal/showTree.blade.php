@extends('layouts.app')

@section('content')
    <div class="container" ng-app="treeApp">
        <div ng-controller="myTreeController">

            <div>
                <input type="button" value="TREE MODEL 1" data-ng-click="roleList = roleList1" /> <input type="button" value="TREE MODEL 2" data-ng-click="roleList = roleList2" />
            </div>

            <div style="margin:10px 0 30px 0; padding:10px; background-color:#EEEEEE; border-radius:5px; font:12px Tahoma;">
                <span><b>Selected Node</b> : @{{currentNode.roleName}}</span>
            </div>

            <!--
              [TREE attribute]
              angular-treeview: the treeview directive
              tree-model : the tree model on $scope.
              node-id : each node's id
              node-label : each node's label
              node-children: each node's children
            -->
            <div
                    data-angular-treeview="true"
                    data-tree-model="roleList"
                    data-node-id="roleId"
                    data-node-label="roleName"
                    data-node-children="children" >
            </div>

        </div>
    </div>


@endsection
