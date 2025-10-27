<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import Button from '@/components/ui/button/Button.vue';
import { Item, ItemContent, ItemGroup, ItemList, ItemMedia, ItemTitle } from '@/components/ui/item';
import { Link } from '@inertiajs/vue3';
import { BicepsFlexed, ChartLine, Earth, IdCard, Skull, Star, UserRound, Zap } from 'lucide-vue-next';
import { ref } from 'vue';
// import { Link } from 'lucide-vue-next';
// import { Competitor } from '@/types/tools';

defineProps<{
    competitor: Competitor;
}>();

interface Competitor {
    name: string;
    summary: string;
    key_info: string[];

    // Grouping general market info for clarity
    overview: {
        market_position: string;
        regions: string[];
        target_audience: string[];
    };

    strengths: string[];
    weaknesses: string[];
    differentiators?: string[];

    value_proposition: {
        summary: string;
        problems_solved: string;
        desired_fulfilled: string;
        benefits: string;
        additional?: string;
    };

    brand_identity: {
        tone: string;
        personality: string;
        visual_style?: string;
    };

    url: string;

    // Source tracking & data confidence — useful for AI-sourced info
    metadata?: {
        source_urls?: string[];
        data_confidence?: number; // 0–1 confidence level
        last_updated?: string; // ISO date string
    };
}

const viewMore = ref(false);
</script>

<template>
    <div class="mb-8 rounded-lg border bg-card p-6 transition">
        <div class="flex flex-col items-start">
            <div class="">
                <!-- HEADER -->
                <div class="grid grid-cols-1 items-center justify-between gap-4 sm:grid-cols-2">
                    <div class="">
                        <div class="mb-2 flex items-center gap-2">
                            <Avatar>
                                <AvatarImage
                                    :src="`http://www.google.com/s2/favicons?domain=${competitor.url}&sz=128`"
                                    :alt="`Website favicon for ${competitor.name}`"
                                />
                                <AvatarFallback>CN</AvatarFallback>
                            </Avatar>
                            <Link :href="competitor.url" target="_blank" rel="noopener noreferrer" class="text-lg hover:underline">
                                <h2 class="text-2xl font-semibold text-foreground">{{ competitor.name }}</h2>
                            </Link>
                        </div>
                        <!-- SUMMARY -->
                        <p class="mb-4 text-lg text-muted-foreground">{{ competitor.summary }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:gap-2">
                        <!-- KEY INFO -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            <span
                                v-for="info in competitor.key_info"
                                :key="info"
                                class="flex h-fit w-fit items-center gap-1 rounded-full bg-muted bg-primary-blue/20 px-2 py-1 text-xs font-medium text-muted-foreground"
                            >
                                <Zap class="size-4" /> {{ info }}
                            </span>
                        </div>

                        <!-- REGIONS -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            <span
                                v-for="info in competitor.overview.regions"
                                :key="info"
                                class="flex h-fit items-center gap-1 rounded-full bg-muted bg-primary-green/20 px-2 py-1 text-xs font-medium text-muted-foreground"
                            >
                                <Earth class="size-4" />{{ info }}
                            </span>
                        </div>

                        <!-- TARGET AUDIENCE -->
                        <div class="mb-4 flex flex-wrap gap-2">
                            <span
                                v-for="info in competitor.overview.target_audience"
                                :key="info"
                                class="flex h-fit gap-1 rounded-full bg-muted bg-primary-pink/20 px-2 py-1 text-xs font-medium text-muted-foreground"
                            >
                                <UserRound class="size-4" />{{ info }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- KEY INFO -->

                <!-- OVERVIEW -->
            </div>

            <div class="flex w-full items-center gap-2">
                <div class="w-full grow border-t"></div>
                <Button variant="ghost" @click.prevent="viewMore = !viewMore">
                    <span v-text="viewMore ? 'Show Less' : 'Show More'"> </span>
                </Button>
                <div class="w-full grow border-t"></div>
            </div>
            <div v-if="viewMore" class="pt-8">
                <!-- STRENGTHS & WEAKNESSES -->
                <!--
                    <div class="h-fit">
                        <div>
                            <BicepsFlexed />
                            <h3 class="mb-2 font-semibold text-foreground">Strengths</h3>
                        </div>
                        <ul class="list-inside list-disc text-muted-foreground">
                            <li v-for="s in competitor.strengths" :key="s">{{ s }}</li>
                        </ul>
                    </div>
                    -->

                <ItemGroup class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                    <Item variant="outline">
                        <ItemContent>
                            <ItemMedia variant="icon">
                                <BicepsFlexed />
                            </ItemMedia>
                            <ItemTitle>Strengths</ItemTitle>
                            <ItemList class="list-inside list-disc">
                                <li v-for="s in competitor.strengths" :key="s">{{ s }}</li>
                            </ItemList>
                        </ItemContent>
                    </Item>
                    <Item variant="outline">
                        <ItemContent>
                            <ItemMedia variant="icon">
                                <Skull />
                            </ItemMedia>
                            <ItemTitle>Weaknesses</ItemTitle>
                            <ItemList class="list-inside list-disc">
                                <li v-for="s in competitor.weaknesses" :key="s">{{ s }}</li>
                            </ItemList>
                        </ItemContent>
                    </Item>
                    <Item variant="outline">
                        <ItemContent>
                            <ItemMedia variant="icon">
                                <Star />
                            </ItemMedia>
                            <ItemTitle>Differenciators</ItemTitle>
                            <ItemList class="list-inside list-disc">
                                <li v-for="s in competitor.differentiators" :key="s">{{ s }}</li>
                            </ItemList>
                        </ItemContent>
                    </Item>
                    <Item variant="outline" class="hidden sm:block md:hidden">
                        <ItemContent>
                            <ItemMedia variant="icon">
                                <IdCard />
                            </ItemMedia>
                            <ItemTitle>Brand Identity</ItemTitle>
                            <ItemList class="list-inside list-disc">
                                <li><strong>Tone:</strong> {{ competitor.brand_identity.tone }}</li>
                                <li v-if="competitor.brand_identity.visual_style">
                                    <strong>Visual Style:</strong> {{ competitor.brand_identity.visual_style }}
                                </li>
                            </ItemList>
                        </ItemContent>
                    </Item>
                </ItemGroup>

                <!--
                    <div class="h-fit">
                        <div>
                            <Skull />
                            <h3 class="mb-2 font-semibold text-foreground">Weaknesses</h3>
                        </div>
                        <ul class="list-inside list-disc text-muted-foreground">
                            <li v-for="w in competitor.weaknesses" :key="w">{{ w }}</li>
                        </ul>
                    </div>
                    -->

                <!-- DIFFERENTIATORS -->

                <!--
                    <div v-if="competitor.differentiators?.length" class="">
                        <div>
                            <Star />
                            <h3 class="mb-2 font-semibold text-foreground">Differentiators</h3>
                        </div>
                        <ul class="list-inside list-disc text-muted-foreground">
                            <li v-for="d in competitor.differentiators" :key="d">{{ d }}</li>
                        </ul>
                    </div>
                    -->

                <!-- VALUE PROPOSITION -->
                <ItemGroup class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <Item variant="outline" class="col-span-2">
                        <ItemContent>
                            <ItemMedia variant="icon">
                                <ChartLine />
                            </ItemMedia>
                            <ItemTitle>Value Proposition</ItemTitle>
                            <ItemList class="list-inside list-disc">
                                <li><strong>Problems Solved:</strong> {{ competitor.value_proposition.problems_solved }}</li>
                                <li><strong>Desired Fulfilled:</strong> {{ competitor.value_proposition.desired_fulfilled }}<br /></li>
                                <li><strong>Benefits:</strong> {{ competitor.value_proposition.benefits }}</li>
                                <li v-if="competitor.value_proposition.additional">
                                    <strong>Additional:</strong> {{ competitor.value_proposition.additional }}
                                </li>
                            </ItemList>
                        </ItemContent>
                    </Item>
                    <Item variant="outline" class="hidden md:block">
                        <ItemContent>
                            <ItemMedia variant="icon">
                                <IdCard />
                            </ItemMedia>
                            <ItemTitle>Brand Identity</ItemTitle>
                            <ItemList class="list-inside list-disc">
                                <li><strong>Tone:</strong> {{ competitor.brand_identity.tone }}</li>
                                <li v-if="competitor.brand_identity.visual_style">
                                    <strong>Visual Style:</strong> {{ competitor.brand_identity.visual_style }}
                                </li>
                            </ItemList>
                        </ItemContent>
                    </Item>
                </ItemGroup>
                <!--
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="col-span-2 mt-4">
                        <div>
                            <ChartLine />
                            <h3 class="mb-2 font-semibold text-foreground">Value Proposition</h3>
                        </div>
                        <div class="space-y-1 text-muted-foreground">
                            <p>{{ competitor.value_proposition.summary }}</p>
                            <p><strong>Problems Solved:</strong> {{ competitor.value_proposition.problems_solved }}</p>
                            <p><strong>Desired Fulfilled:</strong> {{ competitor.value_proposition.desired_fulfilled }}</p>
                            <p><strong>Benefits:</strong> {{ competitor.value_proposition.benefits }}</p>
                            <p v-if="competitor.value_proposition.additional">
                                <strong>Additional:</strong> {{ competitor.value_proposition.additional }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div>
                            <IdCard />
                            <h3 class="mb-2 font-semibold text-foreground">Brand Identity</h3>
                        </div>
                        <div class="space-y-1 text-muted-foreground">
                            <p><strong>Tone:</strong> {{ competitor.brand_identity.tone }}</p>
                            <p><strong>Personality:</strong> {{ competitor.brand_identity.personality }}</p>
                            <p v-if="competitor.brand_identity.visual_style">
                                <strong>Visual Style:</strong> {{ competitor.brand_identity.visual_style }}
                            </p>
                        </div>
                    </div>
                </div>
                    -->

                <div v-if="false" class="mb-4 space-y-1 text-base">
                    <h4 class="font-bold">Market Position:</h4>
                    <p class="text-muted-foreground">{{ competitor.overview.market_position }}</p>
                </div>

                <div v-if="false">
                    <iframe :src="competitor.url" frameborder="0" class="aspect-16/9 w-full border"></iframe>
                </div>
            </div>
        </div>

        <!-- METADATA -->
        <div class="pt-3 text-xs text-muted-foreground">
            <div class="flex gap-2" v-if="competitor.metadata">
                <span v-if="competitor.metadata.data_confidence">Confidence: {{ (competitor.metadata.data_confidence * 100).toFixed(0) }}%</span>
                <div class="border border-transparent border-l-border"></div>

                <span v-if="competitor.metadata.last_updated">Last Updated: {{ competitor.metadata.last_updated }}</span>
                <div class="border border-transparent border-l-border"></div>
                <div v-if="competitor.metadata.source_urls?.length" class="flex flex-wrap gap-1">
                    <span>Sources:</span>
                    <a
                        v-for="(src, i) in competitor.metadata.source_urls"
                        :key="i"
                        :href="src"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="underline hover:text-foreground"
                    >
                        [{{ i + 1 }}]
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
