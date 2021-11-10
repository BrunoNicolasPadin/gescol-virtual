<template>
    <app-layout title="Materias">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / 
                Clases / {{ clase.nombre }}
            </h2>
        </template>

        <button type="button" @click="cargarArchivos()">
            Cargar archivos
        </button>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-3">
                    <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Informacion</h2>

                    <div class="bg-white shadow-md border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Nombre</span>:
                        <span class="text-base">{{ clase.nombre }}</span>
                    </div>

                    <div class="bg-white shadow-md border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Descripcion</span>:
                        <p class="whitespace-pre-line text-base">{{ clase.descripcion }}</p>
                    </div>
                </div>

                <div class="my-3">
                    <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Archivos</h2>

                    <div v-for="archivo in clase.archivos" :key="archivo.id" 
                        class="bg-white border border-gray-200 p-3 text-md">
                        <a :href="'http://127.0.0.1:8000/storage/app/Clases/' + archivo.archivo" target="_blank" rel="noopener noreferrer">
                            {{ archivo.archivo }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraTabla from '@/Shared/Tabla/EstructuraTabla'
    import TdComponente from '@/Shared/Tabla/Td'
    import ThComponente from '@/Shared/Tabla/Th'
    import Editar from '@/Shared/Botones/Editar.vue'
    import Eliminar from '@/Shared/Botones/Eliminar.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraTabla,
            TdComponente,
            ThComponente,
            Editar,
            Eliminar,
            Link,
        },

        props: {
            institucion: Object,
            curso: Object,
            materia: Object,
            clase: Object,
        },

        data() {
            return {
                datos: {
                    id: this.clase.id,
                    type: 'App' + String.raw`\Models` + String.raw`\Clases` + String.raw`\Clase`,
                    carpeta: 'Clases/',
                }
            }
        },

        methods: {
            cargarArchivos() {
                this.$inertia.get(this.route('archivos.create'), this.datos)
            }
        }
    })
</script>