<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Facturas SyC</title>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center mt-4">
        <div class="card" style="width: 22rem;">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="cliente">Cliente</label>
                        <Select class="form-control" id="cliente">
                            <option value="0">Seleccione un cliente...</option>
                        </Select>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <Select id="estado" class="form-control">
                            <option value="0">Seleccione un estado...</option>
                        </Select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="valor_facura">Valor</label>
                        <input type="number" class="form-control" placeholder="Valor de la factura" id="valor_factura">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="fecha_facura">Fecha Factura</label>
                        <input type="date" class="form-control" placeholder="Fecha de la factura" id="fecha_factura">
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary btn-block" id="registrar">Registrar Factura</button>
                    </div>
                </form>
                <span id="alert"></span>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>
                        Fecha factura
                    </th>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Valor Factura
                    </th>
                    <th>
                        Descripcion
                    </th>
                </tr>
            </thead>
            <tbody id="tbody-facturas">
            </tbody>
        </table>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function(){
            $("#registrar").click(registrarFactura);
            consultarClientes();
            consultarEstados();
            consultarFacturas();
        });
        const consultarClientes = function (){
            $.ajax({
                    url: "{{ route('consultar.clientes') }}",
                    type:'GET',
                    success: function(data) {
                        for(let cliente of data){
                            let option = $('<option/>');
                            option.val(cliente.nume_doc);
                            option.html(cliente.nombre);
                            $('#cliente').append(option);
                        }
                    }
            });
        }
        const consultarEstados = function (){
            $.ajax({
                    url: "{{ route('consultar.estados') }}",
                    type:'GET',
                    success: function(data) {
                        for(let estado of data){
                            let option = $('<option/>');
                            option.val(estado.codi_estado);
                            option.html(estado.descripcion);
                            $('#estado').append(option);
                        }
                    }
            });
        }
        const registrarFactura= function(){
            let _token = $("input[name='_token']").val();
            let cliente = parseInt($('#cliente').val());
            let estado = parseInt($('#estado').val());
            let valor_factura = $('#valor_factura').val();
            let fecha_factura = $('#fecha_factura').val();
            let errores = [];
            if(!cliente){
                errores.push("El cliente es obligatorio")
            }
            if(!estado){
                errores.push("El estado es obligatorio")
            }
            if(!valor_factura){
                errores.push("El valor de la factura es obligatorio")
            }
            if(!fecha_factura){
                errores.push("La fecha de la factura es obligatoria")
            }
            if(errores.length){
                $("#alert").html(
                    `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Se detectaron los siguientes errores:</strong><br />
                        ${errores.join('<br>- ')}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    `
                );
                return;
            }
            $.ajax({
                    url: "{{ route('registrar.factura') }}",
                    type:'POST',
                    data:{_token, cliente, estado, valor_factura, fecha_factura},
                    success: function(data) {
                        $('#cliente').val("");
                        $('#estado').val("");
                        $('#valor_factura').val("");
                        $('#fecha_factura').val("");
                        consultarFacturas();
                    }
            });
        }
        const consultarFacturas = function(){
            $("#tbody-facturas").empty();
            $.ajax({
                    url: "{{ route('consultar.facturas') }}",
                    type:'GET',
                    success: function(data) {
                        for(let factura of data){
                            let tr = $("<tr/>");
                            tr.append(
                                `<td>${factura.fecha_fact}</td>
                                <td>${factura.nombre}</td>
                                <td>${factura.valor}</td>
                                <td>${factura.descripcion}</td>
                                `
                            );
                            $("#tbody-facturas").append(tr);
                        }
                    }
            });
        }
    </script>
</body>
</html>