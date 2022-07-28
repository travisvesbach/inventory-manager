<script setup>
    function onEnter(element, done) {
        const { height } = getComputedStyle(element);
        element.style.height = 0;
        getComputedStyle(element).height;
        setTimeout(() => {
            element.style.height = height;
        });

        // call the done callback to indicate transition end
        // optional if used in combination with CSS
        // done()

    }

    function onAfterEnter(element) {
        element.style.height = 'auto';
    }

    function onLeave(element, done) {
        const { height } = getComputedStyle(element);
        element.style.height = height;
        getComputedStyle(element).height;
        setTimeout(() => {
            element.style.height = 0;
        });

        // call the done callback to indicate transition end
        // optional if used in combination with CSS
        // done()
    }
</script>

<template>
    <Transition name="expand" @enter="onEnter" @after-enter="onAfterEnter" @leave="onLeave">
        <slot></slot>
    </Transition>
</template>

<style>
    .expand-enter-active, .expand-leave-active {
        transition-duration: 0.3s;
        transition-property: height, opacity;
        transition-timing-function: ease;
        overflow: hidden;
    }

    .expand-enter-from,
    .expand-leave-to {
        opacity: 0;
    }

</style>
