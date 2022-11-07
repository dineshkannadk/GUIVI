var app = angular.module('guviApp', []);
app.controller('loginController', function($scope) {

    $scope.loginUser = (user2) => {
        console.log(user2);
        let user = Object.assign({},user2)

        console.log(user)
        let settings = {
            "url":"/Guvi_Geek/php/login.php",
            "method":"POST",
            "headers":{
                "Content-Type":"application/json",
            },
            "data": JSON.stringify({
                username:user.username,
                password:user.password,
            })
        }

        $.ajax(settings).done(function(res){
            console.log(res);
            toastr["success"]("Logged in successfully!","Success");
            localStorage.setItem("username",res.username);
            localStorage.setItem("password",res["password"])
            window.location.href='profile.html';
        }).fail(function(err){
            console.log(err);
            toastr["error"]("Username or password is wrong!","Failed");
            $scope.$apply()
        })
    }

})