<!DOCTYPE html>
<html lang="EN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Matrix Media</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body class="antialiased">
    <div ng-app="myApp" ng-controller="myCtrl">
        <div class="container">
            <div class="row">
                <form id="myForm" ng-submit="mySubmit($event)">
                    <input type="text" id="name" name="name" ng-model="name">
                    <input type="text" id="email" name="email" ng-model="email">
                    <input type="hidden" id="photo" name="photo" ng-model="photo">
                    <input type="file" name="file" id="Files">
                    <input type="submit" value="Add">
                    <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                </form>
            </div>
            <br>
            <%= myWelcome %>
        </div>
    </div>
    <script>
        var app = angular.module('myApp', []);
        app.config(function ($interpolateProvider) {
  // To prevent the conflict of `{{` and `}}` symbols
  // between Blade template engine and AngularJS templating we need
  // to use different symbols for AngularJS.

  $interpolateProvider.startSymbol('<%=');
  $interpolateProvider.endSymbol('%>');
});
        app.controller('myCtrl', function($scope, $http) {
            $scope.headers = {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer {{ csrf_field() }}',
                'clt-id': ''
            };
            $scope.baseUrl = window.location.origin; // for developement server
            //   console.log(window.location.origin);
            $scope.mySubmit = (e) => {
                e.preventDefault();
                var ee=document.getElementById("Files");
            // console.log(ee.files[0]);
            var fff=new FormData();
            fff.append("file",ee.files[0]);
            fff.append("_token",$("#csrf").val());
            // return 0;
            $.ajax({
                url: window.location.origin+"/ImageUpload",
                type: "POST",
                data: fff,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    //$("#preview").fadeOut();
                    $("#err").fadeOut();
                },
                success: function(data) {
                    console.log(data);
                    document.getElementById("photo").value=data.imagename;
                    $scope.MainSubmit(data.imagename);
                },
                error: function(e) {
                    $("#err").html(e).fadeIn();
                }
            });
            }
            $scope.MainSubmit=(img)=>{
                $http({
                    method: 'POST',
                    url: $scope.baseUrl + '/Save',
                    data: {
                        name: $scope.name,
                        email: $scope.email,
                        photo:img
                    },
                    headers: $scope.headers,
                }).then(function mySuccess(response) {
                    console.log(response);
                    if (response.data.status) {

                    }
                });
            }
            $scope.Records=[];
            $scope.GetAll = () => {
                $http({
                    method: 'GET',
                    url: $scope.baseUrl + "/GetAll",
                    headers: $scope.headers,
                }).then(function mySuccess(response) {
                    console.log(response);
                    $scope.Records=response.data;
                    if (response.data.status) {

                    }
                });
            }
            $scope.GetAll();
            $scope.myWelcome = "Welcome";
        });
    </script>
</body>

</html>