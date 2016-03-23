/**
 * Created by melodic on 17.03.2016.
 */

var app = angular.module('mainApp', ['notification']);
app.controller('myNotify', function($scope, $http, $interval,$notification) {


    //$notification('New message', {
    //    body: 'You have a new message.',
    //    delay: 3000
    //});

    $interval(function (){
        $http({
            method : "POST",
            dataType:"json",
            url : "/php/core.php?method=getMessages"
        }).then(function mySuccess(response) {
            var messages = response.data;
            if (Array.isArray(messages)){
                for (var i= 0,len = messages.length; i<len;i++){
                    $notification('New message', {
                        body: messages[i]['msg'],
                        delay: messages[i]['delay']
                    });
                }
            }
        }, function myError(response) {
            $scope.myWelcome = response.statusText;
        });
    },5000);
});