<!-- Tailwind Custom Configuration -->
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    primary: {
                        '50': '#eef9ff',
                        '100': '#d8f1ff',
                        '200': '#b9e8ff',
                        '300': '#89dbff',
                        '400': '#51c5ff',
                        '500': '#00A3FF',
                        '600': '#0088DD',
                        '700': '#006BB3',
                        '800': '#005A93',
                        '900': '#004A7A',
                        '950': '#002E4D'
                    },
                    sidebar: {
                        light: '#ffffff',
                        dark: '#0f172a'
                    }
                },
                fontFamily: {
                    sans: ['Figtree', 'Inter', 'system-ui', '-apple-system', 'sans-serif']
                },
                boxShadow: {
                    'card': '0 1px 3px 0 rgba(0,0,0,0.04), 0 1px 2px -1px rgba(0,0,0,0.06)',
                    'card-hover': '0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04)',
                    'nav': '0 1px 3px 0 rgba(0,0,0,0.05)',
                    'dropdown': '0 10px 40px rgba(0,0,0,0.12)'
                },
                animation: {
                    'fade-in': 'fadeIn 0.2s ease-out',
                    'slide-in': 'slideIn 0.3s ease-out',
                    'slide-down': 'slideDown 0.2s ease-out',
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'bounce-slow': 'bounce 2s infinite'
                },
                keyframes: {
                    fadeIn: {
                        '0%': { opacity: '0', transform: 'translateY(-10px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' }
                    },
                    slideIn: {
                        '0%': { opacity: '0', transform: 'translateX(-20px)' },
                        '100%': { opacity: '1', transform: 'translateX(0)' }
                    },
                    slideDown: {
                        '0%': { opacity: '0', transform: 'translateY(-10px) scaleY(0.95)' },
                        '100%': { opacity: '1', transform: 'translateY(0) scaleY(1)' }
                    }
                }
            }
        }
    }
</script>

<!-- Global Custom Styles -->
<style>
    /* Custom Scrollbar Styles */
    ::-webkit-scrollbar {
        width: 5px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .dark ::-webkit-scrollbar-thumb {
        background: #334155;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .dark ::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    /* Layout & Component Animations */
    .sidebar-transition {
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .progress-fill {
        transition: width 1s ease-in-out;
    }

    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    .dark .skeleton {
        background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%);
        background-size: 200% 100%;
    }

    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    [x-cloak] {
        display: none !important;
    }

    /* Sidebar Navigation Styles (Pixel-Perfect Tight Spacing) */
    .nav-link,
    .nav-toggle {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.375rem 0.625rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: color 0.15s ease, transform 0.15s ease;
        color: #64748b;
        text-decoration: none;
        position: relative;
        background: none;
        border: none;
        width: 100%;
        cursor: pointer;
    }

    .nav-sub-link {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.25rem 0.625rem;
        font-size: 0.8125rem;
        border-radius: 0.375rem;
        color: #64748b;
        transition: color 0.15s ease;
        position: relative;
        text-decoration: none;
    }

    .dark .nav-link,
    .dark .nav-toggle,
    .dark .nav-sub-link {
        color: #94a3b8;
    }

    /* Accessibility Focus States */
    .nav-link:focus-visible,
    .nav-toggle:focus-visible,
    .nav-sub-link:focus-visible {
        outline: 2px solid #00A3FF;
        outline-offset: 2px;
    }

    /* Hover States */
    .nav-link:hover,
    .nav-toggle:hover,
    .nav-sub-link:hover {
        background-color: #f1f5f9;
        color: #00A3FF;
    }

    .dark .nav-link:hover,
    .dark .nav-toggle:hover,
    .dark .nav-sub-link:hover {
        background-color: #1e293b;
        color: #51c5ff;
    }

    /* Active States (Soft Blue Pill) */
    .nav-link.active,
    .nav-toggle.active,
    .nav-sub-link.active {
        background-color: #e0f2fe;
        color: #0284c7;
        font-weight: 600;
    }

    .dark .nav-link.active,
    .dark .nav-toggle.active,
    .dark .nav-sub-link.active {
        background-color: rgba(2, 132, 199, 0.18);
        color: #38bdf8;
    }

    /* Navigation Icons (Compact 24px Container) */
    .nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        flex-shrink: 0;
        color: #94a3b8;
        background-color: transparent;
        transition: color 0.15s ease, transform 0.15s ease;
    }

    .dark .nav-icon {
        color: #64748b;
    }

    .nav-link.active .nav-icon,
    .nav-toggle.active .nav-icon {
        background-color: transparent;
        color: #0284c7;
    }

    .dark .nav-link.active .nav-icon,
    .dark .nav-toggle.active .nav-icon {
        background-color: transparent;
        color: #38bdf8;
    }

    .nav-link:hover .nav-icon,
    .nav-toggle:hover .nav-icon {
        color: #00A3FF;
        transform: scale(1.05);
    }

    .dark .nav-link:hover .nav-icon,
    .dark .nav-toggle:hover .nav-icon {
        color: #51c5ff;
        transform: scale(1.05);
    }

    /* Submenu Tree Styles */
    .nav-submenu {
        margin-top: 0.125rem;
        margin-left: 0.75rem;
        padding-left: 0.75rem;
        border-left: 2px solid #e2e8f0;
    }

    .dark .nav-submenu {
        border-left-color: #334155;
    }

    .sub-icon {
        width: 1rem;
        text-align: center;
        font-size: 0.7rem;
        color: #94a3b8;
        flex-shrink: 0;
        transition: color 0.15s ease;
    }

    .nav-sub-link:hover .sub-icon,
    .nav-sub-link.active .sub-icon {
        color: #00A3FF;
    }

    .dark .nav-sub-link:hover .sub-icon,
    .dark .nav-sub-link.active .sub-icon {
        color: #51c5ff;
    }

    .nav-arrow {
        font-size: 0.7rem;
        transition: transform 0.2s ease, color 0.15s ease;
        color: #94a3b8;
    }

    .nav-arrow.rotated {
        transform: rotate(180deg);
    }

    /* Navigation Badges */
    .nav-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.125rem 0.5rem;
        font-size: 0.7rem;
        font-weight: 700;
        border-radius: 9999px;
        background-color: #eef9ff;
        color: #006BB3;
        margin-left: auto;
    }

    .dark .nav-badge {
        background-color: rgba(0, 163, 255, 0.15);
        color: #51c5ff;
    }

    .nav-badge.badge-new {
        background-color: #f0fdf4;
        color: #16a34a;
    }

    .dark .nav-badge.badge-new {
        background-color: rgba(22, 163, 74, 0.15);
        color: #4ade80;
    }

    /* Dark mode autofill fix */
    .dark input:-webkit-autofill,
    .dark input:-webkit-autofill:hover, 
    .dark input:-webkit-autofill:focus, 
    .dark input:-webkit-autofill:active,
    .dark textarea:-webkit-autofill,
    .dark select:-webkit-autofill {
        -webkit-box-shadow: 0 0 0 1000px #0f172a inset !important;
        -webkit-text-fill-color: #f8fafc !important;
        caret-color: #f8fafc !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* Dark mode HTML5 Audio player styling */
    .dark audio {
        filter: invert(1) hue-rotate(180deg) brightness(0.88) contrast(1.1);
        border-radius: 9999px;
    }

    @media print {
        .no-print { display: none !important; }
        .print-only { display: block !important; }
    }
</style>

<!-- Vendor CSS Dependencies -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.css" />
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/datatables/dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/toastr/toastr.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/summernote/summernote-lite.min.css') }}" />
