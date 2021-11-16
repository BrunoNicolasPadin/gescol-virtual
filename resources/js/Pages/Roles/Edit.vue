<template>
    <app-layout title="Instituciones - Roles - Editar">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} /
                <breadcrumb ruta='panel.mostrarRoles' :idsArray='[institucion.id]' bread='Roles' />
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

                            <estructura-input nombreLabel="Clave de acceso acutla" info="Es obligatorio SOLO si deseas cambiar tu clave de acceso.">
                                <template #inputComponente>
                                    <input-componente type="password" v-model="form.claveDeAccesoVieja"/>
                                </template>
                            </estructura-input>

                            <estructura-formulario class="grid grid-cols-2 gap-x-3">
                            <template #estructuraInput>
                                <estructura-input nombreLabel="Clave de acceso para elegir rol" 
                                    info="Es obligatorio SOLO si deseas cambiar tu clave de acceso">
                                    <template #inputComponente>
                                        <input-componente type="password" v-model="form.claveDeAccesoNueva"/>
                                    </template>
                                </estructura-input>

                                <estructura-input nombreLabel="Confirmar clave de acceso" info="Es obligatorio SOLO si deseas cambiar tu clave de acceso">
                                    <template #inputComponente>
                                        <input-componente type="text" v-model="form.claveDeAccesoNueva_confirmation"/>
                                    </template>
                                </estructura-input>
                            </template>
                        </estructura-formulario>
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
            rol: Object,
        },

        data() {
            return {
                form: {
                    nombre: this.rol.nombre,
                    claveDeAccesoVieja: null,
                    claveDeAccesoNueva: null,
                    claveDeAccesoNueva_confirmation: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('roles.update', [this.institucion.id, this.rol.id]), this.form);
            },
        }
    })
</script>
