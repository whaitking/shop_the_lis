<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Botón de Volver y Título --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-sm border border-gray-200 text-[#002395] hover:bg-[#002395] hover:text-white hover:border-[#002395] transition-all duration-300" title="Volver al Dashboard">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-3xl font-black text-[#002395] uppercase tracking-wide">
                        Modificar Tesoro
                    </h1>
                </div>

                {{-- Badge de Estado Actual --}}
                <div class="bg-[#D4AF37]/20 text-[#002395] px-4 py-2 rounded-lg font-bold text-sm border border-[#D4AF37]/50">
                    {{ $item->name }}
                </div>
            </div>

            {{-- Contenedor del Formulario --}}
            <div class="bg-white p-8 sm:p-10 shadow-xl rounded-2xl border-t-4 border-[#D4AF37]">

                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data" id="edit-item-form" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- 1. Información Principal (Grid) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        {{-- Nombre --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Nombre de la Reliquia</label>
                            <input type="text" name="name" value="{{ old('name', $item->name) }}" class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300" required>
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Clasificación</label>
                            <div class="relative">
                                <select name="category_id" class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $item->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#002395]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Precio --}}
                        <div>
                            <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Valor Estimado (€)</label>
                            <div class="relative">
                                <input type="number" name="price" value="{{ old('price', $item->price) }}" step="0.01" min="0" class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 pl-10" required>
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#D4AF37] font-bold">€</span>
                                </div>
                            </div>
                        </div>

                        {{-- Condición --}}
                        <div>
                            <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Condición del Producto</label>
                            <div class="relative">
                                <select name="condition" class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 appearance-none cursor-pointer" required>
                                    <option value="" disabled>Selecciona el estado...</option>
                                    <option value="Nuevo" {{ $item->condition === 'Nuevo' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="Como nuevo" {{ $item->condition === 'Como nuevo' ? 'selected' : '' }}>Como nuevo</option>
                                    <option value="Usado - Buen estado" {{ $item->condition === 'Usado - Buen estado' ? 'selected' : '' }}>Usado - Buen estado</option>
                                    <option value="Usado - Aceptable" {{ $item->condition === 'Usado - Aceptable' ? 'selected' : '' }}>Usado - Aceptable</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#002395]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- 2. Descripción --}}
                    <div>
                        <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Crónica / Descripción</label>
                        <textarea name="description" class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300" rows="5" required>{{ old('description', $item->description) }}</textarea>
                    </div>

                    {{-- 3. Gestión de Imágenes Actuales --}}
                    <div class="pt-6 border-t border-gray-100">
                        <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#D4AF37]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                            </svg>
                            Imágenes Actuales
                        </label>

                        <div class="flex gap-4 overflow-x-auto pb-4 pt-2 snap-x">
                            @forelse($item->images as $image)
                            <div class="relative h-28 w-28 flex-shrink-0 snap-start group rounded-xl overflow-hidden shadow-sm border border-gray-200 hover:border-[#D4AF37] transition-all">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="h-full w-full object-cover">

                                {{-- Capa oscura al hover --}}
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button"
                                        onclick="if(confirm('¿Seguro que deseas eliminar esta imagen del archivo?')) document.getElementById('delete-photo-{{ $image->id }}').submit();"
                                        class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600 shadow-lg transform hover:scale-110 transition-all"
                                        title="Eliminar imagen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @empty
                            <div class="w-full bg-gray-50 border border-dashed border-gray-300 rounded-xl p-4 text-center">
                                <p class="text-sm text-gray-500 font-medium">Este objeto no tiene registro visual. Añade fotos para aumentar su valor.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- 4. Añadir Nuevas Imágenes --}}
                    <div class="pt-6 border-t border-gray-100">
                        <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Añadir Nuevas Imágenes
                        </label>

                        <div class="flex items-start gap-4 flex-wrap mt-4">
                            {{-- Botón de Subida --}}
                            <label for="images" class="cursor-pointer flex flex-col items-center justify-center w-28 h-28 border-2 border-dashed border-[#002395]/30 rounded-xl bg-blue-50/30 hover:bg-blue-50 hover:border-[#002395] transition-all duration-300 group shadow-sm">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-white p-2 rounded-full shadow-sm mb-2 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-[#002395]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                    </div>
                                    <p class="text-[10px] text-[#002395] font-bold uppercase tracking-widest text-center px-1">Nuevas Fotos</p>
                                </div>
                                <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" onchange="previewImages()">
                            </label>

                            {{-- Contenedor de Previsualización (JS) --}}
                            <div id="image-preview" class="flex gap-4 flex-wrap"></div>
                        </div>
                    </div>

                    {{-- 5. Botones de Acción Finales --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-8 border-t border-gray-100">
                        <button type="submit" class="flex-1 flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-4 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Guardar Cambios
                        </button>

                        <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center text-gray-600 bg-gray-100 font-bold uppercase tracking-widest py-4 rounded-xl hover:bg-gray-200 transition-colors">
                            Cancelar
                        </a>
                    </div>
                </form>

                {{-- Formularios Ocultos para Borrar Imágenes --}}
                @foreach($item->images as $image)
                <form id="delete-photo-{{ $image->id }}" action="{{ route('items.images.destroy', $image) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach

            </div>
        </div>
    </div>

    {{-- Script para previsualizar NUEVAS imágenes --}}
    <script>
        function previewImages() {
            const preview = document.getElementById('image-preview');
            const files = document.getElementById('images').files;

            preview.innerHTML = '';

            if (files) {
                Array.from(files).slice(0, 10).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'w-28 h-28 rounded-xl overflow-hidden border-2 border-transparent shadow-sm hover:border-[#D4AF37] transition-colors relative group';

                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-[#002395]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        `;

                        preview.appendChild(div);
                    }

                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</x-app-layout>