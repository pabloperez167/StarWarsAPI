<!-- resources/views/starships.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Starships and Pilots</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</head>
<body ng-app="myApp" ng-controller="StarshipController">
    <h1>Starships and Pilots</h1>
    <ul>
        <li ng-repeat="starship in starships">
            {{ starships.name }}
            <ul>
                <li ng-repeat="pilot in starship.pilots">
                    {{ pilots.name }}
                </li>
            </ul>
        </li>
    </ul>

    <script>
        angular.module('myApp', [])
            .controller('StarshipController', function($scope) {
                // Aquí puedes asignar los datos de las naves y pilotos a $scope.starships desde tu backend
                $scope.starships = {!! $starships !!};
            });
    </script>
</body>
</html>
