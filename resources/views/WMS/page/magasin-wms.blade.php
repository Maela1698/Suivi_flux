@include('CRM.header')
@include('CRM.sidebar')
<style>
    .code {
        display: flex;
        gap: 4px;
        /* Espace entre les cercles */
    }

    .circle {
        border: solid thin black;
        width: 20px;
        /* Largeur du cercle */
        height: 20px;
        /* Couleur de fond du cercle */
        color: white;
        /* Couleur du texte */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        /* Rend le div rond */
        font-size: 24px;
        /* Taille du texte */
    }

    .dropdown-item {
        padding: 10px 20px;
        /* Adjust as needed */
        font-size: 16px;
        /* Modify for better readability */
    }

    label {
        color: black;
        font-size: 12px;
    }
</style>
<div class="content-body">

    <div class="container-fluid">
        @include('WMS.headerWMS')
        <div class="card">
            <section class="py-5">
                <div class="container py-5">
                    <div class="row mb-5">
                        <div class="col-md-8 col-xl-6 text-center mx-auto">
                            <h2 class="fw-bold text-uppercase">MAGASIN {{ $typeWMS->type }}</h2>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;">
                        <div class="col mb-4">
                            <div>
                                <div class="py-4">
                                    <a class="btn btn-primary fw-bold"
                                        href="{{ route('WMS.page-accueil-entree-wms', ['idtypewms' => $typeWMS->id]) }}">Entrée</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div>
                                <div class="py-4">
                                    <a class="btn btn-primary fw-bold"
                                        href="{{ route('WMS.page-stock-wms', ['idtypewms' => $typeWMS->id]) }}">Stock</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div>
                                <div class="py-4">
                                    <a class="btn btn-primary fw-bold"
                                        href="{{ route('WMS.page-accueil-sortie-wms', ['idtypewms' => $typeWMS->id]) }}">Sortie</a>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div>
                                <div class="py-4">
                                    <a class="btn btn-primary fw-bold"
                                        href="{{ route('WMS.page-retour-wms', ['idtypewms' => $typeWMS->id]) }}">Retour</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- ?TSCF? --}}
        @if ($idtypewms == 1)
            @include('WMS.page.tscf-accessoire')
        @endif
        {{-- ?TSCF? --}}

    </div>
    @include('CRM.footer')
