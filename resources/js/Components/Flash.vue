<script setup>
    import { ref, computed, watch } from 'vue'

    const props = defineProps({
        message: {
            type: String,
            default: null
        },
        status: {
            type: String,
            default: null
        },
        timestamp: {
            type: String,
            default: null
        },
    })

    const flash_array = ref([]);

    watch(() => props.timestamp, async () => {
        flash();
    });

    function flash() {
        let message = {
            message: props.message,
            status: props.status
        };


        flash_array.value.push(message);
        hide();
    }

    function hide() {
        setTimeout(() => {
            flash_array.value.shift();
        }, 5000);
    }

    function getStatusClasses(status) {
        return {
            'bg-green-100 text-green-800': status == 'success',
            'bg-red-200 text-red-900': status == 'danger',
            'bg-blue-200 text-blue-800': status == 'info',
            'bg-indigo-200 text-indigo-800': status == 'primary'
        }
    };

    if(props.message) {
        flash();
    }
</script>

<template>
    <div class="h-full">
        <div class="alert-flash flex flex-col items-end">
            <div id="alert" class="rounded py-3 px-5 my-2 opacity-90" v-bind:class="getStatusClasses(messageObj.status)" role="alert" v-for="messageObj in flash_array">
                <span class="whitespace-pre-wrap" v-html="messageObj.message"/>
            </div>
        </div>
    </div>
</template>

<style>
    .alert-flash {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 9999;
        max-width: 25rem;
    }
</style>
