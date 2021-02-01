<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
    use HasFactory;

    public function seleccionarDataTable() {
        return Cliente::select(
            'id', 
            'nombre',
            'ap',
            'am',
            'fecha_nacimiento',
            'genero',
            'foto_cliente'
        )->get();
    }//end seleccionarDataTable

    public function editar($id, $request, $nombre_foto) {
        $cliente = Cliente::find($id);
        
        $cliente->nombre = $request->nombre;
        $cliente->ap = $request->ap;
        $cliente->am = $request->am;
        $cliente->fecha_nacimiento = $request->fecha_nacimiento;
        $cliente->genero = $request->genero;
        $cliente->foto_cliente = $nombre_foto;
        
        if ($cliente->save()) {
            return '1';
        }//end if
        return '2';
    }//end editar

    public function where($id_cliente) {
        return cliente::find($id_cliente);
    }//end where

    public function agregar($request) {
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->ap = $request->ap;
        $cliente->am = $request->am;
        $cliente->fecha_nacimiento = $request->fecha_nacimiento;
        $cliente->genero = $request->genero;
        $cliente->foto_cliente = $request->foto_cliente;

        if ($cliente->save()) {
            return '1';
        }//end if
        return '2';
    }//end agregar

    public function eliminar($id_cliente) {
        $cliente = Cliente::find($id_cliente);
        if($cliente->delete()) {
            return '1';
        }//end if
        else {
            return '2';
        }//end else
    }//end eliminar

}//end class Clietne
