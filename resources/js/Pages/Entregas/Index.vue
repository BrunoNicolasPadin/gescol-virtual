<template>
    <app-layout title="Entregas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / Evaluaciones / 
                {{ evaluacion.nombre }} / Entregas
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
                            <template #th-contenido>Alumno</template>
                        </th-componente>

                        <th-componente colspan=3>
                            <template #th-contenido>Acciones</template>
                        </th-componente>
                    </template>

                    <template #tr>
                        <tr v-for="(entrega, index) in entregas" :key="entrega.id" class="border-b border-gray-300">
                            <td-componente>
                                <template #td-contenido>{{ index + 1 }}</template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    {{ entrega.alumno_materia.rol_user.user.name }}
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <button type="button" @click="mostrarEntrega(entrega.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-1 px-5 rounded-full bg-blue-500 hover:bg-blue-600 hover:shadow-lg">
                                        Ver
                                    </button>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <editar>
                                        <template #contenido>
                                            <Link :href="route('entregas.edit', [institucion.id, curso.id, materia.id, evaluacion.id, entrega.id])">
                                                Calificar
                                            </Link>
                                        </template>
                                    </editar>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <eliminar>
                                        <template #contenido>
                                            <span @click="destroy(entrega.id)">Eliminar</span>
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
            entregas: Array,
        },

        methods: {
            destroy(entrega_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta evaluacion?')) {
                    this.$inertia.delete(this.route('entregas.destroy', [this.institucion.id, this.curso.id, this.materia.id, this.evaluacion.id, entrega_id]));
                }
            },

            mostrarEntrega(entrega_id) {
                this.$inertia.get(this.route('entregas.show', [this.institucion.id, this.curso.id, this.materia.id, this.evaluacion.id, entrega_id]))
            }
        }
    })
</script>
