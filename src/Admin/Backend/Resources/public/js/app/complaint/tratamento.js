angular.module("app")
.controller("CompTratamentoController", [
'$http', '$scope', 'UploadService', 'ComplaintService', 
function ($http, $scope, UploadService, ComplaintService) {
    var ACEITADO='aceitado';
    var REJEITADO='rejeitado';
    var TRATAMENTO='tratamento';
    var PENDENTE='pendente';
    var SEM_RESPOSTA='sem_resposta';
    var VIEW_MODAL='#viewComplaintModal';
    var type='Complaint';

    $("#upload-form").submit(function(e){
        e.preventDefault(); //Prevent Default action.            
        var formURL = $("#upload-form").attr("action");
        var formData = new FormData(this);

        $.ajax({
            url: formURL,
            type: 'POST',
            data:  formData,
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(data, textStatus, jqXHR) {
                $.notify("Anexo enviado.", "success");
                $scope.respondSubmit();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $.notify("O anexo nao pode ser enviado.Tente novamente! " + textStatus, "danger");                                
            }
        });
    });

    function openModal(obj, title, ModalRef) {
        $scope.mObject = obj;
        $scope.modalTitle = title;
        $(ModalRef).modal();
    }    

    $scope.viewComplaint = function(id) {
        $scope.entity = undefined;
        ComplaintService.get(id)
        .then(function (data){
            $scope.entity = data;
            $scope.modalTitle = "Visualizando Queixa/Denuncia";

            $(VIEW_MODAL).modal();
        
            UploadService.byReference(data.annexReference)
            .then(function (resp){
                $scope.files = resp.files;
            });

            if (data.parType == 'par_annex') {
                UploadService.byReference(data.annexReference + "__upload")
                .then(function (resp){
                    $scope.annexFiles = resp.files;
                });    
            }
        });
    }

    $scope.setType = function (v) {
        console.log("changing type to: ", v);
        type = v;
    }

    $scope.noResponseObj = function(obj) {
        if (!confirm("Confirmar " + obj.code + " sem resposta?")) return;
        var req = {id: obj.id, state: SEM_RESPOSTA};
        $http.post('/arfa/web/app_dev.php/administration/Complaint/update_state/'+obj.id, req)
        .then(function (data){
            $.notify(obj.code+" arquivado com sucesso.", "success");            
            $("#row-" + obj.id).addClass('success');
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }

    $scope.respondObj = function (obj) {
        var title='';
        if (obj.type == 'par_tec') {
            title = 'Parecer Tecnico';
        } else if(obj.type == 'par_cent') {
            title = 'Parecer Cientifico';            
        }
        openModal(obj, title, '#respondModal');
    }

    $scope.annexParecer = function (obj, title) {
        openModal(obj, '', '#updateParAnnex');
        $("#admin_backend_upload_reference").val(obj.annexReference + "__upload");        
    }

    $scope.respondSubmit = function() {
        if (!confirm('Confirmar envio de parecer?')) { 
            return;
        }

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

        $http.post('/arfa/web/app_dev.php/administration/Complaint/'+id+'/update_par', req)
        .then(function (data){
            $scope.responseForm.response='';
            $.notify("Parecer atribuido com sucesso!", "success");
            $("#row-" + id).addClass('success');
            $("#xop__"+id).remove();
            $("#xstat_"+id).text($scope.modalTitle);
            $("#xstat_"+id).removeClass('hidden');
            
            $scope.responseForm = false;
            setTimeout(function(){
                $('#respondModal').modal('hide');
                $('#updateParAnnex').modal('hide');                
            }, 500);
        }, function (error) {
            $.notify("A operacao nao pode ser efectuada.Tente novamente!", "danger");            
        });
    }
}]);
