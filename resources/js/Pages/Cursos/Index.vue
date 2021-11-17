<template>
    <app-layout title="Cursos">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                Cursos
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

                        <th-componente colspan=3>
                            <template #th-contenido>Acciones</template>
                        </th-componente>
                    </template>

                    <template #tr>
                        <tr v-for="(curso, index) in cursosFiltrados.data" :key="curso.id" class="border-b border-gray-300">
                            <td-componente>
                                <template #td-contenido>{{ index + 1 }}</template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    {{ curso.nombre }}
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <button type="button" @click="mostrarMaterias(curso.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-1 px-5 rounded-full bg-pink-500 hover:bg-pink-600 hover:shadow-lg">
                                        Materias
                                    </button>
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <editar>
                                        <template #contenido>
                                            <Link :href="route('cursos.edit', [institucion.id, curso.id])">
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
                                            <span @click="destroy(curso.id)">Eliminar</span>
                                        </template>
                                    </eliminar>
                                </template>
                            </td-componente>
                        </tr>
                    </template>
                </estructura-tabla>

                <div class="flex flex-wrap my-3">
                    <div v-for="(link, index, key) in cursosFiltrados.links" :key="key">
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
            cursos: Object,
        },

        data() {
            return {
                cursosFiltrados: this.cursos,
                form: {
                    page: 1,
                }
            }
        },

        methods: {
            destroy(curso_id) {
                if (confirm('¿Estás seguro de que deseas eliminar este curso?')) {
                    this.$inertia.delete(this.route('cursos.destroy', [this.institucion.id, curso_id]));
                }
            },

            mostrarMaterias(curso_id) {
                this.$inertia.get(this.route('materias.index', [this.institucion.id, curso_id]));
            },

            otraPagina(index) {
                this.form.page = index
                axios.post(this.route('cursos.paginarCursos', this.institucion.id), this.form)
                .then(response => {
                    this.cursosFiltrados = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },
        }
    })
</script>
