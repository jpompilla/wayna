<?php namespace Soroche\Wayna;

use System\Classes\PluginBase;
use Backend\Models\User as BackendUserModel;
use Backend\Controllers\Users as BackendUsersController;
use Event;

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
                'telefono' => [
                    'label'   => 'Telefono',
                    'type' => 'text',
                    'tab' => 'Wayna'
                ],
            ]);
        });
        
        Event::listen('backend.form.extendFields', function ($widget) {

            if (
                !$widget->getController() instanceof \RainLab\Pages\Controllers\Index ||
                !$widget->model instanceof \RainLab\Pages\Classes\MenuItem
            ) {
                return;
            }
            
            $widget->addTabFields([
                'viewBag[subtitle]' => [
                    'tab' => 'Details',
                    'type'=> 'text',
                    'label' => 'Subtitle',
                    'comment' => 'Ingresa un subtitulo para el menu',
                    'span' => 'left',
                ],
                'viewBag[thumbnail]' => [
                    'tab' => 'Details',
                    'type'=> 'mediafinder',
                    'label' => 'Thumbnail',
                    'comment' => 'Selecciona una image para el menu',                    
                    'mode' => 'image',
                    'imageWidth' => 100,
                    'imageHeight' => 100,
                    'span' => 'right',
                ],
                'viewBag[stars]' => [
                    'tab' => 'Details',
                    'type'=> 'number',
                    'label' => 'Stars',
                    'comment' => 'Ingresa calificación de este enlace',
                    'step' => 1,
                    'min' => 1,
                    'max' => 5,
                    'span' => 'left',
                ],
                'viewBag[price]' => [
                    'tab' => 'Details',
                    'type'=> 'number',
                    'label' => 'Price from',
                    'comment' => 'Ingresa un monto',
                    'span' => 'left',
                ],
                'viewBag[duration]' => [
                    'tab' => 'Details',
                    'type'=> 'text',
                    'label' => 'Duration',
                    'comment' => 'Ingresa una duracion para el menu',
                    'span' => 'left',
                ],
                'viewBag[description]' => [
                    'tab' => 'Details',
                    'type'=> 'textarea',
                    'label' => 'Description',
                    'comment' => 'Ingresa una descripción para el menu',
                    'size' => 'tiny',
                ],
            ]);
        });
    }
}
