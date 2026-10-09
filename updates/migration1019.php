<?php namespace Soroche\Wayna\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;
use Db;

class Migration1019 extends Migration
{
    public function up()
    {
        Db::statement("
            UPDATE soroche_wayna_reservas r
            JOIN (
              SELECT 
                r2.id AS reserva_id,
                MAX(j2.fecha) AS ultima_fecha
              FROM soroche_wayna_reservas r2
              JOIN JSON_TABLE(
                r2.items,
                '$[*]' COLUMNS(
                  _group VARCHAR(255) PATH '$._group',
                  fecha DATE PATH '$.fecha'
                )
              ) AS j2
              WHERE j2._group = 'paquete'
              GROUP BY r2.id
            ) AS sub ON sub.reserva_id = r.id
            SET r.fecha_fin = sub.ultima_fecha;
        ");
    }

    public function down()
    {
        Db::statement("UPDATE soroche_wayna_reservas SET fecha_fin = NULL;");
    }
}