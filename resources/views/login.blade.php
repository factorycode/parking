<x-base-layout title="Login">
    <main class="grid w-full grow grid-cols-1 lg:grid-cols-2 place-items-center">
        <div class="w-full max-w-[30rem] p-4 sm:px-5">
            <div class="card mt-5 rounded-lg p-5 lg:p-7">
                <div class="mt-4 flex justify-center">
                    <a href="#" class="flex items-center space-x-2">
                        <img class="h-auto w-56" src="{{ asset('images/logo_icon.png') }}" alt="logo" />
                    </a>
                </div>
                <form class="mt-16 mb-10" action="{{ route('login') }}" method="post">
                    @method('POST') @csrf
                    <div>
                        <label class="relative flex">
                            <input
                                class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Username or email" type="text" name="email"
                                value="{{ old('email') }}" />
                            <span
                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </label>
                        @error('email')
                            <span class="text-tiny+ text-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <label class="relative flex">
                            <input
                                class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                placeholder="Password" type="password" name="password" value="{{ old('password') }}" />
                            <span
                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                        </label>
                        @error('password')
                            <span class="text-tiny+ text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center justify-between space-x-2">
                        <label class="inline-flex items-center space-x-2">
                            <input
                                class="form-checkbox is-outline h-5 w-5 rounded border-slate-400/70 bg-slate-100 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-500 dark:bg-navy-900 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" />
                            <span class="line-clamp-1">Remember me</span>
                        </label>
                        <a href="#"
                            class="text-xs text-slate-400 transition-colors line-clamp-1 hover:text-slate-800 focus:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100 dark:focus:text-navy-100">Forgot
                            Password?</a>
                    </div>
                    <button type="submit"
                        class="btn mt-10 h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Sign In
                    </button>
                </form>

            </div>
            <div class="mt-8 flex justify-center text-xs text-slate-400 dark:text-navy-300">
                <a href="#">Privacy Notice</a>
                <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
                <a href="#">Term of service</a>
            </div>
        </div>
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="max-w-md mx-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold">Property Identification Code</h2>
                </div>
                <form action="{{ route('validate-property-code') }}" method="POST">
                    @method('POST') @csrf
                    <!-- Formulario -->
                    @if (session('error'))
                        <div id="error-message"
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div id="success-message"
                            class="alert flex rounded-lg border border-info px-4 py-4 text-info sm:px-5" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @push('scripts')
                        <script>
                            setTimeout(function() {
                                document.getElementById("error-message")?.remove();
                                document.getElementById("success-message")?.remove();
                            }, 8000);
                        </script>
                    @endpush

                    <div class="mb-4">
                        <label class="block text-white text-sm font-bold mb-2" for="property_code">Property Code,
                            Address:</label>
                        <input class="form-input border border-gray-300 rounded-md px-3 py-2 w-full" type="text"
                            id="property_code" name="property_code">
                    </div>
                    @error('property_code')
                        <span class="text-tiny+ text-error">{{ $property_code }}</span>
                    @enderror

                    <div class="text-center">
                        <button
                            class="px-4 py-2 bg-yellow-500 text-white w-full font-semibold rounded hover:bg-yellow-600"
                            type="submit">Validate Property Code</button>
                    </div>
                </form>
            </div>

        </div>
    </main>


</x-base-layout>
