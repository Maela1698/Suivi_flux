<div class="row mb-4">
    <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-white" style="margin-top: -50px; border-radius: 5px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMagasin"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Audit Interne
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMagasin">
                            <a class="dropdown-item" href="{{ route('COMPLIANCE.listeConstat') }}">Constat</a>
                            <a class="dropdown-item" href="{{ route('COMPLIANCE.listePlanAction') }}">Plan Action</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Audit Périmètre
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('COMPLIANCE.listePerimetre') }}">Questionnaires</a>
                            <a class="dropdown-item" href="{{ route('COMPLIANCE.listeConstatPerimetre') }}">Constat</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Audit Procédure
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('COMPLIANCE.listeQuestionnaire') }}">Questionnaires</a>
                            <a class="dropdown-item" href="{{ route('COMPLIANCE.listeConstatProcedure') }}">Constat</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMagasin"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Audit Externe
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMagasin">
                            <a class="dropdown-item" href="{{ route('COMPLIANCEEXTERNE.listeAuditExterne') }}">Audit</a>
                            <a class="dropdown-item" href="{{ route('COMPLIANCEEXTERNE.listePlanActionExterne') }}">Plan Action</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMagasin"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            Budget
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMagasin">
                            <a class="dropdown-item" href="{{ route('COMPLIANCEBUDGET.listeBudgetCompliance') }}">Liste</a>
                        </div>
                    </li>

                </ul>
                <div class="form-inline my-2 my-lg-0" style="color: black;">
                    photo
                </div>
            </div>
        </nav>
    </div>
</div>
