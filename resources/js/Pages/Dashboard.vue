<script setup>
import { defineProps } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { media} = usePage().props;

const user = usePage().props.auth.user;

const isAdmin = user && user.role_id === 1;

const goToAddMedia = () => {
  window.location.href = route('media.create');
};

const editMedia = (id) => {
  window.location.href = route('media.edit', id);
};

const deleteMedia = (id) => {
  if (confirm('¿Estás seguro de que deseas eliminar este medio?')) {
    Inertia.delete(route('media.destroy', id));
  }
};

const reserveMedia = (id) => {
  // Aquí se puede manejar la lógica para reservar el medio
  alert(`Medio ${id} reservado.`);
};

</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="mx-auto max-w-7x2 sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2
                            class="text-xl font-semibold leading-tight text-gray-800">
                            Medios Disponibles
                        </h2>

                        <div v-if="isAdmin" class="mb-4 text-right">
                            <button
                                @click="goToAddMedia"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                            >
                                Agregar Medio
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <!-- Itera sobre los medios pasados al frontend -->
                            <div 
                                v-for="item in media" 
                                :key="item.id" 
                                class="bg-white shadow-xl rounded-lg border-2 border-gray-300 overflow-hidden p-2">
                                
                                <!-- Imagen del medio (si es que hay) -->
                                <img :src="item.image" alt="Media" class="w-full h-60 object-cover shadow-lg rounded-lg border border-gray-200 hover:shadow-2xl transition-all duration-300" />
                                
                                <!-- Contenido de la tarjeta -->
                                <div class="p-4">
                                    <div class="flex items-center justify-between space-x-4">
                                        <!-- Nombre del medio -->
                                        <h3 class="text-xl font-semibold text-gray-800 truncate" :title="item.name">
                                            {{ item.name }}
                                        </h3>

                                        <!-- Descripción truncada con tooltip -->
                                        <p class="text-gray-600 text-sm truncate" :title="item.description">
                                            {{ item.description }}
                                        </p>

                                        <!-- Precio -->
                                        <div class="mt-4 text-lg font-bold text-gray-900 text-right">
                                            {{ parseFloat(item.price_day).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) }}
                                        </div>
                                    </div>

                                    <div class="mt-4 flex justify-between border-t border-gray-200 pt-2">
                                        <!-- Botón Editar -->
                                        <button v-if="isAdmin" class="text-blue-500 hover:text-blue-700 p-2 rounded-full" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Botón Eliminar -->
                                        <button v-if="isAdmin" class="text-red-500 hover:text-red-700 p-2 rounded-full" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i> 
                                        </button>
                                        <!-- Botón Reservar -->
                                        <button class="text-green-500 hover:text-green-700 p-2 rounded-full" title="reservar">
                                            <i class="fas fa-bookmark"></i> <!-- Icono de reservar -->
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

<div>
        
</div>
</template>