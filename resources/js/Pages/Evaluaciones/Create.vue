<template>
    <app-layout title="Evaluaciones - Agregar">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='cursos.index' :idsArray='[institucion.id]' bread='Cursos' />
                {{ curso.nombre }} / 
                <breadcrumb ruta='materias.index' :idsArray='[institucion.id, curso.id]' bread='Materias' />
                {{ materia.nombre }} / 
                <breadcrumb ruta='evaluaciones.index' :idsArray='[institucion.id, curso.id, materia.id]' bread='Evaluaciones' />
                Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
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

                    <estructura-formulario class="grid grid-cols-1 md:grid-cols-2 gap-x-3">
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Fecha y hora de comienzo" info="Formato: DD-MM-AAAA HH:MM:SS. Es obligatorio.">
                                <template #inputComponente>
                                    <input-componente type="text" v-model="form.fechaHoraComienzo" placeholder="09-12-2021 09:30:00"/>
                                </template>
                            </estructura-input>

                            <estructura-input nombreLabel="Fecha y hora de finalizacion" info="Formato: DD-MM-AAAA HH:MM:SS. Es obligatorio.">
                                <template #inputComponente>
                                    <input-componente type="text" v-model="form.fechaHoraFinalizacion" placeholder="09-12-2021 12:45:00"/>
                                </template>
                            </estructura-input>
                        </template>
                    </estructura-formulario>

                    <estructura-formulario>
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Descripción" info="Es obligatorio.">
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
        },

        data() {
            return {
                form: {
                    nombre: null,
                    descripcion: null,
                    fechaHoraComienzo: null,
                    fechaHoraFinalizacion: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('evaluaciones.store', [this.institucion.id, this.curso.id, this.materia.id]), this.form);
            },
        }
    })
</script>
