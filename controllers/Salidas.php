<?php namespace soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Salidas extends Controller
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
        BackendMenu::setContext('soroche.Wayna', 'menu-operaciones', 'menu-salidas');
    }
    /*
    public function listExtendQuery($query)
    {
        //$user = BackendAuth::getUser();
        $query
            //->where('proveedor_id',$user->proveedor_id)
            ->whereIn('tipo_id',[20,21]);
    }
    */
}
