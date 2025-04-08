<script src="{{ asset('js/jquery.min.js') }}"></script>
<script>
    function fetchSections() {
        $.ajax({
            url: '/getSectionCompliance',
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
            selectElement.append(new Option(section.nom_section, section.id));
        });
    }

    function convertToISOFormat(dateString) {
        if (dateString) {
            const [day, month, year] = dateString.split('-');
            return `${year}-${month}-${day}`;
        }
        return dateString;
    }

    function loadConstatDetails(id_audit) {
        $.ajax({
            url: '/getAuditInterneDetail',
            method: 'GET',
            data: { id: id_audit },
            success: function(response) {
                $('#photo_initial').attr('src','');
                $('#photo_final').attr('src','');
                $('#input_photo_initial').prop('disabled', false);
                $('#id_audit').val(id_audit);
                $('#numero').text(response.id);
                $('#numero-input').val(response.id);
                $('#date_constat').val(convertToISOFormat(response.date_detection));
                $('#description').val(response.constat);
                $('input[name="action"]').val(response.action);
                $('input[name="deadline"]').val(convertToISOFormat(response.deadline));
                if (response.photo_initial && response.mime_type_initial) {
                    $('#photo_initial').attr('src', 'data:' + response.mime_type_initial + ';base64,' + response.photo_initial);
                    $('#input_photo_initial').prop('disabled', true);
                }

                if (response.photo_final && response.mime_type_final) {
                    $('#photo_final').attr('src', 'data:' + response.mime_type_final + ';base64,' + response.photo_final);
                }
                
                @if(Session::has('avancement_invalide'))
                    $('input[name="avancement"]').val({{ Session::get('avancement_invalide') }});
                @else
                    $('input[name="avancement"]').val(response.avancement);
                @endif


                if (response.id_section) {
                    console.log('Setting section ID:', response.id_section);
                    $('#id_section').val(response.id_section);
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
            var id_audit = $(this).data('id');
            loadConstatDetails(id_audit);
            localStorage.setItem('id_audit',id_audit);
        });
        @if(Session::has('check_violation'))
            const modal = new bootstrap.Modal(document.getElementById('cinConstat'));
            modal.show();
            loadConstatDetails(localStorage.getItem('id_audit'));
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

<script>
    var rapportAuditInterneUrl = "{{ route('AUDITINTERNE.Rapport') }}"
    document.getElementById('rapport-button').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = rapportAuditInterneUrl;
    });
</script>