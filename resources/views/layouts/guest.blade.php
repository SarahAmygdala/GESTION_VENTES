<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mi Varotra') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animation des Vagues */
        @keyframes wave1 {
            0% {
                transform: translateX(0) scaleY(1);
            }

            50% {
                transform: translateX(-2%) scaleY(1.05);
            }

            100% {
                transform: translateX(0) scaleY(1);
            }
        }

        @keyframes wave2 {
            0% {
                transform: translateX(0) scaleY(1);
            }

            50% {
                transform: translateX(2%) scaleY(0.95);
            }

            100% {
                transform: translateX(0) scaleY(1);
            }
        }

        @keyframes wave3 {
            0% {
                transform: translateX(0) scaleY(1);
            }

            50% {
                transform: translateX(-1%) scaleY(1.02);
            }

            100% {
                transform: translateX(0) scaleY(1);
            }
        }

        .animate-wave-1 {
            animation: wave1 15s ease-in-out infinite;
        }

        .animate-wave-2 {
            animation: wave2 20s ease-in-out infinite;
        }

        .animate-wave-3 {
            animation: wave3 12s ease-in-out infinite;
        }

        /* Flottaison de l'icône centrale */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased h-screen overflow-y-auto md:overflow-hidden bg-blue-700">
    <div class="h-full flex flex-col justify-center items-center relative" x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 100)">

        <svg class="absolute inset-0 w-full h-full object-cover opacity-70 z-0" preserveAspectRatio="none"
            viewBox="0 0 1440 800" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="show"
            x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-70">
            <path class="animate-wave-1 transform-origin-bottom" d="M0 200 C300 0, 800 600, 1440 200 L1440 800 L0 800 Z"
                fill="rgba(255, 255, 255, 0.05)" />
            <path class="animate-wave-2 transform-origin-bottom"
                d="M0 400 C400 200, 900 800, 1440 400 L1440 800 L0 800 Z" fill="rgba(255, 255, 255, 0.03)" />
            <path class="animate-wave-3 transform-origin-bottom"
                d="M0 600 C500 400, 1000 900, 1440 600 L1440 800 L0 800 Z" fill="rgba(255, 255, 255, 0.02)" />
        </svg>

        <div id="tsparticles" class="absolute inset-0 z-0 pointer-events-none mix-blend-screen opacity-50"
            x-show="show" x-transition:enter="transition ease-in duration-2000 delay-1000"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-50"></div>

        <div class="relative z-10 w-full sm:max-w-md px-6 md:px-8 flex flex-col items-center py-10 md:py-0">

            <div class="mb-6 text-white animate-float" x-show="show"
                x-transition:enter="transition ease-out duration-700 delay-300"
                x-transition:enter-start="opacity-0 translate-y-8 scale-90"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                <svg width="112" height="112" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1.5"></circle>
                    <circle cx="20" cy="21" r="1.5"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
            </div>

            <div class="mb-10 text-center" x-show="show"
                x-transition:enter="transition ease-out duration-700 delay-500"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <h1 class="text-white/90 text-2xl font-light tracking-[0.2em] uppercase">Bienvenue sur</h1>
                <h2 class="text-white font-black text-3xl tracking-wider mt-1 drop-shadow-md">
                    {{ strtoupper(setting('store_name', 'MI VAROTRA')) }}</h2>
            </div>

            <div class="w-full relative z-20" x-show="show"
                x-transition:enter="transition ease-out duration-700 delay-500"
                x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tsparticles-preset-links@2/tsparticles.preset.links.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tsParticles.load("tsparticles", {
                preset: "links",
                background: {
                    color: "transparent"
                },
                particles: {
                    number: {
                        value: 60,
                        density: {
                            enable: true,
                            area: 800
                        }
                    },
                    color: {
                        value: "#ffffff"
                    },
                    links: {
                        color: "#ffffff",
                        distance: 150,
                        enable: true,
                        opacity: 0.15,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 0.8,
                        direction: "none",
                        random: false,
                        straight: false,
                        outModes: {
                            default: "bounce"
                        }
                    },
                    size: {
                        value: {
                            min: 1,
                            max: 2
                        },
                        random: true
                    },
                    opacity: {
                        value: 0.3,
                        random: true
                    }
                },
                interactivity: {
                    detectsOn: "window",
                    events: {
                        onHover: {
                            enable: true,
                            mode: "grab"
                        },
                        resize: true
                    },
                    modes: {
                        grab: {
                            distance: 200,
                            links: {
                                opacity: 0.5
                            }
                        }
                    }
                },
                detectRetina: true
            });
        });
    </script>
</body>

</html>
