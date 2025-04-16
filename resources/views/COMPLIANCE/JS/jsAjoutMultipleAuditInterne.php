<script>
    document.getElementById('btn-ajout-mult').addEventListener('click', function() {
    // Créer un nouvel ensemble de champs de formulaire
    const formRow = document.createElement('div');
    formRow.className = 'form-row';
    formRow.innerHTML = `
        <div class="form-group col-md-4">
            <label>Constat</label>
            <input type="text" class="form-control" required name="constat[]">
        </div>
        <div class="form-group col-md-2">
            <label>Action</label>
            <input type="text" class="form-control" required name="action[]">
        </div>
        <div class="form-group col-md-2">
            <label>Priorité</label>
            <select class="form-control" name="priorite[]">
                <option value="1">Faible</option>
                <option value="2">Moyenne</option>
                <option value="3">Elevée</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label>Deadline</label>
            <input type="date" class="form-control" name="deadline[]">
        </div>
        <div class="form-group col-md-1">
            <label>Photo</label>
            <input type="file" class="form-control" name="photo_initial[]" accept="image/*">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-remove">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    `;

    // Ajouter le nouvel ensemble de champs au conteneur
    document.querySelector('.basic-form.formulaire').appendChild(formRow);

    // Ajouter un écouteur d'événement pour le bouton de suppression
    formRow.querySelector('.btn-remove').addEventListener('click', function() {
        formRow.remove();
    });
});

// Ajouter un écouteur d'événement pour les boutons de suppression existants
document.querySelectorAll('.btn-remove').forEach(function(button) {
    button.addEventListener('click', function() {
        this.closest('.form-row').remove();
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        event.preventDefault();

        document.getElementById('sectionInput').addEventListener('input', function () {
            const input = this.value;
            const dataList = document.getElementById('liste_sections');
            const hiddenInput = document.getElementById('id_section_input');
            const responsablePlace = document.getElementById('responsable');
            
            let found = false;

            Array.from(dataList.options).forEach(option => {
                if (option.value === input) {
                    hiddenInput.value = option.getAttribute('data-id');
                    var nom = option.getAttribute('data-nom');
                    var prenom = option.getAttribute('data-prenom');
                    if (!nom && !prenom) {
                        responsablePlace.textContent = "N/A";
                    } else {
                        responsablePlace.textContent = nom + ' ' + prenom;
                    }
                    found = true;
                }
            });
            if (!found) {
                hiddenInput.value = '';
            }
        });
    });
</script>