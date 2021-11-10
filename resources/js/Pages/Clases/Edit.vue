<template>
    <app-layout title="Clases - Editar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / Clases / Editar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
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
                            <estructura-input nombreLabel="Descripcion" info="Es obligatorio.">
                                <template #inputComponente>
                                    <textarea v-model="form.descripcion" cols="131" rows="10"></textarea>
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
            curso: Object,
            materia: Object,
            clase: Object,
        },

        data() {
            return {
                form: {
                    nombre: this.clase.nombre,
                    descripcion: this.clase.descripcion,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('clases.update', [this.institucion.id, this.curso.id, this.materia.id, this.clase.id]), this.form);
            },
        }
    })
</script>
