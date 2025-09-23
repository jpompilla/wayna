<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class Proveedores extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-proveedores');
    }
    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        //$rpta = 
            $query
                ->join('soroche_wayna_proveedores', 'soroche_wayna_negocios.id', '=', 'soroche_wayna_proveedores.proveedor_id')
                ->where('soroche_wayna_proveedores.negocio_id',$user->negocio_id)
                ;
                //->get();
        //dd($rpta);
    }
}
