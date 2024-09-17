<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class MiNegocio extends Controller
{
    public $implement = [
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController'
    ];
    
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-mi-negocio');
    }
    
    public function index(){
        $user = BackendAuth::getUser();
        //dd($user);
        return \Backend::redirect('soroche/wayna/minegocio/preview/'.$user->negocio_id);
    }
}
