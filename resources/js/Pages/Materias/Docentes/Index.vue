<template>
    <app-layout title="Materias - Docentes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / Docentes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <estructura-tabla>
                    <template #head>
                        <th-componente>
                            <template #th-contenido>#</template>
                        </th-componente>

                        <th-componente>
                            <template #th-contenido>Nombre</template>
                        </th-componente>

                        <th-componente>
                            <template #th-contenido>Acciones</template>
                        </th-componente>
                    </template>

                    <template #tr>
                        <tr v-for="(docente, index) in docentes" :key="docente.id" class="border-b border-gray-300">
                            <td-componente>
                                <template #td-contenido>{{ index + 1 }}</template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    {{ docente.user.name }}
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <eliminar>
                                        <template #contenido>
                                            <span @click="destroy(docente.id)">Eliminar</span>
                                        </template>
                                    </eliminar>
                                </template>
                            </td-componente>
                        </tr>
                    </template>
                </estructura-tabla>
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
    import Eliminar from '@/Shared/Botones/Eliminar.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraTabla,
            TdComponente,
            ThComponente,
            Eliminar,
            Link,
        },

        props: {
            institucion: Object,
            curso: Object,
            materia: Object,
            docentes: Array,
        },

        methods: {
            destroy(docente_id) {
                if (confirm('¿Estás seguro de que deseas eliminar este docente para esta esta materia?')) {
                    this.$inertia.delete(this.route('materias.docentes.destroy', [this.institucion.id, this.curso.id, this.materia.id, docente_id]));
                }
            },
        }
    })
</script>
