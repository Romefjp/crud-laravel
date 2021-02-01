@extends('layouts.base')

@section('titleModule', 'Clientes')
@section('mainTask', 'Clientes')

@section('header_content')
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <button type="button" class="btn btn-primary" data-target="#nuevo" data-toggle="modal"><i class="fa fa-plus"></i> Agregar cliente</button>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table table-responsive">
              <table id="clientes" class="table table-bordered table-striped">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Foto</th>
                          <th>Nombre Completo</th>
                          <th>Fecha de Nacimiento</th>
                          <th>Genero</th>
                          <th>Editar</th>
                          <th>Eliminar</th>
                      </tr>
                  </thead>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->

  {{-- modal nuevo --}}
  <div class="modal fade" id="nuevo">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Nuevo Cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span>Todos los campos marcados con (<small class="text-danger">*</small>) son obligatorios</span>
          <hr>
          <form id="form-nuevo-cliente" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
              <center>
                  <div>
                    <img src="{{asset('assets/dist/img/sinimagen.jpg')}}" width="35%" id="vista_previa" class="img-circle">
                  </div>
              </center>
            </div>
            <hr>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Nombre(s):</label> <small class="text-danger">*</small>
                <input type="text" name="nombre" class="form-control" required placeholder="Nombre(s)">
              </div>
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Apellido Paterno:</label> <small class="text-danger">*</small>
                <input type="text" name="ap" class="form-control" required placeholder="Apellido paterno">
              </div>
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Apellido materno:</label> <small class="text-danger">*</small>
                <input type="text" name="am" class="form-control" required placeholder="Apellido materno">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-3">
                <label for="nombre_equipo">Fecha de nacimiento:</label> <small class="text-danger">*</small>
                <input type="date" name="fecha_nacimiento" class="form-control" required>
              </div>
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Genero:</label> <small class="text-danger">*</small>
                <select name="genero" required class="form-control">
                  <option value="">Seleccionar Genero</option>
                  <option value="F">Femenino</option>
                  <option value="M">Masculino</option>
                </select>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-12 form-group">
                <label for="">Fotografía</label> (opcional)
                <input type="file" class="form-control" name="foto_cliente" accept=".jpg, .png, .jpeg" onchange="validate_image(this, 'vista_previa', 'btn-enviar', './assets/dist/img/sinimagen.jpg', 1290, 1280);">
                <span>Tamaño máximo de <strong class="text-danger">1280x1280</strong> menor a <strong class="text-danger">1MB</strong>. Formatos permitidos ( .jpg, .png, .jpeg )</span>
              </div>
            </div>
            
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-cancelar"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn-enviar"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  {{-- modal nuevo --}}
  <div class="modal fade" id="editar">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detalles del Cliente</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span>Todos los campos marcados con (<small class="text-danger">*</small>) son obligatorios</span>
          <hr>
          <form id="form-editar-cliente" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row" style="display: flex; justify-content: center; align-items: center;">
              <center>
                  <div>
                    <img src="" width="35%" id="vista_previa2" class="img-circle">
                  </div>
              </center>
            </div>
            <hr>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Nombre(s):</label> <small class="text-danger">*</small>
                <input type="text" name="nombre" class="form-control" required placeholder="Nombre(s)" id="nombre">
              </div>
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Apellido Paterno:</label> <small class="text-danger">*</small>
                <input type="text" name="ap" class="form-control" required placeholder="Apellido paterno" id="ap">
              </div>
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Apellido materno:</label> <small class="text-danger">*</small>
                <input type="text" name="am" class="form-control" required placeholder="Apellido materno" id="am">
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-3">
                <label for="nombre_equipo">Fecha de nacimiento:</label> <small class="text-danger">*</small>
                <input type="date" name="fecha_nacimiento" class="form-control" required id="fecha_nacimiento">
              </div>
              <div class="form-group col-sm-4">
                <label for="nombre_equipo">Genero:</label> <small class="text-danger">*</small>
                <select name="genero" required class="form-control" id="genero">
                  <option value="">Seleccionar Genero</option>
                  <option value="F">Femenino</option>
                  <option value="M">Masculino</option>
                </select>
              </div>
            </div>
            
            <div class="row">
              <div class="col-sm-12 form-group">
                <label for="">Fotografía</label> (opcional)
                <input type="file" class="form-control" name="foto_cliente" accept=".jpg, .png, .jpeg" onchange="validate_image(this, 'vista_previa2', 'btn-enviar2', './assets/dist/img/sinimagen.jpg', 1290, 1280);">
                <span>Tamaño máximo de <strong class="text-danger">1280x1280</strong> menor a <strong class="text-danger">1MB</strong>. Formatos permitidos ( .jpg, .png, .jpeg )</span>
              </div>
            </div>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="imagen_anterior" id="imagen_anterior">
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-cancelar2"><i class="fa fa-close"></i> Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btn-enviar2"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

@endsection


@section('scripts_complement')
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/new-js/clientes.js')}}"></script>
@endsection