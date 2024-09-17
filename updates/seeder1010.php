<?php namespace Soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Negocio;

class Seeder1010 extends Seeder
{
    public function run()
    {
        $mplus = Negocio::find(1);
        
        //---- Servicios de Proveedor
        $n = $mplus->proveedores()->create(['nombre'=>'Taxi Turismo', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Traslado aeropuerto-hotel', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 3, 'costo' => 5]);
        $n->servicios()->create(['nombre'=>'Traslado hotel-aeropuerto', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 3, 'costo' => 5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Xima Hoteles', 'tipo_id' => 8, 'categoria' => '4 Estrellas']);
        $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 70]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Golden Wayki', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Valle Sagrado C/Tunupa', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 22.5]);
        $n->servicios()->create(['nombre'=>'Maras y Moray', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 6, 'costo' => 128]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'COSITUC', 'tipo_id' => 7, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'BTC Parcial', 'tipo' => 'Entradas', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 18.5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'San Agustin Urubamba', 'tipo_id' => 7, 'categoria' => '4 Estrellas']);
        $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 50]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Transporte Urubamba', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Traslado urubamba-estacion', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 4, 'costo' => 13.5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Peru Rail', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Tren Expeditions', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 55]);
        $n->servicios()->create(['nombre'=>'Tren Vistadome', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 76]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'CONSETUR', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Bus de Subida/Bajada', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 24]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'INC', 'tipo_id' => 7, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Entrada Machupicchu', 'tipo' => 'Entradas', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 42]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Guia Mapi', 'tipo_id' => 5, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Guiado Machupicchu', 'tipo' => 'Guiado', 'lugar_id' => 15, 'capacidad' => 10, 'costo' => 45]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Qoya Palace', 'tipo_id' => 8, 'categoria' => '3 Estrellas']);
        $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 50]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Rhupay', 'tipo_id' => 6, 'categoria' => 'No categorizando']);
        $n->servicios()->create(['nombre'=>'Almuerzo Buffet', 'tipo' => 'Alimentacion', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 6.5]);
                
        $n = $mplus->proveedores()->create(['nombre'=>'Andean Grill', 'tipo_id' => 6, 'categoria' => 'No categorizando']);
        $n->servicios()->create(['nombre'=>'Almuerzo Buffet', 'tipo' => 'Alimentacion', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 16]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Cusco 180', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Tour Escenico', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 18.5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Arnold Expeditions', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Laguna Humantay', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 21.5]);
        $n->servicios()->create(['nombre'=>'Montaña de Colores', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 21.5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Koricancha', 'tipo_id' => 7, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'Entrada Koricancha', 'tipo' => 'Entradas', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 2.5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Tour y turismo', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $n->servicios()->create(['nombre'=>'City Tour Cusco', 'tipo' => 'Entradas', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 5.5]);
        
        //---- Tours
        $n = $mplus->servicios()->create(['nombre'=>'Llegada a Cusco', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 1, 'incluido' => 1, 'incluye' => [['nombre'=>'Traslado del aeropuerto al hotel','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Valle Sagrado', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 4, 'incluido' => 1, 'incluye' => [['nombre'=>'Transporte Turistico','dia'=>0],['nombre'=>'Guia profesional','dia'=>0],['nombre'=>'Almuerzo Buffet','dia'=>0]]],
                ['servicio' => 6, 'incluido' => 1, 'incluye' => [['nombre'=>'Tickets de entrada','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Tren expeditions y Machupicchu', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 8, 'incluido' => 1, 'incluye' => [['nombre'=>'Traslado del hotel a estacion','dia'=>0]]],
                ['servicio' => 9, 'incluido' => 1, 'incluye' => [['nombre'=>'Tren turistico a Machupicchu','dia'=>0]]],
                ['servicio' => 11, 'incluido' => 1, 'incluye' => [['nombre'=>'Bus de subida y bajada a Machupicchu','dia'=>0]]],
                ['servicio' => 12, 'incluido' => 1, 'incluye' => [['nombre'=>'Entrada a Machupicchu','dia'=>0]]],
                ['servicio' => 13, 'incluido' => 1, 'incluye' => [['nombre'=>'Guia profesional','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Tren Vistadome, Maras y Moray ', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 10, 'incluido' => 1, 'incluye' => [['nombre'=>'Tren Vistadome','dia'=>0]]],
                ['servicio' => 5, 'incluido' => 1, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0],['nombre'=>'Guia profesional','dia'=>0]]],
                ['servicio' => 15, 'incluido' => 1, 'incluye' => [['nombre'=>'Almuerzo Buffet','dia'=>0]]],
                ['servicio' => 6, 'incluido' => 1, 'incluye' => [['nombre'=>'Tickets de Entrada','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Almuerzo peruano y tour escenico', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 16, 'incluido' => 1, 'incluye' => [['nombre'=>'Almuerzo 3 tiempos','dia'=>0]]],
                ['servicio' => 17, 'incluido' => 1, 'incluye' => [['nombre'=>'Transporte 180','dia'=>0],['nombre'=>'Guia profesional','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Montaña de Colores', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 19, 'incluido' => 1, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0],['nombre'=>'Guia profesional','dia'=>0],['nombre'=>'Almuerzo buffet','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Laguna Humantay', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 18, 'incluido' => 1, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0],['nombre'=>'Guia profesional','dia'=>0],['nombre'=>'Almuerzo buffet','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Despedida de Cusco', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 2, 'incluido' => 1, 'incluye' => [['nombre'=>'Traslado del hotel al aeropuerto','dia'=>0]]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'City Tour Cusco', 'tipo' => 'Tour', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 21, 'incluido' => 1, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0],['nombre'=>'Guia profesional','dia'=>0]]],
                ['servicio' => 6, 'incluido' => 1, 'incluye' => [['nombre'=>'Tickets de Entrada','dia'=>0]]],
                ['servicio' => 20, 'incluido' => 1, 'incluye' => [['nombre'=>'Entrada a Koricancha','dia'=>0]]]
        ]]);
        
        //---- Paquetes
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 7D (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15,
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'items' => [
                ['servicio' => 22, 'alojamiento' => 3],
                ['servicio' => 23, 'alojamiento' => 7],
                ['servicio' => 24, 'alojamiento' => 14],
                ['servicio' => 25, 'alojamiento' => 3],
                ['servicio' => 26, 'alojamiento' => 3],
                ['servicio' => 27, 'alojamiento' => 3],
                ['servicio' => 29]
        ]]);
    }
}