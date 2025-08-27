<script setup lang="ts">
import { Plus } from 'lucide-vue-next';
import { reactive } from 'vue';
import Tag from './Tag.vue';
interface DetailTag {
    [key: string]: string[];
}
const props = defineProps<{
    tag_group: DetailTag;
}>();

const selected_tags = reactive([]);
</script>

<template>
    <div v-for="(tagGroup, key, group_index) in tag_group" :key="group_index" class="mb-4 flex">
        <div class="flex flex-wrap gap-2">
            <Tag class="border text-nowrap">{{ key }}</Tag>
            <button @click.prevent class="block w-fit" v-for="(tag, index) in tagGroup" :key="index">
                <Tag class="border border-primary/30 text-nowrap text-primary data-[active=true]:bg-primary/30">{{ tag }}</Tag>
            </button>
            <Tag class="block border border-primary/30 text-primary">
                <Plus class="block size-4"></Plus>
            </Tag>
        </div>
    </div>
</template>
