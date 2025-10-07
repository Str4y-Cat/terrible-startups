// composables/useAutosaveField.ts
import { useForm } from '@inertiajs/vue3';
import { debouncedWatch } from '@vueuse/core';
import { computed, ref } from 'vue';
import { errorToast } from './useErrorToast';

export function useAutosaveField(
    route: string,
    fieldName: string,
    initialValue: string | string[],
    options: { debounce?: number; deep?: boolean } = {},
) {
    const localValue = ref(initialValue);
    const isArray = Array.isArray(initialValue);
    const deep = options.deep ?? isArray;
    // dynamic form with a single key
    const form = useForm<Record<string, any>>({
        [fieldName]: initialValue,
    });

    const errorMessage = computed(() => form.errors?.[fieldName] as string | undefined);

    const isSaving = ref(false);

    // autosave
    debouncedWatch(
        () => localValue.value,
        (newVal, oldVal) => {
            if (!isArray && newVal === oldVal) return;

            isSaving.value = true;
            form[fieldName] = newVal;

            form.transform((data: { [key: string]: string[] }) => {
                const filtered: { [key: string]: string[] } = {};
                for (const key in data) {
                    filtered[key] = data[key].filter((val) => val != null && val != '');
                }
                return filtered;
                // return data.filter((val) => {
                //     return val != null;
                // });
            }).patch(route, {
                preserveState: true,
                preserveScroll: true,
                onStart: () => {
                    // console.log('starting autosave', form.data());
                },
                onFinish: () => {
                    isSaving.value = false;
                },
                onSuccess: () => {
                    console.log('success');
                },
                onError: (err) => {
                    console.log('error: ', err);
                    errorToast('Failed to save', err);
                },
            });
        },
        { debounce: options.debounce ?? 1500, deep: deep },
    );

    return {
        localValue,
        errorMessage,
        isSaving,
    };
}
