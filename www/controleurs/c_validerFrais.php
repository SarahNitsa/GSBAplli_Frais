<?php

/**
 * $mois = mois et annee actuel(jour j)
 * $leMois= mois et annee du visiteur selectionne
 */
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {

    case 'selectionnerVisiteurs':
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesCles[] = array_keys($lesVisiteurs);
        $VisiteurASelectionner = $lesCles[0];
        $mois = getMois(date('d/m/Y'));
        $listeMois = getLesDouzeDerniersMois($mois);
        $lesCles1[] = array_keys($listeMois);
        $moisASelectionner = $lesCles1[0];
        include 'vues/v_listeVisiteurs.php';
        break;
    case'detailFichefrais':


        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $mois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $condition = $pdo->estPremierFraisMois($idVisiteur, $mois);

        if (!$condition) {
            $lesVisiteurs = $pdo->getLesVisiteurs();
            $VisiteurASelectionner = $idVisiteur;
            $mois1 = getMois(date('d/m/Y'));
            $listeMois = getLesDouzeDerniersMois($mois1);
            $moisASelectionner = $mois;
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
            $nbrdejustificatifs = $pdo->getNbjustificatifs($idVisiteur, $mois);
            include 'vues/v_detailFichefrais.php';
        } else {
            ajouterErreur("Le mois n'éxite pas pour ce visiteur");
            include 'vues/v_erreurs.php';

            header("Refresh: 1;URL=index.php?uc=validerFrais&action=selectionnerVisiteurs");
        }
        break;

    case'boutton':
        $montant = filter_input(INPUT_POST, 'montant',FILTER_VALIDATE_FLOAT);
        $idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $date = filter_input(INPUT_POST, 'date',  FILTER_SANITIZE_STRING);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

// Traitement correspondant au cas où l'on clique sur le premier bouton de validation
        if (isset($_POST['corrigerff'])) {
            ajouterErreur("Vos modifications ont bien été prise en compte");
            include 'vues/v_erreurs.php';
            $pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais); //permet de modifier le visiteur le mois le tableau de frai forfait dans la base de donnee
       
        }

        // Traitement correspondant au cas où l'on clique sur le deuxième bouton de validation
        else if (isset($_POST['validerfhf'])) {
            var_dump($id, $idVisiteur, $date, $leMois, $libelle, $montant);
            ajouterErreur("Vos modifications ont bien été prise en compte");
            include 'vues/v_erreurs.php';
            $pdo->majFraisHorsForfait($id,$idVisiteur,$date,$leMois ,$libelle, $montant); //permet de modifier le visiteur le mois le tableau de frai forfait dans la base de donnee
            header("Refresh: 1;URL=index.php?uc=validerFrais&action=selectionnerVisiteurs");
            
        } else if (isset($_POST['reporterfhf'])) {
             $mois = getMois(date('d/m/Y'));
            $condition= $pdo-> estPremierFraisMois($idVisiteur, $mois);
            if ($condition){
                $pdo-> creeNouvellesLignesFrais($idVisiteur, $mois);
            }
            $libelle='refusé '.$libelle;
            var_dump($idVisiteur,$mois,$libelle,$date,$montant);
            //$pdo->supprimerFraisHorsForfait($id);
             $pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant);
             ajouterErreur("Vos modifications ont bien été prise en compte");
            include 'vues/v_erreurs.php';
             header("Refresh: 1;URL=index.php?uc=validerFrais&action=selectionnerVisiteurs");
            
            //include 'vues/v_detailFichefrais.php';
            
       
        } else if (isset($_POST['validefinalff'])) {
            $etat='VA';
            $pdo->majEtatFicheFrais($idVisiteur, $leMois, $etat);
            $sommeHF =$pdo->getMontantHF($idVisiteur,$leMois);
            $totalHF=$sommeHF[0][0];
            $sommeFF =$pdo->getMontantFF($idVisiteur,$leMois);
            $totalFF=$sommeFF[0][0];
            $montantTotal=$totalFF+$totalHF;
            $pdo->majTotal($idVisiteur, $leMois, $montantTotal);
            include 'vues/v_retourAccueil.php';
        
    
            
           
        }
        break;
}

