import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

const reverbKey = import.meta.env.VITE_REVERB_APP_KEY;
const isReverbEnabled = String(import.meta.env.VITE_REVERB_ENABLED || '').toLowerCase() === 'true';

if (typeof window !== 'undefined') {
    if (reverbKey && isReverbEnabled) {
        try {
            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'reverb',
                key: reverbKey,
                wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
                wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
                wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),
                forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
                enabledTransports: ['ws', 'wss'],
                enableStats: false,
            });

            const conn = window.Echo?.connector?.pusher?.connection;
            if (conn) {
                conn.bind('error', () => {
                    try { window.Echo?.disconnect(); } catch (_) {}
                    window.Echo = null;
                });
                conn.bind('unavailable', () => {
                    try { window.Echo?.disconnect(); } catch (_) {}
                    window.Echo = null;
                });
                conn.bind('failed', () => {
                    try { window.Echo?.disconnect(); } catch (_) {}
                    window.Echo = null;
                });
            }
        } catch {
            window.Echo = null;
        }
    } else {
        window.Echo = null;
    }
}

createInertiaApp({
    title: (title) => `${title} | ${import.meta.env.VITE_APP_NAME ?? 'INTOK Academy'}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
    progress: { color: '#dc2626' },
});
