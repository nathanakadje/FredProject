@extends('espacemembre')

@section('sendsms')
    
<div class="w3-main" style="margin-top:54px">
  
</section>
        <div class="w3-white w3-round w3-margin-bottom w3-border" style="">
          <div class="w3-padding-large">
           
            <section id="web-application">
               <br>
               <br>
            </section>
            <section id="web-application">
              <h4 class="w3-margin-top w3-border-bottom"></h4>
              <div class="w3-row">
                <div class="card-body py-0">
      
<div class="container mt-5">
    <h2 class="text-center">Envoyer un Message</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="/send">
        @csrf
        <div class="form-group">
            <label for="sender">Expéditeur :</label>
            <input type="text" name="sender" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="recipients">Destinataires (séparés par des virgules) :</label>
            <input type="text" name="recipients" class="form-control">
        </div>
        <div class="form-group">
            <label for="content">Message :</label>
            <textarea name="content" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="file">Importer un fichier Excel :</label>
            <input type="file" name="file" class="form-control-file" accept=".xlsx,.xls">
        </div>
        <button type="submit" class="btn btn-success btn-block">Envoyer</button>
    </form>
</div>


                    {{-- <div class="container">
                        <h2>Envoyer un Message</h2>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                                @if(session('successCount'))
                                    <p>Nombre de contacts valides : {{ session('successCount') }}</p>
                                @endif
                            </div>
                        @endif
                    
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    
                        <form method="POST" action="{{ route('sms.send') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="sender">Expéditeur:</label>
                                <input type="text" class="form-control" id="sender" name="sender" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="recipients">Destinataires:</label>
                                <input type="text" class="form-control" id="recipients" name="recipients" 
                                       placeholder="Séparés par des virgules">
                            </div>
                            
                            <div class="form-group">
                                <label for="content">Message:</label>
                                <textarea class="form-control" id="content" name="content" required></textarea>
                            </div>
                            
                            <div class="form-group" id="parcour">
                                <label for="file">Fichier Excel (optionnel):</label>
                                <input type="file" class="form-control-file" id="file" name="file" 
                                       accept=".xlsx,.xls">
                            </div>

                            
                            <button type="submit" class="btn btn-primary">Envoyer le Message</button>
                        </form>
                    </div> --}}
                </div>
                    </div>
                    </section>
            
        </div>
      </div>
      </div>
</div>
@endsection