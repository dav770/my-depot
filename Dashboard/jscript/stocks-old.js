// Encapsulation dans un objet global
const AppStocks = {
    intervalStock: null,

    CtrlStocks: function () {
        $.post('appajax.php', {
            action: 'ctrl-stock-ajax', 
            
        }, function(resp) {
            
            if (resp.responseAjax == 'SUCCESS') {
            console.log('Execution de CtrlStocks', resp.data);
            // $('#produitTable').html(resp.html)
            if(resp.isalerte != '0'){
                $('#listocks').css('display','block')
            }else{
                $('#listocks').css('display','none')
            }
        }
        else
            $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
                type: 'danger',
                delay: 5000,
                offset: {
                from: "top",
                amount: 100
                    },
                    align: "center",
                allow_dismiss: true
            });
        
        HoldOn.close();

        }, 'json');
        
        return false;
        
    },
    // CtrlStocks: function () {
    //     console.log('Execution de CtrlStocks');
    //     $.post('appajax.php', {
    //         action: 'ctrl-stock', 
            
    //     }, function(resp) {

    //     if (resp.responseAjax == 'SUCCESS') {
    //         $('#produitTable').html(resp.html)
    //         if(resp.isalerte != '0'){
    //             $('#listocks').css('display','block')
    //         }else{
    //             $('#listocks').css('display','none')
    //         }
    //     }
    //     else
    //         $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
    //             type: 'danger',
    //             delay: 5000,
    //             offset: {
    //             from: "top",
    //             amount: 100
    //                 },
    //                 align: "center",
    //             allow_dismiss: true
    //         });
        
    //     HoldOn.close();

    //     }, 'json');
        
    //     return false;
        
    // },

    // lors du 1er lancement de l'application on verifie le stock qui est ensuite verifie toutes les heures depuis startInterval
    InitVerifStocks: function() {
        this.CtrlStocks();
    },

    startInterval: function () {
        this.intervalStock = setInterval(() => {
            this.CtrlStocks();
        }, 60 * 60 * 1000); // verification toutes les heures
    },

    stopInterval: function () {
        if (this.intervalStock !== null) {
            clearInterval(this.intervalStock);
            console.log('Intervalle arrêté');
        }
    },
};

$(document).ready(function () {
    AppStocks.InitVerifStocks();
    // AppStocks.startInterval();

    $('#produitTable').DataTable({
        "ajax": {
            "url": "appajax-datatable.php?action=ctrl-stock-ajax", // Remplacez par l'URL de votre serveur pour récupérer les données
            "type": "POST",                // Méthode HTTP utilisée pour l'appel (GET ou POST)
            "dataSrc": "data"                 // Ajustez si vos données sont dans une propriété spécifique de l'objet JSON
        },
        "columns": [
                    { "data": "id_produit" },
                    { "data": "name_produit" },
                    { "data": "desc_produit" },
                    { "data": "val_produit" },
                    { "data": "val_alerte_produit" },
                    {
                        "data": null, // Colonne pour le bouton personnalisé
                        "render": function(data, type, row) {
                            return `<button class="btn-open-page" data-id="${row.id_produit}">Ouvrir</button>`;
                        }
                    }
                ],
        "pageLength": 10, // Limiter à 10 lignes par page
        "lengthMenu": [5, 10], // Options de choix de lignes par page [5, 10, 25, 50, 100]
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "columnDefs": [
            { "orderable": false, "targets": 4 } // Désactiver le tri pour la colonne des actions
        ]
    });
});




// (function () {
//     // Déclaration de la variable au niveau global
//     let intervalStock;


//     function CtrlStocks() {
//         console.log(document.URL)
//         $.post('appajax.php', {
//             action: 'ctrl-stock', 
            
//         }, function(resp) {

//         if (resp.responseAjax == 'SUCCESS') {
//             $('#produitTable').html(resp.html)
//             if(resp.isalerte != '0'){
//                 $('#listocks').css('display','block')
//             }else{
//                 $('#listocks').css('display','none')
//             }
//         }
//         else
//             $.bootstrapGrowl('<h4>Erreur!</h4> <p>' + resp.message + '</p>', {
//                 type: 'danger',
//                 delay: 5000,
//                 offset: {
//                 from: "top",
//                 amount: 100
//                     },
//                     align: "center",
//                 allow_dismiss: true
//             });
        
//         HoldOn.close();

//     }, 'json');
    
//     return false;
//     }

//     $(document).ready(function () {
//         intervalStock = setInterval(() => {
//             CtrlStocks();
//         }, 5000);
//     });
// })();
