<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    function fetchSections() {
        $.ajax({
            url: '/getSections',
            method: 'GET',
            success: function(sections) {
                populateSectionSelect(sections);
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des sections:', error);
            }
        });
    } 

     // Fonction pour ajouter des options au select
    function populateSectionSelect(sections) {
        const selectElement = $('#id_section');
        selectElement.empty(); // Vider le select avant d'ajouter les nouvelles options
        sections.forEach(section => {
            selectElement.append(new Option(section.designation, section.id));
        });
    }

    function convertToISOFormat(dateString) {
        if (dateString) {
            const [day, month, year] = dateString.split('-');
            return `${year}-${month}-${day}`;
        }
        return dateString;
    }

    function loadConstatDetails(constatId) {
        $.ajax({
            url: '/getConstatDetail',
            method: 'GET',
            data: { id: constatId },
            success: function(response) {
                $('#id_constat').val(constatId);
                $('#numero').text(response.constat_numero);
                $('#numero-input').val(response.constat_numero);
                $('#date_constat').val(convertToISOFormat(response.dateconstat));
                $('#description').val(response.description);
                $('input[name="action"]').val(response.action);
                $('input[name="deadline"]').val(convertToISOFormat(response.constat_deadline));
                var fichier = response.fichier; // Remplacez ceci par la façon dont vous obtenez le nom du fichier
                var basePath = '{{ asset('uploads/constat/') }}';

                // Assurez-vous que basePath se termine par une barre oblique
                if (!basePath.endsWith('/')) {
                    basePath += '/';
                }
                var srcPath = basePath + fichier;

                // Mettre à jour l'attribut src de l'image
                $('#fichierConstat').attr('src', srcPath);
                
                @if(Session::has('avancement_invalide'))
                    $('input[name="avancement"]').val({{ Session::get('avancement_invalide') }});
                @else
                    $('input[name="avancement"]').val(response.constat_avancement);
                @endif


                if (response.section_id) {
                    console.log('Setting section ID:', response.section_id);
                    $('#id_section').val(response.section_id);
                }
                if (response.priorite) {
                    console.log('Setting priorite:', response.priorite);
                    $('#priorite option').each(function() {
                        if ($(this).text() === response.priorite) {
                            $(this).prop('selected', true);
                        }
                    });
                }
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des détails du constat:', error);
            }
        });
    }

</script>
<script>
    $(document).ready(function() {
        fetchSections();
        $('tr[data-target="#cinConstat"]').click(function() {
            var constatId = $(this).data('id');
            loadConstatDetails(constatId);
            localStorage.setItem('constat_id',constatId);
        });
        @if(Session::has('check_violation'))
            const modal = new bootstrap.Modal(document.getElementById('cinConstat'));
            modal.show();
            loadConstatDetails(localStorage.getItem('constat_id'));
            const errorContainer = document.getElementById('check_violation');
            errorContainer.innerText = "{{ Session::get('check_violation') }}";
        @endif
    });
</script>
<script src="{{ asset('js/flatpickr/cdnjs/flatpickr.min.js') }}"></script>

<script src="{{ asset('js/flatpickr/cdnjs/fr.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#daterange", {
            mode: "range",
            dateFormat: "d-m-Y",
            locale: "fr", 
        });
    });
</script>

