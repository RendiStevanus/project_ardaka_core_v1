<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    @props(['title', 'subtitle' => null])

    <div class="auth-page">
        <style>
            .auth-page {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
                background:
                    radial-gradient(1000px 500px at 50% -10%, var(--ardaka-blue-soft), transparent 70%),
                    #f5f8ff;
            }

            .auth-card {
                width: 100%;
                max-width: 420px;
                padding: 2.25rem 2rem;
                background: #fff;
                border-top: 4px solid var(--ardaka-blue);
                border-radius: 1rem;
                box-shadow: 0 10px 40px rgba(26, 86, 219, .12);
            }

            .auth-brand {
                display: flex;
                justify-content: center;
                margin-bottom: 1.5rem;
            }

            .auth-brand img {
                height: 44px;
                width: auto;
            }

            .auth-heading {
                margin-bottom: .25rem;
                font-size: 1.5rem;
                font-weight: 700;
                text-align: center;
            }

            .auth-sub {
                margin-bottom: 1.75rem;
                text-align: center;
                color: #6b7a99;
            }

            .auth-footer {
                margin-top: 1.5rem;
                text-align: center;
                font-size: .925rem;
                color: #6b7a99;
            }

            .auth-copy {
                margin: 1.5rem 0 0;
                font-size: .8rem;
                text-align: center;
                color: #8a97b1;
            }

            .auth-page a {
                color: var(--ardaka-blue);
                font-weight: 500;
                text-decoration: none;
            }

            .auth-page a:hover {
                text-decoration: underline;
            }

            .auth-page .input-group-text {
                display: flex;
                align-items: center;
                background: transparent;
                color: #6b7a99;
            }

            .auth-page .input-group-text .bi::before {
                vertical-align: 0;
                line-height: 1;
            }

            .auth-page .auth-eye {
                cursor: pointer;
            }

            .auth-page .form-control:focus {
                border-color: var(--ardaka-blue);
                box-shadow: 0 0 0 .2rem rgba(26, 86, 219, .15);
            }

            .auth-page .form-check-input:checked {
                background-color: var(--ardaka-blue);
                border-color: var(--ardaka-blue);
            }

            .auth-page .btn-primary {
                --bs-btn-bg: var(--ardaka-blue);
                --bs-btn-border-color: var(--ardaka-blue);
                --bs-btn-hover-bg: var(--ardaka-blue-dark);
                --bs-btn-hover-border-color: var(--ardaka-blue-dark);
                --bs-btn-active-bg: var(--ardaka-blue-dark);
                --bs-btn-active-border-color: var(--ardaka-blue-dark);
                --bs-btn-disabled-bg: var(--ardaka-blue);
                --bs-btn-disabled-border-color: var(--ardaka-blue);
            }

            [data-bs-theme="dark"] .auth-page {
                background:
                    radial-gradient(1000px 500px at 50% -10%, rgba(26, 86, 219, .25), transparent 70%),
                    #151521;
            }

            [data-bs-theme="dark"] .auth-card {
                background: #1e1e2d;
                box-shadow: 0 10px 40px rgba(0, 0, 0, .4);
            }
        </style>

        <div class="auth-card">
            <a href="{{ route('home') }}" class="auth-brand">
                <img src="{{ asset('img/logo/logostt-lightmode.png') }}" alt="Logo">
            </a>

            <h1 class="auth-heading">{{ $title }}</h1>

            @if ($subtitle)
                <p class="auth-sub">{{ $subtitle }}</p>
            @endif

            {{ $slot }}

            @isset($footer)
                <div class="auth-footer">{{ $footer }}</div>
            @endisset
        </div>

        <p class="auth-copy">
            &copy; {{ date('Y') }} ARDAKA TECHNOLOGIES &middot; Simple Systems. Smarter Organizations.
        </p>
    </div>
</div>
