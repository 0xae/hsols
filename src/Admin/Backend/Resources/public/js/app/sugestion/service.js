angular.module("app")
.factory("SugestionService", ['$http', 'UploadService', 
function ($http, UploadService){
    function getById(id) {
        return $http.get('/arfa/web/app_dev.php/administration/Sugestion/' + id +'/json')
        .then(function (resp){
            var data = resp.data;
            return data;
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    function sendResponse(id, req) {
        return $http.post('/arfa/web/app_dev.php/administration/Sugestion/respond/' + id, req)
        .then(function (data){
            return data;            
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    function updateState(id, req) {
        return $http.post('/arfa/web/app_dev.php/administration/Sugestion/update_state/'+id, req)
        .then(function (data){
            return data;
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });        
    }

    return { 
        get: getById,
        respond: sendResponse,
        updateState: updateState
    };
}]);