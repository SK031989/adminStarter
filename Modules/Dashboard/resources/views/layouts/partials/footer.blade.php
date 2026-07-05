{{-- ============================================ --}}
{{-- FOOTER PARTIAL                               --}}
{{-- Include in layout: @include('dashboard::layouts.partials.footer') --}}
{{-- ============================================ --}}

<footer class="h-14 shrink-0 border-t border-slate-200 dark:border-slate-800/80 bg-white dark:bg-slate-900 flex items-center justify-between px-6 md:px-8 text-xs font-medium text-slate-400 dark:text-slate-500 transition-colors duration-200">
    <div>
        <span>&copy; {{ date('Y') }} {{ config('app.name', 'SaaS Starter') }}. All rights reserved.</span>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.privacy-policy') }}"  class="hover:text-slate-700 dark:hover:text-slate-300 transition no-underline">Privacy Policy</a>
        <span class="text-slate-300 dark:text-slate-700">•</span>
        <a href="{{ route('admin.terms-of-service') }}" class="hover:text-slate-700 dark:hover:text-slate-300 transition no-underline">Terms of Service</a>
        <span class="text-slate-300 dark:text-slate-700">•</span>
        <a href="{{ route('admin.support') }}"          class="hover:text-slate-700 dark:hover:text-slate-300 transition no-underline">Support</a>
    </div>
</footer>
