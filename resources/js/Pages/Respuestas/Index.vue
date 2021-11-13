<template>
    <app-layout title="Respuestas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <breadcrumb ruta='' :idsArray=[] bread='Respuestas' />
                Listar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-6">
                    <div class="bg-white p-3 border border-gray-200 rounded-sm shadow-sm my-3">
                        <p class="whitespace-pre-line text-xl font-semibold">{{ comentario.contenido }}</p>
                        <div class="grid grid-cols-2">
                            <h2 class="mt-5 font-extralight text-sm">
                                {{ comentario.user.name }} - 
                                {{ convertirFechaHora(comentario.updated_at)}}
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="my-6">
                    <h2 v-if="mostrarCajaParaResponder == true" class="uppercase text-xl font-semibold text-gray-700 my-2">Respuestas</h2>
                    <h2 v-if="mostrarCajaParaResponder == false" class="uppercase text-xl font-semibold text-gray-700 my-2">Editar respuesta</h2>

                    <form method="post" @submit.prevent="submit">
                        <estructura-formulario>
                            <template #estructuraInput>
                                <estructura-input nombreLabel="" info="Es obligatorio.">
                                    <template #inputComponente>
                                        <textarea v-model="form.contenido" cols="131" rows="5" placeholder="Escribir respuesta..."></textarea>
                                    </template>
                                </estructura-input>
                            </template>
                        </estructura-formulario>

                        <guardar v-if="mostrarCajaParaResponder" />

                        <button v-if="mostrarCajaParaResponder == false" type="button" @click="actualizarRespuesta(form.contenido)" 
                            class="focus:outline-none text-white font-bold text-sm py-1 px-4 rounded-full bg-green-500 hover:bg-green-600 hover:shadow-lg">
                                Actualizar
                        </button>
                    </form>

                    <div class="my-6">
                        <div v-for="respuesta in respuestasFiltradas.data" :key="respuesta.id" 
                            class="bg-white p-3 border border-gray-200 rounded-sm shadow-sm my-3">
                            <p class="whitespace-pre-line text-xl font-semibold">{{ respuesta.contenido }}</p>
                            <div class="grid grid-cols-2">
                                <h2 class="mt-5 font-extralight text-sm">
                                    {{ respuesta.user.name }} - 
                                    {{ convertirFechaHora(respuesta.updated_at)}}
                                </h2>
                                <div class="flex justify-end">
                                    <button type="button" @click="editarRespuesta(respuesta.id, respuesta.contenido)" 
                                        class="mr-2 focus:outline-none text-white font-bold text-sm py-0.5 px-4 rounded-full bg-yellow-500 hover:bg-yellow-600 hover:shadow-lg">
                                            Editar
                                    </button>

                                    <button type="button" @click="eliminarRespuesta(respuesta.id)" 
                                        class="focus:outline-none text-white font-bold text-sm py-0.5 px-4 rounded-full bg-red-500 hover:bg-red-600 hover:shadow-lg">
                                            Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap my-3">
                        <div v-for="(link, index, key) in respuestasFiltradas.links" :key="key">
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
            comentario: Object,
            respuestas: Object,
        },

        data() {
            return {
                form: {
                    contenido: null,
                },
                mostrarCajaParaResponder: true,
                respuestaEditado_id: null,
                formEditado: {
                    contenido: null,
                },
                formPagination: {
                    page: 1,
                },
                respuestasFiltradas: this.respuestas,
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('respuestas.store', this.comentario.id), this.form)
            },

            convertirFechaHora(timestamp) {
                var fechaHoraRespuesta = new Date(timestamp)
                return fechaHoraRespuesta.toLocaleString('es-AR');
            },

            otraPagina(index) {
                this.formPagination.page = index
                axios.post(this.route('respuestas.paginarRespuestas', this.comentario.id), 
                    this.formPagination)
                .then(response => {
                    this.respuestasFiltradas = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            editarRespuesta(respuesta_id, respuesta) {
                this.mostrarCajaParaResponder = false
                this.form.contenido = respuesta
                this.respuestaEditado_id = respuesta_id
            },

            actualizarRespuesta(contenido) {
                this.formEditado.contenido = contenido
                this.$inertia.put(this.route('respuestas.update', [this.comentario.id, this.respuestaEditado_id]), this.formEditado)
                this.form.contenido = null
                this.mostrarCajaParaResponder = true
            },

            eliminarRespuesta(respuesta_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta respuesta?')) {
                    this.$inertia.delete(this.route('respuestas.destroy', [this.comentario.id, respuesta_id]))
                }
            }
        }
    })
</script>