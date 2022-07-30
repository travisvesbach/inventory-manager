<script setup>
    function onEnter(element, done) {
        console.log('onEnter')
        const height = getComputedStyle(element).height;
        element.style.height = 0;
        // getComputedStyle(element).height;
        setTimeout(() => {
            element.style.height = height;
        });
        setTimeout(() => {
            done()
        }, 300)

        // call the done callback to indicate transition end
        // optional if used in combination with CSS

    }

    function onAfterEnter(element) {
        console.log('here')
        element.style.minHeight = element.style.height;
        element.style.height = 'auto';
    }

    function onLeave(element, done) {
        console.log('onleave')
        const height = getComputedStyle(element).height;
        element.style.height = height;
        // getComputedStyle(element).height;
        setTimeout(() => {
            element.style.minHeight = 0;
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
        /*opacity: 0;*/
    }

</style>
