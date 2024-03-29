<x-app-layout title="Vehicles" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex flex-col items-center justify-between space-y-4 py-5 sm:flex-row sm:space-y-0 lg:py-6">
            <div class="flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                <h2 class="text-lg font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    Add Vehicle 
                </h2>

                

            </div>
            <div class="flex justify-center space-x-2">
                <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                    Permit
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
            <div class="col-span-12 lg:col-span-6">
                <div class="card">
                    <div class="tabs flex flex-col">
                        <div class="tab-content p-4 sm:p-5">
                            <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST" id="vehicleForm">
                                @csrf
                                <div class="space-y-5">   
                                    <input type="hidden" name="user_id" value="{{ request()->segment(2) }}">
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">License Plate</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="License Plate" type="text" name="license_plate" required />
                                    </label>
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">VIN</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="VIN" type="text" name="vin" required />
                                    </label>
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Make</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Make" type="text" name="make" required />
                                    </label>
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Model</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Model" type="text" name="model" required />
                                    </label>
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Year</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Year" type="text" name="year" required />
                                    </label>
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Color</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Color" type="text" name="color" required />
                                    </label>
                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Vehicle Type</span>
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Vehicle Type" type="text" name="vehicle_type" required />
                                    </label>
                                    <input type="hidden" name="property_code"
                                        value="{{ $property ? $property->property_code : '' }}" />

                                </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-span-12 lg:col-span-6">
                <div class="card space-y-5 p-4 sm:p-5">
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Permit Status</span>
                        <select name="permit_status"
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </label>

                    <label class="block pt-4">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Permit Type</span>
                        <select name="permit_type"
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                            @php
                                $permitTypes = ['visitor', 'resident', 'temporary', 'employee', 'contractor', 'vip', 'carport', 'reserved', 'handicap', 'fire lane'];
                            @endphp
                            @foreach ($permitTypes as $permitType)
                                <option value="{{ $permitType }}">{{ $permitType }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block pt-4">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Start Date</span>
                        <span class="relative mt-1.5 flex">
                            <input id="start_date_input" name="start_date" x-init="$el._x_flatpickr = flatpickr($el)"
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Start Date:..." type="text" />
                            <span
                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </span>
                    </label>

                    <label class="block pt-4">
                        <span class="font-medium text-slate-600 dark:text-navy-100">End Date</span>
                        <span class="relative mt-1.5 flex">
                            <input id="end_date_input" name="end_date" x-init="$el._x_flatpickr = flatpickr($el)"
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="End Date:..." type="text" />
                            <span
                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </span>
                    </label>

                    <div class="grid grid-cols-2 gap-4 pt-10">
                        <button type="button" onclick="setDateRange(30)"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">1
                            Month</button>
                        <button type="button" onclick="setDateRange(60)"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">2
                            Months</button>
                        <button type="button" onclick="setDateRange(90)"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">3
                            Months</button>
                        <button type="button" onclick="setDateRange(180)"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">6
                            Months</button>
                        <button type="button" onclick="setDateRange(365)"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">1
                            Year</button>
                        <button type="button" onclick="setDateRange(7)"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">1
                            Week</button>
                        <button type="button" onclick="setDateRange(14)"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">2
                            Weeks</button>
                        <button type="button" onclick="setWeekendRange()"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">Weekend</button>
                        <button type="button" onclick="setEndOfMonthRange()"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">End
                            of Month</button>
                        <button type="button" onclick="setEndOfYearRange()"
                            class="btn rounded-full bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">End
                            of Year</button>
                    </div>


                </div>

                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script>
                    const startInput = document.querySelector('input[name="start_date"]');
                    const endInput = document.querySelector('input[name="end_date"]');

                    function setDateRange(days) {
                        const currentDate = new Date();
                        const startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate());
                        const endDate = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate() + days);

                        startInput._x_flatpickr.setDate(startDate, false, 'Y-m-d');
                        endInput._x_flatpickr.setDate(endDate, false, 'Y-m-d');
                    }

                    function setWeekendRange() {
                        const currentDate = new Date();
                        const startDay = currentDate.getDate();
                        const endDay = startDay + (6 - currentDate.getDay()); // Obtener el próximo sábado
                        const startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), startDay);
                        const endDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), endDay);

                        startInput._x_flatpickr.setDate(startDate, false, 'Y-m-d');
                        endInput._x_flatpickr.setDate(endDate, false, 'Y-m-d');
                    }

                    function setEndOfMonthRange() {
                        const currentDate = new Date();
                        const startDay = 1;
                        const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
                        const startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), startDay);
                        const endDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), lastDay);

                        startInput._x_flatpickr.setDate(startDate, false, 'Y-m-d');
                        endInput._x_flatpickr.setDate(endDate, false, 'Y-m-d');
                    }

                    function setEndOfYearRange() {
                        const currentDate = new Date();
                        const startDay = 1;
                        const lastMonth = 11; // Diciembre
                        const lastDay = new Date(currentDate.getFullYear() + 1, 0, 0).getDate();
                        const startDate = new Date(currentDate.getFullYear(), lastMonth, startDay);
                        const endDate = new Date(currentDate.getFullYear(), lastMonth, lastDay);

                        startInput._x_flatpickr.setDate(startDate, false, 'Y-m-d');
                        endInput._x_flatpickr.setDate(endDate, false, 'Y-m-d');
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        flatpickr('.datepicker-input', {
                            enableTime: false,
                            dateFormat: 'Y-m-d',
                            minDate: 'today',
                            clickOpens: true
                        });
                    });
                </script>
            </div>
        </div>
        </div>
        <div class="flex justify-center mt-4">
            <button type="submit" name="saveButton" form="vehicleForm"
                class="btn bg-warning font-medium text-white hover:bg-warning-focus focus:bg-warning-focus active:bg-warning-focus/90 mr-2">
                Save Vehicle
            </button>

            <button type="submit" name="savePrintButton" form="vehicleForm"
                class="btn mr-2 bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                Save & Print
            </button>
            @php
                $property_code = request()->segment(2);
            @endphp
            <a href="{{ route('properties.vehicles', ['property_code' => $property_code]) }}"
                class="px-4 py-2 bg-red-500 text-white rounded-md">Cancel</a>

        </div>
        </form>
        <script>
            const residentNameInput = document.getElementById('resident_name');
            const searchResultsDiv = document.getElementById('searchResults');
            const residentIdInput = document.getElementById('resident_id');

            residentNameInput.addEventListener('input', () => {
                const searchQuery = residentNameInput.value.trim();

                // Realizar una petición AJAX para buscar los residentes
                // Puedes usar Axios o Fetch para hacer la solicitud
                // En este ejemplo, asumimos que tienes una ruta llamada "search.residents"
                // que maneja la búsqueda en el controlador PropertyController
                fetch(`/search-residents?q=${searchQuery}`)
                    .then(response => response.json())
                    .then(data => {
                        // Limpia y muestra los resultados del buscador
                        searchResultsDiv.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(resident => {
                                const residentItem = document.createElement('div');
                                residentItem.classList.add('search-result', 'border', 'border-green-500');
                                residentItem.textContent = resident.name;
                                residentItem.addEventListener('click', () => selectResident(resident.id,
                                    resident.name));
                                searchResultsDiv.appendChild(residentItem);
                            });
                            searchResultsDiv.classList.remove('border-red-500');
                            searchResultsDiv.classList.remove('hidden');
                        } else {
                            const residentNotFound = document.createElement('div');
                            residentNotFound.classList.add('search-result', 'border', 'border-red-500',
                                'text-red-500');
                            residentNotFound.textContent = 'Resident not found.';
                            searchResultsDiv.appendChild(residentNotFound);
                            searchResultsDiv.classList.remove('border-green-500');
                            searchResultsDiv.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching residents:', error);
                    });
            });

            function selectResident(residentId, residentName) {
                residentNameInput.value = residentName;
                residentIdInput.value = residentId;
                searchResultsDiv.classList.add('hidden');
            }
        </script>

    </main>
</x-app-layout>
