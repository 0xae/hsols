angular.module("app")
.service("CompBook", 
['$http', function ($http) {
    function getById(id) {        
        return $http.get('/arfa/web/app_dev.php/administration/CompBook/' + id +"/json")
        .then(function (resp){
            return resp.data;
        }, HandleError);
    }    

    function HandleError(error) {
        var msg="A operacao nao pode ser efectuada.Tente novamente!";
        if (error && error.toString()) {
            msg = error.toString;
        }

        $.notify(msg, "danger");
        return error;
    }

    function updateComp(id, req) {
        return $http.post('/arfa/web/app_dev.php/administration/CompBook/' + id +"/update_comp", req)
        .then(function (resp){
            return resp.data;
        }, HandleError); 
    }

    return {
        get: getById,
        updateComp: updateComp
    }
}]);
