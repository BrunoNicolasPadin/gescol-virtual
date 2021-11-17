<template>
    <app-layout title="Correcciones - Agregar">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                {{ curso.nombre }} / 
                <breadcrumb ruta='materias.index' :idsArray='[institucion.id, curso.id]' bread='Materias' />
                {{ materia.nombre }} / 
                <breadcrumb ruta='evaluaciones.index' :idsArray='[institucion.id, curso.id, materia.id]' bread='Evaluaciones' />
                <breadcrumb ruta='evaluaciones.show' :idsArray='[institucion.id, curso.id, materia.id, evaluacion.id]' :bread='evaluacion.nombre' />
                <breadcrumb ruta='entregas.index' :idsArray='[institucion.id, curso.id, materia.id, evaluacion.id]' bread='Entregas' />
                <breadcrumb ruta='entregas.show' :idsArray='[institucion.id, curso.id, materia.id, evaluacion.id, entrega.id]' :bread='entrega.alumno_materia.rol_user.user.name' />
                Correcciones / Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <form method="post" @submit.prevent="submit">
                    <estructura-formulario>
                        <template #estructuraInput>
                            
                            <estructura-input nombreLabel="Archivo" info="Es obligatorio.">
            
                                <template #inputComponente>
                                    <input ref="file" type="file" @change="processFile($event)" class="hidden">
                                    <div v-if="!form.archivo" class="p-2">
                                        <button type="button" class="px-6 py-4 bg-gray-500 hover:bg-gray-700 rounded-sm text-md font-medium text-white" @click="browse">
                                            Seleccionar archivo
                                        </button>
                                    </div>
                                    <div v-else class="flex items-center justify-between p-2">
                                        <div class="flex-1 pr-1">
                                            {{ form.archivo.name }} <span class="text-black text-md">({{ filesize(form.archivo.size) }})</span>
                                        </div>
                                        <button type="button" class="px-6 py-3 bg-gray-500 hover:bg-gray-700 rounded-sm text-xs font-medium text-white" @click="remove">
                                            Eliminar
                                        </button>
                                    </div>
                                </template>

                            </estructura-input>
                        </template>
                    </estructura-formulario>

                    <guardar />
                </form>
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

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraFormulario,
            EstructuraInput,
            InputComponente,
            Guardar,
        },

        props: {
            institucion: Object,
            curso: Object,
            materia: Object,
            evaluacion: Object,
            entrega: Object,
        },

        data() {
            return {
                form: {
                    archivo: '',
                },
            }
        },

        methods: {
            submit() {
                var formData = new FormData();
                formData.append('archivo', this.form.archivo);

                this.$inertia.post(this.route('correcciones.store', [this.institucion.id, this.curso.id, this.materia.id, this.evaluacion.id, 
                    this.entrega.id]), formData);
            },

            processFile(event) {
                this.form.archivo = event.target.files[0]
            },

            filesize(size) {
                var i = Math.floor(Math.log(size) / Math.log(1024))
                return (size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
            },

            browse() {
                this.$refs.file.click()
            },

            remove() {
                this.form.archivo = ''
            },
        }
    })
</script>
