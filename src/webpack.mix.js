const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/pmis.js', 'public/js')
    .js('resources/js/pension.js', 'public/js')
    .js('resources/js/pmis_operations.js', 'public/js')
    .js('resources/js/accounts.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/application_service.js', 'public/js')
    .js('resources/js/approval_service.js', 'public/js')
    .js('resources/js/leave.js', 'public/js')
    .js('resources/js/attendance.js', 'public/js')
    .js('resources/js/pmis_provident_fund.js', 'public/js')
    .js('resources/js/pmis_acr.js', 'public/js')
    .js('resources/js/overtime.js', 'public/js')
    .js('resources/js/payroll.js', 'public/js')
    .js('resources/js/loan.js', 'public/js')
    .js('resources/js/dashboard/dashboard.js', 'public/js')
    .js('resources/js/cmdashboard/cmdb.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css') .version();

