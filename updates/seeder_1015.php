<?php namespace soroche\Wayna\Updates;

use Seeder;
use Soroche\Wayna\Models\Proveedor;

class Seeder1015 extends Seeder
{
    public function run()
    {
        Proveedor::create(['nombre' => 'Machupicchu 101', 'tipo_id' => 14, 'lugar_id' => 23]);         //Agencia de Turismo
        
        $p = Proveedor::create(['nombre' => 'Wilber Transportes', 'tipo_id' => 15, 'lugar_id' => 23]); //Transporte
            $p->servicios()->create([
                'nombre' => 'Traslado Aeropuerto a Hotel', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 5, 'confidencial' => 8, 'publicado' => 8, 'comision' => 1]);
            $p->servicios()->create([
                'nombre' => 'Traslado Hotel a Aeropuerto', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 5, 'confidencial' => 8, 'publicado' => 8, 'comision' => 1]);            
            $p->servicios()->create([
                'nombre' => 'Transporte Valle Sagrado', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 6, 'costo' => 80, 'confidencial' => 98, 'publicado' => 98, 'comision' => 5]);
            $p->servicios()->create([
                'nombre' => 'Traslado Ollantaytambo a Cusco (Fortune 4)', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 20, 'confidencial' => 28, 'publicado' => 28, 'comision' => 2]);
            $p->servicios()->create([
                'nombre' => 'Traslado Ollantaytambo a Cusco (H1 8)', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 8, 'costo' => 30, 'confidencial' => 42, 'publicado' => 42, 'comision' => 2]);
            $p->servicios()->create([
                'nombre' => 'Traslado Ollantaytambo a Cusco (Sprinter 20)', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 20, 'costo' => 50, 'confidencial' => 62, 'publicado' => 62, 'comision' => 2]);                
            $p->servicios()->create([
                'nombre' => 'Transporte Cusco - Soraypampa - Cusco', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 90, 'confidencial' => 120, 'publicado' => 120, 'comision' => 8]);
                
            $p->servicios()->create([
                'nombre' => 'Transporte Montaña 7 Colores (Fortune)', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 90, 'confidencial' => 120, 'publicado' => 120, 'comision' => 8]);
            $p->servicios()->create([
                'nombre' => 'Transporte Montaña 7 Colores (H1 4)', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 8, 'costo' => 100, 'confidencial' => 140, 'publicado' => 140, 'comision' => 10]);
            $p->servicios()->create([
                'nombre' => 'Transporte Montaña 7 Colores (Sprinter 15)', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 15, 'costo' => 110, 'confidencial' => 160, 'publicado' => 160, 'comision' => 12]);            
        
        $p = Proveedor::create(['nombre' => 'Johan Guia', 'tipo_id' => 16, 'lugar_id' => 23]);               //Guia de Turismo
            $p->servicios()->create([
                'nombre' => 'Guiado Valle Sagrado', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 35, 'confidencial' => 40, 'publicado' => 40, 'comision' => 2]);
            $p->servicios()->create([
                'nombre' => 'Guiado Laguna y Salkantay', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 100, 'confidencial' => 120, 'publicado' => 120, 'comision' => 6]);                            
            $p->servicios()->create([
                'nombre' => 'Guiado Montaña de 7 Colores', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 35, 'confidencial' => 40, 'publicado' => 40, 'comision' => 2]);
        $p = Proveedor::create(['nombre' => 'Samuel Guia', 'tipo_id' => 16, 'lugar_id' => 23]);               //Guia de Turismo
            $p->servicios()->create([
                'nombre' => 'Guiado Machupicchu', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 35, 'confidencial' => 40, 'publicado' => 40, 'comision' => 2]);            
            
        $p = Proveedor::create(['nombre' => 'Restaurante Tunupa', 'tipo_id' => 17, 'lugar_id' => 23]);      //Restaurante
            $p->servicios()->create([
                'nombre' => 'Almuerzo Buffet', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 20, 'confidencial' => 20, 'publicado' => 20, 'comision' => 0]);
                
        $p = Proveedor::create(['nombre' => 'Instituto Nacional de Cultura', 'tipo_id' => 18, 'lugar_id' => 23]); //Entradas
            $p->servicios()->create([
                'nombre' => 'Entrada a Machupicchu', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 42, 'confidencial' => 42, 'publicado' => 42, 'comision' => 0]);
            $p->servicios()->create([
                'nombre' => 'Entrada a Machupicchu con Camino Inca', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 98, 'confidencial' => 98, 'publicado' => 98, 'comision' => 0]);
            $p->servicios()->create([
                'nombre' => 'Entrada a Machupicchu con Huaynapicchu', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 80, 'confidencial' => 80, 'publicado' => 80, 'comision' => 0]);
                
        $p = Proveedor::create(['nombre' => 'Hoteles San Agustin', 'tipo_id' => 19, 'lugar_id' => 23]);       //Hospedaje
            $p->servicios()->create([
                'nombre' => 'Simple - El Dorado', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 40, 'confidencial' => 55, 'publicado' => 85, 'comision' => 4]);
            $p->servicios()->create([
                'nombre' => 'Doble - El Dorado', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 2, 'costo' => 40, 'confidencial' => 55, 'publicado' => 85, 'comision' => 4]);
            $p->servicios()->create([
                'nombre' => 'Matrimonial - El Dorado', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 2, 'costo' => 40, 'confidencial' => 55, 'publicado' => 85, 'comision' => 4]);
            $p->servicios()->create([
                'nombre' => 'Triple - El Dorado', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 3, 'costo' => 60, 'confidencial' => 75, 'publicado' => 90, 'comision' => 6]);
            $p->servicios()->create([
                'nombre' => 'Cuadruple - El Dorado', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 100, 'confidencial' => 120, 'publicado' => 140, 'comision' => 8]);
        
        $p = Proveedor::create(['nombre' => 'Hotel Taypikala', 'tipo_id' => 19, 'lugar_id' => 24]);       //Hospedaje
            $p->servicios()->create([
                'nombre' => 'Simple', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 70, 'confidencial' => 85, 'publicado' => 130, 'comision' => 4]);
            $p->servicios()->create([
                'nombre' => 'Doble', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 2, 'costo' => 70, 'confidencial' => 85, 'publicado' => 130, 'comision' => 4]);
            $p->servicios()->create([
                'nombre' => 'Matrimonial', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 2, 'costo' => 70, 'confidencial' => 85, 'publicado' => 130, 'comision' => 4]);
            $p->servicios()->create([
                'nombre' => 'Triple', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 3, 'costo' => 80, 'confidencial' => 100, 'publicado' => 140, 'comision' => 8]);
                
        $p = Proveedor::create(['nombre' => 'Peru Rail', 'tipo_id' => 15, 'lugar_id' => 23]);       //Transporte
            $p->servicios()->create([
                'nombre' => 'Expedition Ollantaytambo/Aguas Calientes', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 65, 'confidencial' => 65, 'publicado' => 65, 'comision' => 0]);
            $p->servicios()->create([
                'nombre' => 'Vistadome Aguas Calientes/Ollantaytambo', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 65, 'confidencial' => 85, 'publicado' => 85, 'comision' => 0]);
                
        $p = Proveedor::create(['nombre' => 'Bioandean Expeditions', 'tipo_id' => 14, 'lugar_id' => 25]);       //Agencia de Turismo
            $p->servicios()->create([
                'nombre' => 'Desayuno, Almuerzo Buffet y Cena', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 20, 'confidencial' => 35, 'publicado' => 35, 'comision' => 4]);
            $p->servicios()->create([
                'nombre' => 'Domo cuadruple', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 4, 'costo' => 60, 'confidencial' => 80, 'publicado' => 80, 'comision' => 0]);
            $p->servicios()->create([
                'nombre' => 'Almuerzo Pachamanca', 
                'tipo_id' => 22, 'lugar_inicio_id' => 23, 'lugar_fin_id' => 23,
                'capacidad' => 1, 'costo' => 15, 'confidencial' => 25, 'publicado' => 25, 'comision' => 4]);
    }
}