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
                $('#resp').val(response.nom_emp + ' ' + response.prenom_emp);
                $('input[name="deadline"]').val(convertToISOFormat(response.deadline));
                $('input[name="date_real"]').val(response.date_real);
                if (response.photo_initial && response.mime_type_initial) {
                    $('#photo_initial').attr('src', 'data:' + response.mime_type_initial + ';base64,' + response.photo_initial);
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
                

                if (response.new_deadline) {
                    $('#new_deadline').val(response.new_deadline);
                } else {
                    $('#new_deadline').val(''); // Vider le contenu de l'input si la condition n'est pas remplie
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        event.preventDefault();

        document.getElementById('sectionInput').addEventListener('input', function () {
            const input = this.value;
            const dataList = document.getElementById('liste_sections');
            const hiddenInput = document.getElementById('id_section_input');
          
            
            let found = false;

            Array.from(dataList.options).forEach(option => {
                if (option.value === input) {
                    hiddenInput.value = option.getAttribute('data-id');
                    var nom = option.getAttribute('data-nom');
                    var prenom = option.getAttribute('data-prenom');
                    $('input[name="resp_id"]').prop('disabled',false);
                    $('input[name="resp_id"]').val(nom + ' ' + prenom);
                    $('input[name="resp_id"]').prop('disabled',true);
                    found = true;
                }
            });
            if (!found) {
                hiddenInput.value = '';
            }
        });
    });
</script>
@if(session('scrollTo'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const element = document.querySelector("{{ session('scrollTo') }}");
            if (element) {
                // Ajouter la classe de surbrillance
                element.classList.add('highlight');

                // Ajuster le défilement en fonction de la hauteur de l'en-tête
                const headerHeight = 60; // Remplacez par la hauteur réelle de votre en-tête
                window.scrollTo({
                    top: element.getBoundingClientRect().top + window.pageYOffset - headerHeight,
                    behavior: 'smooth'
                });

                // Retirer la classe après 6 secondes
                setTimeout(function() {
                    element.classList.remove('highlight');
                }, 2000);
            }
        });
    </script>
@endif

<script>
    document.getElementById('btn-ajout-mult').addEventListener('click', function() {
        window.location.href = "{{ route('AUDITINTERNE.ajoutMultiple') }}";
    });
    document.getElementById('rapportHebdo-button').addEventListener('click', function() {
        window.location.href = "{{ route('AUDITINTERNE.rapportHebdo') }}";
    });
</script>

