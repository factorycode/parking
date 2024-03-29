<style>
    body {
      font-family: Arial, sans-serif;
      font-size: 15px;
  }

  /* Estilos para la tabla principal */
  table {
      width: 100%;
      border-collapse: collapse;
  }

  td {
      vertical-align: top;
  }



  /* Estilos para la primera columna */
  .column1 {
      width: 50%;
      padding: 20px;
      background-color: #f0f0f0;
  }

  .column1 .card-content {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
  }

  .property-name {
      font-size: 18px;
      font-weight: bold;
      text-align: center;
  }

  .permit-type {
      font-size: 14px;
      color: #555;
      text-align: center;
  }




  .license-plate {
      font-size: 16px;
      font-weight: bold;
      border: 1px solid #000;
      padding: 5px 10px;
      border-radius: 4px;
      margin-top: -20px;
      /* Ajusta el valor negativo según cuánto quieras subir el span */
  }


  .date {
      font-size: 12px;
      color: #777;
  }

  /* Estilos para la segunda columna */
  .column2 {
      width: 50%;
      padding: 20px;
  }

  .instructions h2 {
      font-size: 18px;
      font-weight: bold;
  }

  .instructions ol {
      list-style-type: decimal;
      padding-left: 20px;
  }

  .instructions li {
      font-size: 14px;
      color: #333;
      margin-bottom: 0px;
  }

  .flex {
      display: flex;
      align-items: center;
      /* Centrar verticalmente */
  }

  .flex img {
      margin-right: 0px;
      /* Agregar margen a la derecha de la imagen */
  }

  .flex-container {
      display: flex;
      justify-content: center;
      /* Centrar horizontalmente */
      align-items: center;
      /* Centrar verticalmente */
      height: 200vh;
      /* Establecer la altura del contenedor (ajusta según tus necesidades) */
  }


  .logo {
      width: 50px;
      /* Ancho de la imagen */
      height: auto;
      /* Altura automática para mantener la proporción */
      margin-right: 20px;
      /* Margen derecho para separar la imagen del texto */
  }

  .signature-line-top {
      border-top: 0px solid #000;
      /* Color y estilo de la línea de separación superior */
      height: 10px;
      /* Altura de la línea de separación superior (ajústala según tus necesidades) */
  }

  .signature-line {
      border-top: 1px solid #000;
      /* Color y estilo de la línea de firma */
      height: 1px;
      /* Altura de la línea de firma (ajústala según tus necesidades) */
  }
</style>
<x-app-layout title="Factura 2" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50 lg:text-2xl">
                Acuerdo de Permiso
            </h2>

            <div class="flex">
                <form action="{{ route('vehicles.printPDF') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    <button type="submit" id="print-pdf-button"
                        class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 sm:h-9 sm:w-9">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </button>
                </form>
                <a href="{{ route('properties.vehicles', ['property_code' => $vehicle->property_code]) }}"
                    class="btn ml-5 bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                    Cancelar
                </a>
            </div>

        </div>
        <div class="grid grid-cols-1" id="document">
            <div class="card px-5 py-12 sm:px-18">

                <div class="container mx-auto">
                    <div class="grid grid-cols-2 gap-4">


                        <div class="p-4 bg-neutral-300">
                            <div class="card px-5 py-8 sm:px-8 bg-white rounded-lg shadow-md w-80 h-48 mx-auto">
                                @if (is_null($propertySetting) || is_null($propertySetting->name))
                                <p class="text-lg text-center font-semibold">{{ $property_name }}</p> 
                                @else
                                    @if ($propertySetting->name === '1')
                                        <p class="text-lg text-center font-semibold">{{ $property_name }}</p>
                                    @elseif ($propertySetting->name === 0)
                                        <!-- No se muestra nada cuando $propertySetting->name es igual a "0" -->
                                    @endif
                                @endif


                                <div class="mb-2">
                                    @if (is_null($propertySetting) || is_null($propertySetting->type))
                                    <p class="text-sm text-center text-gray-500">{{ $permit_type }}</p>
                                    @else
                                       
                                        @if ($propertySetting->type === '1')
                                        <p class="text-sm text-center text-gray-500">{{ $permit_type }}</p>
                                        @elseif ($propertySetting->type === 0)
                                            <!-- No se muestra nada cuando $propertySetting->name es igual a "0" -->
                                        @endif
                                    @endif
                                </div>

                                <div class="flex items-center justify-center mb-2">
                                    @if (is_null($propertySetting) || is_null($propertySetting->logo))
                                        @if ($logo)
                                            <img src="{{ asset($logo) }}" alt="Logo Resident" class="w-12 h-12 mr-2">
                                        @else
                                            <img src="{{ asset('favicon.png') }}" alt="Logo por defecto"
                                                class="w-12 h-12 mr-2">
                                        @endif
                                    @else
                                       
                                        @if ($propertySetting->logo === '1')
                                            @if ($logo)
                                                <img src="{{ asset($logo) }}" alt="Logo Resident"
                                                    class="w-12 h-12 mr-2">
                                            @else
                                                <img src="{{ asset('favicon.png') }}" alt="Logo por defecto"
                                                    class="w-12 h-12 mr-2">
                                            @endif
                                        @elseif ($propertySetting->logo === 0)
                                            <!-- No se muestra nada cuando $propertySetting->logo es igual a "0" -->
                                        @endif
                                    @endif

                                    @if (is_null($propertySetting) || is_null($propertySetting->license))
                                        <span class="border border-black text-black px-2 py-1 rounded">{{ $license_plate }}</span>
                                    @else
                                        @if ($propertySetting->license === '1')
                                        <span class="border border-black text-black px-2 py-1 rounded">{{ $license_plate }}</span>
                                        @elseif ($propertySetting->license === 0)
                                            <!-- No se muestra nada cuando $propertySetting->name es igual a "0" -->
                                        @endif
                                    @endif
                                </div>


                                <div class="text-center">
                                    @if (is_null($propertySetting) || is_null($propertySetting->start_date))
                                    <p class="mb-2 text-xs font-semibold">
                                        From: {{ $start_date->format('d/m/Y') }} To:
                                        {{ Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                                    </p>
                                    @else
                                    @if ($propertySetting->start_date === "1")
                                    <p class="mb-2 text-xs font-semibold">
                                        From: {{ $start_date->format('d/m/Y') }} To:
                                        {{ Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                                    </p>
                                    @elseif ($propertySetting->license === 0)
                                    <!-- No se muestra nada cuando $propertySetting->name es igual a "0" -->
                                @endif
                                @endif
                                </div>
                            </div>
                        </div>
                         

                        <div class="p-4">
                            <div class="">
                                <h2 class="text-lg font-bold text-center mb-4">Instrucciones</h2>
                                <ol class="list-decimal pl-4">
                                    <li class="mb-2">Limpie el área donde se colocará la etiqueta.</li>
                                    <li class="mb-2">Separe la etiqueta del documento por las perforaciones.</li>
                                    <li class="mb-2">Despegue el revestimiento que cubre el borde azul de la etiqueta.
                                    </li>
                                    <li class="mb-2">Coloque la etiqueta en la ventana sobre la pegatina de
                                        registro/inspección del vehículo y alísela suavemente contra el vidrio.</li>
                                </ol>
                            </div>
                        </div>

                    </div>
                </div>

                <div class=" p-6">
                    
                    <h2 class="text-2xl font-semibold mb-6">Acuerdo</h2>
                    <p>Este Acuerdo es un anexo y forma parte del Contrato de Arrendamiento de Apartamento, celebrado y
                        firmado entre 3rd. Street Apartments y el/los Residente(s) que se detallan a continuación:</p>
                    <p>Al firmar este anexo, yo/nosotros aceptamos lo siguiente:</p>

                    <ul class="list-disc ml-6 mb-6">
                        <li>Entiendo que se emitirá un permiso de estacionamiento para cada apartamento. Los permisos de
                            estacionamiento no se emitirán a los ocupantes. Acepto colocar el permiso de estacionamiento
                            justo encima de las pegatinas de inspección/registro de mi vehículo.</li>
                        <li>Entiendo que cada permiso está designado para un vehículo específico y no puede transferirse
                            a otro vehículo. Comprendo que el permiso asignado se basa en la información de la matrícula
                            del vehículo. También acepto que, si obtengo un vehículo nuevo, debo devolver el antiguo
                            permiso.</li>
                        <li>El permiso de estacionamiento vencerá el último día del contrato de arrendamiento actual.
                            Comprendo que debo renovar mi permiso de estacionamiento cuando venza mi contrato de
                            arrendamiento actual. También entiendo que se requiere evidencia de registro de vehículo y
                            evidencia de seguro de vehículo válido antes de que se emitan y/o renueven los permisos.
                        </li>
                        <li>Entiendo que los visitantes no pueden estacionar dentro de las puertas de acceso en ningún
                            momento. Todo el estacionamiento para visitantes está designado fuera de las puertas en todo
                            momento. Comprendo que cualquier vehículo estacionado en el estacionamiento designado para
                            Futuros Residentes fuera de las puertas de acceso debe moverse durante el horario de oficina
                            cada día.</li>
                        <li>Entiendo que no puedo estacionar barcos, remolques, vehículos recreativos o vehículos
                            comerciales en la propiedad, en ningún lugar ni en ningún momento. Los vehículos deben
                            conducirse de forma regular y no pueden dejarse abandonados o inoperables en ningún momento.
                        </li>
                        <li>Entiendo que si se remolca un vehículo, puedo contactar a la Compañía de Remolque A.
                            Martinez LLC, las 24 horas del día, al 832-374-7703.</li>
                        <li>Si un vehículo se estaciona dentro de las puertas sin permiso, puedo contactar directamente
                            al servicio de remolque para que retire el vehículo. Todos los vehículos remolcados serán a
                            cargo del propietario/operador del vehículo.</li>
                    </ul>


                    <div style="padding-top: 5em">
                        <table width="99%" cellpadding="5" cellspacing="2">
                            <tbody>
                                <tr>
                                    <td width="205"><span class="center_txt">{{ $name }}</span></td>
                                    <td width="60" class="center_txt">{{ $unit_number }}</td>
                                    <td width="25">&nbsp;</td>
                                    <td width="210"></td>
                                    <td width="95">{{ now()->format('d/m/Y') }}</td>

                                </tr>
                                <tr>
                                    <td width="205" class="border-t border-gray-800">
                                        <span class="center_txt">Nombre Impreso del Residente</span>
                                    </td>
                                    <td width="60" class="center_txt border-t border-gray-800">Núm. de Unidad</td>
                                    <td width="25">&nbsp;</td>
                                    <td width="210" class="border-t border-gray-800">
                                        <span class="center_txt">Firma</span>
                                    </td>
                                    <td width="95" class="border-t border-gray-800">
                                        <span class="center_txt">Fecha</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                
            </div>
        </div>
        <script>
            // Escucha el evento submit del formulario
            document.getElementById('print-pdf-form').addEventListener('submit', function(event) {
                // Evita que el formulario se envíe de manera predeterminada
                event.preventDefault();

                // Realiza una solicitud POST al servidor
                axios.post(this.action, new FormData(this), {
                        responseType: 'blob', // Indica que esperas una respuesta binaria (archivo)
                    })
                    .then(response => {
                        // Crea una URL a partir de los datos binarios
                        const blob = new Blob([response.data], {
                            type: 'application/pdf'
                        });
                        const url = window.URL.createObjectURL(blob);

                        // Abre la URL en una nueva ventana o pestaña
                        window.open(url);

                        // Liberar la URL cuando no se necesite más (opcional)
                        window.URL.revokeObjectURL(url);
                    })
                    .catch(error => {
                        console.error('Error al imprimir PDF:', error);
                    });
            });
        </script>
    </main>
</x-app-layout>
