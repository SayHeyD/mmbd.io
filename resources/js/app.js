import './bootstrap';
import '../css/app.css';
import 'primevue/resources/themes/aura-dark-noir/theme.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import Toast from "primevue/toast";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            // Plugins
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue)
            .use(ToastService)

            // Directives
            .directive('tooltip', Tooltip)

            // Components
            .component('Toast', Toast)

            // Mount app
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
