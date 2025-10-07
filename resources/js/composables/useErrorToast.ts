import { toast } from 'vue-sonner';
type Errors = { [key: string]: string };

export function errorToast(title: string = 'Failed', errors: Errors): void {
    let count = 0;

    for (const key in errors) {
        toast.error(title, {
            style: {
                'border-color': 'var(--color-red-600)',
            },
            description: `${errors[key]}`,
            duration: 10000,
        });

        setTimeout(() => {
            setTimeout(() => {
                toast.error(title, {
                    style: {
                        'border-color': 'var(--color-red-600)',
                    },
                    description: `${errors[key]}`,
                    duration: 10000,
                });
            }, count * 500);
        }, count * 500);
        count++;
    }
}
