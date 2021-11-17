<template>
    <app-layout title="Instituciones - Roles - Agregar">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} /
                <breadcrumb ruta='panel.mostrarRoles' :idsArray='[institucion.id]' bread='Roles' />
                Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <form method="post" @submit.prevent="submit">
                    <div v-for="(form, index) in form.roles" :key="index" class="w-full">
                        <estructura-formulario>
                            <template #estructuraInput>
                                <estructura-input nombreLabel="Nombre" info="Es obligatorio.">
                                    <template #inputComponente>
                                        <input-componente type="text" v-model="form.nombre" autofocus/>
                                    </template>
                                </estructura-input>
                            </template>
                        </estructura-formulario>

                        <estructura-formulario class="grid grid-cols-2 gap-x-3">
                            <template #estructuraInput>
                                <estructura-input nombreLabel="Clave de acceso para elegir rol" 
                                    info="Es obligatorio. Los usuarios que seleccionen registrarse en tu institucion con este rol deberan ingresar 
                                    esta clave de acceso">
                                    <template #inputComponente>
                                        <input-componente type="password" v-model="form.claveDeAcceso"/>
                                    </template>
                                </estructura-input>

                                <estructura-input nombreLabel="Confirmar clave de acceso" info="Es obligatorio.">
                                    <template #inputComponente>
                                        <input-componente type="text" v-model="form.claveDeAcceso_confirmation"/>
                                    </template>
                                </estructura-input>
                            </template>
                        </estructura-formulario>

                        <estructura-formulario>
                            <template #estructuraInput>
                                <button 
                                @click="quitarRol(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Quitar rol
                                </button>
                            </template>
                        </estructura-formulario>
                    </div>

                    <div class="flex justify-first">
                        <button 
                        @click="agregarOtroRol()"
                        type="button" 
                        class="border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                            Agregar otro rol
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
                    roles: [{
                        nombre: null,
                        claveDeAcceso: null,
                        claveDeAcceso_confirmation: null,
                    }],
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('roles.store', this.institucion.id), this.form);
            },

            agregarOtroRol() {
                this.form.roles.push({
                    nombre: null,
                });
            },

            quitarRol(index) {
                this.form.roles.splice(index, 1);
            },
        }
    })
</script>
