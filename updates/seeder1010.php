<?php namespace Soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Negocio;

class Seeder1010 extends Seeder
{
    public function run()
    {
        $mplus = Negocio::find(1);
        
        //---- Servicios de Proveedor
        $tt = $mplus->proveedores()->create(['nombre'=>'Taxi Turismo', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
        $tt->servicios()->create(['nombre'=>'Traslado aeropuerto-hotel', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 3, 'costo' => 5]);
        $tt->servicios()->create(['nombre'=>'Traslado hotel-aeropuerto', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 3, 'costo' => 5]);
        
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
        $n = $mplus->servicios()->create(['nombre'=>'Llegada a Cusco', 'tipo' => 'Tour', 'lugar_id' => 15, 'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Desayuno','dia'=>0,'tipo'=>'Desayuno'],
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Early check-in en el hotel en Cusco','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 1, 'incluye' => [['nombre'=>'Traslado del aeropuerto al hotel','dia'=>0, 'tipo'=>'Traslado']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Valle Sagrado', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 4, 'incluye' => [['nombre'=>'Transporte Turistico','dia'=>0, 'tipo'=>'Transporte'],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia'],['nombre'=>'Almuerzo Buffet','dia'=>0,'tipo'=>'Almuerzo']]],
                ['servicio' => 6, 'incluye' => [['nombre'=>'Tickets de entrada','dia'=>0,'tipo'=>'Entradas']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Tren expeditions y Machupicchu', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Early check-in en el hotel de Aguas Calientes','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 8, 'incluye' => [['nombre'=>'Traslado del hotel a estacion','dia'=>0,'tipo'=>'Traslado']]],
                ['servicio' => 9, 'incluye' => [['nombre'=>'Tren turistico a Machupicchu','dia'=>0,'tipo'=>'Tren']]],
                ['servicio' => 11, 'incluye' => [['nombre'=>'Bus de subida y bajada a Machupicchu','dia'=>0,'tipo'=>'Transporte']]],
                ['servicio' => 12, 'incluye' => [['nombre'=>'Entrada a Machupicchu','dia'=>0,'tipo'=>'Entradas']]],
                ['servicio' => 13, 'incluye' => [['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Tren Vistadome, Maras y Moray ', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 10, 'incluye' => [['nombre'=>'Tren Vistadome','dia'=>0,'tipo'=>'Tren']]],
                ['servicio' => 5, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Transporte']]],
                ['servicio' => 15, 'incluye' => [['nombre'=>'Almuerzo Buffet','dia'=>0,'tipo'=>'Almuerzo']]],
                ['servicio' => 6, 'incluye' => [['nombre'=>'Tickets de Entrada','dia'=>0,'tipo'=>'Entradas']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Almuerzo peruano y tour escenico', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 16, 'incluye' => [['nombre'=>'Almuerzo 3 tiempos','dia'=>0,'tipo'=>'Almuerzo']]],
                ['servicio' => 17, 'incluye' => [['nombre'=>'Transporte 180','dia'=>0,'tipo'=>'Transporte'],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Montaña de Colores', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'Caballos para el trayecto','dia'=>0,'tipo'=>'Traslado'],
                ['nombre'=>'Motos o cuatrimotos para el trayecto','dia'=>0,'tipo'=>'Traslado'],
                ['nombre'=>'Accesorios no indicados','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 19, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0,'tipo'=>'Transporte'],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia'],['nombre'=>'Almuerzo buffet','dia'=>0,'tipo'=>'Almuerzo']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Laguna Humantay', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'Caballos para el trayecto','dia'=>0,'tipo'=>'Traslado'],
                ['nombre'=>'Accesorios no indicados','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 18, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0,'tipo'=>'Transporte'],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia'],['nombre'=>'Almuerzo buffet','dia'=>0,'tipo'=>'Almuerzo']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Despedida de Cusco', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Late check-out en el hotel','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 2, 'incluye' => [['nombre'=>'Traslado del hotel al aeropuerto','dia'=>0,'tipo'=>'Traslado']]]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'City Tour Cusco', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 70, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 26.50, 'comision' => 10]
            ],
            'precios' => [
                [1=>70,2=>70,3=>70,4=>70,5=>70,6=>70,7=>70,8=>70,9=>70,10=>70]
            ],
            'no_incluye' => [
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'Fotos con llamas en las calles de Cusco','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 21, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0,'tipo'=>'Transporte'],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia']]],
                ['servicio' => 6, 'incluye' => [['nombre'=>'Tickets de Entrada','dia'=>0,'tipo'=>'Entradas']]],
                ['servicio' => 20, 'incluye' => [['nombre'=>'Entrada a Koricancha','dia'=>0,'tipo'=>'Entradas']]]
        ]]);
        
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 4* (Cusco)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 100, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 70, 'comision' => 10]
            ],
            'items' => [
                ['servicio' => 3, 'incluye' => [['nombre'=>'Hotel 4 Estrellas (Cusco)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Cusco)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 4* (Urubamba)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 100, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 50, 'comision' => 10]
            ],
            'items' => [
                ['servicio' => 7, 'incluye' => [['nombre'=>'Hotel 4 Estrellas (Urubamba)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Urubamba)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 3* (Aguas Calientes)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',
            'params' => [
                ['adelanto' => 100, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 50, 'comision' => 10]
            ],
            'items' => [
                ['servicio' => 14, 'incluye' => [['nombre'=>'Hotel 3 Estrellas (Aguas Calientes)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Aguas Calientes)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        
        //---- Paquetes: 34
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 7D Cusco (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 250, 'comision' => 140]
            ],
            'precios' => [
                [1=>1300,2=>1000,3=>975,4=>950,5=>950,6=>950,7=>950,8=>950,9=>950,10=>950]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],
                ['tour' => 27, 'hotel' => 31],
                ['tour' => 29]
        ]]);
        
        //----- Servicios
        $n = $mplus->proveedores()->create(['nombre'=>'Hotel Casona Plaza', 'tipo_id' => 8, 'categoria' => '3 Estrellas']);
            $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 55]);
            $n->servicios()->create(['nombre'=>'TWD', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 3, 'costo' => 70]);
        
        $tt->servicios()->create(['nombre'=>'Traslado hotel-terminal', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 3, 'costo' => 5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Turismo Mer', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
            $n->servicios()->create(['nombre'=>'Rutal del Sol', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 56]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Taxi Puno', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
            $n->servicios()->create(['nombre'=>'Traslado terminal-hotel', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 4, 'costo' => 5]);
            $n->servicios()->create(['nombre'=>'Traslado hotel-puerto', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 4, 'costo' => 5]);//40
            $n->servicios()->create(['nombre'=>'Traslado puerto-hotel', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 4, 'costo' => 5]);
            $n->servicios()->create(['nombre'=>'Traslado hotel-aeropuerto', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 4, 'costo' => 5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Hotel Jose Antonio Puno', 'tipo_id' => 8, 'categoria' => '4 Estrellas']);
            $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 60]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Hotel Hacienda Puno', 'tipo_id' => 8, 'categoria' => '3 Estrellas']);
            $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 60]);
            
        $n = $mplus->proveedores()->create(['nombre'=>'Puno Tours', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
            $n->servicios()->create(['nombre'=>'Lago fullday', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 21.5]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Taxi Lima', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
            $n->servicios()->create(['nombre'=>'Traslado aeropuerto-hotel', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 4, 'costo' => 20]);
            $n->servicios()->create(['nombre'=>'Traslado hotel-aeropuerto', 'tipo' => 'Traslado', 'lugar_id' => 15, 'capacidad' => 4, 'costo' => 20]);//47
        
        $n = $mplus->proveedores()->create(['nombre'=>'Hotel San Agustin Riviera', 'tipo_id' => 8, 'categoria' => '3 Estrellas']);
            $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 45]);
            
        $n = $mplus->proveedores()->create(['nombre'=>'Hotel San Agustin Exclusive', 'tipo_id' => 8, 'categoria' => '4 Estrellas']);
            $n->servicios()->create(['nombre'=>'DWB', 'tipo' => 'Alojamiento', 'lugar_id' => 15, 'capacidad' => 2, 'costo' => 70]);
        
        $n = $mplus->proveedores()->create(['nombre'=>'Yeraldine Tours', 'tipo_id' => 4, 'categoria' => 'No categorizado']);
            $n->servicios()->create(['nombre'=>'Ballestas, Paracas y Huacachina', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 110]);
            $n->servicios()->create(['nombre'=>'City Tour Lima', 'tipo' => 'Tour Endoce', 'lugar_id' => 15, 'capacidad' => 1, 'costo' => 38]);
        
        //----- Tours
        $n = $mplus->servicios()->create(['nombre'=>'Ruta del Sol', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado', //52
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 37, 'incluye' => [['nombre'=>'Traslado hotel-terminal','dia'=>0, 'tipo'=>'Traslado']]],
                ['servicio' => 38, 'incluye' => [['nombre'=>'Transporte Ruta del Sol','dia'=>0,'tipo'=>'Transporte'],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia']]],
                ['servicio' => 39, 'incluye' => [['nombre'=>'Traslado terminal-hotel','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Lago Titicaca', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado', //53
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 40, 'incluye' => [['nombre'=>'Traslado hotel-puerto','dia'=>0, 'tipo'=>'Traslado']]],
                ['servicio' => 45, 'incluye' => [['nombre'=>'Llancha para el tour','dia'=>0,'tipo'=>'Transporte'],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Guia']]],
                ['servicio' => 41, 'incluye' => [['nombre'=>'Traslado terminal-hotel','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Despedida de Puno y Llegada a Lima', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado', //54
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Late check-out en el hotel de Puno','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Early check-in en el hotel de Lima','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 42, 'incluye' => [['nombre'=>'Traslado hotel-aeropuerto (Juliaca)','dia'=>0, 'tipo'=>'Traslado']]],
                ['servicio' => 46, 'incluye' => [['nombre'=>'Traslado aeropuerto-hotel (Lima)','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Ballestas, Paracas y Huacachina', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado', //55
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Desayuno','dia'=>0,'tipo'=>'Desayuno'],
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 50, 'incluye' => [['nombre'=>'Fullday Ica','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'City Tour Lima', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado', //56
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 51, 'incluye' => [['nombre'=>'City tour lima','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Despedida de Lima', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado', //57
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 47, 'incluye' => [['nombre'=>'Traslado hotel-aeropuerto (Lima)','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 3* (Cusco)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',//58
            'params' => [
                ['adelanto' => 40, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 27.50, 'comision' => 0]
            ],
            'precios' => [
                [1=>40,2=>40,3=>40,4=>40,5=>40,6=>40,7=>40,8=>40,9=>40,10=>40]
            ],
            'items' => [
                ['servicio' => 35, 'incluye' => [['nombre'=>'Hotel 3 Estrellas (Cuscp)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Cusco)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 3* (Puno)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',//59
            'params' => [
                ['adelanto' => 100, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 50, 'comision' => 10]
            ],
            'items' => [
                ['servicio' => 44, 'incluye' => [['nombre'=>'Hotel 3 Estrellas (Puno)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Puno)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 3* (Lima)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',//60
            'params' => [
                ['adelanto' => 100, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 50, 'comision' => 10]
            ],
            'items' => [
                ['servicio' => 48, 'incluye' => [['nombre'=>'Hotel 3 Estrellas (Lima)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Lima)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 4* (Puno)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',//61
            'params' => [
                ['adelanto' => 100, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 50, 'comision' => 10]
            ],
            'items' => [
                ['servicio' => 43, 'incluye' => [['nombre'=>'Hotel 4 Estrellas (Puno)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Puno)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Hotel 4* (Lima)', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',//62
            'params' => [
                ['adelanto' => 100, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 50, 'comision' => 10]
            ],
            'items' => [
                ['servicio' => 49, 'incluye' => [['nombre'=>'Hotel 4 Estrellas (Lima)','dia'=>0,'tipo'=>'Alojamiento'],['nombre'=>'Desayuno en hotel (Lima)','dia'=>1,'tipo'=>'Desayuno']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Despedida de Cusco y Llegada a Lima', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado', //63
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Late check-out en el hotel de Cusco','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Early check-in en el hotel de Lima','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Almuerzo','dia'=>0,'tipo'=>'Almuerzo'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 2, 'incluye' => [['nombre'=>'Traslado hotel-aeropuerto (Cusco)','dia'=>0, 'tipo'=>'Traslado']]],
                ['servicio' => 46, 'incluye' => [['nombre'=>'Traslado aeropuerto-hotel (Lima)','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Tren Vistadome, Maras y Moray y Despedida ', 'tipo' => 'Tour', 'lugar_id' => 15,'estado'=> 'Privado',//64
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.18, 'ir' => 0.10, 'facturable' => 100, 'comision' => 150]
            ],
            'no_incluye' => [
                ['nombre'=>'Late check-out en el hotel de Cusco','dia'=>0,'tipo'=>'Alojamiento'],
                ['nombre'=>'Cena','dia'=>0,'tipo'=>'Cena'],
                ['nombre'=>'Propinas','dia'=>0,'tipo'=>'Propina'],
                ['nombre'=>'No indicados en el paquete','dia'=>0,'tipo'=>'Propina'],
            ],
            'items' => [
                ['servicio' => 10, 'incluye' => [['nombre'=>'Tren Vistadome','dia'=>0,'tipo'=>'Tren']]],
                ['servicio' => 5, 'incluye' => [['nombre'=>'Transporte turistico','dia'=>0],['nombre'=>'Guia profesional','dia'=>0,'tipo'=>'Transporte']]],
                ['servicio' => 15, 'incluye' => [['nombre'=>'Almuerzo Buffet','dia'=>0,'tipo'=>'Almuerzo']]],
                ['servicio' => 6, 'incluye' => [['nombre'=>'Tickets de Entrada','dia'=>0,'tipo'=>'Entradas']]],
                ['servicio' => 2, 'incluye' => [['nombre'=>'Traslado hotel-aeropuerto (Cusco)','dia'=>0, 'tipo'=>'Traslado']]],
        ]]);
        
        //---- Paquetes:
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 7D Cusco (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 200, 'comision' => 110]
            ],
            'precios' => [
                [1=>1200,2=>900,3=>875,4=>850,5=>850,6=>850,7=>850,8=>850,9=>850,10=>850]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],
                ['tour' => 27, 'hotel' => 58],
                ['tour' => 29]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 12D Cusco, Puno y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 170]
            ],
            'precios' => [
                [1=>2000,2=>1550,3=>1525,4=>1500,5=>1500,6=>1500,7=>1500,8=>1500,9=>1500,10=>1500]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],
                ['tour' => 27, 'hotel' => 58],
                
                ['tour' => 52, 'hotel' => 59],
                ['tour' => 53, 'hotel' => 59],                
                ['tour' => 54, 'hotel' => 60],
                
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 56, 'hotel' => 60],
                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 12D Cusco, Puno y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 200]
            ],
            'precios' => [
                [1=>2150,2=>1700,3=>1675,4=>1650,5=>1650,6=>1650,7=>1650,8=>1650,9=>1650,10=>1650]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],
                ['tour' => 27, 'hotel' => 31],
                
                ['tour' => 52, 'hotel' => 61],
                ['tour' => 53, 'hotel' => 61],                
                ['tour' => 54, 'hotel' => 62],
                
                ['tour' => 55, 'hotel' => 62],
                ['tour' => 56, 'hotel' => 62],
                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 11D Cusco, Puno y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 160]
            ],
            'precios' => [
                [1=>1900,2=>1450,3=>1425,4=>1400,5=>1400,6=>1400,7=>1400,8=>1400,9=>1400,10=>1400]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],
                
                ['tour' => 52, 'hotel' => 59],
                ['tour' => 53, 'hotel' => 59],                
                ['tour' => 54, 'hotel' => 60],
                
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 56, 'hotel' => 60],
                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 11D Cusco, Puno y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 190]
            ],
            'precios' => [
                [1=>2050,2=>1600,3=>1575,4=>1550,5=>1550,6=>1550,7=>1550,8=>1550,9=>1550,10=>1550]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],
                
                ['tour' => 52, 'hotel' => 61],
                ['tour' => 53, 'hotel' => 61],                
                ['tour' => 54, 'hotel' => 62],
                
                ['tour' => 55, 'hotel' => 62],
                ['tour' => 56, 'hotel' => 62],
                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 10D Cusco, Puno y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 400, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 150]
            ],
            'precios' => [
                [1=>1800,2=>1350,3=>1325,4=>1300,5=>1300,6=>1300,7=>1300,8=>1300,9=>1300,10=>1300]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                
                ['tour' => 52, 'hotel' => 59],
                ['tour' => 53, 'hotel' => 59],                
                ['tour' => 54, 'hotel' => 60],
                
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 56, 'hotel' => 60],
                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 10D Cusco, Puno y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 400, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 180]
            ],
            'precios' => [
                [1=>1950,2=>1500,3=>1475,4=>1450,5=>1450,6=>1450,7=>1450,8=>1450,9=>1450,10=>1450]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                
                ['tour' => 52, 'hotel' => 61],
                ['tour' => 53, 'hotel' => 61],                
                ['tour' => 54, 'hotel' => 62],
                
                ['tour' => 55, 'hotel' => 62],
                ['tour' => 56, 'hotel' => 62],
                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 12D Cusco y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 170]
            ],
            'precios' => [
                [1=>2000,2=>1450,3=>1425,4=>1400,5=>1400,6=>1400,7=>1400,8=>1400,9=>1400,10=>1400]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],//Cusco 180
                ['tour' => 30, 'hotel' => 58],//City
                ['tour' => 27, 'hotel' => 58],//Montaña
                ['tour' => 28, 'hotel' => 58],//Laguna                
                ['tour' => 63, 'hotel' => 60],//despedida-llegada
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 56, 'hotel' => 60],                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 12D Cusco y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 200]
            ],
            'precios' => [
                [1=>2150,2=>1600,3=>1575,4=>1550,5=>1550,6=>1550,7=>1550,8=>1550,9=>1550,10=>1550]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],//Cusco 180
                ['tour' => 30, 'hotel' => 31],//City
                ['tour' => 27, 'hotel' => 31],//Montaña
                ['tour' => 28, 'hotel' => 31],//Laguna                
                ['tour' => 63, 'hotel' => 62],//despedida-llegada                
                ['tour' => 55, 'hotel' => 62],
                ['tour' => 56, 'hotel' => 62],                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 11D Cusco y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 160]
            ],
            'precios' => [
                [1=>1900,2=>1350,3=>1325,4=>1300,5=>1300,6=>1300,7=>1300,8=>1300,9=>1300,10=>1300]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],//Cusco 180
                ['tour' => 30, 'hotel' => 58],//City
                ['tour' => 27, 'hotel' => 58],//Montaña
                ['tour' => 63, 'hotel' => 60],//despedida-llegada
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 56, 'hotel' => 60],                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 11D Cusco y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 500, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 190]
            ],
            'precios' => [
                [1=>2050,2=>1500,3=>1475,4=>1450,5=>1450,6=>1450,7=>1450,8=>1450,9=>1450,10=>1450]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],//Cusco 180
                ['tour' => 30, 'hotel' => 31],//City
                ['tour' => 27, 'hotel' => 31],//Montaña
                ['tour' => 63, 'hotel' => 62],//despedida-llegada                
                ['tour' => 55, 'hotel' => 62],
                ['tour' => 56, 'hotel' => 62],                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 10D Cusco y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 400, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 150]
            ],
            'precios' => [
                [1=>1700,2=>1250,3=>1225,4=>1200,5=>1200,6=>1200,7=>1200,8=>1200,9=>1200,10=>1200]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],//Cusco 180
                ['tour' => 27, 'hotel' => 58],//Montaña
                ['tour' => 63, 'hotel' => 60],//despedida-llegada
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 56, 'hotel' => 60],                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 10D Cusco y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 400, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 400, 'comision' => 180]
            ],
            'precios' => [
                [1=>1850,2=>1400,3=>1375,4=>1350,5=>1350,6=>1350,7=>1350,8=>1350,9=>1350,10=>1350]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],//Cusco 180
                ['tour' => 27, 'hotel' => 31],//Montaña
                ['tour' => 63, 'hotel' => 62],//despedida-llegada                
                ['tour' => 55, 'hotel' => 62],
                ['tour' => 56, 'hotel' => 62],                
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 9D Cusco y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 400, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 300, 'comision' => 130]
            ],
            'precios' => [
                [1=>1500,2=>1200,3=>1175,4=>1150,5=>1150,6=>1150,7=>1150,8=>1150,9=>1150,10=>1150]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],//Cusco 180
                ['tour' => 27, 'hotel' => 58],//Montaña
                ['tour' => 63, 'hotel' => 60],//despedida-llegada
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 9D Cusco y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 400, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 300, 'comision' => 160]
            ],
            'precios' => [
                [1=>1650,2=>1350,3=>1325,4=>1300,5=>1300,6=>1300,7=>1300,8=>1300,9=>1300,10=>1300]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],//Cusco 180
                ['tour' => 27, 'hotel' => 31],//Montaña
                ['tour' => 63, 'hotel' => 62],//despedida-llegada                
                ['tour' => 55, 'hotel' => 62],             
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 8D Cusco y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 200, 'comision' => 120]
            ],
            'precios' => [
                [1=>1400,2=>1100,3=>1075,4=>1050,5=>1050,6=>1050,7=>1050,8=>1050,9=>1050,10=>1050]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 27, 'hotel' => 58],//Montaña
                ['tour' => 63, 'hotel' => 60],//despedida-llegada
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 8D Cusco y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 250, 'comision' => 150]
            ],
            'precios' => [
                [1=>1550,2=>1250,3=>1225,4=>1200,5=>1200,6=>1200,7=>1200,8=>1200,9=>1200,10=>1200]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 27, 'hotel' => 31],//Montaña
                ['tour' => 63, 'hotel' => 62],//despedida-llegada                
                ['tour' => 55, 'hotel' => 62],             
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 7D Cusco y Lima (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 200, 'comision' => 110]
            ],
            'precios' => [
                [1=>1300,2=>1000,3=>975,4=>950,5=>950,6=>950,7=>950,8=>950,9=>950,10=>950]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 63, 'hotel' => 60],//despedida-llegada
                ['tour' => 55, 'hotel' => 60],
                ['tour' => 57]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 7D Cusco y Lima (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 250, 'comision' => 140]
            ],
            'precios' => [
                [1=>1450,2=>1150,3=>1125,4=>1100,5=>1100,6=>1100,7=>1100,8=>1100,9=>1100,10=>1100]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 63, 'hotel' => 62],//despedida-llegada                
                ['tour' => 55, 'hotel' => 62],             
                ['tour' => 57]
        ]]);
        
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 8D Cusco (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 200, 'comision' => 120]
            ],
            'precios' => [
                [1=>1300,2=>1000,3=>975,4=>950,5=>950,6=>950,7=>950,8=>950,9=>950,10=>950]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],//Cusco 180
                ['tour' => 27, 'hotel' => 58],//Montaña
                ['tour' => 28, 'hotel' => 58],//Laguna                
                ['tour' => 29]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 8D Cusco (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 300, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 250, 'comision' => 150]
            ],
            'precios' => [
                [1=>1400,2=>1100,3=>1075,4=>1050,5=>1050,6=>1050,7=>1050,8=>1050,9=>1050,10=>1050]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],//Cusco 180
                ['tour' => 27, 'hotel' => 31],//Montaña
                ['tour' => 28, 'hotel' => 31],//Laguna                
                ['tour' => 29]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 6D Cusco (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 250, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 200, 'comision' => 100]
            ],
            'precios' => [
                [1=>1100,2=>830,3=>815,4=>800,5=>800,6=>800,7=>800,8=>800,9=>800,10=>800]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 26, 'hotel' => 58],//Cusco 180
                ['tour' => 29]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 6D Cusco (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 250, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 250, 'comision' => 130]
            ],
            'precios' => [
                [1=>1200,2=>930,3=>915,4=>900,5=>900,6=>900,7=>900,8=>900,9=>900,10=>900]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 26, 'hotel' => 31],//Cusco 180
                ['tour' => 29]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 5D Cusco (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 250, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 200, 'comision' => 90]
            ],
            'precios' => [
                [1=>1000,2=>760,3=>740,4=>720,5=>720,6=>720,7=>720,8=>720,9=>720,10=>720]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 58],
                ['tour' => 29]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 5D Cusco (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 250, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 250, 'comision' => 120]
            ],
            'precios' => [
                [1=>1100,2=>860,3=>840,4=>820,5=>820,6=>820,7=>820,8=>820,9=>820,10=>820]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 25, 'hotel' => 31],
                ['tour' => 29]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 4D Cusco (3 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 250, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 200, 'comision' => 80]
            ],
            'precios' => [
                [1=>900,2=>680,3=>660,4=>650,5=>650,6=>650,7=>650,8=>650,9=>650,10=>650]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 58],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 64]
        ]]);
        $n = $mplus->servicios()->create(['nombre'=>'Paquete 4D Cusco (4 Estrellas)', 'tipo' => 'Paquete', 'lugar_id' => 15, 'estado'=> 'Interno',
            'params' => [
                ['adelanto' => 250, 'pasarela' => 0.05, 'igv' => 0.10, 'ir' => 0.10, 'facturable' => 250, 'comision' => 110]
            ],
            'precios' => [
                [1=>1000,2=>780,3=>760,4=>750,5=>750,6=>750,7=>750,8=>750,9=>750,10=>750]
            ],
            'items' => [
                ['tour' => 22, 'hotel' => 31],
                ['tour' => 23, 'hotel' => 32],
                ['tour' => 24, 'hotel' => 33],
                ['tour' => 64]
        ]]);
    }
}