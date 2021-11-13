<template>
    <app-layout title="Archivos - Agregar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <breadcrumb ruta='' :idsArray=[] bread='Archivos' />
                Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
    import Breadcrumb from '@/Shared/Cabecera/Breadcrumb.vue';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraFormulario,
            EstructuraInput,
            InputComponente,
            Guardar,
            Breadcrumb,
        },

        props: {
            id: String,
            type: String,
            carpeta: String,
        },

        data() {
            return {
                form: {
                    archivo: '',
                    id: this.id,
                    type: this.type,
                    carpeta: this.carpeta,
                },
            }
        },

        methods: {
            submit() {
                var formData = new FormData();
                formData.append('archivo', this.form.archivo);
                formData.append('id', this.form.id);
                formData.append('type', this.form.type);
                formData.append('carpeta', this.form.carpeta);

                this.$inertia.post(this.route('archivos.store'), formData);
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
