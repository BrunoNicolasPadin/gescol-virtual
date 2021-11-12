<template>
    <app-layout title="Instituciones - Inscripcion - Agregar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Inscripcion / Editar
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
                                        <option selected disabled value="">Seleccionar una opcion</option>
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
            roles: Array,
            inscripcion: Object,
        },

        data() {
            return {
                form: {
                    rol_id: this.inscripcion.rol_id,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('instituciones.inscripciones.update', [this.institucion.id, this.inscripcion.id]), this.form);
            },
        }
    })
</script>
