<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
    <head>
        <style>
            .error{
                color: red;
            }
        </style>
        <link href="<?php echo base_url('lib/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo base_url('lib/css/datatables.min.css') ?>" rel="stylesheet">

        <script src="<?php echo base_url('lib/js/jquery-3.2.1.min.js') ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('lib/js/datatables.min.js') ?>"></script>
        <script src="<?php echo base_url('lib/js/bootstrap.min.js') ?>"></script>
        <script src="<?php echo base_url('lib/js/jquery.validate.min.js') ?>"></script>
        <meta charset="utf-8">
        <title>DuoSystem</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>Filtros</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Por status</label>
                    <select class="form-control" id="filterStatus">
                        <option value="">Todos</option>
                        <option value="1">Pendente</option>
                        <option value="2">Em Desenvolvimento</option>
                        <option value="3">Em Teste</option>
                        <option value="4">Concluído</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Pela situação</label>
                    <select class="form-control" id="filterSituation">
                        <option value="">Todas</option>
                        <option value="0">Inativo</option>
                        <option value="1">Ativo</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm" id="activityTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Data de Início</th>
                                <th scope="col">Data de Fim</th>
                                <th scope="col">Status</th>
                                <th scope="col">Situação</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalActivity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="activityForm">
                                <input type="hidden" id="idActivity" name="id">
                                <div class="container">
                                    <div class="row">
                                        <label>Nome</label>
                                        <textarea class="form-control" name="name" id="name" maxlength="255"></textarea>
                                    </div>
                                    <div class="row">
                                        <label>Descrição</label>
                                        <textarea class="form-control" name="description" id="description" maxlength="600"></textarea>
                                    </div>
                                    <div class="row">
                                        <label>Data de início</label>
                                        <input class="form-control" name="s_date" id="s_date" type="date">
                                    </div>
                                    <div class="row">
                                        <label>Data de fim</label>
                                        <input class="form-control" id="e_date" name="e_date" type="date">
                                    </div>
                                    <div class="row">
                                        <label>Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="1">Pendente</option>
                                            <option value="2">Em Desenvolvimento</option>
                                            <option value="3">Em Teste</option>
                                            <option value="4">Concluído</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <label>Situação</label>
                                        <select class="form-control" name="situation" id="situation">
                                            <option value="0">Inativo</option>
                                            <option value="1">Ativo</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Fechar</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" onclick="__addActivity()" id="saveActivity" class="btn btn-primary btn-block">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        var activityTable = $('#activityTable').DataTable({// Inicializa a Datatable
            dom: "<'col-xs-12 col-sm-6 col-md-6 col-lg-6 hidden-print'><'col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right hidden-print'><'pull-right new-activity'>t<'row'<'col-md-5 hidden-print'i><'col-md-7 hidden-print'p>>",
            ajax: "index/loadActivity",
            deferRender: true,
            order: [[1, "desc"]],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                // Bold the grade for all 'A' grade browsers
                console.log(nRow);
                if(aData.status == 4)
                {
                    $(nRow).attr('style', 'background-color: green;');
                }
            },
            columnDefs: [
                {
                    "targets": [0],
                    "visible": false
                },
                {
                    "targets": 3,
                    "class": "vertical_align_middle",
                    "render": function (data, type, full) {
                        var res = data.split("-");
                        return res[2] + '/' + res[1] + '/' + res[0];
                    }
                },
                {
                    "targets": 4,
                    "class": "vertical_align_middle",
                    "render": function (data, type, full) {
                        if(data !== null)
                        {
                            var res = data.split("-");
                            return res[2] + '/' + res[1] + '/' + res[0];
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "targets": 5,
                    "class": "vertical_align_middle",
                    "render": function (data, type, full) {
                        if(data == 1)
                        {
                            return 'Pendente';
                        } else if(data == 2)
                        {
                            return 'Em desenvolvimento';
                        } else if(data == 3)
                        {
                            return 'Em teste';
                        } else {
                            return 'Concluído';
                        }
                    }
                },
                {
                    "targets": 6,
                    "class": "vertical_align_middle",
                    "render": function (data, type, full) {
                        if(data == 0)
                        {
                            return 'Inativo';
                        } else {
                            return 'Ativo';
                        }
                    }
                },
                {
                    "targets": 7,
                    "class": "vertical_align_middle",
                    'orderable': false,
                    "render": function (data, type, full) {
                        if(full.status == 4)
                        {
                            return '<button class="btn btn-danger btn-sm" disabled data-func="edit" data-id="'+data+'" data-title="Editar atividade" data-toggle="modal" data-target="#modalActivity">Editar</button>';
                        } else {
                            return '<button class="btn btn-danger btn-sm" data-func="edit" data-id="'+data+'" data-title="Editar atividade" data-toggle="modal" data-target="#modalActivity">Editar</button>';
                        }
                    }
                }
            ],
            columns: [
                {"data": "id"},
                {"data": "name"},
                {"data": "description"},
                {"data": "start_date"},
                {"data": "end_date"},
                {"data": "status"},
                {"data": "situation"},
                {"data": "id"}
            ]
        });

        $("div.new-activity").html('<button type="button" class="btn btn-primary" data-toggle="modal" data-func="add" data-target="#modalActivity" data-title="Nova atividade">Nova atividade</button>');
        
        $.validator.addMethod("e_date", function(value, elem, param) {
            if($('#status').val() == 4){
                if($('#e_date').val() === '')
                {
                    return false;
                } else {
                    return true;
                }
            }else {
                return true;
            }
        },"Este campo é requerido.");
        
        $.validator.addMethod("t_name", function(value, elem, param) {
            if($('#name').val() === '')
            {
                return false;
            } else {
                return true;
            }
        },"Este campo é requerido.");
        
        $.validator.addMethod("t_desc", function(value, elem, param) {
            if($('#description').val() === '')
            {
                return false;
            } else {
                return true;
            }
        },"Este campo é requerido.");
        
        jQuery.extend(jQuery.validator.messages, {
            required: "Este campo &eacute; requerido.",
            remote: "Por favor, corrija este campo.",
            email: "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
            url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
            date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
            dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
            number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
            digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
            creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
            equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
            accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
            maxlength: jQuery.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
            minlength: jQuery.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
            rangelength: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
            range: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
            max: jQuery.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
            min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
        });
        
        $('form#activityForm').validate({
            ignore: [],
            lang : 'pt',
            rules: {
                name: {
                    t_name: true
                },
                description: {
                    t_desc: true
                },
                s_date: {
                    required: true
                },
                e_date: {
                    e_date: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success');
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).closest('.form-group').addClass('has-success');
            },
            errorElement: 'label',
            errorClass: 'error',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
    
    function __addActivity()
    {
        if($('form#activityForm').valid()) {
            $.ajax({
                url: "index/addActivity",
                method: "POST",
                data: $("#activityForm").serialize(),
                success: function(data)
                {
                    $('#activityTable').DataTable().ajax.reload();
                    $('#modalActivity').modal('hide');
                }
            });
        }
    }
    
    function __editActivity()
    {
        if($('form#activityForm').valid()) {
            $.ajax({
                url: "index/editActivity",
                method: "POST",
                data: $("#activityForm").serialize(),
                success: function(data)
                {
                    $('#activityTable').DataTable().ajax.reload();
                    $('#modalActivity').modal('hide');
                }
            });
        }
    }
    
    $('#modalActivity').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var title = button.data('title');
        var func = button.data('func');
        $('#exampleModalLabel').html(title);
        
        if(func == 'add')
        {
            $('#saveActivity').attr('onclick', '__addActivity()');
        } else {
            var id = button.data('id');
            $('#saveActivity').attr('onclick', '__editActivity()');
            
            data = {'id': id};
            $.ajax({
                url: "index/getActivityById",
                method: "POST",
                data: data,
                success: function(data)
                {
                    var data_json = JSON.parse(data);
                    $("#idActivity").val(data_json.data.id);
                    $("#name").val(data_json.data.name);
                    $("#description").val(data_json.data.description);
                    $("#s_date").val(data_json.data.start_date);
                    $("#e_date").val(data_json.data.end_date);
                    $("#situation").val(data_json.data.situation);
                    $("#status").val(data_json.data.status);
                }
            });
        }
    });
    
    $('#modalActivity').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find("input,textarea").val('').end();
    });
    
    $('#filterStatus').change(function(){
        var id = $(this).val();
        $('#activityTable').DataTable().ajax.url('index/getActivityByStatus/' + id).load();
    });
    
    $('#filterSituation').change(function(){
        var id = $(this).val();
        $('#activityTable').DataTable().ajax.url('index/getActivityBySituation/' + id).load();
    });
</script>