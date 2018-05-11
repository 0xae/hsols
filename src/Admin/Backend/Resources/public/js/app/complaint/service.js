angular.module("app")
.factory("ComplaintService", ['$http', function ($http) {
    function getById(id) {        
        return $http.get('/arfa/web/app_dev.php/administration/Complaint/' + id +"/json")
        .then(function (resp){
            return resp.data;
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
            return error;
        }); 
    }

    function updateState(id, req) {
        return $http.post('/arfa/web/app_dev.php/administration/Complaint/update_state/'+id, req)
        .then(function (data){
            return data;
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
            return error;
        });
    }

    function respond(id, req) {
        return $http.post('/arfa/web/app_dev.php/administration/Complaint/respond/'+id, req)
        .then(function (resp){
            return resp.data;
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
            return error;
        });
    }

    return {
        get: getById,
        updateState: updateState,
        respond: respond
    };
}]);
