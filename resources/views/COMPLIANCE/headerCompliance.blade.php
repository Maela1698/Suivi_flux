<div class="row mb-4">
    <div class="col-xl-8 col-lg-8 col-md-8">
        <nav
            class="navbar navbar-expand-lg navbar-light"
            style="
                margin-top: -50px;
                border-radius: 5px;
                background-color: white;
                width: 155.8%;
                margin-left: -16px;
                display : flex;
                justify-content : space-between;
            "
        >

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown mr-3">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdownMagasin"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="color: black"
                        >
                            Audit Interne
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMagasin"
                        >
                            <a
                                class="dropdown-item"
                                href="{{ route('COMPLIANCE.listeConstat') }}"
                                >Constat</a
                            >
                            <a
                                class="dropdown-item"
                                href="{{ route('COMPLIANCE.listePlanAction') }}"
                                >Plan Action</a
                            >
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdownMenuLink"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="color: black"
                        >
                            Audit Périmètre
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a
                                class="dropdown-item"
                                href="{{ route('COMPLIANCE.listePerimetre') }}"
                                >Questionnaires</a
                            >
                            <a
                                class="dropdown-item"
                                href="{{
                                    route('COMPLIANCE.listeConstatPerimetre')
                                }}"
                                >Constat</a
                            >
                        </div>
                    </li>

                    <li class="nav-item dropdown mr-5">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdownMenuLink"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="color: black"
                        >
                            Audit Procédure
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMenuLink"
                        >
                            <a
                                class="dropdown-item"
                                href="{{
                                    route('COMPLIANCE.listeQuestionnaire')
                                }}"
                                >Questionnaires</a
                            >
                            <a
                                class="dropdown-item"
                                href="{{
                                    route('COMPLIANCE.listeConstatProcedure')
                                }}"
                                >Constat</a
                            >
                        </div>
                    </li>

                    <li class="nav-item dropdown mr-3">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdownMagasin"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="color: black"
                        >
                            Audit Externe
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMagasin"
                        >
                            <a
                                class="dropdown-item"
                                href="{{
                                    route('COMPLIANCEEXTERNE.listeAuditExterne')
                                }}"
                                >Audit</a
                            >
                            <a
                                class="dropdown-item"
                                href="{{
                                    route(
                                        'COMPLIANCEEXTERNE.listePlanActionExterne'
                                    )
                                }}"
                                >Plan Action</a
                            >
                        </div>
                    </li>

                    <li class="nav-item dropdown mr-3">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdownMagasin"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            style="color: black"
                        >
                            Budget
                        </a>
                        <div
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdownMagasin"
                        >
                            <a
                                class="dropdown-item"
                                href="{{
                                    route(
                                        'COMPLIANCEBUDGET.listeBudgetCompliance'
                                    )
                                }}"
                                >Liste</a
                            >
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 mb-2" style="float: right; position: relative; margin-right : -10%">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 50%; width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center;">
                        <i class="icon icon-settings"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" id="sectionButton">Section</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Section</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ajout Section</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('COMPLIANCE.addSection') }}" method="GET">
                                <div class="form-row">
                                    <div class="form-group col-lg">
                                        <label>Section</label>
                                        <input type="text" class="form-control" name="nom_section" required autocomplete="off">
                                        <div id="nom_section_error" class="text-danger mb-3"></div>
                                    </div>
                                    <div class="form-group col-lg">
                                        <label>Responsable</label>
                                        <input class="form-control" list="responsables" id="responsable_input" name="responsable">
                                        <div id="test_error" class="text-danger mb-3"></div>
                                        <datalist id="responsables"></datalist>
                                        <input type="hidden" id="id_employe" name="id_employe"> 
                                    </div>
                                    <div class="form-group col-lg d-flex align-items-end">
                                        <button type="btn" class="btn btn-success">Ajouter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Liste Section</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Designation</th>
                                        <th>Responsable</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="responsableSectionBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Fonction pour afficher le modal et rafraîchir les données
    function openModalAndRefresh() {
        const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
        modal.show();
        fetchAndDisplayResponsableSection();
    }

    // Événement pour ouvrir le modal lors du clic sur le bouton
    document.getElementById('sectionButton').addEventListener('click', function() {
        openModalAndRefresh();
    });

    // Événement pour stocker la valeur de l'input avant la soumission du formulaire
    document.querySelector('form').addEventListener('submit', function(event) {
        const nomSectionInput = document.querySelector('input[name="nom_section"]');
        const nomEmployeInput = document.querySelector('input[name="responsable"]');
        localStorage.setItem('nom_section_value', nomSectionInput.value);
        localStorage.setItem('nom_employe_input', nomEmployeInput.value);
    });

    // Événement pour gérer l'affichage des erreurs après le chargement de la page
    document.addEventListener("DOMContentLoaded", function() {
        // Vérifier s'il y a une erreur dans la session (utilisez Blade pour intégrer PHP)
        @if (Session::has('test_error'))
            // Réappliquer la valeur à l'input
            const nomSectionInput = document.querySelector('input[name="nom_section"]');
            const nomEmployeInput = document.querySelector('input[name="responsable"]');

            if (nomSectionValue) {
                nomSectionInput.value = nomSectionValue;
            }

            if (nomEmployeValue){
                nomEmployeInput.value = nomEmployeValue;
            }

            // Afficher le message d'erreur sous l'input de la section
            const errorContainer = document.getElementById('nom_section_error');
            errorContainer.innerText = "{{ Session::get('section-violation') }}";
            // Ouvrir le modal et rafraîchir les données

            const testErreur = document.getElementById('test_error');
            testErreur.innerText = "{{ Session::get('test_error') }}";
            openModalAndRefresh();

            // Nettoyer la valeur stockée dans localStorage
            localStorage.removeItem('nom_section_value');
        @endif
    });
    document.getElementById('responsable_input').addEventListener('input', function() {
        // Récupérer la valeur saisie dans l'input
        const selectedValue = this.value;

        // Récupérer le datalist
        const datalist = document.getElementById('responsables');

        // Trouver l'option correspondante dans le datalist
        const selectedOption = Array.from(datalist.options).find(option => option.value === selectedValue);

        // Si une option correspondante est trouvée, mettre à jour l'input caché id_employe
        if (selectedOption) {
            const idEmploye = selectedOption.getAttribute('data-id');
            document.getElementById('id_employe').value = idEmploye;
        } else {
            // Si aucune option ne correspond, réinitialiser l'input caché
            document.getElementById('id_employe').value = '';
        }
    });
</script>
<script>
    function fetchAndDisplayResponsableSection() {
        fetch('/getResponsableSection')
            .then(response => response.json())
            .then(data => {
                // Accéder à resp_sections et resp_libres dans la réponse JSON
                const respSections = data.resp_sections;
                const respLibres = data.resp_libres;

                const tbody = document.getElementById('responsableSectionBody');
                const datalist = document.getElementById('responsables');

                tbody.innerHTML = ''; // Vider le contenu existant du tableau
                datalist.innerHTML = ''; // Vider le contenu existant du datalist

                // Remplir le tableau avec les sections responsables
                respSections.forEach((resp) => {
                    const row = `
                        <tr>
                            <th>${resp.id_section}</th>
                            <td>${resp.nom_section}</td>
                            <td>${resp.nom_employe} ${resp.prenom_employe}</td>
                            <td>
                                <span>
                                    <a href="javascript:void(0)" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-pencil color-muted"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Close">
                                        <i class="fa fa-close color-danger"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });

                // Remplir le datalist avec les responsables libres
                respLibres.forEach((responsable) => {
                    const option = document.createElement('option');
                    option.setAttribute('data-id', responsable.id_employe);
                    option.value = `${responsable.nom_employe} ${responsable.prenom_employe}`;
                    datalist.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }
</script>
