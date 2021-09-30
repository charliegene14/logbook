<?php require_once __ROOT__.'/model/passChecking.php';?>

<!--Angular JS Config Script-->
<script>

//Get the boolean PHP password checking
var isValidPass = <?php echo json_encode(isValidPass('Site')); ?>;

//Create blocked templating function to use in router
function locked(view){
    if (isValidPass == true) {
        return view;
    } else {
        return  'view/viewBlock.php';
    }
}

// Create the module
var app = angular.module("app", ['ngRoute']);

// Configure routes
app.config(function($routeProvider){

    $routeProvider

    // Home Page
    .when('/', {
        templateUrl: locked('view/viewAccueil.php'),
    })

    // Login Page
    .when('/login', {
        templateUrl: 'view/viewBlock.php',
    })

    // Custom Page added
    .when('/page/:filename', {
        templateUrl: function (params) {
            return locked('view/viewPage.php?page='+params.filename);
        },
    })

    // Portfolio / Projects Page
    .when('/projects', {
        templateUrl: locked('view/viewProjects.php')
    })

    // Full project Page
    .when('/projects/:id', {
        templateUrl: function (params) {
            return locked('view/viewFullproject.php?id='+params.id);
        },
    })

    // Posts List Page
    .when('/posts', {
        templateUrl: locked('view/viewPosts.php')
    })

    // Full post Page
    .when('/posts/:id', {
        templateUrl: function (params) {
            return locked('view/viewFullPost.php?id='+params.id);
        },
    })

    .when('/404', {
        templateUrl: 'view/exception.php?e=404'
    })

    .otherwise('/404');
});
</script>
