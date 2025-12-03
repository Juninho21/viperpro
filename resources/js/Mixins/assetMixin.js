import { Mixin } from 'laravel-vue-i18n';

export const assetMixin = {
    methods: {
        asset(path) {
            // Remove leading slash if present
            const cleanPath = path.startsWith('/') ? path.substring(1) : path;
            // Use the VITE_ASSET_URL from env if available, otherwise fallback to /
            const baseUrl = import.meta.env.VITE_ASSET_URL || '';
            
            // Remove trailing slash from baseUrl if present and ensure cleanPath doesn't start with one
            const cleanBaseUrl = baseUrl.endsWith('/') ? baseUrl.slice(0, -1) : baseUrl;
            
            return `${cleanBaseUrl}/${cleanPath}`;
        }
    }
};
