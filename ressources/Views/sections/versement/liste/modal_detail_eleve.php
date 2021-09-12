<div class="modal fade" id="details_eleve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #f5a663;">
                <h5 class="modal-title" id="exampleModalLongTitle">Détails d'un(e) élève</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <img class="col-md-6" id="photo" src="" alt="Photo de l'élève">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td style="background: white; border: none; width: 30%;"><strong>Matricule: </strong></td>
                                <td style="background: white; border: none; width: 70%;" id="matricule"><?php "" ?></td>
                            </tr>

                            <tr>
                                <td style="background: white; border: none;"><strong>Nom: </strong></td>
                                <td style="background: white; border: none;" id="nom"><?php "" ?></td>
                            </tr>

                            <tr>
                                <td style="background: white; border: none;"><strong>Prénom: </strong></td>
                                <td style="background: white; border: none;" id="prenom"><?php "" ?></td>
                            </tr>

                            <tr>
                                <td style="background: white; border: none;"><strong>Sexe: </strong></td>
                                <td style="background: white; border: none;" id="sexe"><?php "" ?></td>
                            </tr>

                            <tr>
                                <td style="background: white; border: none;"><strong>Date de naissance: </strong></td>
                                <td style="background: white; border: none;"><?php "" ?></td>
                            </tr>

                            <tr>
                                <td style="background: white; border: none;"><strong>Lieu de naissance: </strong></td>
                                <td style="background: white; border: none;" id="lieu_naissance"><?php "" ?></td>
                            </tr>

                            <tr>
                                <td style="background: white; border: none;"><strong>Classe: </strong></td>
                                <td style="background: white; border: none;" id="classe">
                                    <?php "" ?>

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="background: #f5a663;" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>