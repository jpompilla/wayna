<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Cursos extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_entrenamientos' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-entrenamiento', 'site-menu-cursos');
    }
}
