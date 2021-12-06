$(document).ready(function(){

    $('#formClientes').validate({
        rules:{
            razao_social: "required",
            nome_comercial: "required",
            email: {
                email: true,
                required: true,
            },
            cnpj: {
                required: true
            }
        },
        messages:{
            razao_social: "Por favor, informe Razão Social.",
            nome_comercial: "Por favor, informe o nome comercial.",
            email:{
                required: "Por favor, Informe o e-mail",
                email: "E-mail inválido"
            },
            cnpj: {
                required: "Por favor, informe o numero do CNPJ"
            }
        },
        errorElement: "em",
        errorPlacement: function( error,element ) {
            error.addClass( "help-block" );
            element.parents(".form-group").addClass("has-feedback");

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label") );
            } else {
                error.insertAfter( element );
            }

            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !element.next( "span" )[ 0 ] ) {
                $( "<span class='glyphicon glyphicon-remove form-control-feedback' aria-hidden='true'></span>" ).insertAfter( element );
            }
        },
        success: function ( label, element ) {
            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !$( element ).next( "span" )[ 0 ] ) {
                $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
        },
        unhighlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
        },
        submitHandler: function(form,event){
            afterRequest();
            $.ajax({
                url: base_url + 'call/clientesEdit',
                type: "POST",
                dataType: 'json',
                data: $(form).serialize(),
                beforeSend: function(){
                    setLoading();
                }, 
                success: function (retorno) {
                    setLoading(false);	
                    console.log(retorno);
                    if( retorno.sucesso == 1 ) {
                        swal({
                            title: 'Sucesso!',
                            text: 'Dados alterados com sucesso',
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ok',
                            backdrop:true,
                            allowOutsideClick: false							
                        }).then(function (result) {
                            window.location.href = base_url + 'clientesList';
                        });
                    } else {
                        afterRequest(false);
                        swal({
                            title: 'Erro!',
                            text: 'Falha ao alterar os dados.',
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK',
                            backdrop:true,
                            allowOutsideClick: false
                        }).then(function () {
                            //window.location.href = varUrl;
                        });
                    }
                }, 
                error: function(retorno){
					console.log(retorno);
                    setLoading(false);
                    afterRequest(false);
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
        }
    });
	
	
	
	

	
	$("#add_endereco").click(function(){
		$('#novo_endereco').css("display", "block");
		$('#add_endereco').css("display", "none");
	});
	
	
	$(".adicionarEndereco").click(function () {
		var index = $('.endereco_novo').length +1;
		$(".div_endereco").append('<div class="endereco_novo" id="novo_endereco_'+index+'">	<div class="row">		<div class="form-group col-md-1">			<label>Tipo</label>			<select name="end_tipo[]" id="end_tipo_'+ index +'" class="form-control"><option value=""> Selecione</option><option value="Escritório">Escritório</option><option value="CD">CD</option><option value="Entrega">Entrega</option></select>		</div>		<div class="form-group col-md-2">			<label>Identificação</label>			<input type="text" class="form-control" name="end_identificacao[]" id="identificacao_'+ index +'" value="" placeholder="Ex: Escritório">		</div>		<div class="form-group col-md-2">			<label>CEP</label>			<input type="text" class="form-control cep" name="end_cep[]" id="cep_'+ index +'" value="" placeholder="Ex: 99999-999" onchange="buscaCidade(this.value, '+ index +')">		</div>				<div class="form-group col-md-5">			<label>Cidade</label>			<input type="text" class="form-control" name="end_cidade[]" id="cidade_'+ index +'" value="" placeholder="Ex: São Paulo" readonly="true">		</div>		<div class="form-group col-md-1">			<label>UF</label>			<input type="text" class="form-control" name="end_uf[]" id="uf_'+ index +'" value="" placeholder="Ex: SP" maxlength=2 readonly="true">		</div>		<div class="form-group col-md-1">			<label>&nbsp;</label>			<button type="button" class="form-control btn btn-sm btn-danger btn-request rounded-pill" style="float:right" onclick="excluirEndereco('+index+');">Excluir</button>		</div>	</div>	<div class="row">		<div class="form-group col-md-5">			<label>Endereço</label>			<input type="text" class="form-control" name="end_endereco[]" id="endereco_'+ index +'" value="" placeholder="Ex: Avenida Paulista">		</div>		<div class="form-group col-md-1">			<label>Número</label>			<input type="text" class="form-control" name="end_numero[]" id="numero_'+ index +'" value="" placeholder="Ex: 999">		</div>		<div class="form-group col-md-3">			<label>Bairro</label>			<input type="text" class="form-control" name="end_bairro[]" id="bairro_'+ index +'" value="" placeholder="Ex: Centro">		</div>		<div class="form-group col-md-3">			<label>Complemento</label>			<input type="text" class="form-control" name="end_complemento[]" id="complemento_'+ index +'" value="" placeholder="Ex: Sala 01">		</div>			</div></div>');
	});
	

	
	
	
});

function excluirEndereco(index) {
	$("#novo_endereco_"+index).remove();
}


function buscaCidade(cep, index){
	$(function(){
	
		console.log(cep);
		$.ajax({
			url: base_url + 'call/buscaEndereco',
			type: "POST",
			dataType: 'json',
			data : {
				cep : cep
			},
			beforeSend: function(){
				setLoading();
			},
			success: function (retorno) {
				setLoading(false);
				console.log(retorno);
				if(retorno['erro'] == true){
					setLoading(false);
                    afterRequest(false);
                    swal({
                        title: 'Atenção!',
                        text: 'Cidade não encontrada.',
                        type: 'error',
                        confirmButtonText: 'OK',
                        backdrop:true,
                        allowOutsideClick: false,
                        cancelButtonText: 'Não'
                    }).then(function () {
                        afterRequest(false);
                        //document.getElementById("frmLogin").submit();
                        //window.location.href = varUrl;
                    });
				}
				else{
					$("#cidade_"+ index).val(retorno['localidade']);
					$("#endereco_"+ index).val(retorno['logradouro']);
					$("#complemento_"+ index).val(retorno['complemento']);
					$("#bairro_"+ index).val(retorno['bairro']);
					$("#uf_"+ index).val(retorno['uf']);
				}
			}, 
			error: function(){
				setLoading(false);
				alert('Insumo Inválido');
				
			}
		});
	});
}



function ExcluiEndereco(id){
    swal({
        title: 'Atenção',
        text: 'Deseja realmente excluir este endereço?',
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
            url: base_url + 'call/clientesEnderecoDelete',
            type: "POST",
            dataType: 'json',
            data: {id:id},
            success: function (retorno) {
                
                if( retorno.sucesso == 1 ) {
                    swal({
                        title: 'Sucesso!',
                        text: 'Endereço deletado.',
                        type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        backdrop:true,
                        allowOutsideClick: false,
                        cancelButtonText: 'Não',
                    }).then(function () {
                        location.reload();
                    })
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
        //window.location.href = base_url + 'listaclientess';
    });

}
