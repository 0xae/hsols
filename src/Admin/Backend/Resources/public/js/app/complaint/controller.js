angular.module("app")
.controller("ComplaintViewController", ['$http', '$scope', 'UploadService', function ($http, $scope, UploadService) {
    var url = new URL(location.href);
    var isNew=url.searchParams.get('is_new');
    var uploadedAdded=url.searchParams.get('upload_added');
    
    $scope.categoryConf = {};
    
    $scope.setCategory = function (conf) {
        console.log("conf is " , conf);
        console.info("get ", $scope.categoryConf);

        $scope.categoryConf = JSON.parse(conf);
    }

    $scope.onSubmitForm = function() {
        console.info($scope.categoryConf);
        console.info("set ", $scope.categoryConf);
        $("#admin_backend_complaint_complaintCategory").val(JSON.stringify($scope.categoryConf));

        return false;
    }
}]);
