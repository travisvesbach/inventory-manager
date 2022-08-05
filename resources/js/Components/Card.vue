<template>
    <div class="shadow sm:rounded-lg mx-auto card text-color">
        <div class="p-3 text-lg card-header-footer" v-if="$slots.header">
            <slot name="header"></slot>
        </div>

        <div class="p-3">
            <slot></slot>
        </div>

        <div class="p-3 flex items-center card-header-footer" v-if="$slots.footer || $slots.footerend">
            <slot name="footer"></slot>
            <div class="flex flex-grow items-center justify-end">
                <slot name="footerend"></slot>
            </div>
        </div>
    </div>
</template>
