<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bgify - Hapus Background Foto Dalam Sekejap</title>
    <meta name="description" content="Upload gambar dan biarkan AI Bgify menghapus background secara otomatis dengan hasil profesional dan transparan.">
    <meta name="theme-color" content="#6366f1">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Bgify - Hapus Background Foto Dalam Sekejap">
    <meta property="og:description" content="Hapus background foto otomatis dengan AI. Cepat, akurat, dan hasil PNG transparan berkualitas tinggi.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="https://raw.githubusercontent.com/maskuari/bgify/main/public/images/og-bgify.svg">

    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <script>
        if (localStorage.getItem('bgify-theme') === 'dark' || (!localStorage.getItem('bgify-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <link rel="stylesheet" href="/build/assets/app.css">
    <script type="module" src="/build/assets/app2.js"></script>
</head>
<body class="min-h-screen overflow-x-hidden bg-slate-50 text-slate-950 antialiased transition-colors duration-300 dark:bg-[#070816] dark:text-white">
    <div class="pointer-events-none fixed inset-0 -z-10">
        <div class="absolute left-1/2 top-0 h-[32rem] w-[32rem] -translate-x-1/2 rounded-full bg-fuchsia-400/20 blur-3xl dark:bg-fuchsia-500/20"></div>
        <div class="absolute right-0 top-32 h-[28rem] w-[28rem] rounded-full bg-blue-500/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 h-[26rem] w-[26rem] rounded-full bg-indigo-500/10 blur-3xl"></div>
    </div>

    <header class="sticky top-0 z-40 border-b border-white/20 bg-white/70 backdrop-blur-2xl dark:border-white/10 dark:bg-[#070816]/70">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3 font-bold tracking-tight">
                <span class="grid h-11 w-11 place-items-center overflow-hidden rounded-2xl bg-white p-1.5 shadow-lg shadow-indigo-500/20 ring-1 ring-slate-200 dark:ring-white/10">
                    <img src="https://raw.githubusercontent.com/maskuari/bgify/main/public/images/bgify-logo-color.png" class="h-full w-full object-contain dark:hidden" alt="Logo Bgify">
                    <img src="https://raw.githubusercontent.com/maskuari/bgify/main/public/images/bgify-logo-dark.png" class="hidden h-full w-full object-contain dark:block" alt="Logo Bgify dark">
                </span>
                <span class="text-xl">Bgify</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="#upload" class="hidden rounded-full px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-900/5 dark:text-slate-200 dark:hover:bg-white/10 sm:inline-flex">Upload Foto</a>
                <button type="button" id="themeToggle" class="relative inline-flex h-10 w-[4.75rem] items-center justify-between rounded-full border border-slate-200 bg-white/90 p-1 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-white/10" aria-label="Ganti ke dark mode" aria-pressed="false">
                    <span class="sr-only">Ganti tema</span>
                    <span class="absolute left-1 top-1 h-8 w-8 translate-x-9 rounded-full bg-white shadow-md ring-1 ring-slate-200 transition-transform duration-300 dark:translate-x-0 dark:ring-white/10"></span>
                    <span class="relative z-10 grid h-8 w-8 place-items-center text-slate-400 transition-colors dark:text-indigo-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M20.5 14.6A7.7 7.7 0 0 1 9.4 3.5a8.6 8.6 0 1 0 11.1 11.1Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="relative z-10 grid h-8 w-8 place-items-center text-amber-500 transition-colors dark:text-slate-400">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 4V2M12 22v-2M4.93 4.93 3.52 3.52M20.48 20.48l-1.41-1.41M4 12H2M22 12h-2M4.93 19.07l-1.41 1.41M20.48 3.52l-1.41 1.41M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </span>
                </button>
            </div>
        </nav>
    </header>

    <main>
        <section class="mx-auto grid min-h-[calc(100vh-74px)] max-w-7xl items-center gap-10 px-4 py-10 sm:px-6 sm:py-16 lg:grid-cols-[1fr_0.9fr] lg:gap-12 lg:px-8 lg:py-24">
            <div class="max-w-3xl">
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white/70 px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm backdrop-blur dark:border-white/10 dark:bg-white/10 dark:text-indigo-200">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    AI background removal tanpa ribet
                </div>
                <h1 class="text-3xl font-black leading-tight tracking-tight sm:text-6xl lg:text-7xl">
                    Hapus Background Foto Dalam Sekejap
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600 dark:text-slate-300 sm:mt-6 sm:text-lg sm:leading-8">
                    Upload gambar dan biarkan AI menghapus background secara otomatis dengan hasil profesional dan transparan.
                </p>
                <div class="mt-7 flex flex-col gap-3 sm:mt-9 sm:flex-row">
                    <a href="#upload" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-blue-600 to-fuchsia-600 px-6 py-3.5 text-sm font-bold text-white shadow-xl shadow-indigo-500/30 transition hover:-translate-y-1 hover:shadow-2xl sm:px-7 sm:py-4 sm:text-base">
                        Upload Foto
                    </a>
                    <a href="#upload" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white/80 px-6 py-3.5 text-sm font-bold text-slate-900 shadow-sm backdrop-blur transition hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-white/10 dark:text-white sm:px-7 sm:py-4 sm:text-base">
                        Coba Sekarang
                    </a>
                </div>
                <div class="mt-8 grid max-w-xl grid-cols-3 gap-3 text-sm text-slate-500 dark:text-slate-400">
                    <div><strong class="block text-lg text-slate-950 dark:text-white sm:text-xl">10 MB</strong>maks file</div>
                    <div><strong class="block text-lg text-slate-950 dark:text-white sm:text-xl">PNG</strong>transparan</div>
                    <div><strong class="block text-lg text-slate-950 dark:text-white sm:text-xl">AI</strong>otomatis</div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 rounded-[1.75rem] bg-gradient-to-br from-blue-500/25 to-fuchsia-500/25 blur-2xl sm:-inset-6 sm:rounded-[2rem]"></div>
                <div class="relative overflow-hidden rounded-[1.75rem] border border-white/30 bg-white/70 p-4 shadow-2xl shadow-indigo-500/20 backdrop-blur-2xl dark:border-white/10 dark:bg-white/10 sm:rounded-[2rem] sm:p-5">
                    <div class="mb-3 flex items-start justify-between gap-3 sm:mb-4 sm:items-center">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-300 sm:text-sm">AI Image Studio</p>
                            <p class="text-base font-bold leading-snug sm:text-lg">Smart background detection</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-emerald-400/15 px-3 py-1 text-[11px] font-bold text-emerald-600 dark:text-emerald-300 sm:text-xs">Ready</span>
                    </div>
                    <div class="relative aspect-square overflow-hidden rounded-[1.25rem] bg-slate-100 dark:bg-white/5 sm:rounded-[1.5rem]">
                        <img src="https://raw.githubusercontent.com/maskuari/bgify/main/public/images/hero-bgify-before-after.png" class="h-full w-full object-cover" alt="Contoh foto sebelum dan sesudah background dihapus oleh Bgify">
                        <div class="absolute right-4 top-[36%] rounded-2xl border border-white/40 bg-white/80 px-3 py-2 text-xs font-bold shadow-xl backdrop-blur dark:border-white/10 dark:bg-black/30 sm:right-5 sm:top-24 sm:px-4 sm:py-3 sm:text-sm">AI Cutout
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 rounded-2xl border border-white/40 bg-white/80 p-3 shadow-xl backdrop-blur dark:border-white/10 dark:bg-black/30 sm:bottom-5 sm:left-5 sm:right-5 sm:rounded-3xl sm:p-4">
                            <div class="mb-2 flex items-center justify-between text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500 dark:text-slate-300 sm:mb-3 sm:text-xs sm:tracking-[0.2em]">
                                <span>Processing</span><span>98%</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-white/10">
                                <div class="h-full w-[98%] rounded-full bg-gradient-to-r from-blue-500 to-fuchsia-500"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="upload" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[0.85fr_1.15fr]">
                <div class="rounded-[2rem] border border-white/40 bg-white/80 p-6 shadow-2xl shadow-indigo-500/10 backdrop-blur-2xl dark:border-white/10 dark:bg-white/10 sm:p-8">
                    <div class="mb-6">
                        <p class="text-sm font-bold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-300">Upload</p>
                        <h2 class="mt-2 text-3xl font-black">Mulai dari satu foto</h2>
                        <p class="mt-3 text-slate-600 dark:text-slate-300">Mendukung JPG, JPEG, PNG, dan WEBP hingga 10 MB.</p>
                    </div>

                    <form id="uploadForm" data-endpoint="{{ route('api.bgify.remove-background') }}">
                        <input id="imageInput" class="sr-only" type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                        <label id="dropzone" for="imageInput" class="group flex cursor-pointer flex-col items-center justify-center rounded-[1.5rem] border-2 border-dashed border-indigo-300 bg-indigo-50/70 px-6 py-12 text-center transition hover:-translate-y-1 hover:border-fuchsia-400 hover:bg-fuchsia-50 dark:border-white/15 dark:bg-white/5 dark:hover:bg-white/10">
                            <span class="grid h-16 w-16 place-items-center rounded-3xl bg-gradient-to-br from-blue-600 to-fuchsia-600 text-white shadow-xl shadow-indigo-500/30 transition group-hover:scale-105">
                                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 16V5M7 10l5-5 5 5M5 19h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="mt-5 text-lg font-extrabold">Drag and drop gambar di sini</span>
                            <span class="mt-2 text-sm text-slate-500 dark:text-slate-400">atau klik untuk memilih file</span>
                        </label>

                        <div id="fileMeta" class="mt-4 hidden rounded-2xl bg-slate-100 p-4 text-sm dark:bg-white/10"></div>

                        <div class="mt-5 h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-white/10" aria-hidden="true">
                            <div id="uploadProgress" class="h-full w-0 rounded-full bg-gradient-to-r from-blue-500 to-fuchsia-500 transition-all duration-300"></div>
                        </div>

                        <button id="processButton" type="submit" class="mt-6 inline-flex w-full items-center justify-center gap-3 rounded-full bg-gradient-to-r from-blue-600 to-fuchsia-600 px-6 py-4 text-base font-extrabold text-white shadow-xl shadow-indigo-500/30 transition hover:-translate-y-1 disabled:cursor-not-allowed disabled:opacity-60">
                            <span id="buttonSpinner" class="hidden h-5 w-5 animate-spin rounded-full border-2 border-white/40 border-t-white"></span>
                            <span id="buttonLabel">Hapus Background</span>
                        </button>
                    </form>
                </div>

                <div class="rounded-[2rem] border border-white/40 bg-white/80 p-6 shadow-2xl shadow-indigo-500/10 backdrop-blur-2xl dark:border-white/10 dark:bg-white/10 sm:p-8">
                    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-300">Preview</p>
                            <h2 class="mt-2 text-3xl font-black">Before & After</h2>
                        </div>
                        <button id="resetButton" type="button" class="hidden rounded-full border border-slate-200 px-5 py-2.5 text-sm font-bold transition hover:bg-slate-900/5 dark:border-white/10 dark:hover:bg-white/10">Upload Gambar Baru</button>
                    </div>

                    <div id="emptyState" class="grid min-h-[28rem] place-items-center rounded-[1.5rem] bg-slate-100 text-center dark:bg-white/5">
                        <div class="max-w-sm px-6">
                            <div class="mx-auto grid h-16 w-16 place-items-center rounded-3xl bg-white text-sm font-black text-indigo-600 shadow-lg dark:bg-white/10 dark:text-indigo-200">AI</div>
                            <p class="mt-5 text-lg font-extrabold">Preview akan tampil setelah gambar dipilih.</p>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Hasil AI, gambar asli, dan slider perbandingan tersedia di sini.</p>
                        </div>
                    </div>

                    <div id="previewPanel" class="hidden space-y-6">
                        <div class="grid gap-4 md:grid-cols-2">
                            <figure class="overflow-hidden rounded-[1.25rem] bg-slate-100 dark:bg-white/5">
                                <img id="originalPreview" class="h-64 w-full object-contain" alt="Gambar asli">
                                <figcaption class="border-t border-slate-200 px-4 py-3 text-sm font-bold dark:border-white/10">Gambar asli</figcaption>
                            </figure>
                            <figure class="checkerboard overflow-hidden rounded-[1.25rem]">
                                <div class="relative h-64">
                                    <div id="resultPlaceholder" class="absolute inset-0 grid place-items-center p-6 text-center">
                                        <div>
                                            <div class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-white/80 text-xl shadow-md dark:bg-black/30">AI</div>
                                            <p class="mt-4 text-sm font-bold text-slate-600 dark:text-slate-200">Hasil AI akan muncul setelah diproses.</p>
                                        </div>
                                    </div>
                                    <div id="resultLoading" class="absolute inset-0 hidden place-items-center bg-white/45 p-6 text-center backdrop-blur-sm dark:bg-black/20">
                                        <div>
                                            <div class="mx-auto h-12 w-12 animate-spin rounded-full border-4 border-indigo-200 border-t-indigo-600"></div>
                                            <p class="mt-4 text-sm font-bold text-slate-700 dark:text-slate-100">AI sedang menghapus background...</p>
                                        </div>
                                    </div>
                                    <img id="resultPreview" class="hidden h-full w-full object-contain" alt="Gambar hasil AI">
                                </div>
                                <figcaption class="border-t border-slate-200 bg-white/80 px-4 py-3 text-sm font-bold backdrop-blur dark:border-white/10 dark:bg-black/30">Gambar hasil AI</figcaption>
                            </figure>
                        </div>

                        <div id="comparison" class="relative hidden aspect-[16/10] overflow-hidden rounded-[1.5rem] bg-slate-100 dark:bg-white/5">
                            <img id="compareBefore" class="absolute inset-0 h-full w-full object-contain" alt="Before">
                            <div id="compareAfterWrap" class="absolute inset-0 overflow-hidden checkerboard" style="clip-path: inset(0 50% 0 0);">
                                <img id="compareAfter" class="absolute inset-0 h-full w-full object-contain" alt="After">
                            </div>
                            <div id="compareHandle" class="pointer-events-none absolute inset-y-0 left-1/2 w-1 -translate-x-1/2 bg-white shadow-xl">
                                <span class="absolute left-1/2 top-1/2 grid h-12 w-12 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full bg-white text-sm font-black text-indigo-600 shadow-xl">VS</span>
                            </div>
                            <input id="compareSlider" class="absolute inset-x-0 bottom-5 mx-auto h-2 w-[88%] cursor-ew-resize accent-indigo-600" type="range" min="0" max="100" value="50" aria-label="Slider before after">
                        </div>

                        <div id="downloadActions" class="hidden flex flex-col gap-3 sm:flex-row">
                            <a id="downloadPng" class="inline-flex flex-1 items-center justify-center rounded-full bg-slate-950 px-6 py-3 font-bold text-white transition hover:-translate-y-1 dark:bg-white dark:text-slate-950" href="#">Download PNG Transparan</a>
                            <a id="downloadHd" class="inline-flex flex-1 items-center justify-center rounded-full bg-gradient-to-r from-blue-600 to-fuchsia-600 px-6 py-3 font-bold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-1" href="#">Download HD</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-300">Fitur</p>
                <h2 class="mt-3 text-3xl font-black sm:text-5xl">Dibuat untuk hasil cepat dan rapi</h2>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                <article class="rounded-[1.5rem] border border-white/40 bg-white/80 p-6 shadow-xl shadow-indigo-500/10 backdrop-blur dark:border-white/10 dark:bg-white/10">
                    <h3 class="text-2xl font-black">Cepat</h3>
                    <p class="mt-3 text-slate-600 dark:text-slate-300">Proses hanya beberapa detik.</p>
                </article>
                <article class="rounded-[1.5rem] border border-white/40 bg-white/80 p-6 shadow-xl shadow-indigo-500/10 backdrop-blur dark:border-white/10 dark:bg-white/10">
                    <h3 class="text-2xl font-black">Akurat</h3>
                    <p class="mt-3 text-slate-600 dark:text-slate-300">Menggunakan AI untuk mendeteksi objek secara presisi.</p>
                </article>
                <article class="rounded-[1.5rem] border border-white/40 bg-white/80 p-6 shadow-xl shadow-indigo-500/10 backdrop-blur dark:border-white/10 dark:bg-white/10">
                    <h3 class="text-2xl font-black">Transparan</h3>
                    <p class="mt-3 text-slate-600 dark:text-slate-300">Hasil PNG berkualitas tinggi.</p>
                </article>
            </div>
        </section>

        <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] border border-white/40 bg-white/80 p-6 shadow-2xl shadow-indigo-500/10 backdrop-blur-2xl dark:border-white/10 dark:bg-white/10 sm:p-10">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-300">Cara Kerja</p>
                <h2 class="mt-3 text-3xl font-black sm:text-5xl">Tiga langkah sederhana</h2>
                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    <div class="relative rounded-[1.25rem] bg-slate-100 p-5 dark:bg-white/5">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-blue-600 to-fuchsia-600 font-black text-white">1</span>
                        <h3 class="mt-5 text-xl font-black">Upload Foto</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Pilih gambar dari perangkat atau drag langsung ke upload area.</p>
                    </div>
                    <div class="relative rounded-[1.25rem] bg-slate-100 p-5 dark:bg-white/5">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-blue-600 to-fuchsia-600 font-black text-white">2</span>
                        <h3 class="mt-5 text-xl font-black">AI Memproses Gambar</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Laravel mengirim gambar ke Python rembg untuk dipotong otomatis.</p>
                    </div>
                    <div class="relative rounded-[1.25rem] bg-slate-100 p-5 dark:bg-white/5">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-blue-600 to-fuchsia-600 font-black text-white">3</span>
                        <h3 class="mt-5 text-xl font-black">Download Hasil PNG</h3>
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Simpan file transparan dan gunakan untuk desain, toko online, atau profil.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 py-8 text-center text-sm text-slate-500 dark:border-white/10 dark:text-slate-400">
        Created by Maskuari.2026
    </footer>

    <div id="toast" class="fixed bottom-5 right-5 z-50 hidden max-w-sm rounded-2xl border border-white/30 bg-white/90 px-5 py-4 font-semibold text-slate-900 shadow-2xl backdrop-blur dark:border-white/10 dark:bg-[#101225]/90 dark:text-white"></div>
</body>
</html>



