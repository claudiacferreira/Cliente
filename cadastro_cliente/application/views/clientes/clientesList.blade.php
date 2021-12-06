@extends('base.geral')
@section('conteudo')
<section>
	<!-- Page content-->
    <div class="content-wrapper">
        <div class="content-heading">
            Clientes
            <small>Lista de Clientes</small>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Listagem |
                            <small>Cliente</small>
                            <?php if (can('CLI03')) { ?>
                                <div class="col-md-12 text-right">
                                    <a href="<?php echo base_url('clientesAdd'); ?>" class="btn btn-primary">
                                        Cadastrar
                                    </a>
                                </div>
                            <?php } ?>
                        </div><br>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="clientesList" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
											<th>ID</th>
                                            <th>Razão Social</th>
                                            <th>Nome Comercial</th>
                                            <th>CNPJ</th>
                                            <th>Data Cadastro</th>
											<th>Opções</th>
                                        </tr>
									</thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
