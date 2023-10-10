<?php namespace soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Servicio;

class Seeder1016 extends Seeder
{
    public function run()
    {
        $s = Servicio::create(['nombre' => 'Llegada a Cusco', 
            'description' => '<p>Uno de nuestros representantes te esperará para recibirte a tu llegada a Cusco y trasladarte a tu hotel. Recomendamos llegar en un vuelo por la mañana para tener tiempo de aclimatarse. Este día es libre y te sirve para acostumbrarte a la altura de la ciudad.</p>',
            'tipo_id' => 21, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23]);       //Tour o Actividad        
            $s->servicio_items()->create(['nombre' => 'Traslado del Aeropuerto - Hotel', 'item_id' => 1]);
            $s->save();
        
        $s = Servicio::create(['nombre' => 'Valle Sagrado', 'tipo_id' => 21, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 24]);       //Tour o Actividad        
            $s->servicio_items()->create(['nombre' => 'Transporte Valle Sagrado', 'item_id' => 3]);
            $s->servicio_items()->create(['nombre' => 'Guia para el grupo', 'item_id' => 11]);
            $s->servicio_items()->create(['nombre' => 'Almuerzo Buffet', 'item_id' => 15]);
            $s->servicio_items()->create(['nombre' => 'Tren de turistas Expedition', 'item_id' => 28]);
            $s->save();
        
        $s = Servicio::create(['nombre' => 'Machupicchu', 'tipo_id' => 21, 'lugar_inicio_id' => 24, 'lugar_fin_id' => 23]);       //Tour o Actividad        
            $s->servicio_items()->create(['nombre' => 'Entradas a Machupicchu', 'item_id' => 16]);
            $s->servicio_items()->create(['nombre' => 'Guia para el grupo', 'item_id' => 14]);
            $s->servicio_items()->create(['nombre' => 'Tren de lujo Vistadome', 'item_id' => 29]);
            $s->servicio_items()->create(['nombre' => 'Traslado del Ollantaytambo - Cusco', 'item_id' => 4]);
            $s->save();
        
        $s = Servicio::create(['nombre' => 'Laguna Humantay y Domos', 'tipo_id' => 21, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 25]);       //Tour o Actividad        
            $s->servicio_items()->create(['nombre' => 'Desayuno, Almuerzo y Cena', 'item_id' => 30]);
            $s->servicio_items()->create(['nombre' => 'Transporte Cusco - Soraypampa - Cusco', 'item_id' => 7]);
            $s->servicio_items()->create(['nombre' => 'Guia para el grupo', 'item_id' => 12]);
            $s->servicio_items()->create(['nombre' => 'Alojamiento en Domos de lujo', 'item_id' => 31]);
            $s->save();
        
        $s = Servicio::create(['nombre' => 'Domos y Salkantay', 'tipo_id' => 21, 'lugar_inicio_id' => 25, 'lugar_fin_id' => 23]);       //Tour o Actividad        
            $s->servicio_items()->create(['nombre' => 'Desayuno, Almuerzo y Cena', 'item_id' => 30]);
            $s->save();
        
        $s = Servicio::create(['nombre' => 'Montaña de 7 colores', 'tipo_id' => 21, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23]);       //Tour o Actividad        
            $s->servicio_items()->create(['nombre' => 'Transporte Montaña de Colores', 'item_id' => 8]);
            $s->servicio_items()->create(['nombre' => 'Guia para el grupo', 'item_id' => 13]);
            $s->servicio_items()->create(['nombre' => 'Show de la Pachamanca', 'item_id' => 32]);
            $s->save();
            
        $s = Servicio::create(['nombre' => 'Despedida de Cusco', 'tipo_id' => 21, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23]);       //Tour o Actividad        
            $s->servicio_items()->create(['nombre' => 'Traslado del Hotel - Aeropuerto', 'item_id' => 2]);
            $s->save();
            
        
        /*-----------Paquetes----------------------------*/
        
        $s = Servicio::create(['nombre' => 'Paquete 7D', 'slug' => 'paquete-7d', 'tipo_id' => 20, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23, 'categorias' => [27,28,29]]);       //Paquete 
            
            $s->servicio_items()->create(['dia' => 1, 'nombre' => 'Llegada a Cusco y Aclimatación', 'item_id' => 33, 'categorias' => [27,28,29]]);
            $s->servicio_items()->create(['dia' => 1, 'nombre' => 'Hotel de 4 Estrellas (Cusco)', 'item_id' => 20, 'categorias' => [29]]);
            
            $s->servicio_items()->create(['dia' => 2, 'nombre' => 'Disfruta del Valle Sagrado de los Incas', 'item_id' => 34, 'categorias' => [27,28,29]]);
            $s->servicio_items()->create(['dia' => 2, 'nombre' => 'Hotel de 4 Estrellas (Aguas Calientes)', 'item_id' => 25, 'categorias' => [29]]);
            
            $s->servicio_items()->create(['dia' => 3, 'nombre' => 'Disfruta la magia de Machupicchu', 'item_id' => 35, 'categorias' => [27,28,29]]);
            $s->servicio_items()->create(['dia' => 3, 'nombre' => 'Hotel de 4 Estrellas (Cusco)', 'item_id' => 20, 'categorias' => [29]]);
            
            $s->servicio_items()->create(['dia' => 4, 'nombre' => 'Vive la Laguna Huamantay y lo Domos de Lujo', 'item_id' => 36, 'categorias' => [27,28,29]]);
            
            $s->servicio_items()->create(['dia' => 5, 'nombre' => 'Experimenta el Apu Salkantay', 'item_id' => 37, 'categorias' => [27,28,29]]);
            $s->servicio_items()->create(['dia' => 5, 'nombre' => 'Hotel de 4 Estrellas (Cusco)', 'item_id' => 20, 'categorias' => [29]]);
            
            $s->servicio_items()->create(['dia' => 6, 'nombre' => 'Disfruta de la Montaña de 7 Colores', 'item_id' => 38, 'categorias' => [27,28,29]]);
            $s->servicio_items()->create(['dia' => 6, 'nombre' => 'Hotel de 4 Estrellas (Cusco)', 'item_id' => 20, 'categorias' => [29]]);
            
            $s->servicio_items()->create(['dia' => 7, 'nombre' => 'Llego la despedida', 'item_id' => 39, 'categorias' => [27,28,29]]);
            $s->save();
    }
}