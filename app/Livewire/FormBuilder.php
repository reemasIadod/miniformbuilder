<?php

namespace App\Livewire;

use Livewire\Component;
// use Livewire\Component;
use App\Models\Form;
use Illuminate\Support\Str;

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
        'Text field', 'Button', 'Dropdown', 'Radio button', 'Checkbox', 'Switch option'
    ];
    
    public function mount($formId = null)
    {
        if ($formId) {
            $this->loadForm($formId);
        } else {
            // Initialize with default fields (First Name, Last Name)
            $this->fields = [
                [
                    'id' => rand(),
                    'type' => 'Text field',
                    'label' => 'First Name',
                    'placeholder' => 'John',
                    'required' => true,
                ],
                [
                    'id' => rand(),
                    'type' => 'Text field',
                    'label' => 'Last Name',
                    'placeholder' => '',
                    'required' => true,
                ],
            ];
        }
    }
    
    public function loadForm($formId)
    {
        $form = Form::findOrFail($formId);
        $this->formId = $form->id;
        $this->formTitle = $form->title;
        $this->fields = $form->fields;
        $this->formSettings = $form->settings;
    }
    
    public function updateFormTitle($value)
    {
        $this->formTitle = $value;
    }
    
    public function addField($type)
    {
        $newField = [
            'id' => (string) Str::uuid(),
            'type' => $type,
            'label' => $type,
            'placeholder' => '',
            'required' => false,
        ];
        
        if ($type === 'Dropdown') {
            $newField['options'] = ['Option 1', 'Option 2', 'Option 3'];
        } elseif ($type === 'Radio button') {
            $newField['options'] = ['Option 1', 'Option 2'];
        }
        
        $this->fields[] = $newField;
        $this->searchQuery = '';
    }
    
    public function removeField($index)
    {
        unset($this->fields[$index]);
        $this->fields = array_values($this->fields);
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
        $formData = [
            'title' => $this->formTitle,
            'fields' => $this->fields,
            'settings' => $this->formSettings,
        ];
        
        if ($this->formId) {
            $form = Form::findOrFail($this->formId);
            $form->update($formData);
        } else {
            $form = Form::create($formData);
            $this->formId = $form->id;
        }
        
        session()->flash('message', 'Form saved successfully!');
        
        return redirect()->route('forms.index');
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

        // return view('livewire.form-builder');
    }
}
