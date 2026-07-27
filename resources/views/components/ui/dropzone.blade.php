@props([
    'name' => '',
    'label' => '',
    'multiple' => false,
    'accept' => 'image/*',
    'maxSize' => 2, // in MB
    'previewUrl' => null
])

@php
    $hasError = $name && $errors->has(Str::replaceLast('[]', '', $name));
    $errorName = Str::replaceLast('[]', '', $name);
    
    // Status classes for the dropzone container border
    $statusClasses = $hasError 
        ? 'border-red-400 bg-red-50/30' 
        : 'border-slate-200 bg-slate-50/50 hover:bg-slate-50 hover:border-slate-300';
        
    $inputId = $attributes->get('id', str_replace(['[', ']'], ['', ''], $name));
@endphp

<div class="w-full" x-data="dropzoneComponent({
    name: '{{ $name }}',
    multiple: {{ $multiple ? 'true' : 'false' }},
    maxSize: {{ $maxSize }},
    previewUrl: @js($previewUrl)
})">
    @if($label)
        <label for="{{ $inputId }}" class="mb-2 block text-base font-satoshi-medium text-slate-700">
            {{ $label }}
        </label>
    @endif

    <!-- Dropzone Area -->
    <div 
        @dragover.prevent="isDragOver = true"
        @dragleave.prevent="isDragOver = false"
        @drop.prevent="handleDrop($event)"
        @click="triggerClick"
        :class="{
            'border-slate-400 bg-slate-100 ring-2 ring-slate-100': isDragOver,
            '{{ $statusClasses }}': !isDragOver,
            'aspect-video p-6': !(multiple && files.length > 0),
            'min-h-[180px] h-auto p-4': multiple && files.length > 0
        }"
        class="relative w-full border-2 border-dashed rounded-2xl transition-all duration-200 flex flex-col items-center justify-center text-center cursor-pointer group"
    >
        <!-- Hidden File Input -->
        <input 
            type="file" 
            x-ref="fileInput" 
            name="{{ $name }}"
            id="{{ $inputId }}"
            class="absolute w-[1px] h-[1px] opacity-0 pointer-events-none"
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            @change="handleFiles($event)"
            {{ $attributes->except(['class', 'id', 'name']) }}
        />

        <!-- Upload Prompt (Only visible if empty) -->
        <div x-show="files.length === 0" class="flex flex-col items-center justify-center space-y-2 pointer-events-none">
            <div class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center shadow-sm text-slate-400 group-hover:text-slate-600 transition-colors">
                <i class="ri-upload-cloud-2-line text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-satoshi-medium text-slate-600">
                    <span class="text-slate-800 hover:text-slate-950 font-satoshi-bold">Click to upload</span> or drag and drop
                </p>
                <p class="text-xs text-slate-400 mt-1">
                    Supports {{ Str::upper(str_replace(['image/', '.'], ['', ''], $accept)) }} up to {{ $maxSize }}MB
                </p>
            </div>
        </div>

        <!-- Single File Preview Area (when basic mode and has file) -->
        <template x-if="!multiple && files.length > 0">
            <div class="absolute inset-0 w-full h-full p-2 bg-white rounded-2xl overflow-hidden flex items-center justify-center group/preview animate-fade-in" @click.stop>
                <!-- Image Preview -->
                <template x-if="files[0].isImage">
                    <div class="relative w-full h-full rounded-xl overflow-hidden bg-slate-50 border border-slate-100 flex items-center justify-center">
                        <img :src="files[0].preview" class="w-full h-full object-cover" alt="Preview">
                        
                        <!-- Overlay Details (Elegant and readable dark overlay at the bottom) -->
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-900/90 via-slate-900/60 to-transparent p-4 pt-12 flex flex-col justify-end text-left text-white">
                            <p class="text-sm font-satoshi-bold truncate w-4/5" x-text="files[0].name"></p>
                            <p class="text-xs text-slate-300 font-satoshi-regular mt-0.5" x-text="files[0].size"></p>
                        </div>
                        
                        <!-- Delete Button (Top Right) -->
                        <button type="button" @click.stop="removeFile(files[0].id)" class="absolute top-3 right-3 h-8 w-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-lg border border-red-400 transition-all transform hover:scale-105">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                </template>

                <!-- Non-Image Preview -->
                <template x-if="!files[0].isImage">
                    <div class="relative w-full h-full rounded-xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center p-6 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-white border border-slate-100 flex items-center justify-center shadow-sm text-slate-400 mb-3">
                            <i :class="getFileIcon(files[0].name)" class="text-3xl"></i>
                        </div>
                        
                        <p class="text-sm font-satoshi-bold text-slate-700 truncate max-w-[80%]" x-text="files[0].name"></p>
                        <p class="text-xs text-slate-400 font-satoshi-regular mt-1" x-text="files[0].size"></p>
                        
                        <!-- Delete Button (Top Right) -->
                        <button type="button" @click.stop="removeFile(files[0].id)" class="absolute top-3 right-3 h-8 w-8 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-lg border border-red-400 transition-all transform hover:scale-105">
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                </template>
            </div>
        </template>

        <!-- Multiple Files Grid (inside the dropzone container) -->
        <template x-if="multiple && files.length > 0">
            <div class="w-full h-full" @click.stop>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <template x-for="file in files" :key="file.id">
                        <div class="relative aspect-square rounded-2xl border border-slate-100 bg-white overflow-hidden flex flex-col items-center justify-center group/item p-1 shadow-sm transition-all hover:shadow-md">
                            <!-- Image Card -->
                            <template x-if="file.isImage">
                                <div class="relative w-full h-full rounded-xl overflow-hidden bg-slate-100 flex items-center justify-center">
                                    <img :src="file.preview" class="w-full h-full object-cover" alt="Preview">
                                    
                                    <!-- Overlay Details on hover/focus -->
                                    <div class="absolute inset-0 bg-slate-900/70 opacity-0 group-hover/item:opacity-100 transition-opacity duration-200 flex flex-col justify-end p-2.5 text-white text-left">
                                        <p class="text-[11px] font-satoshi-bold truncate w-full" x-text="file.name"></p>
                                        <p class="text-[9px] text-slate-300 font-satoshi-regular mt-0.5" x-text="file.size"></p>
                                    </div>
                                </div>
                            </template>

                            <!-- Non-Image Card -->
                            <template x-if="!file.isImage">
                                <div class="w-full h-full rounded-xl bg-white flex flex-col items-center justify-center p-3 text-center">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                        <i :class="getFileIcon(file.name)" class="text-xl"></i>
                                    </div>
                                    <p class="text-xs font-satoshi-bold text-slate-700 truncate w-full" x-text="file.name"></p>
                                    <p class="text-[10px] text-slate-400 font-satoshi-regular mt-0.5" x-text="file.size"></p>
                                </div>
                            </template>

                            <!-- Delete Button (Top Right) -->
                            <button type="button" @click.stop="removeFile(file.id)" class="absolute top-2 right-2 h-6 w-6 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow-md border border-red-400 transition-all transform hover:scale-105">
                                <i class="ri-close-line text-sm"></i>
                            </button>
                        </div>
                    </template>

                    <!-- Add More Card inside the grid -->
                    <div @click="triggerClick" class="relative aspect-square rounded-2xl border-2 border-dashed border-slate-200 hover:border-slate-400 hover:bg-slate-100/50 bg-slate-50 flex flex-col items-center justify-center cursor-pointer group/add transition-all duration-200">
                        <div class="w-8 h-8 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover/add:text-slate-700 group-hover/add:border-slate-200 shadow-sm transition-all">
                            <i class="ri-add-line text-lg"></i>
                        </div>
                        <span class="text-[11px] font-satoshi-bold text-slate-500 group-hover/add:text-slate-700 mt-2">Add File</span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Error Handling -->
    @if($hasError)
        <span class="mt-1.5 block text-sm font-medium text-red-600">
            {{ $errors->first($errorName) }}
        </span>
    @endif
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dropzoneComponent', (config) => ({
                    files: [],
                    isDragOver: false,
                    name: config.name,
                    multiple: config.multiple,
                    maxSize: config.maxSize,
                    
                    init() {
                        const existingUrl = config.previewUrl;
                        if (existingUrl) {
                            if (this.multiple) {
                                const urls = Array.isArray(existingUrl) 
                                    ? existingUrl 
                                    : (typeof existingUrl === 'string' && existingUrl.startsWith('[') ? JSON.parse(existingUrl) : [existingUrl]);
                                
                                urls.forEach((url, index) => {
                                    if (!url) return;
                                    const filename = typeof url === 'object' && url.name ? url.name : url.split('/').pop().split('?')[0];
                                    const fileUrl = typeof url === 'object' && url.url ? url.url : url;
                                    this.files.push({
                                        id: 'existing_' + index,
                                        name: filename,
                                        size: 'Existing File',
                                        preview: fileUrl,
                                        isImage: /\.(jpeg|jpg|gif|png|svg|webp)$/i.test(filename),
                                        isExisting: true,
                                        originalUrl: fileUrl
                                    });
                                });
                            } else if (typeof existingUrl === 'string' && existingUrl.trim() !== '') {
                                const filename = existingUrl.split('/').pop().split('?')[0];
                                this.files.push({
                                    id: 'existing',
                                    name: filename,
                                    size: 'Existing File',
                                    preview: existingUrl,
                                    isImage: /\.(jpeg|jpg|gif|png|svg|webp)$/i.test(filename),
                                    isExisting: true,
                                    originalUrl: existingUrl
                                });
                            }
                        }
                    },
                    
                    triggerClick() {
                        this.$refs.fileInput.click();
                    },
                    
                    handleFiles(event) {
                        const fileList = Array.from(event.target.files);
                        this.addFiles(fileList);
                    },
                    
                    handleDrop(event) {
                        this.isDragOver = false;
                        const fileList = Array.from(event.dataTransfer.files);
                        this.addFiles(fileList);
                    },
                    
                    validateFileType(file) {
                        const accept = '{{ $accept }}';
                        if (!accept || accept === '*' || accept === '*/*') return true;
                        
                        const rules = accept.split(',').map(r => r.trim().toLowerCase());
                        const fileName = file.name.toLowerCase();
                        const fileType = file.type.toLowerCase();
                        
                        return rules.some(rule => {
                            if (rule.startsWith('.')) {
                                return fileName.endsWith(rule);
                            } else if (rule.endsWith('/*')) {
                                const typeCategory = rule.replace('/*', '');
                                return fileType.startsWith(typeCategory);
                            } else {
                                return fileType === rule;
                            }
                        });
                    },
                    
                    getAcceptedTypesString() {
                        const accept = '{{ $accept }}';
                        if (accept === 'image/*') return 'images';
                        return accept.split(',').join(', ');
                    },

                    addFiles(fileList) {
                        if (!this.multiple) {
                            // If basic/single, revoke previous blob URL to prevent memory leaks
                            if (this.files.length > 0 && this.files[0].preview.startsWith('blob:')) {
                                URL.revokeObjectURL(this.files[0].preview);
                            }
                            this.files = [];
                        }
                        
                        fileList.forEach(file => {
                            // Validate file type
                            if (!this.validateFileType(file)) {
                                this.$dispatch('show-toast', {
                                    type: 'danger',
                                    message: `File format "${file.name}" is not supported. Please upload ${this.getAcceptedTypesString()}.`
                                });
                                return;
                            }

                            // Validate file size
                            if (file.size > this.maxSize * 1024 * 1024) {
                                this.$dispatch('show-toast', {
                                    type: 'danger',
                                    message: `File "${file.name}" is too large! Maximum allowed size is ${this.maxSize}MB.`
                                });
                                return;
                            }
                            
                            const isImage = file.type.startsWith('image/');
                            const fileId = Math.random().toString(36).substring(2, 9);
                            
                            const fileObj = {
                                id: fileId,
                                file: file,
                                name: file.name,
                                size: this.formatBytes(file.size),
                                preview: isImage ? URL.createObjectURL(file) : '',
                                isImage: isImage,
                                isExisting: false
                            };
                            
                            this.files.push(fileObj);
                        });
                        
                        this.syncFileInput();
                    },
                    
                    removeFile(id) {
                        const index = this.files.findIndex(f => f.id === id);
                        if (index !== -1) {
                            const file = this.files[index];
                            // Revoke object URL to free memory
                            if (file.preview && file.preview.startsWith('blob:')) {
                                URL.revokeObjectURL(file.preview);
                            }
                            if (file.isExisting) {
                                const removalInput = document.createElement('input');
                                removalInput.type = 'hidden';
                                removalInput.name = 'remove_' + this.name.replace('[]', '');
                                removalInput.value = file.originalUrl;
                                this.$el.appendChild(removalInput);
                            }
                            this.files.splice(index, 1);
                            this.syncFileInput();
                        }
                    },
                    
                    syncFileInput() {
                        const dataTransfer = new DataTransfer();
                        this.files.forEach(f => {
                            if (f.file) {
                                dataTransfer.items.add(f.file);
                            }
                        });
                        this.$refs.fileInput.files = dataTransfer.files;
                    },
                    
                    getFileIcon(filename) {
                        const ext = filename.split('.').pop().toLowerCase();
                        switch (ext) {
                            case 'pdf': return 'ri-file-pdf-2-line text-red-500';
                            case 'doc':
                            case 'docx': return 'ri-file-word-2-line text-blue-500';
                            case 'xls':
                            case 'xlsx': return 'ri-file-excel-2-line text-green-500';
                            case 'ppt':
                            case 'pptx': return 'ri-file-ppt-2-line text-orange-500';
                            case 'zip':
                            case 'rar':
                            case 'tar':
                            case 'gz': return 'ri-file-zip-line text-yellow-600';
                            case 'txt': return 'ri-file-text-line text-slate-500';
                            default: return 'ri-file-3-line text-slate-400';
                        }
                    },
                    
                    formatBytes(bytes) {
                        if (bytes === 0) return '0 Bytes';
                        const k = 1024;
                        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                        const i = Math.floor(Math.log(bytes) / Math.log(k));
                        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                    }
                }));
            });
        </script>
    @endpush
@endonce
