@extends('dashboard::layouts.admin')

@section('title', 'System Configuration')

@section('content')
<div class="container-fluid py-4">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl flex items-center gap-3 text-sm">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 dark:border-slate-800/60 pb-5">
                <div class="p-3 bg-purple-100 dark:bg-purple-500/10 text-purple-600 rounded-2xl">
                    <i data-lucide="sliders" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Marketing Theme Configuration</h2>
                    <p class="text-xs text-slate-400 font-medium">Select the active public theme for marketing and landing pages.</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="project_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Project Name</label>
                        <input type="text" name="project_name" id="project_name" value="{{ old('project_name', $projectName) }}" class="form-input block w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-slate-850 dark:border-slate-855 dark:text-white" placeholder="e.g. SaaSStater">
                        @error('project_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="project_logo" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Project Logo Icon (Lucide)</label>
                        <select name="project_logo" id="project_logo" class="form-select block w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-slate-850 dark:border-slate-855 dark:text-white">
                            @php
                                $logos = [
                                    'shield' => 'Shield',
                                    'box' => 'Box',
                                    'cpu' => 'CPU',
                                    'database' => 'Database',
                                    'globe' => 'Globe',
                                    'heart' => 'Heart',
                                    'key' => 'Key',
                                    'lock' => 'Lock',
                                    'settings' => 'Settings',
                                    'user' => 'User',
                                    'activity' => 'Activity',
                                    'briefcase' => 'Briefcase',
                                    'calendar' => 'Calendar',
                                    'compass' => 'Compass',
                                    'feather' => 'Feather',
                                    'server' => 'Server',
                                    'terminal' => 'Terminal',
                                    'wind' => 'Wind'
                                ];
                            @endphp
                            @foreach($logos as $value => $label)
                                <option value="{{ $value }}" {{ old('project_logo', $projectLogo) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('project_logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="project_description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Project Description</label>
                        <textarea name="project_description" id="project_description" rows="3" class="form-textarea block w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-slate-850 dark:border-slate-855 dark:text-white" placeholder="Provide a brief description of this project...">{{ old('project_description', $projectDescription) }}</textarea>
                        @error('project_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="theme" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Active Frontend Theme</label>
                        <select name="theme" id="theme" class="form-select block w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 dark:bg-slate-850 dark:border-slate-855 dark:text-white">
                            <option value="obsidian" {{ $activeTheme === 'obsidian' ? 'selected' : '' }}>Obsidian Cosmic </option>
                            <option value="cyber" {{ $activeTheme === 'cyber' ? 'selected' : '' }}>Cyber Neon Blue</option>
                            <option value="astral" {{ $activeTheme === 'astral' ? 'selected' : '' }}>Astral Purple Glass</option>
                            <option value="minimal" {{ $activeTheme === 'minimal' ? 'selected' : '' }}>Minimalist Light</option>
                        </select>
                        @error('theme')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-gradient-to-tr from-purple-600 to-indigo-600 text-white rounded-xl font-medium text-sm hover:from-purple-700 hover:to-indigo-700 transition shadow-md shadow-purple-500/10 flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
