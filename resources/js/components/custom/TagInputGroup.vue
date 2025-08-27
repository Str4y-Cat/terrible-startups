<script setup lang="ts">
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';
import InputTag from './InputTag.vue';
import Tag from './Tag.vue';

interface DetailTag {
    [key: string]: string[];
}

const props = defineProps<{
    tag_group: DetailTag;
}>();

const emit = defineEmits<{
    (e: 'update:selected', selected: string[]): void;
}>();

// Single array of all selected tags
const selectedTags = ref<string[]>([]);

function toggleTag(tag: string) {
    if (selectedTags.value.includes(tag)) {
        selectedTags.value = selectedTags.value.filter((t) => t !== tag);
    } else {
        selectedTags.value.push(tag);
    }
    emit('update:selected', selectedTags.value);
}
</script>

<template>
    <div v-for="(tagGroup, key, group_index) in tag_group" :key="group_index" class="mb-4 flex">
        <div class="flex flex-wrap gap-2">
            <Tag class="border text-nowrap">{{ key }}</Tag>

            <InputTag v-for="(tag, index) in tagGroup" :key="index" :label="tag" :selected="selectedTags.includes(tag)" @toggle="toggleTag" />

            <!-- Add new tag button -->
            <Tag class="block border border-primary/30 text-primary">
                <Plus class="block size-4" />
            </Tag>
        </div>
    </div>
</template>
