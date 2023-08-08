<x-app-layout title="List of vehicles" is-sidebar-open="true" is-header-blur="true">

    <main class="main-content w-full px-[var(--margin-x)] pb-8">

        <div class="flex items-center space-x-4 py-5 lg:py-6">

            <h4 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-xl">

                <a
                    class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">Residents

                </a>



            </h4>

            <div class="hidden h-full py-1 sm:flex">

                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>

            </div>

        </div>

        @if (session('success_message'))
            <div id="success-message" class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5">

                {{ session('success_message') }}

            </div>
        @endif



        <script>
            // Ocultar el mensaje de éxito después de 5 segundos

            setTimeout(function() {

                var successMessage = document.getElementById('success-message');

                if (successMessage) {

                    successMessage.style.display = 'none';

                }

            }, 5000);
        </script>
        @if (session('error'))
            <div class="text-red-500 mb-4">
                {{ session('error') }}
            </div>
        @endif



        <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">

            <div class="inline-flex space-x-2">

                <div class="inline-flex space-x-4">

                    <div class="inline-flex space-x-4">

                        <a href="#">

                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">

                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8 2.79365V29.2064C8 30.7492 9.23122 32 10.75 32H29.25C30.7688 32 32 30.7492 32 29.2064V7.35127C32 6.60502 31.7061 5.88979 31.1838 5.36503L26.6478 0.807413C26.133 0.29013 25.4381 0 24.714 0H10.75C9.23122 0 8 1.25076 8 2.79365ZM9.75 29.2064V2.79365C9.75 2.2326 10.1977 1.77778 10.75 1.77778H24.375V7.87302C24.375 8.92499 25.2145 9.77778 26.25 9.77778H30.25V29.2064C30.25 29.7674 29.8023 30.2222 29.25 30.2222H10.75C10.1977 30.2222 9.75 29.7674 9.75 29.2064ZM30.25 8V7.35127C30.25 7.07991 30.1431 6.81982 29.9532 6.629L26.125 2.78254V7.87302C26.125 7.94315 26.181 8 26.25 8H30.25Z"
                                    fill="#0EA5E9" />

                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M20.5 13.125C20.5 12.6418 20.8918 12.25 21.375 12.25H27.125C27.6082 12.25 28 12.6418 28 13.125C28 13.6082 27.6082 14 27.125 14H21.375C20.8918 14 20.5 13.6082 20.5 13.125Z"
                                    fill="#69C997" />

                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M20.5 17.125C20.5 16.6418 20.8918 16.25 21.375 16.25H27.125C27.6082 16.25 28 16.6418 28 17.125C28 17.6082 27.6082 18 27.125 18H21.375C20.8918 18 20.5 17.6082 20.5 17.125Z"
                                    fill="#54AD7D" />

                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M20.5 21.125C20.5 20.6418 20.8918 20.25 21.375 20.25H27.125C27.6082 20.25 28 20.6418 28 21.125C28 21.6082 27.6082 22 27.125 22H21.375C20.8918 22 20.5 21.6082 20.5 21.125Z"
                                    fill="#2B593D" />

                                <path
                                    d="M0 9.25C0 8.42157 0.671573 7.75 1.5 7.75H16.5C17.3284 7.75 18 8.42157 18 9.25V24.25C18 25.0784 17.3284 25.75 16.5 25.75H1.5C0.671573 25.75 0 25.0784 0 24.25V9.25Z"
                                    fill="#3D8A58" />

                                <path
                                    d="M5 21.7715L7.80957 16.542L5.25977 11.75H7.20117L8.84863 14.9697L10.4619 11.75H12.3828L9.83301 16.6172L12.6426 21.7715H10.6396L8.81445 18.3057L6.98926 21.7715H5Z"
                                    fill="white" />

                            </svg>

                        </a>

                        <a href="{{ route('addresident') }}"
                            class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                            style="width: auto; height: 40px;">
                            <i class="fa fa-user" aria-hidden="true"></i> &nbsp; Add Resident
                        </a>

                        <a href="#"
                            class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                            style="width: auto; height: 40px;">

                            <i class="fa fa-file" aria-hidden="true"></i> &nbsp; Import information

                        </a>



                    </div>

                </div>

            </div>


            <!-- Basic Table -->

            <div class="card px-4 pb-4 sm:px-5">

                <div class="container mx-auto pt-5 pb-5">

                    <table id="residents" class="table-auto min-w-full">

                        <thead>

                            <tr>
                                <th class="px-4 py-2">Resident Name</th>
                                <th class="px-4 py-2">Aparment/Unit</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Lease Expiration</th>
                                <th class="px-4 py-2">Vehicle Permit aprt</th>
                                <th class="px-4 py-2">Visitors per apartmt</th>
                                <th class="px-4 py-2">Reserved Space</th>
                                <th class="px-4 py-2">Resident Status</th>
                                <th class="px-4 py-2">Resident Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($residents as $resident)
                                <tr>

                                    <td class="px-4 py-2">
                                        {{ $resident->name }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->apart_unit }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->email }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->phone }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->lease_expiration }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->permit_status }}
                                    </td>
                                    <td class="px-4 py-2">
                                        0
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->reserved_space }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->status }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('updateStatus') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="resident_id" value="{{ $resident->id }}">
                                            <label class="inline-flex items-center space-x-2">
                                                <span class="text-red-500">Decline</span>
                                                <input
                                                    class="form-switch h-5 w-10 rounded-full bg-red-500 before:rounded-full before:bg-red-200 checked:bg-green-500 checked:before:bg-white"
                                                    type="checkbox" name="status"
                                                    value="{{ $resident->status === 'Active' ? 'Pending' : 'Active' }}"
                                                    {{ $resident->status === 'Active' ? 'checked' : '' }}
                                                    onchange="this.form.submit()" />
                                                <span class="text-green-500">Approve</span>
                                            </label>
                                        </form>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('residents.edit', ['resident' => $resident->id]) }}"
                                            class="text-info hover:text-text-info mr-2">
                                            <i class="fa fa-pencil"></i>
                                        </a>

                                        <form action="{{ route('residents.destroy', ['resident' => $resident->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        </div>
        <script>
            $(document).ready(function() {

                $('#residents').DataTable({

                    responsive: true

                });

            });
        </script>

    </main>

</x-app-layout>
