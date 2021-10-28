<?php require __ROOT__.'/model/passChecking.php'; ?>

<!--    Angular JS Config Script    -->
<script type="text/javascript">

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
        controller: 'HomeController'
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
        templateUrl: locked('view/viewProjects.php'),
        controller: 'ProjectsController',
    })

    // Full project Page
    .when('/projects/:id', {
        templateUrl: function (params) {
            return locked('view/viewFullproject.php?id='+params.id);
        },
    })

    //Project Versions page
    .when('/versions/:id', {
        templateUrl: function (params) {
            return locked('view/viewVersions.php?id='+params.id);
        },
        controller: 'VersionsController',
    })

    // Posts List Page
    .when('/posts', {
        templateUrl: function (params) {
            var url = 'view/viewPosts.php';
            var symbol = '?';

            if (params.type) {
                url += symbol +'type='+params.type;
                symbol = '&';
            }

            if (params.work) {
                url += symbol +'work='+params.work;
                symbol = '&';
            }

            if (params.tool) {
                url += symbol +'tool='+params.tool;
                symbol = '&';
            }

            if (params.pg) {
                url += symbol +'pg='+params.pg;
                symbol = '&';
            }

            return locked(url);
        },
    })

    // Full post page
    .when('/posts/:id', {
        templateUrl: function (params) {
            return locked('view/viewFullPost.php?id='+params.id);
        },
    })

    //Calendar and Stats page
    .when('/stats', {
        templateUrl: function(params) {
            var url = 'view/viewCalendar.php';
            var symbol = '?';

            if (params.month) {
                url += symbol +'month='+params.month;
                symbol = '&';
            }

            if (params.year) {
                url += symbol +'year='+params.year;
                symbol = '&';
            }
            
            return locked(url)
        },
    })

    // 404 page
    .when('/404', {
        templateUrl: 'view/exception.php?e=404'
    })

    .otherwise('/404');
});

app.controller('ProjectsController', function() {
    <?php require 'public/js/viewProjects.js'; ?>
});

app.controller('HomeController', function() {
    <?php require 'public/js/viewAccueil.js'; ?>
});
    
</script>