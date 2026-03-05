<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Botón de Volver y Título --}}
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-10 h-10 rounded-full bg-white shadow-sm border border-gray-200 text-[#002395] hover:bg-[#002395] hover:text-white hover:border-[#002395] transition-all duration-300" title="Volver al Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-black text-[#002395] uppercase tracking-wide">
                    Consagrar un Tesoro
                </h1>
            </div>

            {{-- Contenedor del Formulario --}}
            <div class="bg-white p-8 sm:p-10 shadow-xl rounded-2xl border-t-4 border-[#D4AF37]">

                <p class="text-gray-500 mb-8 font-medium">Ofrece tu artículo a los miembros de SHOPTHELIS. Sé detallista en tu descripción para asegurar una transacción exitosa.</p>

                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- 1. Información Principal (Grid) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        {{-- Nombre --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Nombre de la Reliquia</label>
                            <input type="text" name="name" placeholder="Ej: Reloj Vintage 1970..." class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300" required>
                        </div>

                        {{-- Categoría --}}
                        <div>
                            <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Clasificación</label>
                            <div class="relative">
                                <select name="category_id" class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 appearance-none cursor-pointer">
                                    <option value="" disabled selected>Selecciona una clase...</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                <input type="number" name="price" step="0.01" min="0" placeholder="0.00" class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300 pl-10" required>
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-[#D4AF37] font-bold">€</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- 2. Descripción --}}
                    <div>
                        <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Crónica / Descripción</label>
                        <textarea name="description" placeholder="Cuenta la historia de este objeto, su estado de conservación, dimensiones..." class="w-full border-gray-200 bg-gray-50 focus:bg-white rounded-lg shadow-inner focus:ring-2 focus:ring-[#D4AF37] focus:border-transparent transition-all duration-300" rows="5" required></textarea>
                    </div>

                    {{-- 3. Galería de Imágenes --}}
                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-bold text-[#002395] uppercase tracking-wider mb-2">Galería Visual</label>
                        <p class="text-xs text-gray-500 mb-4">La primera imagen será la portada. Puedes subir hasta 10 archivos (JPG, PNG, WEBP).</p>

                        <div class="flex items-start gap-4 flex-wrap">
                            {{-- Botón de Subida --}}
                            <label for="images" class="cursor-pointer flex flex-col items-center justify-center w-32 h-32 border-2 border-dashed border-[#002395]/30 rounded-xl bg-blue-50/30 hover:bg-blue-50 hover:border-[#002395] transition-all duration-300 group">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-white p-2 rounded-full shadow-sm mb-2 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-[#002395]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <p class="text-[10px] text-[#002395] font-bold uppercase tracking-widest text-center px-2">Subir Fotos</p>
                                </div>
                                <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" onchange="previewImages()">
                            </label>

                            {{-- Contenedor de Previsualización (JS) --}}
                            <div id="image-preview" class="flex gap-4 flex-wrap"></div>
                        </div>
                    </div>

                    {{-- 4. Botón de Acción --}}
                    <div class="pt-6">
                        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#002395] text-white font-black uppercase tracking-widest py-4 rounded-xl shadow-lg hover:bg-[#D4AF37] hover:text-[#002395] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Publicar en el Mercado
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Script para previsualizar imágenes --}}
    <script>
        function previewImages() {
            const preview = document.getElementById('image-preview');
            const files = document.getElementById('images').files;

            preview.innerHTML = ''; // Limpiar previsualizaciones anteriores

            if (files) {
                Array.from(files).slice(0, 10).forEach(file => { // Límite visual de 10
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'w-32 h-32 rounded-xl overflow-hidden border-2 border-transparent shadow-sm hover:border-[#D4AF37] transition-colors relative group';

                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-[#002395]/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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