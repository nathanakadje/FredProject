@extends('espacemembre')

@section('formulaire')

<div class="w3-mains " style="margin-top:54px">
<div >
  {{-- <h3>Add new Sender</h3> --}}
  <div class="w3-row-padding w3-stretch">
    <div class="w3-col l6">
      <div class="w3-white w3-round w3-margin-bottom w3-border" style="">
        <header class="w3-padding-large w3-large w3-border-bottom" style="font-weight: 500">Add New Sender</header>
        <div class="w3-padding-large">

          @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif

          <form action="/addsender/store" method="POST">
          @csrf
            <div class="w3-margin-bottom">
              <label for="name" class="form-label">Name</label>
             
              <input type="text" class="w3-input w3-border w3-round form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter Your Name" value="{{ old('name') }}" >
              @error('name')
              <div class="text-danger">{{ $message }}</div>
          @enderror
            </div>
{{-- *****************************************************--}}
            <div class="w3-margin-bottom">
              <label for="operator" class="form-label">Operator</label>

              <input type="text" class="w3-input w3-border w3-round form-control @error('operator') is-invalid @enderror" value="{{ old('operator') }}" id="operator" name="operator" placeholder="Enter operator">
              @error('operator')
              <div class="text-danger">{{ $message }}</div>
          @enderror
            </div>
{{-- ***************************************************************************** --}}
            <div class="w3-margin-bottom">
              <label for="country" class="form-label">Country</label>
              
              <input type="text" class="w3-input w3-border w3-round form-control @error('country') is-invalid @enderror" value="{{ old('country') }}" id="country" name="country"  placeholder="Enter the country">
              @error('country')
              <div class="text-danger">{{ $message }}</div>
          @enderror
            </div>
{{-- ******************************************************************************************* --}}
            <div class="w3-margin-bottom">
              <label for="status" class="form-label">Status</label>
             
              <select id="status" class="w3-input w3-border w3-round form-control @error('status') is-invalid @enderror" name="status"  id="status" >                  
                <option value="">Sélectionnez un status</option>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="valide" {{ old('status') == 'valide' ? 'selected' : '' }}>Valide</option>
                <option value="close" {{ old('status') == 'close' ? 'selected' : '' }}>Close</option>
              </select>
              @error('status')
              <div class="text-danger">{{ $message }}</div>
          @enderror
            </div>
{{-- *********************************************************************************************************** --}}
            <div class="w3-margin-bottom">
              <label for="date_sub" class="form-label">Submission Date</label>
             
        <input type="date" class="w3-input w3-border w3-round form-control @error('date_sub') is-invalid @enderror" value="{{ old('date_sub') }}" name="date_sub" max="{{ date('Y-m-d') }}"  placeholder="Enter date">
        @error('date_sub')
        <div class="text-danger">{{ $message }}</div>
    @enderror  
      </div>
{{-- ******************************************************************************************* --}}
            <div class="w3-margin-bottom">
              <label for="date_valid" class="form-label">Validation Date</label>
             
        <input type="date" class="w3-input w3-border w3-round form-control 
        @error('date_valid') is-invalid @enderror" value="{{ old('date_valid') }}" name="date_valid" max="{{ date('Y-m-d') }}" id="date_valid" placeholder="Enter date">
           @error('date_valid')
        <div class="text-danger">{{ $message }}</div>
    @enderror  
      </div>
    {{-- ********************************************************************************************************************** --}}
           
            <div class="w3-margin-bottom">
              <label for="commentaire" class="form-label">Commentaire</label>
        <textarea  class="w3-input w3-border w3-round w3-round form-control @error('date_valid') is-invalid @enderror" name="commentaire"  placeholder="comment">{{ old('commentaire') }}</textarea>
        @error('commentaire')
        <div class="text-danger">{{ $message }}</div>
    @enderror   
      </div> 
         
            <div class="w3-margin-bottom">
              <button class="w3-button w3-primary w3-round"><i class="fa fa-fw fa-lock"></i> Register</button>
            </div>
        </form>
          
        </div>
      </div>
    </div>
    
      @endsection
    
