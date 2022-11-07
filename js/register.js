// function validate(evt) {
//     var theEvent = evt || window.event;
//
//     // Handle paste
//     if (theEvent.type === 'paste') {
//         key = event.clipboardData.getData('text/plain');
//     } else {
//         // Handle key press
//         var key = theEvent.keyCode || theEvent.which;
//         key = String.fromCharCode(key);
//     }
//     var regex = /[0-9]|\./;
//     if( !regex.test(key) ) {
//         theEvent.returnValue = false;
//         if(theEvent.preventDefault) theEvent.preventDefault();
//     }
// }
// let dob = document.getElementById("dob");
// dob.max = new Date().toISOString().split("T")[0];
var app = angular.module('guviApp', []);
app.controller('registerController', function($scope) {

    $scope.registerUser = (user2) => {
        console.log(user2);
        let user = Object.assign({},user2)

        console.log(user)
        let settings = {
            "url":"/Guvi_Geek/php/register.php",
            "method":"POST",
            "headers":{
                "Content-Type":"application/json",
            },
            "data": JSON.stringify({
                name:user.name,
                username:user.email,
                password:user.password,
            })
        }

        $.ajax(settings).done(function(res){
            console.log(res);
            toastr["success"]("You have been registered successfully!","Success");
            window.location.href='login.html';
        }).fail(function(err){
            console.log(err);
            if(err.responseText=='User registered successfully!'){
                toastr["success"]("You have been registered successfully!","Success");
                window.location.href='login.html';
            }else{
                toastr["error"]("Registration failed!","Failed");
            }
            $scope.$apply()
        })
    }

})