<template>
    <app-layout title="Cursos - Agregar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="post" @submit.prevent="submit">
                    <div v-for="(form, index) in form.cursos" :key="index" class="w-full">
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
                                @click="quitarCurso(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Quitar curso
                                </button>
                            </template>
                        </estructura-formulario>
                    </div>

                    <div class="flex justify-first">
                        <button 
                        @click="agregarOtroCurso()"
                        type="button" 
                        class="border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                            Agregar otro curso
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
        },

        data() {
            return {
                form: {
                    cursos: [{
                        nombre: null,
                    }],
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('cursos.store', this.institucion.id), this.form);
            },

            agregarOtroCurso() {
                this.form.cursos.push({
                    nombre: null,
                });
            },

            quitarCurso(index) {
                this.form.cursos.splice(index, 1);
            },
        }
    })
</script>
