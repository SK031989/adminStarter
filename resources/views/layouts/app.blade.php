@php
    $settingsPath = config_path('settings.json');
    $activeTheme = 'obsidian';
    if (file_exists($settingsPath)) {
        $settings = json_decode(file_get_contents($settingsPath), true);
        $activeTheme = $settings['active_theme'] ?? 'obsidian';
    }
    $themeLayout = "themes.{$activeTheme}.layouts.marketing";
@endphp

@extends($themeLayout)

@section('content')
    @yield('content')
@endsection
