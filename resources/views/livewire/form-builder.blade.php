<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-85 bg-gray-900 text-white">
        <div class="p-4">
            <div class="flex items-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="ml-2 text-lg font-semibold">Form Builder</span>
            </div>
            
            <nav>
                <a href="#" class="block py-2.5 px-4 rounded hover:bg-gray-800 mb-1">My Forms</a>
                <a href="#" class="block py-2.5 px-4 rounded hover:bg-gray-800 mb-1">Analytics</a>
                <a href="#" class="block py-2.5 px-4 rounded hover:bg-gray-800 mb-1">Knowledge Base</a>
                <a href="#" class="block py-2.5 px-4 rounded hover:bg-gray-800 mb-1">Help & Support</a>
            </nav>
            
            <div class="absolute bottom-0 left-0  p-4">
                <div class="text-sm">My Profile</div>
                <div class="text-xs text-gray-400">Logged in</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Header -->
        <div class="bg-white border-b px-6 py-4 flex justify-between items-center">
            <div>
                <div class="text-lg font-semibold">Create New Form</div>
                <a href="#" class="text-sm text-blue-500">My Forms</a>
                <span class="text-sm text-gray-400 mx-2">›</span>
                <span class="text-sm text-gray-600">Create New Form</span>
            </div>
            <button wire:click="saveForm" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Publish Form
            </button>
        </div>

        <!-- Form Builder Content -->
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                {{ session('message') }}
            </div>
        @elseif (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="p-6 grid grid-cols-3 gap-4">
            <!-- Form Preview -->
            <div class="col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-4" style="background-color: {{ $formSettings['backgroundColor'] }}">
                    <!-- Form Title -->
                    <div class="mb-6">
                        <input type="text" wire:model.live="formTitle" wire:change="updateFormTitle($event.target.value)" 
                               class="w-full text-lg font-semibold bg-transparent border-b-2 border-gray-200 pb-2 focus:outline-none focus:border-blue-500"
                               style="font-family: {{ $formSettings['fontFamily'] }}">
                    </div>
                    {{-- {{dd($fields)}} --}}
                    <!-- Form Fields -->
                    @foreach($fields as $index => $field)
                           
                        <div class="mb-4 relative " wire:key="field-{{ $field['id'] }}">
                            @if($formSettings['labels'])
                                <label class="block text-sm font-medium mb-1" style="font-family: {{ $formSettings['fontFamily'] }}">
                                    {{ $field['label'] }}
                                </label>
                            @endif
                            <div class="flex justify-arround">
                            @switch($field['type'])
                                @case('text')
                                    <input type="text" placeholder="{{ $field['placeholder'] }}" 
                                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name={{$field['name']}}
                                           style="font-family: {{ $formSettings['fontFamily'] }}">
                                    <button class=" right-0 top-0 text-gray-500 hover:text-gray-700" wire:click="removeField('{{ $field['id'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="red">
                                            <path d="M4 4L16 16M4 16L16 4" stroke="red" stroke-width="2" />
                                        </svg>
                                    </button>
                                    @break
                                    @case('date')
                                    <input type="date" placeholder="{{ $field['placeholder'] }}" 
                                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name={{$field['name']}}
                                           style="font-family: {{ $formSettings['fontFamily'] }}">
                                    <button class=" right-0 top-0 text-gray-500 hover:text-gray-700" wire:click="removeField('{{ $field['id'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="red">
                                            <path d="M4 4L16 16M4 16L16 4" stroke="red" stroke-width="2" />
                                        </svg>
                                    </button>
                                    @break
                                    @case('number')
                                    <input type="number" placeholder="{{ $field['placeholder'] }}" 
                                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" name={{$field['name']}}
                                           style="font-family: {{ $formSettings['fontFamily'] }}">
                                    <button class=" right-0 top-0 text-gray-500 hover:text-gray-700" wire:click="removeField('{{ $field['id'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="red">
                                            <path d="M4 4L16 16M4 16L16 4" stroke="red" stroke-width="2" />
                                        </svg>
                                    </button>
                                    @break
                              
                                
                                @case('checkbox')
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 text-blue-600" name={{$field['name']}}>
                                        <label class="ml-2" style="font-family: {{ $formSettings['fontFamily'] }}">{{ $field['label'] }}</label>
                                    </div>
                                    <button class=" right-0 top-0 text-gray-500 hover:text-gray-700" wire:click="removeField('{{ $field['id'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="red">
                                            <path d="M4 4L16 16M4 16L16 4" stroke="red" stroke-width="2" />
                                        </svg>
                                    </button>
                                    @break

                            @endswitch
                            </div>
                            
                        </div>
                    @endforeach
                    
                    <!-- Add Field Button -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <button wire:click="$toggle('showFieldTypeSelector')" class="text-blue-500 font-medium flex items-center justify-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add New Field
                        </button>
                        
                        <!-- Field Type Selector Dropdown -->
                        @if($showFieldTypeSelector ?? false)
                        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-[9]" >
                            <div class="bg-white p-8 rounded-lg shadow-lg w-3/4 max-w-4xl">
                                <h2 class="text-xl font-semibold">Add Form Fields</h2>
                                <form wire:submit.prevent="addField(Object.fromEntries(new FormData($event.target)))">
                                    <div class="grid grid-cols-2 gap-4 p-2">
                                        <select class="block w-full px-3 py-2 border rounded bg-white" name='fieldtype'>
                                            @foreach($filteredFieldTypes as $type)
                                                <option value="{{ $type }}">{{ ucwords($type) }}</option>
                                            @endforeach
                                        </select>
                                    
                                        <input type="text" placeholder="Field Label" name='fieldlabel' class="block w-full px-3 py-2 border rounded bg-white" required/>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 p-2">
                                        <input type="text" placeholder="Field Name" name='fieldname' class="block w-full px-3 py-2 border rounded bg-white" required/>
                                    </div>

                                    
                                    <button type="button" wire:click="$toggle('showFieldTypeSelector')" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Close</button>

                                    <button type="submit"  class="mt-4 px-4 py-2 bg-green-500 text-white rounded"> Add Field </button>
                                </form>
                            </div>
                        </div>    
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Form Settings -->
            <div class="col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Background Color</h3>
                    <div class="flex space-x-2 mb-6">
                        @foreach($availableColors as $color)
                            <button wire:click="updateFormSetting('backgroundColor', '{{ $color }}')" 
                                    class="w-6 h-6 rounded-full border {{ $formSettings['backgroundColor'] === $color ? 'ring-2 ring-offset-2 ring-blue-500' : '' }}"
                                    style="background-color: {{ $color }};">
                            </button>
                        @endforeach
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-4">Font Family</h3>
                    <div class="mb-6">
                        <select wire:model.live="formSettings.fontFamily" wire:change="updateFormSetting('fontFamily', $event.target.value)"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($availableFontFamilies as $font)
                                <option value="{{ $font }}">{{ $font }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-4">Form Labels</h3>

                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" wire:model.live="formSettings.labels" 
                        wire:change="updateFormSetting('labels', $event.target.checked)" {{ $formSettings['labels'] ? 'checked' : '' }} >
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                        <span class="ml-2">{{ $formSettings['labels'] ? 'Turned ON' : 'Turned OFF' }}</span>
                      </label>

                </div>
            </div>
        </div>
    </div>
</div>
