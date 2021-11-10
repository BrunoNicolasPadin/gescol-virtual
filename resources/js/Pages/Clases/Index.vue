<template>
    <app-layout title="Clases">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / Clases
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

                        <th-componente colspan=3>
                            <template #th-contenido>Acciones</template>
                        </th-componente>
                    </template>

                    <template #tr>
                        <tr v-for="(clase, index) in clasesFiltradas.data" :key="clase.id" class="border-b border-gray-300">
                            <td-componente>
                                <template #td-contenido>{{ index + 1 }}</template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <Link :href="route('clases.show', [institucion.id, curso.id, materia.id, clase.id])"
                                        class="hover:underline">
                                        {{ clase.nombre }}
                                    </Link>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <editar>
                                        <template #contenido>
                                            <Link :href="route('clases.edit', [institucion.id, curso.id, materia.id, clase.id])">
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
                                            <span @click="destroy(clase.id)">Eliminar</span>
                                        </template>
                                    </eliminar>
                                </template>
                            </td-componente>
                        </tr>
                    </template>
                </estructura-tabla>

                <div class="flex flex-wrap my-3">
                    <div v-for="(link, index, key) in clasesFiltradas.links" :key="key">
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
            clases: Object,
        },

        data() {
            return {
                clasesFiltradas: this.clases,
                form: {
                    page: 1,
                }
            }
        },

        methods: {
            destroy(clase_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta clase?')) {
                    this.$inertia.delete(this.route('clases.destroy', [this.institucion.id, this.curso.id, this.materia.id, clase_id]));
                }
            },

            otraPagina(index) {
                this.form.page = index
                axios.post(this.route('clases.paginarClases', [this.institucion.id, this.curso.id, this.materia.id]), this.form)
                .then(response => {
                    this.clasesFiltradas = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },
        }
    })
</script>
