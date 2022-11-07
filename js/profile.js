function validate(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}
let dob = document.getElementById("dob");
dob.max = new Date().toISOString().split("T")[0];
var app = angular.module('guviApp', []);
app.controller('profileController', function($scope) {

    $scope.updateUser = (user2) => {
        console.log(user2);
        let user = Object.assign({},user2)

        console.log(user)
        let settings = {
            "url":"/Guvi_Geek/php/profile.php",
            "method":"POST",
            "headers":{
                "Content-Type":"application/json",
            },
            "data": JSON.stringify({
                name:user.name,
                username:user.email,
                password:user.password,
                dob:user.dob,
                phoneNumber:user.phoneNumber
            })
        }

        $.ajax(settings).done(function(res){
            console.log(res);
            toastr["success"]("Profile updated successfully!","Success");
        }).fail(function(err){
            console.log(err);
            if(err.responseText=='Profile updated successfully!'){
                toastr["success"]("Profile updated successfully!","Success");
            }else{
                toastr["error"]("Profile update failed!","Failed");
            }
            $scope.$apply()
        })
    }

    $scope.getUser = () => {
        let settings = {
            "url":"/Guvi_Geek/php/get_profile.php",
            "method":"POST",
            "headers":{
                "Content-Type":"application/json",
            },
            "data": JSON.stringify({
                username:localStorage.getItem("username"),
            })
        }

        $.ajax(settings).done(function(res){
            console.log(res);
            $scope.user = res;
            $scope.$apply();
        }).fail(function(err){

        })
    }
    $scope.getUser();

})