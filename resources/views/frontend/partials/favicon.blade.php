<!-- Favicons & Platform Icons -->
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

<!-- Web App Manifest & Android / PWA Support -->
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<meta name="theme-color" content="#111827">
<meta name="msapplication-TileColor" content="#0B0F17">
<meta name="application-name" content="PickMeRoute">

<!-- Apple iOS Safari Web App Directives -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="PickMeRoute">

<!-- Search Engine Optimization (SEO) Metadata -->
<meta name="description" content="{{ __('Daily scheduled intercity passenger minivan shuttle between Montreal (Namur Metro) and Toronto (Yorkdale & Yonge). Fixed schedule, reserved seating, cash payment upon boarding.') }}">
<meta name="keywords" content="Montreal Toronto shuttle, intercity shuttle Montreal Toronto, Montreal Toronto bus, PickMeRoute, reserved minivan shuttle, Station Metro Namur to Yorkdale">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Bilingual Hreflang Canonical Alternate Directives -->
<link rel="alternate" hreflang="en" href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}">
<link rel="alternate" hreflang="fr" href="{{ request()->fullUrlWithQuery(['lang' => 'fr']) }}">
<link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

<!-- Open Graph Protocol (Facebook, WhatsApp, LinkedIn, iMessage previews) -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="PickMeRoute">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', 'PickMeRoute — ' . __('Daily Montreal ↔ Toronto Passenger Shuttle'))">
<meta property="og:description" content="{{ __('Daily scheduled intercity passenger minivan shuttle between Montreal (Namur Metro) and Toronto (Yorkdale & Yonge). Fixed schedule, reserved seating, cash payment upon boarding.') }}">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="PickMeRoute Daily Montreal ↔ Toronto Shuttle">
<meta property="og:locale" content="{{ app()->getLocale() === 'fr' ? 'fr_CA' : 'en_CA' }}">
<meta property="og:locale:alternate" content="{{ app()->getLocale() === 'fr' ? 'en_CA' : 'fr_CA' }}">

<!-- Twitter Card Protocol (Twitter / X Card Previews) -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', 'PickMeRoute — ' . __('Daily Montreal ↔ Toronto Passenger Shuttle'))">
<meta name="twitter:description" content="{{ __('Daily scheduled intercity passenger minivan shuttle between Montreal (Namur Metro) and Toronto (Yorkdale & Yonge). Fixed schedule, reserved seating, cash payment upon boarding.') }}">
<meta name="twitter:image" content="{{ asset('images/og-image.jpg') }}">
<meta name="twitter:image:alt" content="PickMeRoute Montreal ↔ Toronto Shuttle">
