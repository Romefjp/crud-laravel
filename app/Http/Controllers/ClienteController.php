<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller {

    public function index()  {
        return view('panel.clientes');
    }//end index

    public function dataTable() {
        $clientes = new Cliente();
        return '{"data": '.json_encode($this->construirDatosDataTable($clientes)).'}';
    }//end dataTable

    private function construirDatosDataTable($clientes) {
        $resultado = [];
        $total = 0;
        foreach ($clientes->seleccionarDataTable() as $valor) {
            $resultado[] = [
                'total' => ++$total,
                'foto' => '<img src="'.( $valor->foto_cliente == NULL ? asset('assets/dist/img/sinimagen.jpg') : asset('foto_clientes/'.$valor->foto_cliente) ).'" width="75px">',
                'nombre' => $valor->nombre.' '.$valor->ap.' '.$valor->am,
                'fecha_nacimiento' => date("d/m/Y", strtotime($valor->fecha_nacimiento,)),
                'genero' => ($valor->genero == 'M' ? 'Masculino' : 'Femenino' ),
                'editar' => '<button class="btn btn-warning text-white" data-target="#editar" data-toggle="modal" onclick="cargar_datos_modal_cliente('.$valor->id.')"><i class="fa fa-edit"></i> Editar</button>',
                'eliminar' => '<button class="btn btn-danger text-white eliminar" id="'.$valor->id.'"><i class="fa fa-trash"></i> Eliminar</button>',
            ];
        }//end foreach $clientes
        return $resultado;
    }//end construirDatosDataTable

    public function agregar(Request $request) {
        $cliente = new Cliente();

        $imagen = $request->file('foto_cliente');
        $nombre = rand().'.'.$imagen->getClientOriginalExtension();
        $imagen->move(public_path('foto_clientes'), $nombre);
        $request->foto_cliente = $nombre;

        return $cliente->agregar($request);
    }//end agregar

    public function eliminar($id) {
        $cliente = new Cliente();
        return $cliente->eliminar($id);
    }//end eliminar

    public function obtener_datos($id_cliente) {
        $model = new cliente();
        $cliente = $model->where($id_cliente);

        $resultado = [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
            'ap' => $cliente->ap,
            'am' => $cliente->am,
            'fecha_nacimiento' => $cliente->fecha_nacimiento,
            'genero' => $cliente->genero,
            'src_cliente' => ( $cliente->foto_cliente == NULL ? asset('assets/dist/img/sinimagen.jpg') : asset('assets/foto_clientes/'.$cliente->foto_cliente) ),
            'imagen_anterior' => $cliente->foto_cliente
        ];
        return json_encode($resultado);
    }//end obtener_datos

    public function editar(Request $request) {
        $cliente = new Cliente();
        $imagen = $request->file('foto_cliente');
        $nombre = rand().'.'.$imagen->getClientOriginalExtension();
        $imagen->move(public_path('foto_clientes'), $nombre);

        if($request->imagen_anterior != NULL && file_exists(public_path('foto_clientes/'.$request->imagen_anterior))) {
            unlink(public_path('foto_clientes/'.$request->imagen_anterior));
        }//end of if}
        
        if ($cliente->editar($request->id, $request, $nombre)) {
            return '1';
        }//end if
        return '2';
    }//end editar

}//end class ClienteController
