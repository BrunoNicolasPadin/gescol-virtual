<template>
    <app-layout title="Instituciones - Permisos - Agregar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Permisos / Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="post" @submit.prevent="submit">
                    <div v-for="(form, index) in form.permisos" :key="index" class="w-full">
                        <estructura-formulario>
                            <template #estructuraInput>
                                <estructura-input nombreLabel="Nombre" info="Es obligatorio.">
                                    <template #inputComponente>
                                        <input-componente type="text" v-model="form.nombre" autofocus/>
                                    </template>
                                </estructura-input>
                            </template>
                        </estructura-formulario>

                        <estructura-formulario>
                            <template #estructuraInput>
                                <button 
                                @click="quitarPermiso(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Quitar permiso
                                </button>
                            </template>
                        </estructura-formulario>
                    </div>

                    <div class="flex justify-first">
                        <button 
                        @click="agregarOtroPermiso()"
                        type="button" 
                        class="border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                            Agregar otro permiso
                        </button>
                    </div>

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
        },

        data() {
            return {
                form: {
                    permisos: [{
                        nombre: null,
                    }],
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('permisos.store', this.institucion.id), this.form);
            },

            agregarOtroPermiso() {
                this.form.permisos.push({
                    nombre: null,
                });
            },

            quitarPermiso(index) {
                this.form.permisos.splice(index, 1);
            },
        }
    })
</script>
