<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-8">

        <nav class="navbar navbar-expand-lg navbar-light"
            style="margin-top: -50px;border-radius: 5px;background-color: white;width: 155%;margin-left: -15.5px;">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    {{--  <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            KPI
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>  --}}
                    <li class="nav-item dropdown mr-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                            BC
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @foreach ($typebc as $tb)
                                <a class="dropdown-item" href="{{ route('CRM.ajoutBc', ['idbc' => $tb->id]) }}"
                                    id="{{ $tb->type_bc }}link">{{ $tb->type_bc }}</a>
                            @endforeach
                            {{--  <a class="dropdown-item" href="{{ route('CRM.ajoutBcGeneral') }}" id="general">General</a>  --}}
                        </div>
                    </li>
                    {{--  <li class="nav-item dropdown mr-5">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black">
                                      TSCF
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                      <a class="dropdown-item" href="{{ route('CRM.tscfCoupeType') }}">TSCF Coupe Type</a>
                                      <a class="dropdown-item" href="{{ route('CRM.tableauDeBordTscf') }}">Tableau de bord</a>
                                    </div>
                                  </li>  --}}
                </ul>
                <div class="form-inline my-2 my-lg-0" style="color: black;">
                    photo
                </div>
            </div>
        </nav>
    </div>

</div>
<br>

<script>
    document.getElementById('Tissulink').addEventListener('click', function () {
        localStorage.removeItem('formConfirmed');
        localStorage.removeItem('removedRows');
    });
</script>
<script>
    document.getElementById('Accessoirelink').addEventListener('click', function () {
        localStorage.removeItem('formConfirmed');
        localStorage.removeItem('removedRows');
    });
</script>
<script>
    document.getElementById('CoupeTypelink').addEventListener('click', function () {
        localStorage.removeItem('formConfirmed');
        localStorage.removeItem('removedRows');
    });
</script>
<script>
    document.getElementById('Tissulink').addEventListener('click', function () {
        localStorage.removeItem('table');
    });
</script>
<script>
    document.getElementById('Accessoirelink').addEventListener('click', function () {
        localStorage.removeItem('table');
    });
</script>
