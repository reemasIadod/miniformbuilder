<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Form;
use App\Models\FormInput;
use Illuminate\Support\Str;
use ReflectionClass;

class FormBuilder extends Component
{

    public $formTitle = 'Untitled Form';
    public $formId = null;
    public $fields = [];
    public $searchQuery = '';
    public $showFieldTypeSelector =false;
    public $formSettings = [
        'backgroundColor' => '#ffffff',
        'fontFamily' => 'Roboto',
        'labels' => true,
    ];

    public $availableColors = [
        '#f5f7fa', '#ffc107', '#8bc34a', '#9c27b0', '#2196f3', '#000000'
    ];
    
    public $availableFontFamilies = [
        'Roboto', 'Open Sans', 'Montserrat', 'Lato', 'Poppins', 'Arial'
    ];
    
    public $availableFieldTypes = [
        'text', 'checkbox', 'date', 'number',
    ];
    
    public function mount($formId = null)
    {

        $totalSavedFields = Form::count();
       
        if ($totalSavedFields > 0) {
         
            $formId = Form::first()->toArray();
            $this->loadForm($formId);
        } else {
            // Initialize with default fields (First Name, Last Name)
            $this->fields=[];
            
        }
    }
    
    public function loadForm($formId)
    {
        $form = Form::where("id",$formId)->get()->toArray();
        $form = $form[0];
        $formFields = FormInput::where("form_id",$formId)->get()->toArray();

        $formFieldsArray=[];
        foreach ($formFields as $key => $value) {
            
            $formFieldsArray[]=[
                'id' => $value['id_index'],
                'type' => $value['type'],
                'label' => $value['label'],
                'name' => $value['name'],
                'placeholder' => '',
                'required' => true,
            ];
        
        }
        
        $this->formId = $form['id'];
        $this->formTitle = $form['label'];
        $this->fields =  $formFieldsArray;
        $this->formSettings = [
            'backgroundColor' => $form['bg_color'],
            'fontFamily' => $form['font_family'],
            'labels' => $form['has_form_labels'],


        ];

    }
    
    public function updateFormTitle($value)
    {
        $this->formTitle = $value;
    }

    
    public function addField($formData)
    {

        $newField = [
            'id' => (string) Str::uuid(),
            'type' => $formData['fieldtype'],
            'label' => $formData['fieldlabel'],
            'name' => $formData['fieldname'],
            'placeholder' => '',
            'required' => false,
        ];
        
        if ($formData['fieldtype'] === 'Dropdown') {
            $newField['options'] = ['Option 1', 'Option 2', 'Option 3'];
        } elseif ($formData['fieldtype'] === 'Radio button') {
            $newField['options'] = ['Option 1', 'Option 2'];
        }
        
        $this->fields[] = $newField;
        $this->searchQuery = '';
        $this->showFieldTypeSelector =false;
    }
    
    public function removeField($key)
    {

        $this->fields  = array_filter($this->fields, function($field ) use ($key) {
                return $field['id'] !== $key;
            });
    }
    
    public function updateField($index, $property, $value)
    {
        $this->fields[$index][$property] = $value;
    }
    
    public function updateFormSetting($setting, $value)
    {
        $this->formSettings[$setting] = $value;
    }
    
    public function saveForm()
    {

        if(empty($this->fields)){
            session()->flash('error', 'Form fields can not empty');
        
            return redirect()->route('home');
        }

        $formData = [
            'title' => $this->formTitle,
            'fields' => $this->fields,
            'settings' => $this->formSettings,
        ];
        
        
        Form::truncate();
        FormInput::truncate();
     
        $oFormData=[
            'label' =>$formData['title'],
            'bg_color' =>$formData['settings']['backgroundColor'],
            'font_family' =>$formData['settings']['fontFamily'],
            'has_form_labels' =>($formData['settings']['labels']) ? 1 : 0,
            
        ];

        $form = Form::create($oFormData);


        $fields=$formData['fields'];
        
        

        $oFormDataFields=[];
        foreach ($fields as $key => $value) {
            $oFormDataFields[]=[
                'id_index' =>$value['id'],
                'form_id' => $form->id,
                'type' => $value['type'],
                'label'=>$value['label'],
                'name' => $value['name']
            ];
        }
        FormInput::insert($oFormDataFields);

        $this->formId = $form->id;
          

        session()->flash('message', 'Form saved successfully!');
        
        return redirect()->route('home');

    }
    



    public function render()
    {

        $filteredFieldTypes = empty($this->searchQuery) 
        ? $this->availableFieldTypes 
        : array_filter($this->availableFieldTypes, fn($type) => 
            str_contains(strtolower($type), strtolower($this->searchQuery))
        );

        return view('livewire.form-builder', [
            'filteredFieldTypes' => $filteredFieldTypes
        ]);

    }
}
