let mix = require('laravel-mix');

mix.setPublicPath('public');
mix.setResourceRoot('../../wp-content/plugins/crm-roadmap/public');
mix.disableNotifications()
    .js('src/main.js', 'assets/js/admin.js').vue({ version: 3 })
    .js('src/frontend/frontend-main.js', 'assets/js/frontend.js').vue({version: 3})
    .sourceMaps(false)