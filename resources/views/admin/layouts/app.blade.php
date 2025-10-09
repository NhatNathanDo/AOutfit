<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ theme: localStorage.getItem('theme') || 'light', toggle(){ this.theme = this.theme==='light' ? 'dark' : 'light'; localStorage.setItem('theme', this.theme); document.documentElement.dataset.theme = this.theme; } }" x-init="document.documentElement.dataset.theme = theme">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="color-scheme" content="light dark">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

    </head>
    <body class="min-h-screen flex flex-col bg-base-200 text-base-content selection:bg-primary/30 selection:text-primary-content">
        <div class="bg-base-200 flex min-h-screen flex-col">
        <!-- ---------- HEADER ---------- -->
        <div class="bg-base-100 sticky top-0 z-50 flex lg:ps-75">
        <div class="mx-auto w-full max-w-7xl">
            <nav class="navbar h-16">
            <button
                type="button"
                class="btn btn-soft btn-square btn-sm me-2 lg:hidden"
                aria-haspopup="dialog"
                aria-expanded="false"
                aria-controls="layout-toggle"
                data-overlay="#layout-toggle"
            >
                <span class="icon-[tabler--menu-2] size-4.5"></span>
            </button>
            </nav>
        </div>
        </div>
        <!-- ---------- END HEADER ---------- -->

        <!-- ---------- MAIN SIDEBAR ---------- -->
        <aside
        id="layout-toggle"
        class="overlay overlay-open:translate-x-0 drawer drawer-start inset-y-0 start-0 hidden h-full [--auto-close:lg] sm:w-75 lg:block lg:translate-x-0 lg:shadow-none"
        aria-label="Sidebar"
        tabindex="-1"
        >
        <div class="drawer-body border-base-content/20 h-full border-e p-0">
            <div class="flex h-full max-h-full flex-col">
            <button
                type="button"
                class="btn btn-text btn-circle btn-sm absolute end-3 top-3 lg:hidden"
                aria-label="Close"
                data-overlay="#layout-toggle"
            >
                <span class="icon-[tabler--x] size-5"></span>
            </button>
            <div class="text-base-content border-base-content/20 flex flex-col items-center gap-4 border-b px-4 py-6">
                <div class="text-center">
                <h1 class="text-lg font-bold leading-none">AOutfit Admin</h1>
                </div>
            </div>
            <div class="h-full overflow-y-auto">
                <ul class="menu menu-sm gap-1 px-4">
                <!-- Dashboard -->
                <li class="mt-2.5">
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--dashboard] size-4.5"></span>
                    <span class="grow">Dashboard</span>
                    <span class="badge badge-sm badge-primary rounded-full">2</span>
                    </a>
                </li>
                <li class="text-base-content/50 mt-2.5 p-2 text-xs uppercase">Quản lý</li>
                <!-- Content Performance -->
                <li>
                    <a href="{{ route('admin.products.page') }}" class="px-2">
                    <span class="icon-[tabler--shirt] size-4.5"></span>
                        Sản phẩm
                    </a>
                </li>
                <!-- Audience Insights -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--label] size-4.5"></span>
                        Nhãn hàng
                    </a>
                </li>
                <!-- Engagement Metrics -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--category] size-4.5"></span>
                        Danh mục
                    </a>
                </li>
                <!-- Hashtag Performance -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--hash] size-4.5"></span>
                    <span class="grow">Hashtag Performance</span>
                    <span class="badge badge-sm badge-success rounded-full">3</span>
                    </a>
                </li>
                <!-- Competitor Analysis -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--arrows-left-right] size-4.5"></span>
                    Competitor Analysis
                    </a>
                </li>
                <!-- Campaign Tracking -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--clock] size-4.5"></span>
                    Campaign Tracking
                    </a>
                </li>
                <!-- Sentiment Analysis -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--file-digit] size-4.5"></span>
                    Sentiment Analysis
                    </a>
                </li>
                <!-- Influencer -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--crown] size-4.5"></span>
                    Influencer
                    </a>
                </li>

                <li class="text-base-content/50 mt-2.5 p-2 text-xs uppercase">Supporting Features</li>
                <!-- Real-Time Monitoring -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--heart-rate-monitor] size-4.5"></span>
                    Real-Time Monitoring
                    </a>
                </li>
                <!-- Scheduled Posts & Calendar -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--calendar-stats] size-4.5"></span>
                    Scheduled Posts & Calendar
                    </a>
                </li>
                <!-- Reports & Export -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--arrow-back-up] size-4.5"></span>
                    Reports & Export
                    </a>
                </li>
                <!-- Settings & Integrations -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--settings] size-4.5"></span>
                    Settings & Integrations
                    </a>
                </li>
                <!-- Management -->
                <li>
                    <a href="#" class="px-2">
                    <span class="icon-[tabler--users] size-4.5"></span>
                    Management
                    </a>
                </li>
                </ul>
            </div>
            </div>
        </div>
        </aside>
        <!-- ---------- END MAIN SIDEBAR ---------- -->
        <div class="flex grow flex-col lg:ps-75">
        <!-- ---------- MAIN CONTENT ---------- -->
        <main class="mx-auto w-full max-w-9xl flex-1 p-4">
            <div class="grid grid-cols-1 gap-6">
            <div class="card w-full">
                <div class="card-body border-base-content/20 rounded-box skeleton m-3 border">
                    @yield('content')
                </div>
            </div>
            </div>
        </main>
        <!-- ---------- END MAIN CONTENT ---------- -->

        <!-- ---------- FOOTER CONTENT ---------- -->
        <footer class="bg-base-100">
            <div class="mx-auto h-14 w-full max-w-7xl px-6"></div>
        </footer>
        <!-- ---------- END FOOTER CONTENT ---------- -->
        </div>
    </div>
        {{-- <script src="../node_modules/flyonui/flyonui.js"></script>
        <script src="../path/to/vendor/jquery/dist/jquery.min.js"></script>
        <script src="../path/to/vendor/datatables.net/js/dataTables.min.js"></script> --}}
    </body>
</html>