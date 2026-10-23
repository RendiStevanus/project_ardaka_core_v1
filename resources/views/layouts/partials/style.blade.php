<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}">
<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}">

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    .btn-xs {
        --bs-btn-padding-y: .25rem;
        --bs-btn-padding-x: .5rem;
        --bs-btn-font-size: .75rem;
    }

    .btn i {
        position: relative;
        top: -2px;
    }

    .dropdown-item i {
        position: relative;
        top: -2px;
    }

    /* Dark */
    html[data-bs-theme="dark"] .btn-xs {
        --bs-btn-padding-y: .25rem;
        --bs-btn-padding-x: .5rem;
        --bs-btn-font-size: .75rem;
    }

    html[data-bs-theme="dark"] .btn i {
        position: relative;
        top: -2px;
    }

    html[data-bs-theme="dark"] .dropdown-item {
        color: #fff;
    }

    html[data-bs-theme="dark"] .dropdown-item i {
        position: relative;
        color: #fff;
        top: -2px;
    }

    /* =========================================================
       Sticky Footer - Mazer
       ========================================================= */

    html,
    body {
        min-height: 100%;
    }

    #app {
        min-height: 100vh;
    }

    #app #main {
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
    }

    #app #main #main-content {
        flex: 1 0 auto !important;
    }

    #app #main>footer {
        margin-top: auto !important;
        flex-shrink: 0 !important;
    }
</style>
