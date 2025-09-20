// composables/useAutosaveField.ts
import { useForm } from '@inertiajs/vue3';
import { debouncedWatch } from '@vueuse/core';
import { computed, ref } from 'vue';

export function useAutosaveField(route: string, fieldName: string, initialValue: string | string[], options: { debounce?: number } = {}) {
    const localValue = ref(initialValue);

    // dynamic form with a single key
    const form = useForm<Record<string, any>>({
        [fieldName]: initialValue,
    });

    const errorMessage = computed(() => form.errors?.[fieldName] as string | undefined);

    const isSaving = ref(false);

    // autosave
    debouncedWatch(
        localValue,
        (newVal, oldVal) => {
            if (newVal === oldVal) return;

            isSaving.value = true;
            form[fieldName] = newVal;

            form.patch(route, {
                preserveState: true,
                preserveScroll: true,
                onStart: () => {
                    console.log(form.data());
                },
                onFinish: () => {
                    isSaving.value = false;
                },
                onSuccess: () => {
                    console.log('success');
                },
                onError: () => {
                    console.log('failed');
                },
            });
        },
        { debounce: options.debounce ?? 1500 },
    );

    return {
        localValue,
        errorMessage,
        isSaving,
    };
}
