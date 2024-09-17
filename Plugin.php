<?php namespace Soroche\Wayna;

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
    
    public function registerListColumnTypes()
    {
        return [
            'dolares' => function($value) { 
                return number_format($value, 2);
            }
        ];
    }
    
    public function boot(){
        
        BackendUserModel::extend(function($model) {
            $model->belongsTo['negocio'] = [
                'soroche\Wayna\Models\Negocio'
            ];
        });
        
        BackendUsersController::extendFormFields(function($form, $model, $context){

            if (!$model instanceof BackendUserModel)
                return;

            $form->addTabFields([
                'negocio' => [
                    'label'   => 'Negocio',
                    'type' => 'relation',
                    'nameFrom' => 'nombre',
                    'emptyOption' => '-- No asignado --',
                    'tab' => 'Wayna'
                ], 
            ]);
        });
    }
}
