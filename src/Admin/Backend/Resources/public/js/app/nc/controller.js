angular.module("app")
.factory('NCService', ['$http', function ($http) {
    function updateState(id, state) {
        var req = {
            id: id,
            state: state
        };

        return $http.post('/arfa/web/app_dev.php/administration/IReclamation/update_state/' + id, req)
        .then(function (resp){
            return resp.data;
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    function sendToResponse(id) {
        return $http.post('/arfa/web/app_dev.php/administration/IReclamation/send_to_response/' + id)
        .then(function (resp){
            return resp.data;
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");
        });
    }

    return {
        updateState: updateState,
        sendToResponse: sendToResponse
    };
}])

.controller("NCController", ['$http', '$scope', 'Admin', 'NCService',
function ($http, $scope,  Admin, NCService) {
    var RESPOND_MODAL="#sugestionRespondModal";
    var Table = '#obj-listing';
    $scope.state = Admin.stage;
    $scope.objectType = "Sugestion";
    
    $(Table+' tbody').on('click', 'tr', function () {
        var tableEl = $(Table).DataTable();        
        var data = tableEl.row(this).data();
        console.info(''+data[0]+'\'s row');
    });

    $scope.fetchType = function() {
        var Type=$scope.objectType;
        $http.get('/arfa-nc/web/app_dev.php/administration/nc-objects/search?type=' + Type)
        .then(function (resp){
            var tableEl = $(Table).DataTable();            
            tableEl.rows()
                .remove()
                .draw();
            resp.data.forEach(function (obj){
                tableEl.row.add([
                    obj.code,
                    obj.date,
                    obj.resp_date,
                    obj.created_by,
                    ''
                ]).draw(true);
            });
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");
        });
    }

    $scope.fetchType();
}]);

