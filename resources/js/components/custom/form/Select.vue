<script setup lang="ts">
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
const props = defineProps<{
    label?: string;
    values: Array<string>;
    placeholder: string;
    required?: boolean;
    bind?: object;
}>();

const handelize = (val: string) => {
    return val.toLowerCase().replace(' ', '-');
};
</script>

<template>
    <Select>
        <SelectTrigger>
            <SelectValue :placeholder="props.placeholder" />
        </SelectTrigger>
        <SelectContent>
            <SelectGroup>
                <SelectLabel v-if="props.label">{{ props.label }}</SelectLabel>
                <SelectItem v-for="(value, index) in props.values" :key="index" :value="handelize(value)"> {{ value }} </SelectItem>
            </SelectGroup>
        </SelectContent>
    </Select>
</template>
