angular.module("app")
.controller("SugestionAcompController", ['$http', 'SugestionService', 'UploadService', '$scope','Admin', 
function ($http, SugestionService, UploadService, $scope, Admin) {
    var stage=Admin.stage;
    var RESPOND_MODAL='#sugestionRespondModal';

    function getSugestion(id) {
        return $http.get('/arfa/web/app_dev.php/administration/Sugestion/' + id +'/json')
        .then(function (resp){
            var data = resp.data;
            return data;
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.acceptObj = function(obj) {
        if (!confirm("Confirmar " + obj.code + " como favoravel?")){ 
            return;
        }

        var req = {id: obj.id, state: stage.TRATAMENTO};
        $http.post('/arfa/web/app_dev.php/administration/Sugestion/update_state/'+obj.id, req)
        .then(function (data){
            $.notify(obj.code+" aceite para tratamento.", "success");            
            $("#row-" + obj.id).addClass('success');
            $("#row-" + obj.id + "-ok").show();
            $("#row-"+obj.id+"-dispatch").remove();
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.rejectObj = function(obj) {
        $scope.mObject = obj;
        $('#rejectModal').modal();
    }

    $scope.selectObj = function(obj) {
        $scope.mObject = obj;
        $('#rejectModal').modal();
    }

    $scope.markAsNoCompetence = function(label, id) {
        var obj = {id: id};
        if (!confirm("Confirmar "+label+" como sem competencia?")){ 
            return;
        }

        var req = {id: obj.id, state: stage.NO_COMP};
        $http.post('/arfa/web/app_dev.php/administration/Sugestion/update_state/'+obj.id, req)
        .then(function (data){
            $.notify(label+" marcado como sem competencia.", "success");            
            $("#row-" + obj.id).addClass('success');
            $("#row-"+obj.id+"-not-for-me").show();
            $("#row-"+obj.id+"-dispatch").remove();
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.rejectSubmit = function() { 
        if (!confirm("Confirmar Queixa/Denunca como nao favoravel?")) {
            return;
        }

        var req = {
            id: $scope.mObject.id,
            state: stage.NO_FAVORAVEL,
            rejectionReason: $scope.rejectForm.response
        };

        $http.post('/arfa/web/app_dev.php/administration/Sugestion/update_state/'+req.id, req)
        .then(function (data){
            $.notify($scope.mObject.code+" marcado como nao favoravel!", "warning");
            $scope.mObject.response = '';
            // $("#row-" + req.id).remove();
            $("#row-" + req.id).addClass('danger');
            $('#rejectModal').modal('hide');
            $("#row-"+req.id+"-not-favor").show();            
            $("#row-"+req.id+"-dispatch").remove();            
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.noResponse = function (id) { 
        if (!confirm("Confirmar Queixa/Denunca como sem resposta?")) {
            return;
        }

        var req = {
            id: id, 
            state: stage.NO_RESPONSE
        };

        $http.post('/arfa/web/app_dev.php/administration/Sugestion/update_state/'+req.id, req)
        .then(function (data){
            $.notify("Marcado como sem resposta!", "success");
            $("#row-"+req.id+"-dispatch").remove();            
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.respond = function (id) {
        SugestionService.get(id)
        .then(function (data){
            $scope.mObject = data;
            $(RESPOND_MODAL).modal();    
        });
    }

    $scope.submitResponse = function () {
        var id = $scope.mObject.id;
        var req = {
            id: id,
            response: $scope.responseForm.response
        };

        $http.post('/arfa/web/app_dev.php/administration/Sugestion/respond/'+id, req)
        .then(function (data){
            $scope.responseForm.response='';
            $.notify("Respondido com sucesso!", "success");
            $("#row-" + id).addClass('success');
            $("#row-" + id + "-dispatch").remove();
            $scope.responseForm = false;
            setTimeout(function(){
                $(RESPOND_MODAL).modal('hide');                
            }, 500);
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.viewSugestion = function (id, label) {
        $scope.entity = undefined;
        $scope.files = undefined;

        SugestionService.get(id)
        .then(function (data){
            $scope.entity = data;
            if (data.type == 'reclamacao') { // reclamacao
                $scope.modalTitle = "Visualizando Reclamação";
            } else { // sugestao
                $scope.modalTitle = "Visualizando Sugestão";                
            }

            $('#viewSugestionModal').modal();

            UploadService.byReference(data.annexReference)
            .then(function (resp){
                $scope.files = resp.files;
                console.info("upload: ", resp);
            }, function (err) {
                return data;
            });

            if (data.parType == 'par_annex') {
                UploadService.byReference(data.annexReference + "__upload")
                .then(function (resp){
                    $scope.annexFiles = resp.files;
                });    
            }
        });

    }
}]);
