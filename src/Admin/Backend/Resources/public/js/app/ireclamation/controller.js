angular.module("app")
.factory('IReclService', ['$http', function ($http) {
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

.controller("IReclController", ['$http', '$scope', 'UploadService', 'Admin', 'IReclService',
function ($http, $scope, UploadService, Admin, IReclService) {
    var RESPOND_MODAL="#sugestionRespondModal";
    $scope.state = Admin.stage;

    function getRecl(id) {
        return $http.get('/arfa/web/app_dev.php/administration/IReclamation/' + id +'/json')
        .then(function (resp){
            return resp.data;
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.setIReclDetails = function(type) {
        if (type == 'analysis') {
            $scope.ireclDetails = {
                label: 'Análise',
                resp: $scope.entity.analysisResp,
                date:$scope.entity.analysisDate,
                description: $scope.entity.analysisDetail
            };
        } else if (type == 'decision') {
            $scope.ireclDetails = {
                label: 'Decisão',
                resp: $scope.entity.decisionResp,
                date:$scope.entity.decisionDate,
                description: $scope.entity.decisionDetail
            };
        } else if (type == 'action') {
            $scope.ireclDetails = {
                label: 'Ação',
                resp: $scope.entity.actionResp,
                date:$scope.entity.actionDate,
                description: $scope.entity.actionDetail
            };
        } else {
            $scope.ireclDetails = {};
        }
    }

    $scope.viewIRecl = function (id, type) {
        var labelX = 'Reclamacao Interna';
        $scope.entity = undefined;
        $('a[href="#home"]').tab('show'); 

        getRecl(id).then(function (data){
            $scope.entity = data;
            $scope.modalTitle = "Visualizando " + labelX;

            $('#viewIRECLModal').modal();

            UploadService.byReference(data.annexReference)
            .then(function (resp){
                $scope.files = resp.files;
            });
        });
    }

    $scope.respondIRecl = function (id, label) {
        getRecl(id).then(function (data){
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

        $http.post('/arfa/web/app_dev.php/administration/IReclamation/respond/'+id, req)
        .then(function (data){
            $scope.responseForm.response='';
            $.notify("Respondido com sucesso!", "success");
            $("#row-" + id).addClass('success');
            $("#row-" + id + "-dispatch").remove();
            $("#ir-analysis-"+id+"-state").remove();
            $("#ir-analysis-"+id+"-resp").attr("style", "display:inherit !important");
            $scope.responseForm = false;
            setTimeout(function(){
                $(RESPOND_MODAL).modal('hide');                
            }, 500);
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.notFavorable = function (id, label) {
        if (!confirm("Confirmar " + label + " como não favoravel ?")){
            return;
        }

        IReclService.updateState(id, Admin.stage.NO_RESPONSE)
        .then(function (data){
            $.notify(label+" arquivado com sucesso.", "success");

            $("#row-" + id).addClass('success');
            $("#row-" + id + "-dispatch").remove();
        });
    }

    $scope.sendToAnalysis = function (id) {
        if (!confirm('Confirmar envio para análise?')) {
            return;
        }

        IReclService.updateState(id, Admin.stage.ANALYSIS)
        .then(function (data){
            $.notify("Objecto actualizado com sucesso.", "success");

            $("#row-" + id).addClass('success');
            $("#row-" + id + "-dispatch").remove();
            $("#ir-analysis-"+id).attr("style", "display:inherit !important");
        });
    }
}])

.controller("IReclViewController", [
'$http', '$scope', 'UploadService', 'Admin', 'IReclService',
function ($http, $scope, UploadService, Admin, IReclService) {
    $scope.state = Admin.stage;

    $scope.sendTo = function (id, state, label, oldState) {
        if (!confirm('Confirmar envio para ' + label + ' ?')) {
            return;
        }

        IReclService.updateState(id, state)
        .then(function (data){
            $.notify("Objecto actualizado com sucesso.", "success");

            $("#row-" + id).addClass('success');
            $("#row-" + id + "-dispatch").remove();
            $("#ir-analysis-"+id).attr("style", "display:inherit !important");
        
            setTimeout(() => {
                if (oldState) {                
                    location.href = '/arfa/web/app_dev.php/administration/IReclamation/by_state/'+oldState;                    
                }
            }, 1200);
        });
    }

    $scope.finishIRecl = function (id) {
        if (!confirm('Confirmar envio para resposta?')) {
            return;
        }

        IReclService.sendToResponse(id)
        .then(function (data){
            $.notify("Objecto actualizado com sucesso.", "success");

            $("#row-" + id).addClass('success');
            $("#row-" + id + "-dispatch").remove();
            $("#ir-analysis-"+id).attr("style", "display:inherit !important");

            setTimeout(() => {
                // $("#admin_backend_ireclamation_submit").click();
                if (oldState) {                
                    location.href = '/arfa/web/app_dev.php/administration/IReclamation/by_state/action';
                }
            }, 1200);
        });
    }
}]);
