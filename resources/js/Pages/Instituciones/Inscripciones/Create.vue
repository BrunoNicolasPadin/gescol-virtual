<template>
    <app-layout title="Instituciones - Inscripcion - Agregar">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                <breadcrumb ruta='panel.mostrarInicio' :idsArray=[] bread='Panel / Tus roles' />
                Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="post" @submit.prevent="submit">
                    <estructura-formulario>
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Seleccionar tu rol en el colegio" info="Es obligatorio.">
                                <template #inputComponente>
                                    <select v-model="form.rol_id" autofocus>
                                        <option selected disabled value="">Seleccionar un rol</option>
                                        <option v-for="rol in roles" :key="rol.id" :value="rol.id">{{ rol.nombre }}</option>
                                    </select>
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
            roles: Array,
        },

        data() {
            return {
                form: {
                    rol_id: '',
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('instituciones.inscripciones.store', this.institucion.id), this.form);
            },
        }
    })
</script>
