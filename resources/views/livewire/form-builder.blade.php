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
                                @case('Text field')
                                    <input type="text" placeholder="{{ $field['placeholder'] }}" 
                                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           style="font-family: {{ $formSettings['fontFamily'] }}">
                                    <button class=" right-0 top-0 text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                            </svg>
                                    </button>
                                    @break
                                
                                @case('Button')
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded"
                                            style="font-family: {{ $formSettings['fontFamily'] }}">
                                        {{ $field['label'] }}
                                    </button>
                                    @break
                                
                                @case('Dropdown')
                                    <select class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            style="font-family: {{ $formSettings['fontFamily'] }}">
                                        @foreach($field['options'] ?? [] as $option)
                                            <option>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @break
                                
                                @case('Radio button')
                                    <div class="space-y-2">
                                        @foreach($field['options'] ?? [] as $option)
                                            <div class="flex items-center">
                                                <input type="radio" name="radio-{{ $field['id'] }}" class="h-4 w-4 text-blue-600">
                                                <label class="ml-2" style="font-family: {{ $formSettings['fontFamily'] }}">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @break
                                
                                @case('Checkbox')
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 text-blue-600">
                                        <label class="ml-2" style="font-family: {{ $formSettings['fontFamily'] }}">{{ $field['label'] }}</label>
                                    </div>
                                    @break
                                
                                @case('Switch option')
                                    <div class="flex items-center">
                                        <div class="relative inline-block w-10 align-middle select-none">
                                            <input type="checkbox" class="absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                            <label class="block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                                        </div>
                                        <span class="ml-2" style="font-family: {{ $formSettings['fontFamily'] }}">{{ $field['label'] }}</span>
                                    </div>
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
                            <div class="mt-2 bg-white rounded-md shadow-lg border border-gray-200 max-h-60 overflow-y-auto">
                                <div class="p-2">
                                    <input type="text" wire:model.live="searchQuery" placeholder="Search" 
                                           class="w-full border border-gray-300 rounded px-3 py-2 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    
                                    @foreach($filteredFieldTypes as $type)
                                        <button wire:click="addField('{{ $type }}')" 
                                                class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                                            {{ $type }}
                                        </button>
                                    @endforeach
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
                    <div class="flex items-center">
                        <div class="relative inline-block w-10 align-middle select-none">
                            <input type="checkbox" wire:model.live="formSettings.labels" 
                                   wire:change="updateFormSetting('labels', $event.target.checked)"
                                   class="absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer"
                                   {{ $formSettings['labels'] ? 'checked' : '' }} />
                            <label class="block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                        <span class="ml-2">{{ $formSettings['labels'] ? 'Turned ON' : 'Turned OFF' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
