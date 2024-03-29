<x-app-layout title="List of Residents" is-sidebar-open="true" is-header-blur="true">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
            <h4 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-xl">
                <a
                    class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                    Residents of {{ $propertyName }}
                </a>

            </h4>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
        </div>
        @if (session('error-message'))
        <div id="error-message" class="text-red-600 font-bold">
            {{ session('error-message') }}
        </div>
    @endif
    
    @if (session('success_message'))
        <div id="success-message" class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5">
            {{ session('success_message') }}
        </div>
    @endif
    
    <!-- Agregar un contenedor para el mensaje de éxito devuelto por JSON -->
    <div id="json-success-message" class="alert flex rounded-lg border border-success px-4 py-4 text-success sm:px-5" style="display: none;"></div>
    
    <script>
        // Ocultar el mensaje de éxito después de 5 segundos
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000);
    
        // Mostrar el mensaje de éxito devuelto por JSON
        var jsonSuccessMessage = document.getElementById('json-success-message');
        if (jsonSuccessMessage) {
            jsonSuccessMessage.innerText = ''; // Limpiar el contenido previo
        }
    
        // Ocultar el mensaje de error después de 5 segundos
        setTimeout(function() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000);
    </script>
    
    

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
                        <a href="{{ route('resident.addresident', ['property_code' => $propertyCode]) }}"
                            class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                            style="width: auto; height: 40px;">
                            <i class="fa-solid fa-users"></i>
                            &nbsp; Add Resident
                        </a>
                        
                        
                         
                        <a href="{{ route('residents.import') }}"
                            class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                            style="width: auto; height: 40px;">
                            <i class="fa-solid fa-file-import"></i>
                            &nbsp; Import
                        </a>
                        <a href="{{ route('residents.import.uploaded') }}"
                            class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                            style="width: auto; height: 40px;">
                            <i class="fa-solid fa-upload"></i>
                            &nbsp; Uploaded Files
                        </a>

                        <button id="sendMassEmailButton" type="button"
                            class="btn bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
                            style="width: auto; height: 40px; margin-right: 10px;">
                            <i class="fa-solid fa-envelope"></i>
                            &nbsp; Send Massive Email
                        </button>

                    </div>
                </div>
            </div>


            <!-- Basic Table -->
            <div class="card px-4 pb-4 sm:px-5">
                <div class="container mx-auto pt-5 pb-5">
                   
                    <table id="residents" class="table-auto min-w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Select</th>
                                <th class="px-4 py-2">Qr-code</th>
                                <th class="px-4 py-2">Resident Name</th>
                                <th class="px-4 py-2">Apart/Unit</th>
                                <th class="px-4 py-2">Lease Expiration</th>
                                <th class="px-4 py-2">Vehicles Per Apartment</th>
                                <th class="px-4 py-2">Visitors Per Apartment</th>
                                <th class="px-4 py-2">Reserved</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Resident Status</th>
                                <th class="px-4 py-2">Confirmation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($residents as $resident)
                                <tr>
                                    <td class="px-4 py-2">
                                        <input type="checkbox" name="selectedResidents[]" value="{{ $resident->id }}">
                                    </td>
                                    <td class="px-4 py-2">
                                        <button id="boton-modelo-{{ $resident->id }}"
                                            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                                            style="background-color: #0EA5E9;"
                                            onclick="toggleModal({{ $resident->id }})">

                                            {{ $resident->id }}

                                        </button>

                                        <!-- Ventana modal -->

                                        <div id="modal-modelo-{{ $resident->id }}"
                                            class="fixed z-10 inset-0 overflow-y-auto hidden">

                                            <div class="flex items-center justify-center min-h-screen px-4">

                                                <div class="fixed inset-0 bg-black opacity-50"></div>

                                                <!-- Capa de fondo semitransparente -->

                                                <div class="bg-white rounded-lg max-w-lg mx-auto p-6 relative">

                                                    <h2
                                                        class="text-lg text-center mb-2 text-slate-700 dark:text-navy-100">

                                                        {{ $resident->name }}

                                                    </h2>

                                                    <h4
                                                        class="text-lg text-center mb-2 text-slate-700 dark:text-navy-100">

                                                        QR code: {{ $resident->apart_unit }}

                                                    </h4>
                                                    <div class="visible-print flex justify-center items-center">
                                                        {!! QrCode::size(200)->generate('https://amartineztowingop.com/register?user_id=' . $resident->id) !!}
                                                    </div>
                                                    <p class="my-2">Scan me to return to the original page.</p>

                                                    <button id="cerrar-modal-modelo-{{ $resident->id }}"
                                                        class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center"
                                                        onclick="toggleModal({{ $resident->id }})">

                                                        Cerrar

                                                    </button>

                                                </div>

                                            </div>

                                        </div>
                                    </td>

                                    <td class="px-4 py-2">
                                        {{ $resident->name }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->apart_unit }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            $leaseExpiration = $resident->lease_expiration;
                                            $currentDate = now();
                                            $expired = $leaseExpiration < $currentDate;
                                        @endphp

                                        @if ($expired)
                                            <span class="text-red-600">Expired</span>
                                        @else
                                            <span class="text-green-600">{{ $leaseExpiration }}</span>
                                        @endif
                                    </td>

                                    <td class="py-2">
                                        @if ($vehiclesPerApartment)
                                            <!-- Mostrar el contenido si $vehiclesPerApartment tiene datos -->
                                            {{ $vehiclesPerApartment }}
                                        @else
                                            <!-- Mostrar el código alternativo si $vehiclesPerApartment no tiene datos -->
                                            <form method="POST"
                                                action="{{ route('update_reserved_space', ['departmentId' => $resident->department_id]) }}">
                                                @csrf
                                                <div class="flex items-center">
                                                    <input type="text" name="reserved_space"
                                                        value="{{ $resident->reserved_space }}"
                                                        class="w-10 h-8 border border-gray-300 text-black {{ strlen($resident->reserved_space) === 3 ? 'text-black' : 'text-red-500' }}">
                                                    <button type="submit" class="ml-1">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        @if ($reservedSpotPerApartment)
                                            <!-- Mostrar el contenido si $reservedSpotPerApartment tiene datos -->
                                            {{ $reservedSpotPerApartment }}
                                        @else
                                            <!-- Mostrar el código alternativo si $reservedSpotPerApartment no tiene datos -->
                                            <form method="POST"
                                                action="{{ route('update_reserved_space', ['departmentId' => $resident->department_id]) }}">
                                                @csrf
                                                <div class="flex items-center">
                                                    <input type="text" name="reserved_space"
                                                        value="{{ $resident->reserved_space }}"
                                                        class="w-10 h-8 border border-gray-300 text-black {{ strlen($resident->reserved_space) === 3 ? 'text-black' : 'text-red-500' }}">
                                                    <button type="submit" class="ml-1">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                    
                                    <td class="px-4 py-2">
                                        {{ $resident->reserved }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->status }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex space-x-2">
                                            <!-- Botón de aprobación -->
                                            <a href="{{ route('residents.approve', ['id' => $resident->id]) }}"
                                                class="btn h-8 w-8 p-0 text-green-500 hover:bg-green-200 focus:bg-green-200 active:bg-green-300 rounded-full">
                                                <i class="fa fa-check"></i>
                                            </a>

                                            <!-- Botón de rechazo -->
                                            <a href="{{ route('residents.decline', ['id' => $resident->id]) }}"
                                                class="btn h-8 w-8 p-0 text-red-500 hover:bg-red-200 focus:bg-red-200 active:bg-red-300 rounded-full">
                                                <i class="fa fa-times"></i>
                                            </a>


                                            <a href="{{ route('residents.edit', ['resident' => $resident->id, 'propertyCode' => $propertyCode]) }}"
                                                class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            

                                            <a href="{{ route('residents.resetPassword', $resident->id) }}"
                                                class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                                <i class="fa fa-key"></i>
                                            </a>
                                            <a href="{{ route('download.terms.pdf', $resident->id) }}"
                                                class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="{{ route('show_resident_cars', ['residentId' => $resident->id]) }}"
                                                class="btn h-8 w-8 p-0 text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25">
                                                <i class="fa fa-car"></i>
                                            </a>
                                            <form id="delete-form-{{ $resident->id }}"
                                                action="{{ route('residents.destroy', $resident->id) }}"
                                                method="POST">
                                                @csrf
                                                <a href="#"
                                                    class="btn h-8 w-8 p-0 text-error hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90"
                                                    onclick="confirmDelete('{{ $resident->id }}');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </form>
                                        </div>
                                        <script>
                                            function confirmDelete(residentId) {
                                                if (confirm('Are you sure you want to delete this resident?')) {
                                                    // Enviar el formulario de eliminación
                                                    document.getElementById('delete-form-' + residentId).submit();
                                                }
                                            }
                                        </script>
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->email }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $resident->phone }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="{{ $resident->terms_agreement_status === 'accepted' ? 'text-green-500' : 'text-red-500' }}">
                                            {{ $resident->terms_agreement_status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-2">
                                        {{ $resident->date_status }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <input type="hidden" name="propertyCode" value="{{ $propertyCode }}">
                    
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
        <script>
            function toggleModal(residentId) {
                const modal = document.getElementById(`modal-modelo-${residentId}`);
                modal.classList.toggle('hidden');
            }

            
                // Add a click event to the "Send Massive Email" button
                document.getElementById('sendMassEmailButton').addEventListener('click', function () {
                    // Get all the selected checkboxes
                    const selectedResidents = document.querySelectorAll('input[name="selectedResidents[]"]:checked');
            
                    // Get the value of propertyCode
                    const propertyCode = document.querySelector('input[name="propertyCode"]').value;
            
                    // Create an array to store the IDs of selected residents
                    const selectedResidentIds = [];
            
                    // Add the IDs of selected residents to the array
                    selectedResidents.forEach((resident) => {
                        selectedResidentIds.push(resident.value);
                    });
            
                    // Check if at least one checkbox is selected
                    if (selectedResidentIds.length === 0) {
                        // Show a SweetAlert2 alert for no selected residents
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Residents Selected',
                            text: 'Please select at least one resident to send a mass email.',
                        });
                    } else {
                        // Create an object with the data to send to the server
                        const requestData = {
                            propertyCode: propertyCode,
                            selectedResidents: selectedResidentIds,
                        };
            
                        // Perform the Axios request if at least one checkbox is selected
                        axios.post('{{ route('send_mass_email') }}', requestData)
                            .then(function (response) {
                                // Handle the server response if needed
                                console.log(response.data);
            
                                // Show a success notification using SweetAlert2
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Mass Email Sent Successfully',
                                    showConfirmButton: false,
                                    timer: 1500 // Automatically closes after 1.5 seconds
                                });
                            })
                            .catch(function (error) {
                                // Handle errors if needed
                                console.error(error);
            
                                // Show an error notification using SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error Sending Mass Email',
                                    text: 'An error occurred while sending the mass email. Please try again.',
                                });
                            });
                    }
                });
            </script>

    </main>
</x-app-layout>
