<script>
    // Restez avec le script JavaScript pour synchroniser le champ visible et l'ID caché
    document.getElementById('clientInput').addEventListener('input', function () {
        const input = this.value;
        const dataList = document.getElementById('tiersList');
        const hiddenInput = document.getElementById('clientIdInput');
        let found = false;

        Array.from(dataList.options).forEach(option => {
            if (option.value === input) {
                hiddenInput.value = option.getAttribute('data-id');
                found = true;
            }
        });
        if (!found) {
            hiddenInput.value = '';
        }
    });
</script>