<template>
    <app-layout title="Panel - Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel / Roles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 md:px-8">
                <div class="h-screen grid grid-cols-6 rounded-sm shadow-md border border-gray-300">
                        <div class="bg-gray-200 text-center p-2">
                            <div class="bg-gray-100 rounded-lg shadow-md my-3">
                                <Link :href="route('cursos.index', institucion.id)" class="hover:underline">
                                    Cursos
                                </Link>
                            </div>

                            <div class="bg-gray-100 rounded-lg shadow-md my-3">
                                <Link :href="route('panel.mostrarRoles', institucion.id)" class="hover:underline">
                                    Roles
                                </Link>
                            </div>
                        </div>
                        <div class="col-span-5 bg-gray-100 px-2 text-right">
                            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                                <div class="container mx-auto px-6">
                                    <titulo-con-boton>
                                        <template #titulo>
                                            Roles
                                        </template>

                                        <template #boton>
                                            <Link :href="route('roles.create', institucion.id)">
                                                Agregar
                                            </Link>
                                        </template>
                                    </titulo-con-boton>

                                    <estructura-tabla class="bg-gray-200 border border-gray-300 h-auto">
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
                                            <tr v-for="(rol, index) in roles" :key="rol.id">
                                                <td-componente>
                                                    <template #td-contenido>{{ index + 1 }}</template>
                                                </td-componente>

                                                <td-componente>
                                                    <template #td-contenido>
                                                            {{ rol.nombre }}
                                                    </template>
                                                </td-componente>

                                                <td-componente>
                                                    <template #td-contenido>
                                                        <button @click="desplegarDropdown(rol.id)" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:focus:bg-gray-600 dark-mode:hover:bg-gray-600 md:w-auto md:inline md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                            <span>Acciones</span>
                                                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open == rol.id, 'rotate-0': open != rol.id}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                        </button>
                                                        <div v-show="open == rol.id && abierto == true " class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                                                            <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                                                                <Link :href="route('rolPermisos.index', [institucion.id, rol.id])" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                    Permisos
                                                                </Link>
                                                                <Link :href="route('roles.edit', [institucion.id, rol.id])" class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                    Editar
                                                                </Link>
                                                                <div class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                    <button @click="destroy(rol)">
                                                                        Eliminar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </td-componente>
                                            </tr>
                                        </template>
                                    </estructura-tabla>
                                </div>
                            </main>
                        </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraBuscador from '@/Shared/Paneles/EstructuraBuscador'
    import Eliminar from '@/Shared/Botones/Eliminar'
    import TituloConBoton from '@/Shared/Cabecera/TituloConBoton.vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import EstructuraTabla from '@/Shared/Tabla/EstructuraTabla'
    import TdComponente from '@/Shared/Tabla/Td'
    import ThComponente from '@/Shared/Tabla/Th'

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraBuscador,
            Eliminar,
            TituloConBoton,
            Link,
            EstructuraTabla,
            TdComponente,
            ThComponente,
        },

        props: {
            institucion: Object,
            roles: Array,
        },

        data() {
            return {
                open: '',
                abierto: false,
                
            }
        },

        methods: {
            desplegarDropdown(id) {
                if (this.abierto == false) {
                    this.open = id;
                    this.abierto = true;
                } else {
                    this.abierto = false;
                }
            },

            destroy(rol) {
                if (confirm('¿Estás seguro de que deseas eliminar este rol?')) {
                    this.$inertia.delete(this.route('roles.destroy', [rol.institucion_id, rol.id]));
                }
            }
        },
    })
</script>
