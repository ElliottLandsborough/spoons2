angular.module('homeCtrl', ['geolocation'])

// inject the Home service into our controller
.controller('homeController', function($scope, $http, geolocation, Home) {

    geolocation.getLocation().then(function(data){
        $scope.coords = {lat:data.coords.latitude, long:data.coords.longitude}; // {{coords}}
    });



    /*

    ////////////////////////////////////

    // object to hold all the data for the new comment form
    $scope.commentData = {};

    // loading variable to show the spinning loading icon
    $scope.loading = true;

    // get all the comments first and bind it to the $scope.comments object
    // use the function we created in our service
    // GET ALL COMMENTS ==============
    Home.get()
        .success(function(data) {
            $scope.comments = data;
            $scope.loading = false;
        });

    // function to handle submitting the form
    // SAVE A COMMENT ================
    $scope.submitComment = function() {
        $scope.loading = true;

        // save the comment. pass in comment data from the form
        // use the function we created in our service
        Home.save($scope.commentData)
            .success(function(data) {

                // if successful, we'll need to refresh the comment list
                Home.get()
                    .success(function(getData) {
                        $scope.comments = getData;
                        $scope.loading = false;
                    });

            })
            .error(function(data) {
                console.log(data);
            });
    };

    // function to handle deleting a comment
    // DELETE A COMMENT ====================================================
    $scope.deleteComment = function(id) {
        $scope.loading = true; 

        // use the function we created in our service
        Home.destroy(id)
            .success(function(data) {

                // if successful, we'll need to refresh the comment list
                Home.get()
                    .success(function(getData) {
                        $scope.comments = getData;
                        $scope.loading = false;
                    });

            });
    };

    */

});