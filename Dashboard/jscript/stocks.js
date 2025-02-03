// Encapsulation dans un objet global
const AppStocks = {
    intervalStock: null,

    // Fonction de vérification initiale du stock
    CtrlStocks: function () {
        $.post('appajax.php', {
            action: 'ctrl-stock-ajax',
        }, function (resp) {
            if (resp.responseAjax === 'SUCCESS') {
                console.log('Vérification initiale du stock réussie', resp);

                // Afficher ou masquer le bouton en fonction de `isalerte`
                if (resp.isalerte > 0) {
                    $('#listocks').css('display', 'block'); // Affiche le bouton
                } else {
                    $('#listocks').css('display', 'none'); // Masque le bouton
                }
            } else {
                console.error('Erreur lors de la vérification du stock:', resp.message);
                $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
                    type: 'danger',
                    delay: 5000,
                    offset: { from: "top", amount: 100 },
                    align: "center",
                    allow_dismiss: true
                });
            }
        }, 'json');
    },

    // InitVerifStocks: function() {
    //     this.CtrlStocks();
    // },

    // Fonction pour recharger la DataTable
    reloadDataTable: function () {
        $('#produitTable').DataTable().ajax.reload();
    },

    // Fonction pour démarrer le contrôle périodique
    startInterval: function () {
        this.intervalStock = setInterval(() => {
            this.CtrlStocks(); // Vérification des alertes
            this.reloadDataTable(); // Recharge les données de la DataTable
        }, 60 * 60 * 1000); // Vérification toutes les heures
    },

    // Fonction pour arrêter le contrôle périodique
    stopInterval: function () {
        if (this.intervalStock !== null) {
            clearInterval(this.intervalStock);
            console.log('Intervalle arrêté');
        }
    }
};



$(document).ready(function () {
    // AppStocks.InitVerifStocks();
    // Vérification initiale des stocks
    AppStocks.CtrlStocks();

    $('#produitTable').DataTable({
        "ajax": {
            "url": "appajax-datatable.php?action=ctrl-stock-ajax", // URL correcte vers le backend
            "type": "POST", // Méthode HTTP pour récupérer les données
            "dataSrc": "data" // Clé contenant les données à afficher
        },
        "columns": [
            // { "data": "id_produit" },
            { "data": "name_produit" },
            { "data": "desc_produit" },
            { "data": "val_produit" },
            { "data": "niv_alerte_produit" },
            // {
            //     "data": null, // Colonne pour le bouton personnalisé
            //     "render": function (data, type, row) {
            //         return `<button class="btn-open-page" data-id="${row.id_produit}">Ouvrir</button>`;
            //     }
            // }
        ],
        "pageLength": 10, // Limiter à 10 lignes par page
        "lengthMenu": [5, 10, 25, 50, 100], // Options pour le nombre de lignes par page
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        // "columnDefs": [
        //     { "orderable": false, "targets": 5 } // Désactiver le tri pour la colonne Actions
        // ]
    });

    // Démarrage du contrôle périodique
    AppStocks.startInterval();
});
