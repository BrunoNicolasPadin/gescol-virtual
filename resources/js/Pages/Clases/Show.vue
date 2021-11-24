<template>
    <app-layout title="Clase">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                {{ curso.nombre }} / 
                <breadcrumb ruta='materias.index' :idsArray='[institucion.id, curso.id]' bread='Materias' />
                {{ materia.nombre }} / 
                <breadcrumb ruta='clases.index' :idsArray='[institucion.id, curso.id, materia.id]' bread='Clases' />
                {{ clase.nombre }}
            </h2>
        </template>

        <!-- <button type="button" @click="cargarArchivos()">
            Cargar archivos
        </button> -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="my-3">
                    <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Información</h2>

                    <div class="bg-white shadow-md border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Nombre</span>:
                        <span class="text-base">{{ clase.nombre }}</span>
                    </div>

                    <div class="bg-white shadow-md border border-gray-200 p-3 text-lg">
                        <span class="font-semibold">Descripción</span>:
                        <p class="whitespace-pre-line text-base">{{ clase.descripcion }}</p>
                    </div>
                </div>

                <div class="my-3">
                    <h2 class="uppercase text-xl font-semibold text-gray-700 my-2">Archivos</h2>

                    <div v-for="archivo in clase.archivos" :key="archivo.id" 
                        class="bg-white border border-gray-200 p-3 text-md">
                        <a :href="'storage/Clases/' + archivo.archivo" target="_blank" rel="noopener noreferrer">
                            {{ archivo.archivo }}
                        </a>
                    </div>
                </div>

                <div class="my-6">
                    <h2 v-if="mostrarCajaParaComentar == true" class="uppercase text-xl font-semibold text-gray-700 my-2">Comentarios</h2>
                    <h2 v-if="mostrarCajaParaComentar == false" class="uppercase text-xl font-semibold text-gray-700 my-2">Editar comentario</h2>

                    <form method="post" @submit.prevent="submit">
                        <estructura-formulario>
                            <template #estructuraInput>
                                <estructura-input nombreLabel="" info="Es obligatorio.">
                                    <template #inputComponente>
                                        <textarea v-model="form.contenido" cols="131" rows="5" placeholder="Escribir comentario..."></textarea>
                                    </template>
                                </estructura-input>
                            </template>
                        </estructura-formulario>

                        <guardar v-if="mostrarCajaParaComentar" />

                        <button v-if="mostrarCajaParaComentar == false" type="button" @click="actualizarComentario(form.contenido)" 
                            class="focus:outline-none text-white font-bold text-sm py-1 px-4 rounded-full bg-green-500 hover:bg-green-600 hover:shadow-lg">
                                Actualizar
                        </button>
                    </form>

                    <div class="my-6">
                        <div v-for="comentario in clase.comentarios.data" :key="comentario.id" 
                            class="bg-white p-3 border border-gray-200 rounded-sm shadow-sm my-3">
                            <p class="whitespace-pre-line text-xl font-semibold">{{ comentario.contenido }}</p>
                            <div class="grid grid-cols-2">
                                <h2 class="mt-5 font-extralight text-sm">
                                    {{ comentario.user.name }} - 
                                    {{ convertirFechaHora(comentario.updated_at)}} - 
                                    <Link :href="route('respuestas.index', comentario.id)" class="hover:underline">
                                        Respuestas
                                    </Link>
                                </h2>
                                <div class="flex justify-end">
                                    <button type="button" @click="editarComentario(comentario.id, comentario.contenido)" 
                                        class="mr-2 focus:outline-none text-white font-bold text-sm py-0.5 px-4 rounded-full bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg">
                                            Editar
                                    </button>

                                    <button type="button" @click="eliminarComentario(comentario.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-0.5 px-4 rounded-full bg-red-500 hover:bg-red-600 hover:shadow-lg">
                                            Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap my-3">
                        <div v-for="(link, index, key) in clase.comentarios.links" :key="key">
                            <button @click="otraPagina(link.label)" 
                            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border border-black rounded hover:bg-white" 
                            :class="{ 'bg-white': link.active }" v-html="link.label" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraFormulario from '@/Shared/Formulario/EstructuraFormulario'
    import EstructuraInput from '@/Shared/Formulario/EstructuraInput'
    import InputComponente from '@/Shared/Formulario/InputComponente'
    import Guardar from '@/Shared/Botones/Guardar'
    import { Link } from '@inertiajs/inertia-vue3';
    import Breadcrumb from '@/Shared/Cabecera/Breadcrumb.vue';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraFormulario,
            EstructuraInput,
            InputComponente,
            Guardar,
            Link,
            Breadcrumb,
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
                },
                form: {
                    contenido: null,
                    id: this.clase.id,
                    type: 'App' + String.raw`\Models` + String.raw`\Clases` + String.raw`\Clase`,
                },
                mostrarCajaParaComentar: true,
                comentarioEditado_id: null,
                formEditado: {
                    contenido: null,
                },
                formPagination: {
                    page: 1,
                }
            }
        },

        methods: {
            cargarArchivos() {
                this.$inertia.get(this.route('archivos.create'), this.datos)
            },

            submit() {
                this.$inertia.post(this.route('comentarios.store'), this.form)
            },

            convertirFechaHora(timestamp) {
                var fechaHoraComentario = new Date(timestamp)
                return fechaHoraComentario.toLocaleString('es-AR');
            },

            otraPagina(index) {
                this.formPagination.page = index
                axios.post(this.route('clases.paginarComentarios', [this.institucion.id, this.curso.id, this.materia.id, this.clase.id]), 
                    this.formPagination)
                .then(response => {
                    this.clase.comentarios = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            editarComentario(comentario_id, comentario) {
                this.mostrarCajaParaComentar = false
                this.form.contenido = comentario
                this.comentarioEditado_id = comentario_id
            },

            actualizarComentario(contenido) {
                this.formEditado.contenido = contenido
                this.$inertia.put(this.route('comentarios.update', this.comentarioEditado_id), this.formEditado)
                this.form.contenido = null
                this.mostrarCajaParaComentar = true
            },

            eliminarComentario(comentario_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta comentario?')) {
                    this.$inertia.delete(this.route('comentarios.destroy', comentario_id))
                }
            }
        }
    })
</script>