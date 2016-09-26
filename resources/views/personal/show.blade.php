@extends('layouts.app')

@section('content')
    <div class="container" ng-app="testApp" ng-controller="personalCtrl" ng-init="getAllDataByPages()">
        <div class="panel panel-danger" ng-if="error!=''" ng-click="clearError()">
            <p class="text-warning text-center" style="padding:15px 0 0 0;">@{{error}}</p>
        </div>
        <h2 class="text-center">Список сотрудников</h2>
        <p class="text-center">отображение в виде таблицы</p>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <input type="text" style="padding: 5px;" class="col-xs-8 text-warning" placeholder="Введи текст для поиска..." name="search" ng-model="search">
                <input type="button" class="btn btn-info col-xs-offset-1 col-xs-3" value="Искать" ng-click="getAllDataByPages()">
            </div>
        </div>
        <hr>
        <button data-toggle="modal" class="btn btn-default" ng-init="addresult=''" data-target="#createPersonal">Добавить сотрудника</button>
        <hr>
        <!--
        <label for="pageIndex">Номер страницы</label>
        <input id="pageIndex" type="number" value="1" min="0"  ng-model="index">
        <label for="pageCount">Количество элементов на странице</label>
        <input id="pageCount" type="number" value="1" min="1" max="20" ng-model="count">
        <input type="button" ng-click="getAllDataByPages(0)" value="Отправить">
        -->

        <ul class="pagination" ng-if="error==''">
            <li ng-if="pageList[0]-9>=0" ng-click="getAllDataByPages(0)"><a href="">Начало</a></li>
            <li ng-if="pageList[0]-9>0" ng-click="getAllDataByPages(pageList[0]-10)"><a href="">Сюдой</a></li>
            <li ng-repeat="p in pageList" ng-click="getAllDataByPages(p)"><a href="">@{{p}}</a></li>
            <li ng-if="pageCount>10&&pageList[pageList.length]!=pageCount" ng-click="getAllDataByPages(pageList[9]+1)"><a href="">Тудой</a></li>
            <li ng-if="pageCount>10&&pageList[pageList.length]!=pageCount" ng-click="getAllDataByPages(pageCount)"><a href="">Конец</a></li>
        </ul>
        <table class="table" ng-if="error==''">
            <thead>
            <tr>
                <th class="canSort" ng-click="sort(0)">ID</th>
                <th class="canSort" ng-click="sort(1)">Имя</th>
                <th class="canSort" ng-click="sort(2)">Должность</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody ng-repeat="person in personalList">
            <tr>
                <td ng-click="toSearch(this,1)">@{{ person.id }}</td>
                <td ng-click="toSearch(this,2)">@{{ person.name }}</td>
                <td ng-click="toSearch(this,3)">@{{ person.post }}</td>
                <td><a href="" data-toggle="modal" data-target="#personalSettings" ng-click="setSettings(person.id)" >редактировать</a></td>
            </tr>

            </tbody>
        </table>
        <ul class="pagination" ng-if="error==''">
            <li ng-if="pageList[0]-9>=0" ng-click="getAllDataByPages(0)"><a href="">Начало</a></li>
            <li ng-if="pageList[0]-9>0" ng-click="getAllDataByPages(pageList[0]-10)"><a href="">Сюдой</a></li>
            <li ng-repeat="p in pageList" ng-click="getAllDataByPages(p)"><a href="">@{{p}}</a></li>
            <li ng-if="pageCount>10&&pageList[pageList.length]!=pageCount" ng-click="getAllDataByPages(pageList[9]+1)"><a href="">Тудой</a></li>
            <li ng-if="pageCount>10&&pageList[pageList.length]!=pageCount" ng-click="getAllDataByPages(pageCount)"><a href="">Конец</a></li>
        </ul>
        <hr>

        <!-- окошко редактирования-->

        <div id="personalSettings" class="modal fade" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Окно редактирование сотрудника</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="personName">Имя пользователя</label>
                            <input id="personName" class="form-control" type="text" ng-model="oneperson.name">
                        </div>

                        <div class="form-group">
                            <label for="personPost">Должность</label>
                            <input id="personPost" class="form-control" type="text" ng-model="oneperson.post">
                        </div>

                        <div class="form-group">
                            <label for="personLvl">Уровень</label>
                            <input id="personLvl" class="form-control" type="text" ng-model="oneperson.lvl">
                        </div>

                        <div class="form-group">
                            <input class="btn btn-primary" type="button" value="Сохранить" ng-click="updatePersonal()">
                            <input class="btn btn-danger pull-right" type="button" value="Удалить" ng-click="delPersonal()">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default close-settings" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- окошко добавлениея сотрудника-->

        <div id="createPersonal" class="modal fade" role="dialog" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Окно добавления сотрудника</h4>
                    </div>

                    <div class="modal-body">
                        <div  ng-if="addresult!=''"class="panel panel-success">
                            <div class="panel-body">
                                @{{ addresult }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="personName">Имя пользователя</label>
                            <input id="personName" class="form-control" type="text" ng-model="addperson.name">
                        </div>

                        <div class="form-group">
                            <label for="personPost">Должность</label>
                            <input id="personPost" class="form-control" type="text" ng-model="addperson.post">
                        </div>

                        <div class="form-group">
                            <label for="personLvl">Уровень</label>
                            <input id="personLvl" class="form-control" type="text" ng-model="addperson.lvl">
                        </div>

                        <div class="form-group">
                            <input class="btn btn-success" type="button" ng-click="addPersonal()" value="Добавить">

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
