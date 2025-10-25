import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: false,
    wsPath: '/ws',
    enabledTransports: ['ws', 'wss'],
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                fetch('/broadcasting/auth', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        socket_id: socketId,
                        channel_name: channel.name
                    })
                })
                .then(response => response.json())
                .then(data => callback(null, data))
                .catch(error => callback(error));
            }
        };
    }
});

// Debug Echo connection
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('✅ Echo connected to Reverb');
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.log('❌ Echo disconnected from Reverb');
});

window.Echo.connector.pusher.connection.bind('error', (error) => {
    console.error('❌ Echo connection error:', error);
});
