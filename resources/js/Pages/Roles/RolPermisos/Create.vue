<template>
    <app-layout title="Rol - Agregar permisos">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='panel.mostrarRoles' :idsArray='[institucion.id]' bread='Roles' />
                {{ rol.nombre }} / 
                <breadcrumb ruta='rolPermisos.index' :idsArray='[institucion.id, rol.id]' bread='Permisos' />
                Agregar
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-for="permiso in permisos" :key="permiso.id" class="bg-white rounded-md shadow-md p-2 my-3 grid grid-cols-2">
                    <div class="font-bold">
                        {{ permiso.nombre }}
                    </div>
                    <div class="flex justify-end">
                        <button type="button" name="botonAgregar" @click="submit(permiso.id)"
                            class="focus:outline-none text-white text-sm p-2.5 rounded-md bg-green-500 hover:bg-green-700 hover:shadow-lg font-bold">
                            Agregar
                        </button>
                    </div>
                </div>
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
    import Agregar from '@/Shared/Botones/Agregar'
    import Breadcrumb from '@/Shared/Cabecera/Breadcrumb.vue';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraFormulario,
            EstructuraInput,
            InputComponente,
            Guardar,
            Agregar,
            Breadcrumb,
        },

        props: {
            institucion: Object,
            rol: Object,
            permisos: Array,
        },

        data() {
            return {
                form: {
                    permiso_id: null,
                },
            }
        },

        methods: {
            submit(permiso_id) {
                this.form.permiso_id = permiso_id
                this.$inertia.post(this.route('rolPermisos.store', [this.institucion.id, this.rol.id]), this.form);
            },
        }
    })
</script>
