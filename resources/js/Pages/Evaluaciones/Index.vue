<template>
    <app-layout title="Evaluaciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <breadcrumb ruta='' :idsArray=[] :bread='institucion.nombre' />
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                <breadcrumb ruta='materias.index' :idsArray='[institucion.id, curso.id]' bread='Materias' />
                <breadcrumb ruta='' :idsArray=[] :bread='materia.nombre' />
                Evaluaciones
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
                            <template #th-contenido>Comienza - Finaliza</template>
                        </th-componente>

                        <th-componente colspan=3>
                            <template #th-contenido>Acciones</template>
                        </th-componente>
                    </template>

                    <template #tr>
                        <tr v-for="(evaluacion, index) in evaluacionesFiltradas.data" :key="evaluacion.id" class="border-b border-gray-300">
                            <td-componente>
                                <template #td-contenido>{{ index + 1 }}</template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <Link :href="route('evaluaciones.show', [institucion.id, curso.id, materia.id, evaluacion.id])"
                                        class="hover:underline">
                                        {{ evaluacion.nombre }}
                                    </Link>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    {{ evaluacion.fechaHoraComienzo }} a {{ evaluacion.fechaHoraFinalizacion }}
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <button type="button" @click="mostrarEntregas(evaluacion.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-1 px-5 rounded-full bg-blue-500 hover:bg-blue-600 hover:shadow-lg">
                                        Entregas
                                    </button>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <editar>
                                        <template #contenido>
                                            <Link :href="route('evaluaciones.edit', [institucion.id, curso.id, materia.id, evaluacion.id])">
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
                                            <span @click="destroy(evaluacion.id)">Eliminar</span>
                                        </template>
                                    </eliminar>
                                </template>
                            </td-componente>
                        </tr>
                    </template>
                </estructura-tabla>

                <div class="flex flex-wrap my-3">
                    <div v-for="(link, index, key) in evaluacionesFiltradas.links" :key="key">
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
            materia: Object,
            evaluaciones: Object,
        },

        data() {
            return {
                evaluacionesFiltradas: this.evaluaciones,
                form: {
                    page: 1,
                }
            }
        },

        methods: {
            destroy(evaluacion_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta evaluacion?')) {
                    this.$inertia.delete(this.route('evaluaciones.destroy', [this.institucion.id, this.curso.id, this.materia.id, evaluacion_id]));
                }
            },

            otraPagina(index) {
                this.form.page = index
                axios.post(this.route('evaluaciones.paginarEvaluaciones', [this.institucion.id, this.curso.id, this.materia.id]), this.form)
                .then(response => {
                    this.evaluacionesFiltradas = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            mostrarEntregas(evaluacion_id) {
                this.$inertia.get(this.route('entregas.index', [this.institucion.id, this.curso.id, this.materia.id, evaluacion_id]))
            }
        }
    })
</script>
