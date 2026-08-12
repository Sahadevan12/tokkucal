@if (config('services.analytics.id') && config('app.env') === 'production')
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.analytics.id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', @json(config('services.analytics.id')));
    </script>
@endif
