<style>
    .entete {
        color: #7571f9;
        background-color: white;
    }
    .carte {
        color: white;
        background-color: white;
    }
    .texte {
        color: black;
    }
    .table {
        color: black;
    }
    .button-group {
        display: flex;
        justify-content: space-around;
    }
    .button-group form {
        margin-right: 10px; /* Adjust spacing as needed */
    }
    .form-inline .form-group {
        margin-right: 5px; /* Reduce the margin between form fields */
    }
    .form-inline .form-control {
        padding-left: 5px; /* Adjust padding if needed */
        padding-right: 5px; /* Adjust padding if needed */
    }
    .form-group.mb-2, .form-group.mx-sm-1.mb-2 {
        margin-bottom: 0; /* Remove bottom margin to bring elements closer */
    }
    .form-inline .form-control-plaintext {
        margin-right: 5px; /* Reduce space after "Stade" label */
    }
    .form-inline select, .form-inline button {
        margin-left: 5px; /* Reduce space before select and button */
    }
</style>
@include('CRM.header')
@include('CRM.sidebar')

<div class="content-body">
    <div class="container-fluid mt-3">
        @include('CRM.headerBc')
        <div class="card col-12 carte">
            <div class="card-header d-flex justify-content-center align-items-center entete">
                <h3 class="entete">BC GENERAL</h3>
            </div>

            <div class="card-body">
                <div class="row mt-3" style="display: flex; align-items: center;justify-content: space-between; border-bottom: solid 3px lightgrey;">
                        <div class="col-5" style="margin-left: 100px;">
                            <img src="" class="img-fluid rounded-start mb-5" alt="Logo" width="200" height="200px">
                        </div>
                        <div class="col-5" style="margin-top: -60px;margin-left:30px;">
                            <p class="texte mb-0"><b>Société Anonyme avec conseil d'administration</b> </p>
                            <p class="texte mb-0"><b>au capital de 148 400 000 Ariary</b></p>
                            <p class="texte mb-0"><b>LOT 03810D Ambohitrangano Sabotsy Namehana</b></p>
                            <p class="texte mb-0"><b>Antananarivo 103</b></p>
                            <p class="texte mb-0"><b>NIF: 2000100388</b></p>
                            <p class="texte mb-0"><b>STAT: 14105 11 1995 0 00077</b></p>
                            <p class="texte mb-0"><b>Décret d'agrément n°95-410 du 30 Mai 1995</b></p>
                            <p class="texte mb-0"><b>TEL 22 451 54 / 22 534 84</b></p>
                            <p class="texte mb-0"><b>FAX / 24 741 05</b></p>
                        </div>
                </div>

                <br>

                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 151px;">Date :</span>
                    </div>
                    <input type="date" name="date_general" class="form-control custom-input">
                </div>
                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 151px;">N° BC :</span>
                    </div>
                    <input type="text" class="form-control" value="{{ $numero }}_General/LOI/{{ date('Y') }}">
                </div>

                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <label class="input-group-text" style="width: 151px;">Fournisseur</label>
                    </div>
                    <select class="custom-select" name="fournisseur">
                        <option selected>Chosiser un fornisseur...</option>
                        @foreach($fournisseur as $f)
                        <option value="{{ $f->id }}">{{ $f->nomtier }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Échéance Livraison :</span>
                    </div>
                    <input type="date" class="form-control" name="echeance">
                </div>
            <div class="col-5" style="float: right;margin-top: -155px;">
                <div class="input-group mb-1" style="width: 370px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style="width: 151px;">TVA :</span>
                    </div>
                    <input type="text" class="form-control" value="" >
                </div>
            </div>
            <button type="button" class="btn btn-primary">Save</button>
                <br>
                <br>
            </div>
        </div>
    </div>
    <!-- #/ container -->
</div>


@include('CRM.footer')
