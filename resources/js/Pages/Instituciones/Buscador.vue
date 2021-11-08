<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <estructura-buscador :titulo="'Instituciones'">
                    <template #buscador-input>
                        <input class="text-2xl placeholder-gray-600 text-gray-800 pb-4 pt-5 pl-20 pr-4 rounded w-full border-b-4 focus:outline-none focus:border-blue-800" 
                        type="text" 
                        placeholder="Buscar..."
                        v-model="form.nombre"
                        @keyup="buscar()">
                    </template>
                </estructura-buscador>

                <div v-for="institucion in institucionesFiltradas.data" :key="institucion.id"
                    class="grid grid-cols-2 bg-white p-4 rounded-md shadow-md border-2 border-green-500 my-4">
                    <h1 class="text-2xl font-semibold">
                        {{ institucion.nombre }}
                    </h1>
                    <div class="flex justify-end">
                        <agregar>
                            <template #link>
                                <Link :href="route('instituciones.inscripciones.create', institucion.id)">
                                    Inscribirme
                                </Link>
                            </template>
                        </agregar>
                    </div>
                </div>
                    

                <div class="flex flex-wrap my-3">
                    <div v-for="(link, index, key) in institucionesFiltradas.links" :key="key">
                        <button @click="otraPagina(link.label)" 
                        class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-black rounded hover:bg-white" 
                        :class="{ 'bg-white': link.active }" v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraBuscador from '@/Shared/Buscador/EstructuraBuscador'
    import Agregar from '@/Shared/Botones/Agregar.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            AppLayout,
            EstructuraBuscador,
            Agregar,
            Link,
        },

        props: {
            instituciones: Object,
        },

        data() {
            return {
                institucionesFiltradas: this.instituciones,
                form: {
                    page: 1,
                    nombre: '',
                }
            }
        },

        methods: {
            buscar() {
                this.form.page = 1
                axios.post(this.route('instituciones.filtrarInstituciones'), this.form)
                .then(response => {
                    this.institucionesFiltradas = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            otraPagina(index) {
                this.form.page = index
                axios.post(this.route('instituciones.filtrarInstituciones'), this.form)
                .then(response => {
                    this.institucionesFiltradas = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },
        }
    }
</script>