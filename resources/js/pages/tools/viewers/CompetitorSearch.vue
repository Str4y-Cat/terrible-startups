<script setup lang="ts">
import CompetitorCard from '@/components/custom/tools/comptitorSearch/CompetitorCard.vue';
import CompetitorCardSkeleton from '@/components/custom/tools/comptitorSearch/CompetitorCardSkeleton.vue';
import { CompetitorSearchContent } from '@/types/tools';
import { ref } from 'vue';

const props = defineProps<{
    content: CompetitorSearchContent;
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

    metadata?: {
        source_urls?: string[];
        data_confidence?: number; // 0–1 confidence level
        last_updated?: string; // ISO date string
    };
}

const competitors: Competitor[] = [
    {
        name: 'Syncora',
        summary:
            'Syncora is a SaaS collaboration platform that centralizes communication, project management, and workflow automation for distributed teams.',
        key_info: ['SaaS', 'Collaboration', 'Workflow Automation', 'B2B', 'Founded 2020'],

        overview: {
            market_position:
                'Positioned as a flexible, mid-market collaboration tool focused on remote-first teams seeking unified communication and task management.',
            regions: ['North America', 'Europe', 'Asia-Pacific'],
            target_audience: ['Remote teams', 'Startups', 'Creative agencies'],
        },

        strengths: [
            'Clean and intuitive interface',
            'Strong integrations with major productivity tools',
            'Reliable real-time collaboration features',
            'Excellent onboarding and support',
        ],

        weaknesses: ['Limited offline functionality', 'No built-in video conferencing', 'Less appealing for large enterprise clients'],

        differentiators: [
            'Unified chat and task management in one workspace',
            'Smart workflow suggestions using AI',
            'Fast setup with minimal learning curve',
        ],

        value_proposition: {
            summary: 'Syncora unifies communication and workflow automation to help teams collaborate seamlessly across time zones.',
            problems_solved: 'Disjointed tools, missed deadlines, and communication gaps in remote settings.',
            desired_fulfilled: 'Empowers distributed teams to work as efficiently as in-office teams.',
            benefits: 'Improved collaboration, reduced tool fatigue, faster project completion.',
            additional: 'Integrates with Slack, Notion, and Google Workspace for smooth adoption.',
        },

        brand_identity: {
            tone: 'Friendly, helpful, and transparent.',
            personality: 'Modern, adaptable, and collaborative.',
            visual_style: 'Minimalist, warm tones with bold accent colors.',
        },

        url: 'https://www.syncora.io',

        metadata: {
            source_urls: ['https://www.syncora.io/about', 'https://reviews.example.com/syncora'],
            data_confidence: 0.9,
            last_updated: '2025-10-26',
        },
    },

    {
        name: 'Apexlytics',
        summary:
            'Apexlytics provides cloud-based business intelligence and analytics tools that help organizations make data-driven decisions with ease.',
        key_info: ['SaaS', 'Data Analytics', 'Business Intelligence', 'B2B', 'Founded 2018'],

        overview: {
            market_position:
                'Premium analytics provider targeting mid-sized to enterprise businesses seeking deeper insights through AI-powered dashboards.',
            regions: ['North America', 'Europe'],
            target_audience: ['Enterprises', 'Data analysts', 'Marketing teams'],
        },

        strengths: [
            'Advanced data visualization capabilities',
            'Seamless integration with major databases',
            'Customizable dashboards',
            'Strong data governance and security features',
        ],

        weaknesses: ['Complex setup for non-technical users', 'High licensing costs', 'Limited mobile experience'],

        differentiators: ['AI-driven predictive analytics', 'Automated anomaly detection', 'Drag-and-drop dashboard customization'],

        value_proposition: {
            summary: 'Apexlytics simplifies enterprise analytics through intuitive, AI-enhanced dashboards.',
            problems_solved: 'Slow reporting cycles and lack of actionable insights in traditional BI tools.',
            desired_fulfilled: 'Empowers decision-makers with real-time, accurate data visibility.',
            benefits: 'Faster insights, better strategic decisions, improved data literacy.',
            additional: 'Supports integrations with Snowflake, BigQuery, and Salesforce.',
        },

        brand_identity: {
            tone: 'Confident, insightful, and professional.',
            personality: 'Analytical, forward-thinking, trustworthy.',
            visual_style: 'Sleek, data-focused interface with cool blue tones.',
        },

        url: 'https://www.apexlytics.io',

        metadata: {
            source_urls: ['https://www.apexlytics.io', 'https://techdata.example.com/apexlytics-review'],
            data_confidence: 0.88,
            last_updated: '2025-10-26',
        },
    },

    {
        name: 'TaskForge',
        summary:
            'TaskForge offers a project management platform that helps small teams plan, track, and deliver projects efficiently with collaborative task boards and AI scheduling.',
        key_info: ['SaaS', 'Project Management', 'Productivity', 'B2B', 'Founded 2019'],

        overview: {
            market_position: 'Positioned as a budget-friendly Asana alternative for small and medium teams that value simplicity and automation.',
            regions: ['Global'],
            target_audience: ['Small businesses', 'Startups', 'Freelancers'],
        },

        strengths: ['Affordable pricing plans', 'Simple and intuitive design', 'Strong automation for recurring tasks', 'Responsive mobile app'],

        weaknesses: ['Limited integration options', 'No built-in reporting tools', 'Basic permission controls'],

        differentiators: ['AI-assisted project scheduling', 'Lightweight and fast UI performance', 'Transparent flat-rate pricing model'],

        value_proposition: {
            summary: 'TaskForge simplifies team project management through automation and clarity.',
            problems_solved: 'Manual scheduling, disorganized task tracking, and missed deadlines.',
            desired_fulfilled: 'Gives teams a clear overview of progress and priorities.',
            benefits: 'Saves time, reduces project delays, boosts accountability.',
            additional: 'Integrates with Google Calendar and Slack for better coordination.',
        },

        brand_identity: {
            tone: 'Friendly, supportive, and efficient.',
            personality: 'Practical, energetic, reliable.',
            visual_style: 'Vibrant color palette with modern flat icons.',
        },

        url: 'https://www.taskforge.app',

        metadata: {
            source_urls: ['https://www.taskforge.app/features'],
            data_confidence: 0.93,
            last_updated: '2025-10-26',
        },
    },

    {
        name: 'Vaultify',
        summary:
            'Vaultify is a cloud security platform offering threat detection, compliance monitoring, and identity management for modern enterprises.',
        key_info: ['SaaS', 'Cybersecurity', 'Compliance', 'Enterprise', 'Founded 2017'],

        overview: {
            market_position: 'Enterprise-focused cybersecurity provider emphasizing compliance automation and proactive risk management.',
            regions: ['North America', 'Europe', 'Middle East'],
            target_audience: ['Enterprises', 'Financial institutions', 'Healthcare providers'],
        },

        strengths: [
            'Comprehensive compliance automation',
            'Advanced threat intelligence analytics',
            'Robust API integrations',
            'High-level customer support and SLAs',
        ],

        weaknesses: ['Steep learning curve', 'High pricing for smaller organizations', 'Overwhelming configuration options'],

        differentiators: ['Real-time risk scoring system', 'AI-assisted compliance recommendations', 'End-to-end identity protection suite'],

        value_proposition: {
            summary: 'Vaultify secures enterprise systems and ensures compliance through automation and AI-driven insights.',
            problems_solved: 'Manual compliance tracking, fragmented security tools, slow incident response.',
            desired_fulfilled: 'Gives organizations confidence in their data protection posture.',
            benefits: 'Reduced risk exposure, faster audits, stronger compliance alignment.',
            additional: 'Compatible with AWS, Azure, and GCP security ecosystems.',
        },

        brand_identity: {
            tone: 'Serious, protective, and authoritative.',
            personality: 'Trustworthy, advanced, and vigilant.',
            visual_style: 'Dark mode aesthetic with sharp geometric visuals.',
        },

        url: 'https://www.vaultify.io',

        metadata: {
            source_urls: ['https://www.vaultify.io', 'https://securitynews.example.com/vaultify'],
            data_confidence: 0.86,
            last_updated: '2025-10-26',
        },
    },

    {
        name: 'FlowBank',
        summary:
            'FlowBank provides an API-driven fintech platform that enables startups to build and launch digital banking services quickly and securely.',
        key_info: ['SaaS', 'Fintech', 'API Platform', 'B2B2C', 'Founded 2021'],

        overview: {
            market_position: 'API-first banking-as-a-service provider targeting fintech startups and challenger banks.',
            regions: ['North America', 'Europe'],
            target_audience: ['Fintech startups', 'Neobanks', 'Payment providers'],
        },

        strengths: [
            'Rapid integration with existing infrastructure',
            'Scalable and compliant banking APIs',
            'Strong developer documentation',
            'Excellent uptime and performance',
        ],

        weaknesses: ['Limited customization for non-standard financial products', 'Requires regulatory knowledge to implement effectively'],

        differentiators: ['Plug-and-play banking modules', 'Built-in fraud detection AI', 'PSD2 and SOC2 compliance out of the box'],

        value_proposition: {
            summary: 'FlowBank accelerates digital banking innovation with secure, developer-friendly APIs.',
            problems_solved: 'Complex banking integrations and long product launch cycles.',
            desired_fulfilled: 'Enables fintechs to launch faster and focus on user experience.',
            benefits: 'Shorter development times, lower compliance costs, faster market entry.',
            additional: 'Supports card issuing, payments, and customer onboarding modules.',
        },

        brand_identity: {
            tone: 'Professional, confident, and innovative.',
            personality: 'Technical, forward-looking, and precise.',
            visual_style: 'Clean and tech-oriented with gradients of blue and teal.',
        },

        url: 'https://www.flowbank.dev',

        metadata: {
            source_urls: ['https://www.flowbank.dev/docs', 'https://fintechpulse.example.com/flowbank'],
            data_confidence: 0.9,
            last_updated: '2025-10-26',
        },
    },

    {
        name: 'Lumino',
        summary:
            'Lumino is an AI-powered marketing automation platform that helps brands optimize campaigns, personalize content, and predict customer behavior.',
        key_info: ['SaaS', 'AI Marketing', 'Automation', 'B2C', 'Founded 2022'],

        overview: {
            market_position:
                'Emerging AI marketing tool positioned for growth-focused brands seeking smarter personalization and campaign automation.',
            regions: ['Global'],
            target_audience: ['Marketing teams', 'E-commerce brands', 'Digital agencies'],
        },

        strengths: [
            'Advanced AI-driven audience segmentation',
            'Strong content personalization engine',
            'Clean, visual campaign dashboard',
            'Affordable for startups and SMBs',
        ],

        weaknesses: ['Limited reporting customization', 'Few third-party integrations', 'No built-in CRM capabilities'],

        differentiators: ['Real-time AI campaign optimization', 'Automatic A/B testing recommendations', 'Predictive customer engagement scoring'],

        value_proposition: {
            summary: 'Lumino empowers marketers with AI tools to create smarter, more effective campaigns.',
            problems_solved: 'Generic targeting, wasted ad spend, and poor personalization.',
            desired_fulfilled: 'Helps brands connect authentically and efficiently with audiences.',
            benefits: 'Higher conversion rates, improved ROI, and faster campaign execution.',
            additional: 'Integrates with Meta Ads, HubSpot, and Shopify.',
        },

        brand_identity: {
            tone: 'Energetic, creative, and insightful.',
            personality: 'Innovative, bold, and data-driven.',
            visual_style: 'Vibrant gradients with lively motion effects.',
        },

        url: 'https://www.lumino.ai',

        metadata: {
            source_urls: ['https://www.lumino.ai', 'https://marketingreview.example.com/lumino'],
            data_confidence: 0.92,
            last_updated: '2025-10-26',
        },
    },
];
const trigger = ref(false);
</script>

<template>
    <Button @click="trigger = !trigger">Test</Button>
    <div v-if="trigger" class="flex w-full flex-col">
        <CompetitorCardSkeleton class="w-full" v-for="n in 5" :key="n"></CompetitorCardSkeleton>
    </div>

    <div v-else>
        <CompetitorCard v-for="competitor in competitors" :key="competitor.name" :competitor="competitor" />
    </div>
</template>
