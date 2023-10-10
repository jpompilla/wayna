<?php namespace soroche\Wayna;

use System\Classes\PluginBase;
use Backend\Models\User as BackendUserModel;
use Backend\Controllers\Users as BackendUsersController;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
    
    public function boot(){
        /*
        BackendUserModel::extend(function($model) {
            $model->belongsTo['elproveedor'] = [
                'soroche\Wayna\Models\Proveedor'
            ];
        });
        
        BackendUsersController::extendFormFields(function($form, $model, $context){

            if (!$model instanceof BackendUserModel)
                return;

            $form->addTabFields([
                'elproveedor' => [
                    'label'   => 'Proveedor',
                    'comment' => '(Wayna) Usuario pertenece al proveedor',
                    'type' => 'relation',
                    'nameFrom' => 'nombre',
                    'tab' => 'Relations'
                ],                
            ]);
        });
        */
    }
}
