<div class="col-md-2 mb-2" style="float: right; position: relative; margin-right: -110px; margin-top: -20px;">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 50%; width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center;">
            <i class="icon icon-settings"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('CRM.listeEtatTier') }}">Etat</a>
            <a class="dropdown-item" href="{{ route('CRM.listeUnite') }}">Unite</a>
            <a class="dropdown-item" href="{{ route('CRM.listeQualite') }}">Qualité</a>
        </div>
    </div>
</div>
