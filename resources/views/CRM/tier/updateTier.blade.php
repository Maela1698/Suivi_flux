@include('CRM.header')
@include('CRM.sidebar')

<!--**********************************
        Content body start
***********************************-->
<style>
    .form-control {
        border: 1px solid #b5b5b5;
    }

    label {
        color: #767575;
    }
</style>

<style>
    #suggestionsList {
        max-height: 200px;
        overflow-y: auto;
        color: #767575;
    }
</style>

<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        @include('CRM.headerCrm')
        <div class="row">
            <div class="card col-12">
                <div class="card-header d-flex justify-content-between align-items-center entete">
                    <h3 class="entete">MODIFIER TIERS</h3>
                </div>

                <div class="card-body">
                    <div class="form-validation">
                        <form action="{{ route('CRM.modifTier') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Nom Tier et Acteur -->
                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Nom tier</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="nomTier"
                                                value="{{ $tier[0]->nomtier }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Acteur</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="idActeur" required>
                                                @foreach ($acteur as $a)
                                                    <option
                                                        value="{{ $a->id }}"{{ $a->id == $tier[0]->idacteurtiers ? 'selected' : '' }}>
                                                        {{ $a->acteur }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Site Web, Logo et Cahier de Charge -->
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Site web</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="webSite"
                                                value="{{ $detailtier[0]->website }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Logo actuel :</label>
                                        </div>
                                        <div class="custom-file" style=" border: 1px solid #b5b5b5;">
                                            <input type="hidden" name="photoRecent"  value="{{ $detailtier[0]->logo }}">
                                            <input type="file" class="custom-file-input" id="fileInput"
                                                name="logo">
                                            <label class="custom-file-label">'Choisissez un fichier' </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">

                                                <label class="col-form-label">Cahier de charge actuel : </label>

                                        </div>
                                        <div class="custom-file" style=" border: 1px solid #b5b5b5;">
                                            @if(!empty($cahiercharge[0]->cahiercharge))
                                                <input type="hidden" name="cahierCRecent" value="{{ $cahiercharge[0]->cahiercharge }}">
                                            @endif
                                            
                                            <input type="file" class="custom-file-input" id="fileInput1"
                                                name="cahierCharge">
                                            <label class="custom-file-label"> 'Choisissez un fichier' </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pays, Ville et Code Postal -->
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Pays</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="nomPays" class="form-control"
                                                placeholder="Entrez un nom de pays" value="{{ $tier[0]->nom_fr_fr }}"
                                                oninput="syncHiddenField('nomPays', 'idPays')" required>
                                            <input type="hidden" id="idPays" class="form-control" name="idPays"
                                                value="{{ $tier[0]->idpays }}" required>
                                            <ul id="suggestionsList" class="list-group mt-2" style="display: none;">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Ville</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="ville"
                                                value="{{ $detailtier[0]->ville }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Code Postal</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="codePostal"
                                                value="{{ $detailtier[0]->codepostal }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Adresse, Tel et Email -->
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Adresse</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="adresse"
                                                value="{{ $detailtier[0]->adresse }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Tel</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="numPhone"
                                                value="{{ $detailtier[0]->numphone }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Email</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="emailTier"
                                                value="{{ $detailtier[0]->emailtier }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nom Interlocuteur, Email Interlocuteur et Contact Interlocuteur -->

                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Nom interlocuteur </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="nomInter">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Email interlocuteur </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="emailInter">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Contact interlocuteur </label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" id="contactInter">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Plus </label>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-success" id="addMoreButton">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered" id="interlocuteurTableAjout">
                                    <thead>
                                        <tr>
                                            <th>Nom interlocuteur</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($interlocateur as $index => $interlocuteur)
                                            <tr>
                                                <td><input type="text" class="form-control"
                                                        value="{{ $interlocuteur->nominterlocateur }}"
                                                        name="nom{{ $index }}"></td>
                                                <td><input type="text" class="form-control"
                                                        value="{{ $interlocuteur->emailinterlocateur }}"
                                                        name="email{{ $index }}"></td>
                                                <td><input type="text" class="form-control"
                                                        value="{{ $interlocuteur->contactinterlocateur }}"
                                                        name="contact{{ $index }}"></td>
                                                <td><button type="button"
                                                        class="btn btn-danger btn-sm delete-existing-row">Supprimer</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($interlocateur->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">Pas d'interlocuteur inséré</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>


                            <!-- Unité Monétaire, Qualité et Etat -->
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Unité monétaire</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="idUnite" required>
                                                @foreach ($unite as $u)
                                                    <option
                                                        value="{{ $u->id }}"{{ $u->id == $tier[0]->idunitemonetaire ? 'selected' : '' }}>
                                                        {{ $u->unite }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Qualité</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="idQualite" required>
                                                @foreach ($qualite as $q)
                                                    <option
                                                        value="{{ $q->id }}"{{ $q->id == $tier[0]->idqualitetiers ? 'selected' : '' }}>
                                                        {{ $q->qualite }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Etat</label>
                                        </div>
                                        <div class="col-12">
                                            <select class="form-control" name="idEtat" required>
                                                @foreach ($etat as $e)
                                                    <option
                                                        value="{{ $e->id }}"{{ $e->id == $tier[0]->idetattiers ? 'selected' : '' }}>
                                                        {{ $e->etattiers }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MerchSenior, MerchJunior et Assistant(e) -->
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">MerchSenior</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" name="merchSenior" class="form-control"
                                                value="{{ $detailtier[0]->merchsenior }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Email MerchSenior</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="emailMerchSenior"
                                                value="{{ $detailtier[0]->emailmerchsenior }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Contact MerchSenior</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="contactMerchSenior"
                                                value="{{ $detailtier[0]->contactmerchsenior }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">MerchJunior</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="merchJunior"
                                                value="{{ $detailtier[0]->merchjunior }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Email MerchJunior</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="emailMerchJunior"
                                                value="{{ $detailtier[0]->emailmerchjunior }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Contact MerchJunior</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="contactMerchJunior"
                                                value="{{ $detailtier[0]->contactmerchjunior }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Assistant(e)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="assistant"
                                                value="{{ $detailtier[0]->assistant }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Email assistant(e)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="emailAssistant"
                                                value="{{ $detailtier[0]->emailassistant }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row no-gutters">
                                        <div class="col-12">
                                            <label class="col-form-label">Contact assistant(e)</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="contactAssistant"
                                                value="{{ $detailtier[0]->contactassistant }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="nombreLignesExistantes" id="nombreLignesExistantes"
                                value="{{ count($interlocateur) }}">
                            <input type="hidden" name="nombreLignesNouvelles" id="nombreLignesNouvelles"
                                value="0">
                            <input type="hidden" name="idTiers" value="{{ $idtier }}">

                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto text-right d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning">Modifier</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--**********************************
        modal start
***********************************-->

<div class="modal fade custom-modal" id="confirmDeleteModal" tabindex="-1"
    aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette ligne ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                <button type="button" class="btn btn-primary" id="confirmDeleteButton">Oui</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-modal" id="confirmAddModal" tabindex="-1" aria-labelledby="confirmAddModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmAddModalLabel">Confirmation d'ajout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sur de vouloir modifier ces informations ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAddButton">Valider</button>
            </div>
        </div>
    </div>
</div>

<!--**********************************
        modal end
***********************************-->

<!--**********************************
        javascript start
***********************************-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('fileInput');
        var fileLabel = fileInput.nextElementSibling;

        fileInput.addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'Choose file';
            fileLabel.textContent = fileName;
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('fileInput1');
        var fileLabel = fileInput.nextElementSibling;

        fileInput.addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'Choose file';
            fileLabel.textContent = fileName;
        });
    });
</script>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        var rowCount = 0;
        var exist = parseInt($('#nombreLignesExistantes').val());

        // Lorsque le formulaire est soumis
        $('form').on('submit', function(event) {
            event.preventDefault();
            $('#confirmAddModal').modal('show');
        });

        $('#confirmAddButton').click(function() {
            $('form').off('submit').submit();
        });

        $('#addMoreButton').click(function() {
            var nom = $('#nomInter').val();
            var email = $('#emailInter').val();
            var contact = $('#contactInter').val();

            if (nom || email || contact) {
                var newRow = '<tr>' +
                    '<td><input class="form-control" type="text" value="' + nom + '" name="nomAjout' +
                    rowCount + '"></td>' +
                    '<td><input class="form-control" type="text" value="' + email +
                    '" name="emailAjout' + rowCount + '"></td>' +
                    '<td><input class="form-control" type="text" value="' + contact +
                    '" name="contactAjout' + rowCount + '"></td>' +
                    '<td><button type="button" class="btn btn-danger btn-sm delete-row">Supprimer</button></td>' +
                    '</tr>';

                $('#interlocuteurTableAjout tbody').append(newRow);
                $('#interlocuteurTableAjout').removeClass('d-none');

                $('#nomInter').val('');
                $('#emailInter').val('');
                $('#contactInter').val('');

                rowCount += 1;
                $('#nombreLignesNouvelles').val(rowCount);
            }
        });

        $(document).on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            rowCount -= 1;
            $('#nombreLignesNouvelles').val(rowCount);

            // Réindexer les noms des inputs dans le tableau d'ajout
            reindexInputs('#interlocuteurTableAjout', 'Ajout');

            if ($('#interlocuteurTableAjout tbody tr').length === 0) {
                $('#interlocuteurTableAjout').addClass('d-none');
            }
        });

        $(document).on('click', '.delete-existing-row', function() {
            $(this).closest('tr').remove();
            exist -= 1;
            $('#nombreLignesExistantes').val(exist);

            // Réindexer les noms des inputs dans le tableau existant
            reindexInputs('#interlocuteurTable', '');

            if ($('#interlocuteurTable tbody tr').length === 0) {
                $('#interlocuteurTable').addClass('d-none');
            }
        });

        // Fonction pour réindexer les noms des inputs
        function reindexInputs(tableId, suffix) {
            $(tableId + ' tbody tr').each(function(index) {
                $(this).find('input[name^="nom' + suffix + '"]').attr('name', 'nom' + suffix + index);
                $(this).find('input[name^="email' + suffix + '"]').attr('name', 'email' + suffix +
                    index);
                $(this).find('input[name^="contact' + suffix + '"]').attr('name', 'contact' + suffix +
                    index);
            });
        }
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nomPays = document.getElementById('nomPays');
        var idPays = document.getElementById('idPays');
        var suggestionsList = document.getElementById('suggestionsList');

        nomPays.addEventListener('input', function() {
            var query = nomPays.value;

            if (query.length < 1) {
                suggestionsList.style.display = 'none';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '{{ route('recherche-pays') }}?nomPays=' + encodeURIComponent(query),
            true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var countries = JSON.parse(xhr.responseText);
                    suggestionsList.innerHTML = '';
                    if (countries.length > 0) {
                        countries.forEach(function(country) {
                            var li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = country.nom_fr_fr;
                            li.addEventListener('click', function() {
                                nomPays.value = country.nom_fr_fr;
                                idPays.value = country.id;
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(li);
                        });
                        suggestionsList.style.display = 'block';
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                }
            };
            xhr.send();
        });

        document.addEventListener('click', function(event) {
            if (!nomPays.contains(event.target) && !suggestionsList.contains(event.target)) {
                suggestionsList.style.display = 'none';
            }
        });
    });
</script>

<script>
    function syncHiddenField(textInputId, hiddenInputId) {
        const textInput = document.getElementById(textInputId);
        const hiddenInput = document.getElementById(hiddenInputId);

        if (textInput.value.trim() === '') {
            hiddenInput.value = ''; // Clear the hidden field if the text input is empty
        }
    }
</script>

<!--**********************************
        javascript start
***********************************-->

<!--**********************************
        Content body end
***********************************-->
@include('CRM.footer')
