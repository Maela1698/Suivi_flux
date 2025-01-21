@include('CRM.header')
@include('CRM.sidebar')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('GMAO.headerGMAO')
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="col-sm-4">
                           <h3  class="entete">AJOUTER PIECE(S)</h3>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">Insérer ici les pièces</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form-valide" action="{{route('GMAO.storepiece')}}" method="post" enctype="multipart/form-data" autocomplete="off" id="piece-form">
                                @csrf
                                @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif


                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Date Insertion</label>
                                        <input type="date" class="form-control" placeholder="Date Insertion" id="date_ajout" name="date_ajout">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Designation</label>
                                        <input type="text" class="form-control" placeholder="Désignation" id="designation" name="designation">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Reference</label>
                                        <input type="text" class="form-control" placeholder="Reference" id="reference" name="reference">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Duree de vie <small><em>en heure</em></small></label>
                                        <input type="text" class="form-control" placeholder="Duree de vie" id="duree_vie" name="duree_vie">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Nombre</label>
                                        <input type="number" class="form-control" placeholder="nombre de pièces" id="nbr" name="nbr" min=1>
                                    </div>
                                </div>
                                <div class="form-row d-flex">
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Prendre une photo</label>
                                            </div>
                                            <div class="col-12">
                                                <video id="video" width="320" height="240" autoplay class="mb-2"></video>
                                                <canvas id="canvas" width="320" height="240" style="display:none;" class="mb-2"></canvas>

                                                <div class="d-flex justify-content-between">
                                                    <button type="button" id="snap" class="btn btn-primary mb-1">
                                                        <i class="fas fa-camera"></i> Prendre la photo
                                                    </button>
                                                    <form id="photo-form" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" id="imageData" name="image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image demande -->
                                    <div class="col-4">
                                        <div class="row no-gutters">
                                            <div class="col-12">
                                                <label class="col-form-label">Image pièce <small>importer si on ne prends pas de photos</small></label>
                                            </div>
                                            <div class="col-12">
                                                <label class="custom-file-upload">
                                                    <input type="file" class="form-control-file" name="photo_machine">
                                                    <i class="fas fa-image"></i> Ajouter une image
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('GMAO.boutongmao')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@include('CRM.footer')
{{-- photo --}}
<script>
    const video = document.querySelector('#video');
    const canvas = document.querySelector('#canvas');
    const snap = document.querySelector('#snap');
    const imageData = document.querySelector('#imageData');

    // Accéder à la caméra
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        });

    // Prendre la photo
    snap.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, 320, 240);
        const dataUrl = canvas.toDataURL('image/png');
        imageData.value = dataUrl;

        // Rendre le canvas visible après la capture
        canvas.style.display = 'block'; // Change l'affichage du canvas
    });

    // Soumettre le formulaire principal d'ajout de machine
    const machineForm = document.querySelector('#machine-form');
    //machineForm.addEventListener('submit', (event) => {
      //  if (!imageData.value) {
        //    alert('Veuillez prendre une photo avant de soumettre le formulaire.');
          //  event.preventDefault();
        //}
    //});
</script>
{{-- photo --}}
