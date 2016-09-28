@extends('layouts.app')

@section('content')
    <style>
        .btn {
            margin-right: 8px;
        }

        .angular-ui-tree-handle {
            background: #f8faff;
            border: 1px solid #dae2ea;
            color: #7c9eb2;
            padding: 10px 10px;
        }

        .angular-ui-tree-handle:hover {
            color: #438eb9;
            background: #f4f6f7;
            border-color: #dce2e8;
        }

        .angular-ui-tree-placeholder {
            background: #f0f9ff;
            border: 2px dashed #bed2db;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        tr.angular-ui-tree-empty {
            height:100px
        }

        .group-title {
            background-color: #687074 !important;
            color: #FFF !important;
        }


        /* --- Tree --- */
        .tree-node {
            border: 1px solid #dae2ea;
            background: #f8faff;
            color: #7c9eb2;
        }

        .nodrop {
            background-color: #f2dede;
        }

        .tree-node-content {
            margin: 10px;
        }
        .tree-handle {
            padding: 10px;
            background: #428bca;
            color: #FFF;
            margin-right: 10px;
        }

        .angular-ui-tree-handle:hover {
        }

        .angular-ui-tree-placeholder {
            background: #f0f9ff;
            border: 2px dashed #bed2db;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
    </style>
    <div class="container" ng-app="treeApp">




        <div ng-controller="myTreeController">
                <!-- Nested node template -->
                <script type="text/ng-template" id="nodes_renderer.html">
                    <div ui-tree-handle>
                        @{{node.title}} and  @{{node.name}}
                        <a class="btn btn-primary btn-xs" data-nodrag ng-click="clickMe(this)"></a>
                        <a class="btn btn-success btn-xs" data-nodrag ng-click="toggle(this)"></a>
                        <a class="pull-right btn btn-danger btn-xs" data-nodrag ng-click="remove(this)"></a>
                        <a class="pull-right btn btn-primary btn-xs" data-nodrag ng-click="newSubItem(this)" style="margin-right: 8px;"></a>
                    </div>
                    <ol ui-tree-nodes="" ng-model="node.nodes">
                        <li ng-repeat="node in node.nodes" ui-tree-node ng-include="'nodes_renderer.html'">
                        </li>
                    </ol>
                </script>
            <div class="row">
                <div class="col-md-6">
                    <div ui-tree="treeOptions">
                        <ol ui-tree-nodes="" ng-model="data" id="tree-root">
                            <li ng-repeat="node in data" ui-tree-node ng-include="'nodes_renderer.html'"></li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-6">
                    <pre class="code">@{{ data | json }}</pre>
                </div>

            </div>

          </div>
    </div>


@endsection
