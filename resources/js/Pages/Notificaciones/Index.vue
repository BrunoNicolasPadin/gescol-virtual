<template>
    <app-layout title="Notificaciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notificaciones
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <estructura-notificacion :notificacion_id='notificacion.id'
                    v-for="notificacion in notificaciones" :key="notificacion.id">
                    <template #notificacion>
                        <span v-if="notificacion.type == 'App\\Notifications\\Evaluaciones\\EvaluacionCreada' ">
                            Tienes una nueva evaluacion de 
                            <Link :href="route('evaluaciones.show', 
                                [notificacion.data.institucion_id, notificacion.data.curso_id, notificacion.data.materia_id, notificacion.data.id])" 
                                class="underline">
                                {{ notificacion.data.materia }}
                            </Link>
                            para el {{ notificacion.data.comienzo }}
                        </span>

                        <span v-if="notificacion.type == 'App\\Notifications\\Clases\\ClaseCreada' ">
                            Tienes una nueva clase de 
                            <Link :href="route('clases.show', 
                                [notificacion.data.institucion_id, notificacion.data.curso_id, notificacion.data.materia_id, notificacion.data.id])" 
                                class="underline">
                                {{ notificacion.data.materia }}
                            </Link>
                        </span>

                        <span v-if="notificacion.type == 'App\\Notifications\\Entregas\\EntregaCalificada' ">
                            Tu 
                            <Link :href="route('entregas.show', 
                                [notificacion.data.institucion_id, notificacion.data.curso_id, notificacion.data.materia_id, 
                                notificacion.data.evaluacion_id, notificacion.data.id])" 
                                class="underline">
                                entrega</Link> para {{ notificacion.data.materia }} fue calificada con un {{ notificacion.data.calificacion }}
                        </span>
                    </template>
                </estructura-notificacion>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import EstructuraNotificacion from '@/Shared/Notificaciones/EstructuraNotificacion.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            AppLayout,
            EstructuraNotificacion,
            Link,
        },

        props: {
            notificaciones: Array,
        },
    })
</script>
