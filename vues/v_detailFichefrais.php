<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */



?>
    
<form action="index.php?uc=validerFrais&action=boutton" 
      method="post" role="form">
   <div class="row"> 
    <div class="col-md-4">
        <div class="form-group">
            <label for="lstVisiteur" accesskey="n">Choisir un Visiteur : </label>
            <select id="lstVisiteur" name="lstVisiteur" class="form-control">
                <?php
                foreach ($lesVisiteurs as $unVisiteur) {
                    $id = $unVisiteur['id'];
                    $nom = $unVisiteur['nom'];
                    $prenom = $unVisiteur['prenom'];
                    if ($id == $VisiteurASelectionner) {
                        ?>
                        <option selected value="<?php echo $id ?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $id ?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                        <?php
                    }
                }
                ?>    

            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="lstMois" accesskey="n">Mois : </label>
            <select id="lstMois" name="lstMois" class="form-control">
                <?php
                foreach ($listeMois as $unMois) {
                    $mois=$unMois['mois'];
                    $numAnnee = $unMois['numAnnee'];
                    $numMois = $unMois['numMois'];
                    if ($mois == $moisASelectionner) {
                        ?>
                        <option selected value="<?php echo $mois ?>">
                            <?php echo   $numMois.'/'.$numAnnee ?> </option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $mois ?>">
                            <?php echo  $numMois.'/'.$numAnnee ?> </option>
                        <?php
                    }
                }
                ?>    

            </select>
        </div>   
    </div>
         

</div>

<div class="row">   
<div  style="color:orangered">
<h2>Valider la fiche de frais </h2> 
</div> 
      
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
         
            <fieldset>       
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite']; ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                 <input id="corrigerff" name="corrigerff" type="submit" value="Corriger" class="btn btn-success" />
                 <input id=" reinitialiser" name="reinitialiser" type="reset" value="Réinitialiser"class="btn btn-danger"/>
                
            </fieldset>
         
    </div>
</div>
<br><br>
 
    
<div class="row">
    <div style="border-color:orangered"  class="panel panel-info">
        <div style="background-color:orangered;
                    color:white"   class="panel-heading">Descriptif des éléments hors forfait </div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                    <td> <input type="text" value="<?php echo $date ?>"
                                name="date"
                                size="10" maxlength="10"> 
                     <input type="hidden"value="<?php echo $id ?>"
                                name="id"
                                size="10" maxlength="10"></td>
                                
                    <td> <input type="text" value="<?php echo $libelle ?>"
                                name="libelle"
                                size="20" maxlength="20"></td>
                    <td><input  type="text" value="<?php echo $montant ?>"
                                name="montant"
                                size="8" maxlength="8"></td>
                    <td>
                     <input id="validerfhf" name="validerfhf" type="submit" value="Corriger" class="btn btn-success" >
                      <input id="reporterfhf" name="reporterfhf" type="submit" value="Reporter" class="btn btn-danger">
                    </td>
                           
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
</div>
 
<div>
    <label>Nombre de justificatifs 
        <input type="text" id="nbrjustificatifs" 
               name="nbrdejustificatifs"
               size="3" maxlength="2" 
               value="<?php echo $nbrdejustificatifs ?>" 
               >
    </label>
</div>

<br/>
<br/>


<div>
      <input id="validefinalff" name="validefinalff" type="submit" value="Valider"class="btn btn-success" />
</div>

</form>
 

