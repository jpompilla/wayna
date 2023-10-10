<?php namespace soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Tipo;

class Seeder1011 extends Seeder
{
    public function run()
    {
        Tipo::create(['nombre' => 'Jose - BCP - Dolares', 'tipo' => 'Cuenta Bancaria']);
        Tipo::create(['nombre' => 'Jose - Interbank - Dolares', 'tipo' => 'Cuenta Bancaria']);
        Tipo::create(['nombre' => 'Jose - Efectivo - Dolares', 'tipo' => 'Cuenta Bancaria']);
        
        Tipo::create(['nombre' => 'Embajador - Inscripcion', 'tipo' => 'Pago']);
        Tipo::create(['nombre' => 'Embajador - Publicidad', 'tipo' => 'Pago']);
        Tipo::create(['nombre' => 'Embajador - Egreso Publicidad', 'tipo' => 'Pago']);
        Tipo::create(['nombre' => 'Plataforma - Egreso General', 'tipo' => 'Pago']);
        Tipo::create(['nombre' => 'Plataforma - Ingreso', 'tipo' => 'Pago']);
        
        Tipo::create(['nombre' => 'Caja', 'tipo' => 'Centro de Costo']);
        Tipo::create(['nombre' => 'Publicidad', 'tipo' => 'Centro de Costo']);
        Tipo::create(['nombre' => 'Comisiones', 'tipo' => 'Centro de Costo']);
        Tipo::create(['nombre' => 'Cuentas', 'tipo' => 'Centro de Costo']);
        Tipo::create(['nombre' => 'Operaciones', 'tipo' => 'Centro de Costo']);
        
        Tipo::create(['nombre' => 'Agencia de Turismo', 'tipo' => 'Proveedor']);
        Tipo::create(['nombre' => 'Transporte', 'tipo' => 'Proveedor']);
        Tipo::create(['nombre' => 'Guia de Turismo', 'tipo' => 'Proveedor']);
        Tipo::create(['nombre' => 'Restaurante', 'tipo' => 'Proveedor']);
        Tipo::create(['nombre' => 'Entradas', 'tipo' => 'Proveedor']);
        Tipo::create(['nombre' => 'Hospedaje', 'tipo' => 'Proveedor']);
        
        Tipo::create(['nombre' => 'Paquete Turistico', 'tipo' => 'Servicio']);
        Tipo::create(['nombre' => 'Actividad (Tour)', 'tipo' => 'Servicio']);
        Tipo::create(['nombre' => 'Servicio de Proveedor', 'tipo' => 'Servicio']);
        
        Tipo::create(['nombre' => 'Cusco', 'tipo' => 'Lugar']);
        Tipo::create(['nombre' => 'Aguas Calientes', 'tipo' => 'Lugar']);
        Tipo::create(['nombre' => 'Soraypampa', 'tipo' => 'Lugar']);
        
        Tipo::create(['nombre' => 'Estandar', 'tipo' => 'Categoria']);
        Tipo::create(['nombre' => '2 Estrellas', 'tipo' => 'Categoria']);
        Tipo::create(['nombre' => '3 Estrellas', 'tipo' => 'Categoria']);
        Tipo::create(['nombre' => '4 Estrellas', 'tipo' => 'Categoria']);
        Tipo::create(['nombre' => '5 Estrellas', 'tipo' => 'Categoria']);
        
        Tipo::create(['nombre' => 'Pendiente', 'tipo' => 'Estado Reserva']);
        Tipo::create(['nombre' => 'En Proceso', 'tipo' => 'Estado Reserva']);
        Tipo::create(['nombre' => 'Completado', 'tipo' => 'Estado Reserva']);
        
        Tipo::create(['nombre' => 'Pasaporte', 'tipo' => 'Tipo de Documento']);
        Tipo::create(['nombre' => 'DNI', 'tipo' => 'Tipo de Documento']);
        Tipo::create(['nombre' => 'Cedula', 'tipo' => 'Tipo de Documento']);
        
        Tipo::create(['nombre' => 'Recibo Ingreso', 'tipo' => 'Comprobante de Pago']);
        Tipo::create(['nombre' => 'Recibo Egreso', 'tipo' => 'Comprobante de Pago']);
        Tipo::create(['nombre' => 'Factura de Compra', 'tipo' => 'Comprobante de Pago']);
        Tipo::create(['nombre' => 'Boleta de Compra', 'tipo' => 'Comprobante de Pago']);
        Tipo::create(['nombre' => 'Recibo por Honorarios', 'tipo' => 'Comprobante de Pago']);
        Tipo::create(['nombre' => 'Factura de Venta', 'tipo' => 'Comprobante de Pago']);
        Tipo::create(['nombre' => 'Boleta de Venta', 'tipo' => 'Comprobante de Pago']);
        
        Tipo::create(['nombre' => 'Pendiente', 'tipo' => 'Estado de Pago']);
        Tipo::create(['nombre' => 'En proceso', 'tipo' => 'Estado de Pago']);
        Tipo::create(['nombre' => 'Pagado', 'tipo' => 'Estado de Pago']);
        Tipo::create(['nombre' => 'Contabilizado', 'tipo' => 'Estado de Pago']);
    }
}