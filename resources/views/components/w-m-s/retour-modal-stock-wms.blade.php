<div class="modal" id="retour-{{ $typeretour }}-modal-{{ $idstock }}">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: white">
            <div class="modal-header" style="text-align: left;">
                <h4 class="modal-title" style="color: black">
                    Retour</h4>
            </div>
            <div class="modal-body">
                <p class="text-center alert alert-info" style="color: black">Faire un
                    retour {{ $typeretour }}</p>
                <form id="modification-form" action="{{ route('WMS.retour-wms-wms-type') }}" method="get"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idstockwms" value="{{ $idstock }}">
                    <input type="hidden" name="idtyperetour" value="{{ $idtyperetour }}">
                    <input type="hidden" name="date_retour" value="{{ date('Y-m-d') }}">
                    <div class="mb-3"><label class="form-label">Quantité</label>
                        <input class="form-control" type="text" name="quantite">
                    </div>
                    <div class="mb-3"><label class="form-label">Commentaire</label>
                        <textarea class="form-control" type="text" name="commentaire"></textarea>
                    </div>
            </div>
            <div style="text-align: center">
                <div class="modal-footer" style="text-align: center">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"
                        onclick="resetFormValues()">Annuler</button>
                    <button class="btn btn-danger" type="submit">Retourner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
