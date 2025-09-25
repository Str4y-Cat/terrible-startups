import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import '../css/app.css';
import { initializeTheme } from './composables/useAppearance';
import { useHistory } from './composables/useHistory';

const appName = import.meta.env.VITE_APP_NAME || 'Terrible Startups';

createInertiaApp({
    // title: (title) => (title ? `${title} - ${appName}` : appName),
    title: (title) => (title ? `${title}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    // progress: {
    //     color: '#4B5563',
    // },
});

const { trackNavigation } = useHistory();
router.on('navigate', () => {
    trackNavigation();
});

// This will set light / dark mode on page load...
initializeTheme();
