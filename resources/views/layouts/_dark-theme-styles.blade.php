<style>
    :root {
        --app-bg: #0d1117;
        --app-surface: #161b22;
        --app-surface-soft: #1f2630;
        --app-border: #2f3947;
        --app-text: #e6edf3;
        --app-muted: #9aa4b2;
        --app-brand: #1f8f55;
        --app-brand-dark: #0f5132;
    }

    body.app-theme {
        background: radial-gradient(circle at top left, rgba(31, 143, 85, 0.18), transparent 28%), var(--app-bg);
        color: var(--app-text);
    }

    .app-topbar {
        background: linear-gradient(90deg, var(--app-brand-dark), var(--app-brand));
    }

    .app-main {
        flex: 1 1 auto;
    }

    .card {
        background-color: var(--app-surface);
        border-color: var(--app-border);
        color: var(--app-text);
    }

    .card-header,
    .card-footer {
        background-color: color-mix(in srgb, var(--app-surface-soft) 88%, black 12%);
        border-color: var(--app-border);
        color: var(--app-text);
    }

    .table {
        --bs-table-color: var(--app-text);
        --bs-table-bg: transparent;
        --bs-table-striped-color: var(--app-text);
        --bs-table-striped-bg: rgba(255, 255, 255, 0.02);
        --bs-table-active-bg: rgba(255, 255, 255, 0.04);
        --bs-table-hover-color: #fff;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
        border-color: var(--app-border);
    }

    .table > :not(caption) > * > * {
        border-bottom-color: var(--app-border);
    }

    .form-control,
    .form-select,
    .form-check-input {
        background-color: #0f141b;
        border-color: var(--app-border);
        color: var(--app-text);
    }

    .form-control::placeholder {
        color: var(--app-muted);
    }

    .form-control:focus,
    .form-select:focus,
    .form-check-input:focus {
        border-color: #3d7bfd;
        box-shadow: 0 0 0 0.2rem rgba(61, 123, 253, 0.2);
    }

    .text-secondary,
    .text-muted {
        color: var(--app-muted) !important;
    }

    .bg-white,
    .bg-light,
    .bg-body-tertiary {
        background-color: var(--app-surface) !important;
    }

    .border,
    .border-top,
    .border-bottom,
    .border-secondary,
    .border-secondary-subtle {
        border-color: var(--app-border) !important;
    }

    .dropdown-menu {
        --bs-dropdown-bg: #0f141b;
        --bs-dropdown-color: var(--app-text);
        --bs-dropdown-border-color: var(--app-border);
        --bs-dropdown-link-color: var(--app-text);
        --bs-dropdown-link-hover-bg: rgba(255, 255, 255, 0.08);
        --bs-dropdown-link-hover-color: #fff;
        --bs-dropdown-divider-bg: var(--app-border);
    }

    .pagination {
        --bs-pagination-bg: #0f141b;
        --bs-pagination-border-color: var(--app-border);
        --bs-pagination-color: var(--app-muted);
        --bs-pagination-hover-bg: #1c2430;
        --bs-pagination-hover-color: #fff;
        --bs-pagination-hover-border-color: #4b5563;
        --bs-pagination-active-bg: var(--app-brand);
        --bs-pagination-active-border-color: var(--app-brand);
    }

    .alert-success {
        background-color: rgba(31, 143, 85, 0.2);
        border-color: rgba(31, 143, 85, 0.45);
        color: #d7fbe7;
    }

    .block { display: block; }
    .inline-flex { display: inline-flex; }
    .flex { display: flex; }
    .items-center { align-items: center; }
    .justify-end { justify-content: flex-end; }
    .w-full { width: 100%; }
    .mt-1 { margin-top: 0.25rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-4 { margin-top: 1rem; }
    .text-sm { font-size: 0.875rem; }
    .rounded-md { border-radius: 0.375rem; }
    .underline { text-decoration: underline; }
    .text-gray-600 { color: var(--app-muted) !important; }
    .text-gray-900 { color: var(--app-text) !important; }
    .hover\:text-gray-900:hover { color: #ffffff !important; }
    .focus\:outline-none:focus { outline: none !important; }
    .focus\:ring-2:focus,
    .focus\:ring-indigo-500:focus {
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25) !important;
    }
</style>