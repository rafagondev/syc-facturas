<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\EstadosFactura;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturasController extends Controller
{
    public function consultarClientes()
    {
        try {
            $clientes = Cliente::select('nume_doc', 'nombre')->get();
            return $clientes;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function consultarEstados()
    {
        try {
            $estados = EstadosFactura::select('codi_estado', 'descripcion')->get();
            return $estados;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function consultarFacturas()
    {
        try {
            $facturas  = Factura::select('fecha_fact', 'clientes.nombre', 'estados_factura.descripcion')
            ->selectRaw('SUM(valor_fact) as valor')
            ->join('clientes', 'factura.nume_doc', 'clientes.nume_doc')
            ->join('estados_factura', 'estados_factura.codi_estado', 'factura.codi_estado')
            ->groupBy('fecha_fact','clientes.nombre','estados_factura.descripcion')
            ->get();
            return $facturas;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function registrarFactura(Request $request)
    {
        try {
            $factura = new Factura();
            $factura->nume_doc = $request->cliente;
            $factura->codi_estado = $request->estado;
            $factura->valor_fact = $request->valor_factura;
            $factura->fecha_fact = $request->fecha_factura;
            $factura->save();
            return 'Se ha creado la factura exitosamente';
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
