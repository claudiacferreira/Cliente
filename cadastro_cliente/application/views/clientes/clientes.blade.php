@extends('base.geral')
@section('conteudo')
<style>
	hr{
		margin-top:10px;
	}
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            Cadastro de Clientes
			
        </div>
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-heading">
					@if($tela == 'clientesView')
						Visualizar 
					@endif
					
					@if($tela == 'clientesEdit')
						Editar 
					@endif
					
					@if($tela == 'clientesAdd')
						Cadastrar 
					@endif
					| 
                    <small>Clientes</small>
                    <?php if(can('CLI05')) { ?>
                        <div class="col-md-12 text-right">
                            <a href="<?php echo base_url('clientesList'); ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-step-backward" aria-hidden="true"></i>  Voltar à lista de clientes
                            </a>
                        </div>
                    <?php } ?>
                </div>
				<form action="" id="formClientes" method="post">
					<div class="panel-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nome">Razão Social</label>
                                <input type="text" class="form-control" name="razao_social" id="razao_social" value="{{$clientes['razao_social']}}" placeholder="Ex: Razão Social ME" {{$disabled}} >
                                <input type="hidden" class="form-control" id="id" name="id" value="{{$clientes['id_clientes']}}" {{$disabled}} >
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nome Comercial</label>
                                <input type="text" class="form-control" name="nome_comercial" id="nome_comercial" value="{{$clientes['nome_comercial']}}" placeholder="Ex: Nome Fantasia" {{$disabled}} >
                            </div>
                        </div>
                        <div class="row">
							<div class="form-group col-md-3">
                                <label>CNPJ</label>
                                <input type="text" class="form-control" name="cnpj" id="cnpj" value="{{$clientes['cnpj']}}" placeholder="Ex: 99.999.999/9999-99" {{$disabled}}>
                            </div>
							<div class="form-group col-md-3">
                                <label>Inscrição Estadual</label>
                                <input type="text" class="form-control" name="inscricao_estadual" id="inscricao_estadual" value="{{$clientes['inscricao_estadual']}}" placeholder="99999999999-9" {{$disabled}}>
                            </div>
                            <div class="form-group col-md-6">
                                <label>E-mail</label>
                                <input type="text" class="form-control" name="email" id="email" value="{{$clientes['email']}}" placeholder="Ex: email@email.com" {{$disabled}}>
                            </div>
                        </div>
						<hr>
					</div>
					
					
					<!-- CONTATO ------------------------------------------------------------------------------------------------------------------------------------------------------------------>
					
					<div class="panel-body div_contato">
						<div class="row">
							<div class="form-group col-md-12">
								<h4><b>Contato</b></h4>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-1">
								<label>DDD</label>
								<input type="text" class="form-control ddd" name="ddd" id="ddd" value="{{$clientes['ddd']}}" placeholder="Ex: 99" {{$disabled}}>
							</div>
							<div class="form-group col-md-2">
								<label>Telefone</label>
								<input type="text" class="form-control telefone" name="telefone" id="telefone" value="{{$clientes['telefone']}}" placeholder="Ex: 99999-9999" {{$disabled}}>
							</div>
							<div class="form-group col-md-1">
								<label>Ramal</label>
								<input type="text" class="form-control" name="ramal" id="ramal" value="{{$clientes['ramal']}}" placeholder="Ex: 9999" {{$disabled}}>
							</div>
						
							<div class="form-group col-md-2">
								<label>Tipo</label>
								<select name="tipo_linha" id="tipo_linha" class="form-control" {{$disabled}}>
									<option value=""> Tipo</option>
									<option value="Fixo" @if($clientes['tipo_linha'] == 'Fixo')  {{'selected'}} @endif >Fixo</option>
									<option value="Celular" @if($clientes['tipo_linha'] == 'Celular')  {{'selected'}} @endif >Celular</option>
								</select>
							</div>
						</div>
						<hr>
					</div>
					
			
			
			
			
					
					
					<!-- ENDEREÇO ----------------------------------------------------------------------------------------------------------------------------------------------------------------->
					
					<div class="panel-body div_endereco">
						<div class="row">
							<div class="form-group col-md-12">
								<h4><b>Endereços</b></h4>
							</div>
						</div>
						@isset ($enderecos)
							@foreach($enderecos as $key => $endereco)
								<div class="row">
									<div class="form-group col-md-1">
										<label>Tipo</label>
										<select name="end_tipo_{{$endereco['id_clientes_endereco']}}" id="end_tipo" class="form-control" {{$disabled}}>
											<option value=""> Selecione</option>
											<option value="Escritório" @if($endereco['tipo'] == 'Escritório')  {{'selected'}} @endif >Escritório</option>
											<option value="CD" @if($endereco['tipo'] == 'CD')  {{'selected'}} @endif >CD</option>
											<option value="Entrega" @if($endereco['tipo'] == 'Entrega')  {{'selected'}} @endif >Entrega</option>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label>Identificação</label>
										<input type="text" class="form-control" name="end_identificacao_{{$endereco['id_clientes_endereco']}}" id="identificacao" value="{{$endereco['identificacao']}}" placeholder="Ex: Escritório" {{$disabled}}>
									</div>
									<div class="form-group col-md-2">
										<label>CEP</label>
										<input type="text" class="form-control cep" name="end_cep_{{$endereco['id_clientes_endereco']}}" id="cep" value="{{$endereco['cep']}}" placeholder="Ex: 99999-999" onchange="buscaCidade(this.value, 100{{$key}})" {{$disabled}}>
									</div>
									@if($tela == 'clientesView')
										<div class="form-group col-md-6">
											<label>Cidade</label>
											<input type="text" class="form-control" name="end_cidade_{{$endereco['id_clientes_endereco']}}" id="cidade_100{{$key}}" value="{{$endereco['cidade']}}" placeholder="Ex: São Paulo" readonly="true">
										</div>
										<div class="form-group col-md-1">
											<label>UF</label>
											<input type="text" class="form-control uf" name="end_uf_{{$endereco['id_clientes_endereco']}}" id="uf_100{{$key}}" value="{{$endereco['uf']}}" placeholder="Ex: SP" maxlength=2 readonly="true">
										</div>
									@else
										@if($key == 0)
											<div class="form-group col-md-6">
												<label>Cidade</label>
												<input type="text" class="form-control" name="end_cidade_{{$endereco['id_clientes_endereco']}}" id="cidade_100{{$key}}" value="{{$endereco['cidade']}}" placeholder="Ex: São Paulo" readonly="true">
											</div>
											<div class="form-group col-md-1">
												<label>UF</label>
												<input type="text" class="form-control uf" name="end_uf_{{$endereco['id_clientes_endereco']}}" id="uf_100{{$key}}" value="{{$endereco['uf']}}" placeholder="Ex: SP" maxlength=2 readonly="true">
											</div>
										@else
											<div class="form-group col-md-5">
												<label>Cidade</label>
												<input type="text" class="form-control" name="end_cidade_{{$endereco['id_clientes_endereco']}}" id="cidade_100{{$key}}" value="{{$endereco['cidade']}}" placeholder="Ex: São Paulo" readonly="true">
											</div>
											<div class="form-group col-md-1">
												<label>UF</label>
												<input type="text" class="form-control uf" name="end_uf_{{$endereco['id_clientes_endereco']}}" id="uf_100{{$key}}" value="{{$endereco['uf']}}" placeholder="Ex: SP" maxlength=2 readonly="true">
											</div>
											
											<div class="form-group col-md-1">
												<label>&nbsp;</label>
												<button type="button" class="form-control btn btn-sm btn-danger btn-request rounded-pill" onclick="ExcluiEndereco({{$endereco['id_clientes_endereco']}})" style="float:right">Excluir</button>
											</div>
										@endif
									@endif
								</div>
								<div class="row">
									<div class="form-group col-md-5">
										<label>Endereço</label>
										<input type="text" class="form-control" name="end_endereco_{{$endereco['id_clientes_endereco']}}" id="endereco_100{{$key}}" value="{{$endereco['endereco']}}" placeholder="Ex: Avenida Paulista" {{$disabled}}>
									</div>
									<div class="form-group col-md-1">
										<label>Número</label>
										<input type="text" class="form-control" name="end_numero_{{$endereco['id_clientes_endereco']}}" id="numero" value="{{$endereco['numero']}}" placeholder="Ex: 999" {{$disabled}}>
									</div>
									<div class="form-group col-md-3">
										<label>Bairro</label>
										<input type="text" class="form-control" name="end_bairro_{{$endereco['id_clientes_endereco']}}" id="bairro_100{{$key}}" value="{{$endereco['bairro']}}" placeholder="Ex: Centro" {{$disabled}}>
									</div>
									<div class="form-group col-md-3">
										<label>Complemento</label>
										<input type="text" class="form-control" name="end_complemento_{{$endereco['id_clientes_endereco']}}" id="complemento_100{{$key}}" value="{{$endereco['complemento']}}" placeholder="Ex: Sala 01" {{$disabled}}>
									</div>
									
								</div>
								
							@endforeach
						@endisset	
					
						
						
						
						
						@if($tela == 'clientesAdd')
							<div id="novo_endereco">
								<div class="row">
									<div class="form-group col-md-1">
										<label>Tipo</label>
										<select name="end_tipo[]" id="end_tipo" class="form-control" {{$disabled}}>
											<option value=""> Selecione</option>
											<option value="Escritório">Escritório</option>
											<option value="CD">CD</option>
											<option value="Entrega">Entrega</option>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label>Identificação</label>
										<input type="text" class="form-control" name="end_identificacao[]" id="identificacao" value="" placeholder="Ex: Escritório" {{$disabled}}>
									</div>
									<div class="form-group col-md-2">
										<label>CEP</label>
										<input type="text" class="form-control cep" name="end_cep[]" id="cep" value="" placeholder="Ex: 99999-999" onchange="buscaCidade(this.value, '0')" {{$disabled}}>
									</div>
									
									<div class="form-group col-md-6">
										<label>Cidade</label>
										<input type="text" class="form-control" name="end_cidade[]" id="cidade_0" value="" placeholder="Ex: São Paulo" readonly="true">
									</div>
									<div class="form-group col-md-1">
										<label>UF</label>
										<input type="text" class="form-control" name="end_uf[]" id="uf_0" value="" placeholder="Ex: SP" maxlength=2 readonly="true">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-5">
										<label>Endereço</label>
										<input type="text" class="form-control" name="end_endereco[]" id="endereco_0" value="" placeholder="Ex: Avenida Paulista" {{$disabled}}>
									</div>
									<div class="form-group col-md-1">
										<label>Número</label>
										<input type="text" class="form-control" name="end_numero[]" id="numero" value="" placeholder="Ex: 999" {{$disabled}}>
									</div>
									<div class="form-group col-md-3">
										<label>Bairro</label>
										<input type="text" class="form-control" name="end_bairro[]" id="bairro_0" value="" placeholder="Ex: Centro" {{$disabled}}>
									</div>
									<div class="form-group col-md-3">
										<label>Complemento</label>
										<input type="text" class="form-control" name="end_complemento[]" id="complemento_0" value="" placeholder="Ex: Sala 01" {{$disabled}}>
									</div>
									
								</div>
							</div>
						@endif
					
					</div>
			
			
			
			
			
			
			
			

					<div class="panel-body">
						@if($tela != 'clientesView')
							<div class="row">
								<div class="form-group col-md-12">
									<center><button type="button" class="btn btn-sm btn-light btn-request rounded-pill adicionarEndereco">+ Adicionar Endereço</button></center>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="form-group col-md-12">
									<button type="submit" class="btn btn-lg btn-primary btn-request" {{$disabled}}>Salvar</button>
								</div>
							</div>
						@endif
					</div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop
