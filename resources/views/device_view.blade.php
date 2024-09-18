<x-layout>
   {{-- {{ $device }} --}}
   <div class="row">
      <div class="col-md-4">
         <div class="card rounded-3 shadow-sm border">
            <div class="card-header py-3">
               <h4 class="my-0">Datos del cliente</h4>
            </div>
            <div class="card-body p-3">
               <div class="d-flex gap-2 mb-3">
                  <img src="http://localhost:8000/assets/images/user.png" alt="twbs" width="30" height="30" class="rounded-circle flex-shrink-0">
                  <div>
                     <label for="">Nombre cuenta</label>
                     <span class="d-block text-secondary">{{ $device->name }}</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-phone"></i>
                  <div>
                     <label for="">Celular o teléfono</label>
                     <span class="d-block text-secondary">{{ $device->phone }}</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-calendar"></i>
                  <div>
                     <label for="">Fecha de creación</label>
                     <span class="d-block text-secondary">{{ $device->created_at }}</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-calendar"></i>
                  <div>
                     <label for="">última actualización</label>
                     <span class="d-block text-secondary">{{ $device->updated_at }}</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-phone"></i>
                  <div>
                     <label for="">Estado</label>
                     <span class="d-block text-secondary">Activo</span>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-md-4">
         <div class="card rounded-3 shadow-sm border">
            <div class="card-header py-3">
               <h4 class="my-0">Datos de la cuenta</h4>
            </div>
            <div class="card-body p-3">
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-phone"></i>
                  <div>
                     <label for="">Plan</label>
                     <span class="d-block text-secondary">{{ $device->plan->name }} ({{ $device->plan->description}})</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-cash-coin"></i>
                  <div>
                     <label for="">Precio / A cuenta / Saldo</label>
                     <span class="d-block text-secondary"><span class="text-primary">{{ $device->plan->price}} Bs </span>/ <span class="text-success">{{ $device->an_account}} Bs</span> / {{ $device->plan->price - $device->an_account}} Bs</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-calendar"></i>
                  <div>
                     <label for="">Fecha de inicio</label>
                     <span class="d-block text-secondary">{{ $device->started_at }}</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-calendar"></i>
                  <div>
                     <label for="">Fecha de culminación</label>
                     <span class="d-block text-secondary">{{ $device->finished_at }}</span>
                  </div>
               </div>
               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-tv"></i>
                  <div>
                     <label for="">Cantidad de dispositivos</label>
                     <span class="d-block text-secondary">{{ $device->quantity }}</span>
                  </div>
               </div>

               <div class="mb-3">
                  <label class="mb-2" for="">Progreso</label>
                  <div class="progress" role="progressbar" aria-label="Basic example" aria-valuemin="0" aria-valuemax="100">
                     <div class="progress-bar w-75"></div>
                  </div>
                  <div class="d-flex justify-content-between">
                     <small class="text-body-secondary">20/92</small>
                     <small>20%</small>
                  </div>
               </div>

               <div class="d-flex gap-2 mb-3">
                  <i class="bi bi-journal"></i>
                  <div>
                     <label for="">Datos adicionales</label>
                     <span class="d-block text-secondary">{{ $device->additional_data}}</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>      
</div>
</x-layout>