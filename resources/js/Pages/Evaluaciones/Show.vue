<template>
    <app-layout title="Materias">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / 
                Evaluaciones / {{ evaluacion.nombre }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="">
                    <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Informacion</h2>

                    <div class="bg-white border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Nombre</span>:
                        <span>{{ evaluacion.nombre }}</span>
                    </div>
                    
                    <div class="bg-white border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Comienzo</span>:
                        <span>{{ evaluacion.fechaHoraComienzo }}</span>
                    </div>

                    <div class="bg-white border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Finalizacion</span>:
                        <span>{{ evaluacion.fechaHoraFinalizacion }}</span>
                    </div>

                    <div class="bg-white border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Descripcion</span>:
                        <p class="whitespace-pre-line">{{ evaluacion.descripcion }}</p>
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
            evaluacion: Object,
        },

        methods: {
            
        }
    })
</script>