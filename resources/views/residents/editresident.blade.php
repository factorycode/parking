<x-app-layout title="Edit Resident" is-header-blur="true">

    <main class="main-content w-full px-[var(--margin-x)] pb-8">

        <div class="flex items-center space-x-4 py-5 lg:py-6">

            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">

                DASHBOARD

            </h2>

            <div class="hidden h-full py-1 sm:flex">

                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>

            </div>

            <ul class="hidden flex-wrap items-center space-x-2 sm:flex">

                <li class="flex items-center space-x-2">

                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="#">Users</a>

                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />

                    </svg>

                </li>

                <li>Edit Resident</li>

            </ul>

        </div>



        <template x-if="$store.breakpoints.isXs">

            <div x-data="{ isStuck: false }" class="pb-6" x-intersect:enter.full.margin.-60px.0.0.0="isStuck = false"
                x-intersect:leave.full.margin.-60px.0.0.0="isStuck = true">

                <div :class="isStuck && 'fixed right-0 top-[60px] w-full z-10'">

                    <div class="transition-all duration-200"
                        :class="isStuck && 'py-2.5 px-4 bg-white dark:bg-navy-700 shadow-lg relative'">

                        <ol class="steps with-space-line">

                            <li class="step before:bg-primary dark:before:bg-accent">

                                <div class="step-header rounded-full bg-primary text-white dark:bg-accent">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">

                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />

                                    </svg>

                                </div>

                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">

                                    Create Account

                                </h3>

                            </li>

                            <li class="step before:bg-primary dark:before:bg-accent">

                                <div class="step-header rounded-full bg-primary text-white dark:bg-accent">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">

                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />

                                    </svg>

                                </div>

                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">

                                    Select Service

                                </h3>

                            </li>

                            <li class="step before:bg-slate-200 dark:before:bg-navy-500">

                                <div class="step-header rounded-full bg-primary text-white dark:bg-accent">

                                    3

                                </div>

                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">

                                    Address

                                </h3>

                            </li>

                            <li class="step before:bg-slate-200 dark:before:bg-navy-500">

                                <div
                                    class="step-header rounded-full bg-slate-200 text-slate-800 dark:bg-navy-500 dark:text-white">

                                    4

                                </div>

                                <h3 class="text-xs font-medium text-slate-700 dark:text-navy-100">

                                    Review

                                </h3>

                            </li>

                        </ol>

                    </div>

                </div>

            </div>

        </template>

        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

            <div class="col-span-12 sm:col-span-10">

                <div class="card p-4 sm:p-5">

                    <p class="text-base font-medium text-slate-700 dark:text-navy-100 mb-5">
                        Edit Resident
                    </p>
                    <form action="{{ route('residents.update', ['resident' => $resident->id]) }}" method="POST">
                        @csrf <!-- Directiva para generar el token CSRF -->



                        <!-- Campo: Resident Name -->
                        <div class="mb-4 pt-5">
                            <label class="relative flex">
                                <input
                                    class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="Resident name" type="text" name="name"
                                    value="{{ old('name', $resident->name) }}" />
                            </label>
                            @error('name')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Campo: UserName -->
                        <div class="mb-4 pt-5">
                            <label class="relative flex">
                                <input
                                    class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="UserName" type="text" name="user"
                                    value="{{ old('user', $resident->user) }}" />
                            </label>
                            @error('user')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Apart/unit -->
                        <div class="mb-4">
                            <label class="relative flex">
                                <input
                                    class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="Apart/unit" type="text" name="apart_unit"
                                    value="{{ old('apart_unit', optional($resident->department)->apart_unit) }}" />
                            </label>
                            @error('apart_unit')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="mb-4">
                            <label class="relative flex">
                                <input
                                    class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="Reserved spaces" type="text" name="reserved_space"
                                    value="{{ old('reserved_space', optional($resident->department)->reserved_space) }}" />
                            </label>
                            @error('reserved_space')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>



                        <!-- Campo: Phone -->
                        <div class="mb-4">
                            <label class="relative flex">
                                <input
                                    class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="Phone" type="text" name="phone"
                                    value="{{ old('phone', $resident->phone) }}" />
                            </label>
                            @error('phone')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Email -->
                        <div class="mb-4">
                            <label class="relative flex">
                                <input id="email"
                                    class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                                    placeholder="Email" type="email" name="email"
                                    value="{{ old('email', $resident->email) }}" />
                            </label>
                            @error('email')
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @enderror
                        </div>


                        <div>
                            <button type="submit"
                                class="btn bg-warning ml-3 font-medium text-white hover:bg-warning-focus focus:bg-warning-focus active:bg-warning-focus/90">
                                Submit
                            </button>
                            <button type="button"
                                class="btn bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90"
                                onclick="window.location.href='{{ route('recidents') }}'">
                                Cancel
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        <script>
            $(document).ready(function() {

                $('#email').keyup(function() {

                    var email = $(this).val();

                    $.ajax({

                        url: '{{ route('verificar-correo') }}',

                        method: 'GET',

                        data: {

                            email: email

                        },

                        success: function(response) {

                            if (response.existe) {

                                // El correo existe en la base de datos

                                $('#email-error').text('The email is already registered.');

                            } else {

                                // El correo no existe en la base de datos

                                $('#email-error').text('');

                            }

                        },

                        error: function() {

                            // Error en la llamada AJAX

                            $('#email-error').text('Error en la consulta.');

                        }

                    });

                });

            });
        </script>
    </main>

</x-app-layout>