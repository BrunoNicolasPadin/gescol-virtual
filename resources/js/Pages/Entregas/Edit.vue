<template>
    <app-layout title="Entregas - Calificar">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                {{ curso.nombre }} / 
                <breadcrumb ruta='materias.index' :idsArray='[institucion.id, curso.id]' bread='Materias' />
                {{ materia.nombre }} / 
                <breadcrumb ruta='evaluaciones.index' :idsArray='[institucion.id, curso.id, materia.id]' bread='Evaluaciones' />
                <breadcrumb ruta='evaluaciones.show' :idsArray='[institucion.id, curso.id, materia.id, evaluacion.id]' :bread='evaluacion.nombre' />
                <breadcrumb ruta='entregas.index' :idsArray='[institucion.id, curso.id, materia.id, evaluacion.id]' bread='Entregas' />
                Calificar a {{ entrega.alumno_materia.rol_user.user.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <form method="post" @submit.prevent="submit">
                    <estructura-formulario>
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Calificación" info="No es obligatorio.">
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
