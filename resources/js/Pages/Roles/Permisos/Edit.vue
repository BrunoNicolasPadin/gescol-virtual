<template>
    <app-layout title="Instituciones - Permisos - Editar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Permisos / {{ permiso.name }} / Editar
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
            permiso: Object,
        },

        data() {
            return {
                form: {
                    nombre: this.permiso.name,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('permisos.update', [this.institucion.id, this.permiso.id]), this.form);
            },
        }
    })
</script>
