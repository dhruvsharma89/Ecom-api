    var myApp = angular.module('myApp', ['ngRoute']);

myApp.controller("myController",function($http,$rootScope){
     $http.get("http://localhost/api/product/read.php").then(function(response){
                          $rootScope.myWel = response.data.records;
                          console.log($rootScope.myWel[0].url);
                      });

$rootScope.cartname=" h";
$rootScope.cartimage=" h";
$rootScope.cartprice=" h";
$rootScope.cartdescription=" h";

    
$rootScope.addtocart=function(){
    $rootScope.pid=this.dt.id;
    $rootScope.cartname=this.dt.name;
    $rootScope.cartimage=this.dt.url;
    $rootScope.cartprice=this.dt.price;
    $rootScope.cartdescription=this.dt.description;
    
    console.log(this.dt.id);
    console.log(this.dt.price);
    console.log("Heloooooooooooooooo"+$rootScope.cartimage);
    
}


$rootScope.sendtocart=function(){
    
  var parameter = JSON.stringify({user:"ramesh", pid:$rootScope.pid, quantity:"1"});
    console.log(parameter+"$$$");
    $http.post("http://localhost/api/cart/add.php",parameter).then(function(response){
                          
                          console.log(response);
                      });
}


$rootScope.readcart= function(){
    console.log("Readthecart");
    $http.get("http://localhost/api/cart/read.php").then(function(data){
                           
        $rootScope.cdata=data.data;
        console.log($rootScope.cdata);
        console.log($rootScope.cdata);
        $rootScope.calculate();
        
                      });
}

$rootScope.calculate=function(){
    
    $rootScope.total=0;
        for (x in $rootScope.cdata.products) {
    var i=0;
           $rootScope.total=parseInt($rootScope.total)+parseInt($rootScope.cdata.products[x].price); 
            console.log(x+""+i);
            ++i;
            
}
    console.log($rootScope.total);

}

$rootScope.deletecart= function(){
    console.log(this);
    var parameter = JSON.stringify({user:this.dt.user,cart_id:this.dt.cart_id});
    console.log(parameter);
    $http.post("http://localhost/api/cart/delete.php",parameter).then(function(data){
        
        console.log(data);
        
        
                      });
    $rootScope.readcart();
}



});



myApp.config(function ($routeProvider) {
    
    $routeProvider
    
    .when('/', {
        templateUrl: 'mainpg.html',
        controller: 'mainController'
    })
    .when('/mainpg', {
        templateUrl: 'mainpg.html',
        controller: 'mainController'
    })
    
    .when('/bestselling', {
        templateUrl: 'bestselling.html',
        controller: 'secondController'
    })
    
    .when('/gridlist', {
        templateUrl: 'gridlist.html',
        controller: 'thirdController'
    })
    .when('/addtocart', {
        templateUrl: 'addtocart.html',
        controller: 'fourthController'
    })
    .when('/cart', {
        templateUrl: 'cart.html',
        controller: 'fourthController'
    })
    .when('/login', {
        templateUrl: 'login.html',
        controller: 'fifthController'
    })
    .when('/signup', {
        templateUrl: 'signup.html',
        controller: 'sixthController'
    })
    
});

myApp.controller('mainController', ['$scope','$http', '$log', function($scope,$http, $log) {

    $scope.name = 'Main';   
}]);

myApp.controller('secondController', ['$scope', '$log', '$routeParams', function($scope, $log, $routeParams) {
    
    $scope.num = $routeParams.num || 1;
    
}]);
myApp.controller('thirdController', ['$scope','$log', '$http','$rootScope', function($scope,$log,$http,$rootScope) {
    
    $scope.name = 'gridlist';
    $http.get("mydata.json").then(function(response){
                          $rootScope.myWel = response.data;
                          console.log( $rootScope.myWel.s[0].url);
                      });

    
}]);
myApp.controller('fourthController', ['$scope', '$log','$rootScope', function($scope, $log,$rootScope) {
    
    $scope.name = 'addtocart';
    $scope.name=$rootScope.cartname;
    $scope.url=$rootScope.cartimage;
    $scope.price=$rootScope.cartprice;
    $scope.description=$rootScope.cartdescription;
    
    console.log($scope.url);
    
}]);
myApp.controller('fifthController', ['$scope','$http', '$log', function($scope,$http, $log) {

    $scope.name = 'fifth';   
}]);
myApp.controller('sixthController', ['$scope','$http', '$log', function($scope,$http, $log) {

    $scope.name = 'sixth';   
}]);
