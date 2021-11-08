<template>
    <div>
        <div class="flex border-b mb-5">
            <div class="w-5/6">
                <h1 class="text-3xl py-4">
                    <slot name="titulo"></slot>
                </h1>
            </div>
            <div class="w-1/6">
                <button type="button" class="float-right border border-blue-500 bg-blue-500 text-white font-bold rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                    <slot name="boton"></slot>
                </button>
            </div>
        </div>
    </div>
</template>