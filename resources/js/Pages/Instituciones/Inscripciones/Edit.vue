<template>
    <app-layout title="Inscripción - Editar">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                <breadcrumb ruta='panel.mostrarInicio' :idsArray=[] bread='Tus roles' />
                Editar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
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

                    <estructura-formulario>
                        <template #estructuraInput>
                            <estructura-input nombreLabel="Clave de acceso" info="Es obligatorio.">
                                <template #inputComponente>
                                    <input-componente type="password" v-model="form.claveDeAcceso"/>
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
            inscripcion: Object,
        },

        data() {
            return {
                form: {
                    rol_id: this.inscripcion.rol_id,
                    claveDeAcceso: null,
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
