<template>
    <app-layout title="Materias - Docentes - Agregar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / Docentes / Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="post" @submit.prevent="submit">
                    <estructura-formulario>
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Seleccionar rol a mostrar" info="Es obligatorio.">
                                <template #inputComponente>
                                    <select v-model="formRol.rol_id" autofocus @change="rolSeleccionado()">
                                        <option selected disabled value="">Seleccionar un rol</option>
                                        <option v-for="rol in roles" :key="rol.id" :value="rol.id">
                                            {{ rol.nombre }}
                                        </option>
                                    </select>
                                </template>
                            </estructura-input>
                        </template>
                    </estructura-formulario>
                </form>

                <form v-if="mostrarDocentesSelect" method="post" @submit.prevent="submit">
                    <div v-for="(form, index) in form.docentesMateria" :key="index" class="w-full">
                        <estructura-formulario>
                            <template #estructuraInput>
                                <estructura-input nombreLabel="Docente" info="Es obligatorio.">
                                    <template #inputComponente>
                                        <select v-model="form.docente_id">
                                            <option selected disabled value="">Seleccionar un docente</option>
                                            <option v-for="docente in docentes" :key="docente.id" :value="docente.id">
                                                {{ docente.user.name }}
                                            </option>
                                        </select>
                                    </template>
                                </estructura-input>
                            </template>
                        </estructura-formulario>

                        <estructura-formulario>
                            <template #estructuraInput>
                                <button 
                                @click="quitarDocente(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Quitar docente
                                </button>
                            </template>
                        </estructura-formulario>
                    </div>

                    <div class="flex justify-first">
                        <button 
                        @click="agregarOtroDocente()"
                        type="button" 
                        class="border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                            Agregar otro docente
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
            curso: Object,
            materia: Object,
            roles: Array,
        },

        data() {
            return {
                formRol: {
                        rol_id: '',
                },
                mostrarDocentesSelect: false,
                form: {
                    docentesMateria: [{
                        docente_id: '',
                    }],
                },
                docentes: null,
            }
        },

        methods: {
            rolSeleccionado() {
                axios.post(this.route('materias.docentes.obtenerDocentes', [this.institucion.id, this.curso.id, this.materia.id]), this.formRol)
                .then(response => {
                    this.mostrarDocentesSelect = true
                    this.docentes = response.data
                })
                .catch(e => {
                    alert('Ocurrió un error pero no es tu culpa. Mejor inténtalo mas tarde.');
                })
            },

            submit() {
                this.$inertia.post(this.route('materias.docentes.store', [this.institucion.id, this.curso.id, this.materia.id]), this.form);
            },

            agregarOtroDocente() {
                this.form.docentesMateria.push({
                    docente_id: null,
                });
            },

            quitarDocente(index) {
                this.form.docentesMateria.splice(index, 1);
            },
        }
    })
</script>
