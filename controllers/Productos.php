<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class Productos extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'view_productos' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-productos');
    }
    
    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        //$rpta = 
            $query
                ->where('negocio_id', $user->negocio_id)
                ->whereIn('tipo', ['Paquete','Tour'])
                ->whereIn('estado', ['Interno','Publicado'])
                ;
                //->get();
        //dd($rpta);
    }
}
