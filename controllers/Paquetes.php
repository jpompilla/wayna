<?php namespace Soroche\Wayna\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use Soroche\Wayna\Models\Servicio;
use Flash;
use Redirect;

class Paquetes extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_productos' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Soroche.Wayna', 'menu-paquetes');
    }
    public function listExtendQuery($query)
    {
        $user = BackendAuth::getUser();
        //$rpta = 
            $query
                ->where('negocio_id', $user->negocio_id)
                ->where('tipo', 'Paquete')
                ;
                //->get();
        //dd($rpta);
    }
    
    /*
    public function duplicate($id = null){
        $config = $this->makeConfig('$/soroche/wayna/models/servicio/paquete_fields.yaml');
        
        $original = Servicio::find($id);
        $duplicado = $original->replicate();
        $duplicado->nombre = 'Copia de '.$original->nombre;
        $config->model = $duplicado;
        
        $this->initForm($duplicado);        
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        
        $this->vars['widget'] = $widget;
    }
    */
    public function duplicate($id = null){
        $original = Servicio::find($id);
        $duplicado = $original->replicate();
        $duplicado->nombre = 'Copia de '.$original->nombre;
        $duplicado->estado = 'Borrador';
        $duplicado->save();
        return \Backend::redirect('soroche/wayna/paquetes/update/' . $duplicado->id)->with('message', 'Servicio duplicado');
    }
}
