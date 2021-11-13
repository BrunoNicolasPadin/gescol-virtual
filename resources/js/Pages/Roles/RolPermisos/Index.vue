<template>
    <app-layout title="Permisos del rol">
        <template #header>
            <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                {{ institucion.nombre }} / 
                <breadcrumb ruta='panel.mostrarRoles' :idsArray='[institucion.id]' bread='Roles' />
                {{ rol.nombre }} / 
                Permisos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <estructura-tabla>
                    <template #head>
                        <th-componente>
                            <template #th-contenido>#</template>
                        </th-componente>

                        <th-componente>
                            <template #th-contenido>Nombre</template>
                        </th-componente>

                        <th-componente>
                            <template #th-contenido>Acciones</template>
                        </th-componente>
                    </template>

                    <template #tr>
                        <tr v-for="(permiso, index) in permisos" :key="permiso.id" class="border-b border-gray-300">
                            <td-componente>
                                <template #td-contenido>{{ index + 1 }}</template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    {{ permiso.nombre }}
                                </template>
                            </td-componente>

                            <td-componente>
                                <template #td-contenido>
                                    <eliminar>
                                        <template #contenido>
                                            <span @click="destroy(permiso.id)">Eliminar</span>
                                        </template>
                                    </eliminar>
                                </template>
                            </td-componente>
                        </tr>
                    </template>
                </estructura-tabla>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraTabla from '@/Shared/Tabla/EstructuraTabla'
    import TdComponente from '@/Shared/Tabla/Td'
    import ThComponente from '@/Shared/Tabla/Th'
    import Breadcrumb from '@/Shared/Cabecera/Breadcrumb.vue';
    import Eliminar from '@/Shared/Botones/Eliminar.vue'

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraTabla,
            TdComponente,
            ThComponente,
            Breadcrumb,
            Eliminar,
        },

        props: {
            institucion: Object,
            rol: Object,
            permisos: Array,
        },

        methods: {
            destroy(permiso_id) {
                if (confirm('¿Estás seguro de que deseas eliminar este permiso para este rol?')) {
                    this.$inertia.delete(this.route('rolPermisos.destroy', [this.institucion.id, this.rol.id, permiso_id]));
                }
            },
        }
    })
</script>
