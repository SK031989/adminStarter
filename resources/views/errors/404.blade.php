@php
    $settingsPath = config_path('settings.json');
    $theme = config('marketing.default_theme', 'obsidian');
    if (file_exists($settingsPath)) {
        $settings = json_decode(file_get_contents($settingsPath), true);
        $theme = $settings['active_theme'] ?? $theme;
    }
@endphp

@include("themes.{$theme}.pages.404")
