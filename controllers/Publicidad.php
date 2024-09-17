<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use Soroche\Wayna\Models\Pago;
use Soroche\Wayna\Models\Asiento;

class Publicidad extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'manage_publicidad_adts' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-publicidad');
    }
    
    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        $query->where('pagable_id', $user->id)->where('pagable_type', 'Backend\Models\User');
    }
}
