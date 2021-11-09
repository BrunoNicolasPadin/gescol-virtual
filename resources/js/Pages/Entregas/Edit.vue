<template>
    <app-layout title="Entregas - Calificar">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Instituciones / {{ institucion.nombre }} / Cursos / {{ curso.nombre }} / Materias / {{ materia.nombre }} / Evaluaciones / 
                {{ evaluacion.nombre }} / Entregas / Calificar a {{ entrega.alumno_materia.rol_user.user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <form method="post" @submit.prevent="submit">
                    <estructura-formulario>
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Calificacion" info="No es obligatorio.">
                                <template #inputComponente>
                                    <input-componente type="text" v-model="form.calificacion" autofocus/>
                                </template>
                            </estructura-input>
                        </template>
                    </estructura-formulario>

                    <estructura-formulario>
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Comentario" info="No ees obligatorio.">
                                <template #inputComponente>
                                    <textarea v-model="form.comentario" cols="131" rows="10"></textarea>
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
            evaluacion: Object,
            entrega: Object,
        },

        data() {
            return {
                form: {
                    calificacion: this.entrega.calificacion,
                    comentario: this.entrega.comentario,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('entregas.update', [this.institucion.id, this.curso.id, this.materia.id, this.evaluacion.id, this.entrega.id]),
                    this.form);
            },
        }
    })
</script>
