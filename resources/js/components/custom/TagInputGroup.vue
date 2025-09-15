<script setup lang="ts">
import { ref } from 'vue';
import InputTag from './InputTag.vue';

interface SelectedTag {
    key: string;
    value: string;
}

const props = defineProps<{
    tag_group: { [key: string]: string[] };
    title: string;
}>();

const emit = defineEmits<{
    (e: 'update:selected', selected: SelectedTag[]): void;
}>();

// Single array of all selected tags
const selectedTags = ref<SelectedTag[]>([]);

function toggleTag(tag: SelectedTag) {
    const includesTag = isTagIncluded(tag);

    //if the selected tags contains the current tag
    if (includesTag) {
        //remove the tag
        selectedTags.value = selectedTags.value.filter((current_tag) => {
            return current_tag.key !== tag.key || current_tag.value !== tag.value;
        });
    } else {
        //add the tag

        selectedTags.value.push(tag);
    }
    emit('update:selected', selectedTags.value);
}

function isTagIncluded(tag: SelectedTag) {
    //returns true if both the tag matches a tag in the selected tags
    return selectedTags.value.some((current_tag) => {
        return current_tag.key == tag.key && current_tag.value == tag.value;
    });
}
</script>

<template>
    <div class="group mt-4 gap-2 pt-2">
        <h3 class="mb-4 border-b-1 border-dashed border-transparent border-b-muted pb-1 text-2xl group-has-focus:border-b-primary/20">
            {{ title }}
        </h3>

        <div v-for="(tagGroup, key, group_index) in tag_group" :key="group_index" class="mb-8 flex flex-col gap-2">
            <h4 class="text-base font-bold text-nowrap text-foreground/70 capitalize">{{ key }}</h4>
            <div class="flex flex-wrap gap-2">
                <InputTag
                    v-for="(tag, index) in tagGroup"
                    :key="index"
                    :parent="key"
                    :label="tag"
                    :selected="isTagIncluded({ key: key, value: tag })"
                    @toggle="toggleTag"
                />
            </div>
        </div>
    </div>
</template>
