/**
 * Created by melodic on 17.03.2016.
 */

var app = angular.module('mainApp', ['notification','smart-table','ui.bootstrap']);
app.controller('myNotify', function($scope, $http, $interval,$notification,$sce) {
    function getData(){
        $http({
            method : "POST",
            dataType:"json",
            url : "/php/core.php?method=getDashboardData",
            data: {}
        }).then(function mySuccess(response) {
            var data = response.data;
            $scope.app_count=data['app_count'];
            $scope.msg_count=data['msg_count'];
            var messages = data.messages;
            //console.log(data);
            $scope.htmlPopover = $sce.trustAsHtml(data['last_msg']);
            if (Array.isArray(messages)){
                for (var i= 0,len = messages.length; i<len;i++){
                    $notification(messages[i]['title'], {
                        body: messages[i]['msg'],
                        delay: messages[i]['delay'],
                    });
                }
            }
        }, function myError(response) {
            $scope.myWelcome = response.statusText;
        });
    }
    getData();
    $interval(getData,5000);
});




//TABLE EXAMPLE
//app.controller('safeCtrl', ['$scope', function ($scope) {
//
//    var firstnames = ['Laurent', 'Blandine', 'Olivier', 'Max'];
//    var lastnames = ['Renard', 'Faivre', 'Frere', 'Eponge'];
//    var dates = ['1987-05-21', '1987-04-25', '1955-08-27', '1966-06-06'];
//    var id = 1;
//
//    function generateRandomItem(id) {
//
//        var firstname = firstnames[Math.floor(Math.random() * 3)];
//        var lastname = lastnames[Math.floor(Math.random() * 3)];
//        var birthdate = dates[Math.floor(Math.random() * 3)];
//        var balance = Math.floor(Math.random() * 2000);
//
//        return {
//            id: id,
//            firstName: firstname,
//            lastName: lastname,
//            birthDate: new Date(birthdate),
//            balance: balance
//        }
//    }
//
//    $scope.rowCollection = [];
//
//    for (id; id < 5; id++) {
//        $scope.rowCollection.push(generateRandomItem(id));
//    }
//
//    //add to the real data holder
//    $scope.addRandomItem = function addRandomItem() {
//        $scope.rowCollection.push(generateRandomItem(id));
//        id++;
//    };
//
//    //remove to the real data holder
//    $scope.removeItem = function removeItem(row) {
//        var index = $scope.rowCollection.indexOf(row);
//        if (index !== -1) {
//            $scope.rowCollection.splice(index, 1);
//        }
//    }
//}]);