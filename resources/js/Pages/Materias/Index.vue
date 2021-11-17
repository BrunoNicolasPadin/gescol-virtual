<template>
    <app-layout title="Materias">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                {{ curso.nombre }} / 
                Materias
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <estructura-tabla>
                    <template #head>
                        <th-componente>
                            <template #th-contenido>#</template>
                        </th-componente>

                        <th-componente>
                            <template #th-contenido>Nombre</template>
                        </th-componente>

                        <th-componente colspan=6>
                            <template #th-contenido>Acciones</template>
                        </th-componente>
                    </template>

                    <template #tr>
                        <tr v-for="(materia, index) in materias" :key="materia.id" class="border-b border-gray-300">
                            <td-componente>
                                <template #td-contenido>{{ index + 1 }}</template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    {{ materia.nombre }}
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <button type="button" @click="anotarse(materia.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-1 px-5 rounded-full bg-blue-800 hover:bg-blue-900 hover:shadow-lg">
                                        Anotarse
                                    </button>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <button type="button" @click="mostrarClases(materia.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-1 px-5 rounded-full bg-green-500 hover:bg-green-600 hover:shadow-lg">
                                        Clases
                                    </button>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <button type="button" @click="mostrarEvaluaciones(materia.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-1 px-5 rounded-full bg-blue-500 hover:bg-blue-600 hover:shadow-lg">
                                        Evaluaciones
                                    </button>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <button type="button" @click="mostrarDocentes(materia.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-1 px-5 rounded-full bg-pink-500 hover:bg-pink-600 hover:shadow-lg">
                                        Docentes
                                    </button>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <editar>
                                        <template #contenido>
                                            <Link :href="route('materias.edit', [institucion.id, curso.id, materia.id])">
                                                Editar
                                            </Link>
                                        </template>
                                    </editar>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <eliminar>
                                        <template #contenido>
                                            <span @click="destroy(materia.id)">Eliminar</span>
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
    import Editar from '@/Shared/Botones/Editar.vue'
    import Eliminar from '@/Shared/Botones/Eliminar.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import Breadcrumb from '@/Shared/Cabecera/Breadcrumb.vue';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraTabla,
            TdComponente,
            ThComponente,
            Editar,
            Eliminar,
            Link,
            Breadcrumb,
        },

        props: {
            institucion: Object,
            curso: Object,
            materias: Array,
        },

        methods: {
            destroy(materia_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta materia?')) {
                    this.$inertia.delete(this.route('materias.destroy', [this.institucion.id, this.curso.id, materia_id]));
                }
            },

            mostrarDocentes(materia_id) {
                this.$inertia.get(this.route('materias.docentes.index', [this.institucion.id, this.curso.id, materia_id]));
            },

            mostrarEvaluaciones(materia_id) {
                this.$inertia.get(this.route('evaluaciones.index', [this.institucion.id, this.curso.id, materia_id]));
            },

            mostrarClases(materia_id) {
                this.$inertia.get(this.route('clases.index', [this.institucion.id, this.curso.id, materia_id]));
            },

            anotarse(materia_id) {
                this.$inertia.post(this.route('materias.alumnos.store', [this.institucion.id, this.curso.id, materia_id]));
            }
        }
    })
</script>
