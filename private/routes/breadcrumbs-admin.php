<?php

/**
 * Admin Pages Breadcrumbs
 */

// Home
Breadcrumbs::for('admin.home', function ($breadcrumbs) {
    $breadcrumbs->push('Yönetim Paneli', route('admin.home'));
});

// Home > Dashboard
Breadcrumbs::for('admin.dashboard.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.home');
    $breadcrumbs->push('Başlangıç', route('admin.dashboard.index'));
});

// Home > Settings
Breadcrumbs::for('admin.settings.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.home');
    $breadcrumbs->push('Ayarlar', route('admin.settings.edit'));
});