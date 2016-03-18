/**
 * Created by melodic on 17.03.2016.
 */

var app = angular.module('mainApp', ['ngNotify']);
app.controller('myNotify', function($scope, $http, $interval,ngNotify) {

    ngNotify.config({
        html: true,
        theme: 'pure',
        position: 'top',
        duration: 3000,
        type: 'info',
        sticky: false,
        button: true
    });

    ngNotify.set('<i class="fa fa-info"></i> Last Update 18.03.2016');

    $interval(function (){
        $http({
            method : "POST",
            dataType:"json",
            url : "/php/core.php?method=getMessages"
        }).then(function mySuccess(response) {
            var messages = response.data;
            console.log(messages);
            if (Array.isArray(messages)){
                for (var i= 0,len = messages.length; i<len;i++){
                    ngNotify.set(messages[i]['msg']);
                }
            }
        }, function myError(response) {
            $scope.myWelcome = response.statusText;
        });
    },5000);
});