<div class="control-list list-scrollable" data-control="listwidget">
    <div class="container-fluid">
    <div class="row row-flush">
        <!--?= dd($record->itinerario) ?-->
        <?php foreach ($records as $record): ?>
            <!--?= dd($record->params) ?-->
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="product">
                    <h3 class="title"><?= $record->nombre ?></h3>
                    <p><span class="tipo"><?= $record->tipo ?></span> <span class="tipo"><?= $record->dias ?> día(s)</span></p>

                    <table class="itinerario">
                    <?php foreach ($record->items as $i=>$item): ?>
                    <?php 
                        $coincidencias = [];
                        if(preg_match('/:\s*(.*?)\s*(?:\+.*?\((.*?)\))?$/', $item['nombre'], $coincidencias)):
                    ?>
                        <tr>
                            <td class="tour">
                                <span class="dia"><?= $i+1 ?></span><?= $coincidencias[1] ?>
                            </td>
                            <td class="hotel">
                                <?php if (array_key_exists(2, $coincidencias)): ?><i class="icon-hotel"></i> <?= $coincidencias[2] ?><?php endif ?>
                            </td>
                        </tr>
                    <?php endif ?>
                    <?php endforeach ?>
                    </table>
                    
                    <div class="prices">
                        <div class="price">
                            <span class="text">01 pax</span><br>
                            US$ <?= number_format($record->precios[0][1], 0, '.', ',') ?>
                        </div>
                        <div class="price">
                            <span class="text">02 pax</span><br>
                            US$ <?= number_format($record->precios[0][1], 0, '.', ',') ?>
                        </div>
                        <div class="price">
                            <span class="text">03 pax</span><br>
                            US$ <?= number_format($record->precios[0][1], 0, '.', ',') ?>
                        </div>
                        <div class="price">
                            <span class="text">04 pax</span><br>
                            US$ <?= number_format($record->precios[0][1], 0, '.', ',') ?>
                        </div>
                        <div class="reserva">
                            <span class="text">Reserva</span><br>
                            US$ <?= number_format($record->params[0]['adelanto'], 0, '.', ',') ?>
                        </div>
                        <div class="comision">
                            <span class="text">Comisión</span><br>
                            US$ <?= number_format($record->params[0]['comision'], 0, '.', ',') ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    </div>

    <?php if ($showPagination): ?>
        <div class="list-footer">
            <div class="list-pagination">
                <?php if ($showPageNumbers): ?>
                    <?= $this->makePartial('list_pagination') ?>
                <?php else: ?>
                    <?= $this->makePartial('list_pagination_simple') ?>
                <?php endif ?>
            </div>
        </div>
    <?php endif ?>
</div>

<style>
    .product{
        border-radius: 5px;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1); 
        margin: 10px; 
        padding:10px;
        background-color: #fff;
        min-height: 360px;

        & .title{
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        & .tipo{
            font-size: 12px;
            color: #fff;
            background-color: #999999ff;
            padding: 2px 6px;
            border-radius: 5px;
        }
        & table.itinerario{
            list-style-type: disc;
            padding-left: 20px;
            font-size: 12px;
            & td{
                margin-bottom: 1px;
                & .dia{
                    padding: 1px 4px;
                    background-color: #dc573baa;
                    color: #fff;
                    font-size: 10px;
                    margin-right: 5px;
                    border-radius: 3px;
                }

            }
            & td.tour{
                width: 75%;
            }
            & td.hotel{
                font-size: 10px;
                color: #666;
                padding-left: 10px;
            }
        }
        & .prices{
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
            & > div{
                width: 16.5%;
                text-align: center;
                font-size: 12px;
                & .text{
                    font-weight: bold;
                }
            }
            & > div.price{
                background-color: #ebebebff;
            }
            & > div.reserva{
                margin-left: 2px;
                background-color: #d2ddd2ff;
            }
            & > div.comision{
                margin-left: 2px;
                background-color: #dbd2dbff;
            }
        }
    }
</style>