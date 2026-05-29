<?php namespace Soroche\Wayna\Updates;

use Schema;
use DB;
use Winter\Storm\Database\Updates\Migration;

class Migration1022 extends Migration
{
    public function up()
    {
        // Opcional: Elimina el procedimiento si ya existe para evitar errores
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_flujo_proyectado;");

        // Crea el procedimiento almacenado
        DB::unprepared("
            CREATE PROCEDURE sp_flujo_proyectado()
            BEGIN
                SELECT 
                	SUBSTRING(r.fecha_fin,1,7) AS 'mes'
                	,r.id AS 'reserva_id'
                	,r.name
                	,r.nro_paxs 
                	,r.total as 'ingresos'
                	,CASE r.nro_paxs
                	    WHEN 1 THEN SUM(IFNULL(c.co1,c.ca1)) * r.nro_paxs
                	    WHEN 2 THEN SUM(IFNULL(c.co2,c.ca2)) * r.nro_paxs
                   	    WHEN 3 THEN SUM(IFNULL(c.co3,c.ca3)) * r.nro_paxs
                	    ELSE SUM(IFNULL(c.co4,c.ca4)) * r.nro_paxs
                	END as 'costo_operativo'
                	,r.totalpagos * 0.042 AS 'izipay'
                	,r.totalpagos * 0.10 AS 'impuestos'	
                	,r.comision
                FROM
                	soroche_wayna_reservas r 
                	JOIN JSON_TABLE (
                		r.items, '$[*]' COLUMNS (
                	        dia INT PATH '$.dia',
                	        grupo VARCHAR(50) PATH '$._group',
                	        nombre VARCHAR(255) PATH '$.nombre',
                	        actividad_id INT PATH '$.actividad',
                	        tour_id INT PATH '$.tour',
                	        hotel_id INT PATH '$.hotel')
                    ) AS i
                	LEFT JOIN soroche_wayna_servicios s ON s.id IN (i.tour_id, i.hotel_id, i.actividad_id)
                	JOIN JSON_TABLE (
                		s.costos, '$.operativo' COLUMNS(
                	        co1 DECIMAL(10,2) PATH '$.\"1\"',
                	        co2 DECIMAL(10,2) PATH '$.\"2\"',
                	        co3 DECIMAL(10,2) PATH '$.\"3\"',
                	        co4 DECIMAL(10,2) PATH '$.\"4\"',
                	        ca1 DECIMAL(10,2) PATH '$[1]',
                	        ca2 DECIMAL(10,2) PATH '$[2]',
                	        ca3 DECIMAL(10,2) PATH '$[3]',
                	        ca4 DECIMAL(10,2) PATH '$[4]'
                		)
                	) AS c
                WHERE
                	r.estado IN ('Confirmado')
                	AND r.deleted_at IS NULL
                GROUP BY
                	SUBSTRING(r.fecha_fin,1,7)
                	,r.id
                	,r.name
                	,r.nro_paxs
                	,r.total
                	,r.totalpagos
                	,r.comision;
            END
        ");
    }

    public function down()
    {
        // Elimina el procedimiento al deshacer la migración
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_flujo_proyectado;");
    }
}