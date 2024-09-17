<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class Entrenamientos extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'attend_entrenamientos' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-entrenamiento', 'side-menu-entrenamientos');
    }
    
    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        $query->where('user_id', $user->id);
    }

    public function preview($recordId, $codigo = null)
    {
        $model = $this->formFindModelObject($recordId);
    
        if (empty($model->contenido)) {
            $model->contenido = $model->curso->contenido;
        }
        $unidad = null;
        $actividad = null;
        if($codigo){
            $unidad = intval(explode('.',$codigo)[0])-1;
            $actividad = intval(explode('.',$codigo)[1])-1;            
        }
        $this->vars['unidad'] = $unidad;
        $this->vars['actividad'] = $actividad;
        $this->vars['formModel'] = $model;
        $this->vars['codigo'] = $codigo;
    }
}
