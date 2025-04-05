<script setup>
import { defineProps } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { media } = usePage().props;

const user = usePage().props.user;  // Asumiendo que el usuario está siendo pasado desde Inertia

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

                        <!-- Mostrar algo diferente si el usuario está autenticado -->
                        <div v-if="user">
                            
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <!-- Itera sobre los medios pasados al frontend -->
                            <div 
                                v-for="item in media" 
                                :key="item.id" 
                                class="bg-white shadow-lg rounded-lg overflow-hidden p-3">
                                
                                <!-- Imagen del medio (si es que hay) -->
                                <img :src="item.image_url" alt="Media" class="w-full h-48 object-cover" />
                                
                                <!-- Contenido de la tarjeta -->
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ item.name }}</h3>
                                    <p class="text-gray-600">{{ item.description }}</p>
                                    <div class="mt-4">
                                        <!-- Puedes agregar un botón u otro contenido aquí -->
                                        <Link :href="`/media/${item.id}`" class="text-blue-500 hover:underline">Ver más</Link>
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