$(document).ready(function(){
    //https://datatables.net/
    $('#clientesList').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[[0,"desc"]],
        "ajax": {
            url: base_url+'call/clientesList', //ta no model
            type: 'POST'
        },
        "columns" : [
            {"data": "id_clientes","name": "id_clientes"},
			{"data": "razao_social","name":"razao_social"},
			{"data": "nome_comercial","name":"nome_comercial"},
			{"data": "cnpj","name":"cnpj"},
            {"data": "dt_ins_clientes","name":"dt_ins_clientes"},
            {"data": "options","name":"options","orderable":false,"className":"nowrap"}
        ],
        "language": language
    });

    
});

function delete_clientes(id){
    swal({
        title: 'Atenção',
        text: 'Deseja realmente excluir este cliente?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        backdrop:true,
        allowOutsideClick: false,
        cancelButtonText: 'Não'
    }).then(function (result) {
        $.ajax({
            url: base_url + 'call/clientesDelete',
            type: "POST",
            dataType: 'json',
            data: {id:id},
            success: function (retorno) {
                
                if( retorno.sucesso == 1 ) {
                    swal({
                        title: 'Sucesso!',
                        text: 'Cliente deletado.',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        backdrop:true,
                        allowOutsideClick: false,
                        cancelButtonText: 'Não'
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    swal({
                        title: 'Erro!',
                        text: 'Falha ao alterar os dados.',
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        backdrop:true,
                        allowOutsideClick: false,
                        cancelButtonText: 'Não'
                    }).then(function () {
                        //window.location.href = varUrl;
                    });
                }
            }, 
            error: function(){
                swal({
                    title: 'Erro!',
                    text: 'Falha ao alterar os dados.',
                    type: 'error',
                    confirmButtonText: 'OK',
                    backdrop:true,
                    allowOutsideClick: false,
                }).then(function () {
                    //document.getElementById("frmLogin").submit();
                    //window.location.href = varUrl;
                });
            }
        });
    }).catch(function(result){
        //window.location.href = base_url + 'listafornecedors';
    });

}
