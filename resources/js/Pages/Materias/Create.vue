<template>
    <app-layout title="Materias - Agregar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <breadcrumb ruta='' :idsArray=[] :bread='institucion.nombre' />
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                <breadcrumb ruta='materias.index' :idsArray='[institucion.id, curso.id]' bread='Materias' />
                Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="post" @submit.prevent="submit">
                    <div v-for="(form, index) in form.materias" :key="index" class="w-full">
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
                                @click="quitarMateria(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Quitar materia
                                </button>
                            </template>
                        </estructura-formulario>
                    </div>

                    <div class="flex justify-first">
                        <button 
                        @click="agregarOtraMateria()"
                        type="button" 
                        class="border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                            Agregar otra materia
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
            institucion: Object,
            curso: Object,
        },

        data() {
            return {
                form: {
                    materias: [{
                        nombre: null,
                    }],
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('materias.store', [this.institucion.id, this.curso.id]), this.form);
            },

            agregarOtraMateria() {
                this.form.materias.push({
                    nombre: null,
                });
            },

            quitarMateria(index) {
                this.form.materias.splice(index, 1);
            },
        }
    })
</script>
