<template>
    <teleport to="head">
        <title>Inicio</title>
    </teleport>
    <section class="text-gray-600 body-font">
        <div class="px-5 py-24 mx-auto grid grid-cols-1 md:grid-cols-2" style="background:url('https://cdn.shopify.com/s/files/1/0426/9209/articles/google-workspace-for-education-la-mejor-opcion-para-ensenar-en-linea-2_960x502_crop_center.jpg?v=1619724820960w')">
            <div class="lg:w-3/5 p-4">
                <span class="uppercase font-bold text-4xl text-black bg-yellow-300 p-1">
                    Gescol
                </span>
                <div class="mt-6">
                    <span class="text-black font-normal bg-yellow-200 p-1">
                        Registrate para llevar a tu instituto al siguiente nivel
                    </span>
                </div>
            </div>

            <div v-if="canLogin != true" class="flex justify-center">
                <Link :href="route('panel.mostrarInicio')" class="text-sm text-gray-700 underline">
                    <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        Panel
                    </button>
                </Link>
            </div>

            <div v-else class="flex justify-center">
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        Iniciar sesión
                    </button>
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    <button class="text-black bg-indigo-50 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-100 rounded text-lg">
                        Registrarse
                    </button>
                </Link>
            </div>
        </div>
    </section>

    <div class="bg-gray-100">
        <h1 class="text-5xl text-center uppercase py-6 font-semibold">Instituciones</h1>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-x-3 py-10">
            <div class="w-full ml-auto mr-auto px-4">
                <img alt="..." class="max-w-full rounded-lg shadow-lg" :src="'storage/Inicio/materias.png'">
            </div>

            <div class="mt-10 px-4">
                <ul class="font-normal text-md lg:text-xl">
                    <li class="my-2">- Registra todas las instituciones que desees</li>
                    <li class="my-2">- Registra los roles y los permisos que tu desees</li>
                    <li class="my-2">- Registra los cursos con sus materias y elige a los docentes a cargo de estas</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <h1 class="text-5xl text-center uppercase py-6 font-semibold">Docentes</h1>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-x-3 py-10">
            <div class="w-full ml-auto mr-auto px-4">
                <img alt="..." class="max-w-full rounded-lg shadow-lg" :src="'storage/Inicio/evaluacion.png'">
            </div>

            <div class="mt-10 px-4">
                <ul class="font-normal text-md lg:text-xl">
                    <li class="my-2">- Crea tus clases y sube los archivos necesarios para que tus alumnos los descarguen</li>
                    <li class="my-2">- Crea tus examenes, tareas, TPs, etc...</li>
                    <li class="my-2">- Califica las entregas de tus alumnos y sube las correcciones</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-gray-100">
        <h1 class="text-5xl text-center uppercase py-6 font-semibold">Alumnos</h1>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-x-3 py-10">
            <div class="w-full ml-auto mr-auto px-4">
                <img alt="..." class="max-w-full rounded-lg shadow-lg" :src="'storage/Inicio/entrega.png'">
            </div>

            <div class="mt-10 px-4">
                <ul class="font-normal text-md lg:text-xl">
                    <li class="my-2">- Mantente informado de los examenes y tareas a realizar</li>
                    <li class="my-2">- Realiza tus entregas de forma online en vez de imprimir el trabajo</li>
                    <li class="my-2">- Resuelve tus dudas con tu docente de forma online y rapida</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <h1 class="text-5xl text-center uppercase py-6 font-semibold">Sobre nosotros</h1>
        <p class="p-6 text-left leading-10 font-normal">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Libero aspernatur earum magni vitae tempore eligendi quo saepe nemo repellendus perspiciatis! Culpa doloribus sit magnam modi saepe! Quaerat pariatur incidunt quam?
        Quam amet aliquid cumque quis laboriosam quasi est accusantium? Sequi cum alias quibusdam officia ratione mollitia in, animi molestias consequuntur tempora, pariatur velit dolore numquam quia ut libero molestiae sed.
        Accusamus natus dolore ducimus dicta voluptatum! Numquam ratione nesciunt aspernatur sint nulla repellendus aut inventore magni fuga eaque esse, provident, maiores illum molestiae ullam exercitationem fugiat nemo modi. Dolores, nulla.
        Enim, quisquam exercitationem possimus quo modi, dolore ad ut eveniet quibusdam temporibus ducimus itaque nesciunt culpa accusantium adipisci natus iusto provident excepturi doloremque nostrum est, autem similique voluptatum! Praesentium, iusto.
        Distinctio sint harum, velit rem odio numquam fugiat. Molestiae unde aut harum nemo velit quos ea eius fugiat reiciendis dicta reprehenderit sint quasi id, laboriosam dolor quisquam? Veniam, esse quis.</p>
    </div>

    <div class="bg-gray-100">
        <h1 class="text-5xl text-center uppercase py-6 font-semibold">Contacta con nosotros</h1>
        
        <form method="post" @submit.prevent="submit" class="px-10 lg:px-40">
            <estructura-formulario>
                <template #estructuraInput>
                    <estructura-input nombreLabel="Email" info="Es obligatorio.">
                        <template #inputComponente>
                            <input-componente type="email" required v-model="form.email"/>
                        </template>
                    </estructura-input>
                </template>
            </estructura-formulario>

            <estructura-formulario>
                <template #estructuraInput>
                    <estructura-input nombreLabel="Asunto" info="Es obligatorio.">
                        <template #inputComponente>
                            <input-componente type="text" required v-model="form.asunto"/>
                        </template>
                    </estructura-input>
                </template>
            </estructura-formulario>

            <estructura-formulario>
                <template #estructuraInput>
                    <estructura-input nombreLabel="Mensaje" info="Es obligatorio.">
                        <template #inputComponente>
                            <textarea 
                            class="bg-white rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" 
                            name="body" 
                            placeholder='Mensaje...' 
                            v-model="form.mensaje"/>
                        </template>
                    </estructura-input>
                </template>
            </estructura-formulario>

            <guardar />
        </form>
    </div>

    <div class="bg-gray-200">
        <footer class="flex flex-wrap items-center justify-between p-3 m-auto">
            <div class="container mx-auto flex flex-col flex-wrap items-center justify-between">
                <div class="flex mx-auto text-gray-500 text-center">
                    <span>Copyright © 2021 - Gym | Todos los derechos reservados.
                    </span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import EstructuraFormulario from '@/Shared/Formulario/EstructuraFormulario'
    import EstructuraInput from '@/Shared/Formulario/EstructuraInput'
    import InputComponente from '@/Shared/Formulario/InputComponente'

    export default defineComponent({
        components: {
            Head,
            Link,
            AppLayout,
            EstructuraFormulario,
            EstructuraInput,
            InputComponente,
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },

        data() {
            return {
                form: {
                    email: null,
                    asunto: null,
                    mensaje: null,
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('contacto.enviarEmail'), this.form)
            },
        }
    })
</script>
