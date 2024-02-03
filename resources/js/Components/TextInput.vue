<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    error: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="dark:bg-gray-900 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :class="[error ? 'border-red-700 text-red-700 placeholder:text-red-700' : 'border-gray-300 dark:border-gray-700 dark:text-gray-300']"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    >
</template>
