angular.module("app")
.controller("TratamentoController", ['$http', '$scope', function ($http, $scope) {
    var ACEITADO='aceitado';
    var REJEITADO='rejeitado';
    var TRATAMENTO='tratamento';
    var PENDENTE='pendente';
    var SEM_RESPOSTA='sem_resposta';
    var type='Complaint';

    $scope.viewObject = function(id) {
        console.info("")
        $scope.entity = undefined;
        $http.get('/arfa/web/app_dev.php/administration/'+type+ '/' + id+"/json")
        .then(function (resp){
            var data = resp.data;
            $scope.entity = data;
            $scope.modalTitle = "Visualizando " + label(type);
            $('#viewComplaintModal').modal();
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.setType = function (v) {
        console.log("changing type to: ", v);
        type = v;
    }

    function label(type) {
        if (type == "Complaint") {
            return "Queixa/Denuncia";
        } else {
            return "Sugestao/Reclamacao";            
        }
    }

    $scope.noResponseObj = function(obj) {
        if (!confirm("Confirmar " + obj.code + " sem resposta?")) return;
        var req = {id: obj.id, state: SEM_RESPOSTA};
        $http.post('/arfa/web/app_dev.php/administration/'+type+'/update_state/'+obj.id, req)
        .then(function (data){
            $.notify(obj.code+" arquivado com sucesso.", "success");            
            $("#row-" + obj.id).addClass('success');
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.respondObj = function (obj, title) {
        $scope.mObject = obj;
        if (obj.type == 'par_tec') {
            $scope.modalTitle = 'Parecer Tecnico';
        } else {
            $scope.modalTitle = 'Parecer Cientifico';            
        }
        $('#respondModal').modal();
    }

    $scope.respondSubmit = function() {
        if (!confirm('Confirmar envio de parecer?')) return;
        var response = $scope.responseForm;
        var id = $scope.mObject.id;
        var type = $scope.mObject.type;
        var req = {
            id: id,
            parCode: response.parCode,
            parSubject: response.parSubject,
            parDestination: response.parDestination,
            parDescription: response.parDescription,
            type: type
        };

        console.info(response);
        console.info(req);

        $http.post('/arfa/web/app_dev.php/administration/Complaint/'+id+'/update_par', req)
        .then(function (data){
            $scope.responseForm.response='';
            $.notify($scope.modalTitle+" atribuido com sucesso!", "success");
            $("#row-" + id).addClass('success');
            $("#xop__"+id).remove();
            $("#xstat_"+id).text($scope.modalTitle);
            $("#xstat_"+id).removeClass('hidden');
            
            $scope.responseForm = false;
            setTimeout(function(){
                $('#respondModal').modal('hide');                
            }, 500);
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.viewSugestion = function (id, type) {
        var labelX = 'Reclamacao';
        if (type == 'sugestao') labelX = 'Sugestao';
        $scope.entity = undefined;
        $http.get('/arfa/web/app_dev.php/administration/Sugestion/' + id +'/json')
        .then(function (resp){
            var data = resp.data;
            $scope.entity = data;
            $scope.modalTitle = "Visualizando " + labelX;
            $('#viewSugestionModal').modal();
        }, function (error) {
            $.notify("A operacao não pode ser efectuada.Tente novamente!", "danger");            
        });
    }
}]);