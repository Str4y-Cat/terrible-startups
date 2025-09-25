import { Idea } from '@/types/general';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

export default function useIdeaOptions(idea: Idea) {
    const getIdeaContext = () => {
        console.log('Getting context');
        router.visit(route('tool.context', idea.id), {
            method: 'post',
            onSuccess: (response) => {
                console.log('SUCCESS', response);
            },
            onError: (err) => {
                toast.error('Failed to save', {
                    style: {
                        'border-color': 'var(--color-red-600)',
                    },
                    description: 'Error performing search',
                });
            },
        });
    };

    const deleteIdea = () => {
        router.visit(`/ideas/${idea.id}`, {
            method: 'delete',
        });
    };

    const downloadIdea = () => {
        window.open(`/ideas/${idea.id}/download`, '_blank');
    };

    return {
        getIdeaContext,
        deleteIdea,
        downloadIdea,
    };
}
