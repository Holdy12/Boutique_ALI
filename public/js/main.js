cat << 'EOF' > public/js/main.js
document.addEventListener("DOMContentLoaded", function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet élément ?");
            if (!confirmation) {
                e.preventDefault();
            }
        });
    });
});
EOF
