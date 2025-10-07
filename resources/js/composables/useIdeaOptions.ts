import { Idea } from '@/types/general';
import { router } from '@inertiajs/vue3';
import { errorToast } from './useErrorToast';

export default function useIdeaOptions(idea: Idea) {
    const getIdeaContext = () => {
        console.log('Getting context');
        router.visit(route('tool.context', idea.id), {
            method: 'post',
            onSuccess: (response) => {
                console.log('SUCCESS', response);
            },
            onError: (err) => {
                errorToast('Failed to save', err);
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
