<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketingController extends Controller
{
    /**
     * Show the main landing / home page.
     */
    public function index(): View
    {
        $features = config('marketing.features', []);
        $pricing  = config('marketing.pricing', []);

        return view($this->getThemeView('index'), compact('features', 'pricing'));
    }

    /**
     * Show the detailed features list.
     */
    public function features(): View
    {
        $features = config('marketing.features', []);

        return view($this->getThemeView('features'), compact('features'));
    }

    /**
     * Show the pricing page.
     */
    public function pricing(): View
    {
        $pricing = config('marketing.pricing', []);

        return view($this->getThemeView('pricing'), compact('pricing'));
    }

    /**
     * Show the contact page.
     */
    public function contact(): View
    {
        return view($this->getThemeView('contact'));
    }

    /**
     * Retrieve the view path of the active theme.
     */
    protected function getThemeView(string $view): string
    {
        $settingsPath = config_path('settings.json');
        $theme = config('marketing.default_theme', 'obsidian');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            $theme = $settings['active_theme'] ?? $theme;
        }
        return "themes.{$theme}.pages.{$view}";
    }
}
