@extends('espacemembre')
@section('actions')

    <div class="w3-main" style="margin-top:54px">
    
        
        <section class="badge-dot " >
        <div class="w3-right card-toolbar" style="margin-right: 10px"> 
            <h4>
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-md-9">
                            <input type="text" 
                                   id="searchInput" 
                                   class="form-control" 
                                   placeholder="Enter keywords">
                        </div>
                    </div>
                </div>
            </h4>
        </div>
        {{-- <div>
        <h3 class="w3-left card-toolbar mb-3" style="margin-left: 15px">
            <!-- Bouton d'export avec menu déroulant -->
            
            <div class="dropdown">
                <!-- Bouton principal avec une icône et un libellé -->
                <button class="btn btn-sm btn-success dropdown-toggle text-white w3-margin-top"  type="button" id="exportCsvBtn" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download"></i> Exporter
                </button>
            
                <!-- Menu déroulant contenant les options d'exportation -->
                <ul class="dropdown-menu" aria-labelledby="exportCsvBtn">
                    <li>
                        <a class="dropdown-item" href="{{ route('actions.exported', ['type' => 'excel'] + request()->query()) }}">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('actions.exported', ['type' => 'csv'] + request()->query()) }}">
                            <i class="fas fa-file-csv"></i> Export CSV
                        </a>
      
                    </li>
                </ul>
            </div>
        </h3>
        </div>  --}}
    </section>
        <div class="w3-white w3-round w3-margin-bottom w3-border" style="">
          <div class="w3-padding-large">
            <section class="badge-dot">
                <div class="card-toolbar">
                    <h4>
                      <br>
                      <br>
                    </h4>
                </div>
            </section>
            <section id="web-application">
               
            </section>
            <section id="web-application">
              <h4 class="w3-margin-top w3-border-bottom"></h4>
              <div class="w3-row">
                <div class="card-body py-0">
                    <table class="table table-sm table-hover  w3-table w3-bordered  table-striped table-bordered" id="tabledatas" > 
                            <thead>
                              <tr>
                                {{-- <th  data-searchable="false">Create_at</th> --}}
                                <th  data-searchable="true">Name</th>
                                <th  data-searchable="true">Operator</th>
                                <th  data-searchable="true">Country</th>
                                <th  data-searchable="true">Status</th>
                                {{-- <th  data-searchable="false">Sub Date</th> --}}
                                <th  data-searchable="false">Udpdate</th>
                                <th  data-searchable="false">Action</th>                              
                              </tr>
                            </thead>
                               
                        <tbody id="tableBody">
                        @forelse ($user as $senders)
                        <tr>
                            <td>{{ $senders->name }}</td>
                            <td>{{ $senders->operator }}</td>
                            <td>{{ $senders->country }}</td>
                            <td>
                                @switch($senders->status)
                                @case('close')
                                <span class="badge bg-danger ">{{ $senders->status }}</span>
                                @break
                                @case('pending')
                                <span class="badge bg-warning text-dark">{{ $senders->status }}</span>
                                @break
                                @default
                                <span class="badge bg-success ">{{ $senders->status }}</span> 
                                @endswitch
                            </td>
                            <td>{{ $senders->updated_at->format('d/m/Y H:i') }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($senders->date_sub)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($senders->date_valid)->format('d/m/Y') }}</td> --}}
                        
                                <td>
                                    <a href="#" onclick="openEditModal({{ $senders->id }})"><i class="fa fa-edit text-primary me-3 edit-btn"></i><span style="color: rgba(161, 1, 1, 0.822)">Actions</span></a>
                                    {{-- <a href="#" onclick="deleteUser({{ $senders->id }})"><i class="fa fa-trash text-danger me-3 "></i><span style="color: rgba(243, 10, 10, 0.801)">Delete</span></a> --}}
                               
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun enregistrement trouvé</td>
                            </tr>
                            
                        @endforelse
                        
                    </table>
                    <div class="pagination">
                        {{ $user->links() }}
                    </div> 
                            <!-- Pagination -->
    

                            <div class="modal fade" id="editDeleteModal" tabindex="-1" aria-labelledby="editDeleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDeleteModalLabel">Edit/Delete Record</h5>
                                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm">
                                                @csrf
                                                <input type="hidden" id="editRecordId" name="id">
                                                
                                                <div class="mb-3">
                                                    <label for="editName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="editName" name="name" required maxlength="11" >
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="editOperator" class="form-label">Operator</label>
                                                    <input type="text" class="form-control" id="editOperator" name="operator" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="editCountry" class="form-label">Country</label>
                                                    <input type="text" class="form-control" id="editCountry" name="country" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="editStatus" class="form-label">Status</label>
                                                    <select class="form-select" id="editStatus" name="status" required>
                                                        <option value="pending">Pending</option>
                                                        <option value="valide">Valide</option>
                                                        <option value="close">Close</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-sm " id="deleteButton">Delete</button>
                                            <button type="button" class="btn btn-primary btn-sm" id="updateButton">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                   <!-- Fenêtre modale pour l'édition -->
{{-- <div class="modal" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong></strong>Editing sender</strong></h5>
                <button type="button" class="close" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="userId">
                    
                    <div class="form-group">
                        <label for="name">Name :</label>
                        <input type="text" id="name" name="name" class="form-control" maxlength="11" >
                    </div>
                    
                    <div class="form-group save">
                        <label for="country">Operator :</label>
                        <input type="text" id="country" name="country" class="form-control">
                    </div>
                    
                    <div class="form-group save" >
                        <label for="status">Status :</label>
                    
                        <select id="status" class="w3-input w3-border w3-round form-control @error('status') is-invalid @enderror" name="status"  id="status" >                  
                            <option value="">Sélectionnez un status</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="valide" {{ old('status') == 'valide' ? 'selected' : '' }}>Valide</option>
                            <option value="close" {{ old('status') == 'close' ? 'selected' : '' }}>Close</option>
                          </select>
                    </div>
                    
                    <div class="form-group"  >
                        <label for="operator">Opérateur :</label>
                        <input type="text" id="operator" name="operator" class="form-control">
                    </div>
                    <div class="save">
                    <button type="button" class="btn btn-primary btn-sm"  onclick="saveChanges()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

</div>
</div>        
  </div>
        </div>
        </div>
   
@endsection

