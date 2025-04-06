<script setup>
    import { defineProps, ref, onMounted } from 'vue'
    import { usePage, Head } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

    const { media } = usePage().props
    const user = usePage().props.auth.user
    const locations = ref([]);
    const types = ref([]);
    const isAdmin = user && user.role_id === 1

    const fetchLocations = async () => {
        try {
            const response = await fetch('/locations');
            const data = await response.json();
            locations.value = data;
        } catch (error) {
            console.error('Error fetching locations:', error);
        }
    };

    const fetchTypes = async () => {
        try {
            const response = await fetch('/types');
            const data = await response.json();
            types.value = data;
        } catch (error) {
            console.error('Error fetching types:', error)
        }
    };

    onMounted(() => {
        fetchLocations();
        fetchTypes()
    });

    const goToAddMedia = () => {
    window.location.href = route('media.create')
    }

    const editMedia = (id) => {
    window.location.href = route('media.edit', id)
    }

    const deleteMedia = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este medio?')) {
        Inertia.delete(route('media.destroy', id))
    }
    }

    const reserveMedia = (id) => {
    // Aquí se puede manejar la lógica para reservar el medio
    alert(`Medio ${id} reservado.`)
    }

    const showModal = ref(false)

    const modalRef = ref(null)

    const openModal = () => {
    showModal.value = true
    // Asegurar foco para capturar ESC
    nextTick(() => {
        modalRef.value?.focus()
    })
    }

    const closeModal = () => {
    showModal.value = false
    }

    const form = ref({
    name: '',
    price_day: '',
    // Agrega los demás campos según los necesites
    })

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
                                @click="showModal = true"
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

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.self="closeModal">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative"
            @keydown.esc="closeModal"
            tabindex="0"
            ref="modalRef">
            <!-- Botón cerrar -->
            <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>

            <!-- Contenido del modal -->
            <h2 class="text-xl font-bold mb-4">Crear nuevo medio</h2>

            <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-4">
                
                <!-- Nombre -->
                <div>
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input v-model="form.name" type="text" class="w-full border rounded p-2" required>
                </div>

                <!-- Ubicación -->
                <div>
                <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                <select v-model="form.location_id" class="w-full border rounded p-2" required>
                    <option value="" disabled>Selecciona una ubicación</option>
                    <option v-for="loc in locations" :key="loc.id" :value="loc.id">{{ loc.name }}</option>
                </select>
                </div>

                <!-- Tipo -->
                <div>
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select v-model="form.type_id" class="w-full border rounded p-2" required>
                    <option value="" disabled>Selecciona un tipo</option>
                    <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
                </select>
                </div>

                <!-- Imagen -->
                <div>
                <label class="block text-sm font-medium text-gray-700">Imagen</label>
                <input type="file" @change="handleImage" accept="image/*" class="w-full border rounded p-2">
                </div>

                <!-- Precio -->
                <div>
                <label class="block text-sm font-medium text-gray-700">Precio por día (MXN)</label>
                <input v-model="form.price_day" type="number" step="0.01" min="0" class="w-full border rounded p-2" required>
                </div>

                <!-- Botón Enviar -->
                <div class="text-right">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            showModal: Boolean,
        },
        data() {
            return {
            locations: [], // Para las ubicaciones
            types: [],     // Para los tipos de medios
            form: {
                location_id: '',
                type_id: '',
            }
            };
        },

        methods: {
            openModal() {
                this.$emit('openModal');
            },
            closeModal() {
                this.$emit('closeModal');
            },
            async fetchLocations() {
                const response = await fetch('/locations');
                const data = await response.json();
                console.log(data);
                
                this.locations = data;
            },
            async fetchTypes() {
                const response = await fetch('/types');  // Llamamos al controlador que retorna los tipos de medios
                const data = await response.json();
                this.types = data;
            }
        },
        watch: {
            showModal(newValue) {
                if (newValue) {
                    // Lógica al abrir el modal, si es necesario
                    this.$nextTick(() => {
                        // Asegura que el modal tenga el foco si es necesario
                        this.$refs.modalRef?.focus();
                    });
                }
            }
        },
        
        methods: {
            
        }
    };
</script>

<style scoped>
/* Estilos del modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-container {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
}
.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;
}
</style>