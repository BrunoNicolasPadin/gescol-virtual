<template>
    <app-layout title="Instituciones - Editar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <breadcrumb ruta='' :idsArray=[] bread='Instituciones' />
                Editar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="post" @submit.prevent="submit">
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
                            <estructura-input nombreLabel="Clave de acceso actual" info="Rellenar solo si quiere cambiar la clave de acceso.">
                                <template #inputComponente>
                                    <input-componente type="password" v-model="form.claveDeAccesoActual"/>
                                </template>
                            </estructura-input>
                        </template>
                    </estructura-formulario>

                    <estructura-formulario class="grid grid-cols-1 md:grid-cols-2 gap-x-2 gap-y-3">
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Clave de acceso nueva" info="Rellenar solo si quiere cambiar la clave de acceso.">
                                <template #inputComponente>
                                    <input-componente type="password" v-model="form.claveDeAcceso"/>
                                </template>
                            </estructura-input>

                            <estructura-input nombreLabel="Confirmar clave de acceso nueva" info="Rellenar solo si quiere cambiar la clave de acceso.">
                                <template #inputComponente>
                                    <input-componente type="password" v-model="form.claveDeAcceso_confirmation"/>
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
            institucion: Object,
        },

        data() {
            return {
                form: {
                    nombre: this.institucion.nombre,
                    claveDeAccesoActual: null,
                    claveDeAccesoNueva: null,
                    claveDeAccesoNueva_confirmation: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('instituciones.update', this.institucion.id), this.form);
            },
        }
    })
</script>
