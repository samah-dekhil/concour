<?php

namespace App\Controller;

use App\Entity\Concours;
use App\Entity\Grade;
use App\Entity\Inscription;
use App\Entity\InscriptionDisabled;
use App\Form\InscriptionEditionType;
use App\Form\InscriptionType;
use App\Repository\GouvernoratRepository;
use App\Repository\GradeRepository;
use App\Repository\InscriptionDisabledRepository;
use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// #[Route('/concours/{idConcours}/grade')]
class InscriptionController extends AbstractController
{

   
    /*
     ***********DAF-dashboard INSCRIPTIONS***************************
     */

    #[Route('/admin/daf_concours/{tokenConcours}/dashboard', name: 'daf_dashboard')]
    public function dafDashboard(#[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours, InscriptionRepository $InscriptionRepository,
        GouvernoratRepository $GouvernoratRepository, GradeRepository $gradeRepository): Response {

        $list = $InscriptionRepository->findAll();
        $inscriptions = [];
        $grades = $gradeRepository->findAll();

        foreach ($grades as $grade) {
            $ids[$grade->getLibelle()] = $grade->getToken();
            $inscriptions[$grade->getLibelle()] = $InscriptionRepository->findBy(['grade' => $grade->getId()]);
        }

        $gouvs = $GouvernoratRepository->findAll();

        return $this->render('inscription/dashboard-daf.html.twig', [
            'list' => $list,
            'gouvs' => $gouvs,
            'inscriptions' => $inscriptions,
            'ids' => $ids,
            'concours'=>$concours

        ]);
    }

    /**
     * *******LISTE TOUTES LES INSCRIPTIONS ***************************
     *
     */
    #[Route('/admin/daf_concours/{tokenConcours}/inscriptions', name: 'daf_inscription_actives_index')]
    public function listeInscriptionsDAF(#[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours, InscriptionRepository $InscriptionRepository,
        GouvernoratRepository $GouvernoratRepository, GradeRepository $gradeRepository): Response {
        //***********************************************check if inscription is avaiable****************************************************
        $Now = new \DateTime();
        $exportExcel = "0";
        // if ($concours->getDateFinInscription()->format('Y-m-d') < $Now->format('Y-m-d')) {
        //     $exportExcel = "1";
        // }

        $list = $InscriptionRepository->findAll();
        $inscriptions = [];
        $grades = $gradeRepository->findAll();
        foreach ($grades as $grade) {
            $ids[$grade->getLibelle()] = $grade->getToken();
            $inscriptions[$grade->getLibelle()] = $InscriptionRepository->findBy(['grade' => $grade->getId()]);
        }

        $gouvs = $GouvernoratRepository->findAll();
        return $this->render('inscription/index-daf.html.twig', [
            'list' => $list,
            'gouvs' => $gouvs,
            'inscriptions' => $inscriptions,
            'ids' => $ids,
            'exportExcel' => $exportExcel,
        ]);
    }

    /**
     * *******LISTE_INSCRIPTIONS PAR GRADE***************************
     *
     */

    #[Route('/admin/daf_concours/{tokenConcours}/grade/{token}/inscriptions', methods: ['GET', 'POST'], name: 'inscriptions_grade')]
    public function inscGrade(Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,
        #[MapEntity(mapping: ['token' => 'token'])] Grade $grade, GouvernoratRepository $GouvernoratRepository, InscriptionRepository $InscriptionRepository): Response {
        //***********************************************check if inscription is avaiable****************************************************
        $Now = new \DateTime();
        $exportExcel = "0";
        if ($concours->getDateFinInscription()->format('Y-m-d') < $Now->format('Y-m-d')) {
            $exportExcel = "1";
        }

        $list = $InscriptionRepository->findBy(['grade' => $grade->getId()]);

        $gouvs = $GouvernoratRepository->findAll();
        return $this->render('inscription/index-daf-par-grade.html.twig', [
            'list' => $list,
            'gouvs' => $gouvs,
            'grade' => $grade,
            'exportExcel' => $exportExcel,
        ]);
    }


    /**
     * ACCES ADMIN *******LISTE_INSCRIPTIONS_DÉSACTIVÉES************************* **
     *
     */

    #[Route('/admin/concours/{tokenConcours}/inscriptions_desactivees', name: 'inscription_desactives_index')]
    public function indexDisabledInsc(#[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours, InscriptionDisabledRepository $InscriptionDisabledRepository): Response
    {
        $list = $InscriptionDisabledRepository->findAll();
        return $this->render('inscription/inscription_desactivees.html.twig', [
            'list' => $list,
        ]);
    }
    /*
     * Create new entity Inscription
     */
    #[Route('/concours/{tokenConcours}/grade/{token}/inscription', methods: ['GET', 'POST'], name: 'inscription_new')]
    public function new (Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours,
        #[MapEntity(mapping: ['token' => 'token'])] Grade $grade, GouvernoratRepository $GouvernoratRepository): Response {

        //***********************************************check if inscription is avaiable****************************************************
        $Now = new \DateTime();

        if ($concours->getDateFinInscription()->format('Y-m-d') < $Now->format('Y-m-d')) {
            return $this->redirectToRoute('app_home');
        }

        if ($concours->getDateDebutInscription()->format('Y-m-d') > $Now->format('Y-m-d')) {
            return $this->redirectToRoute('app_home');
        }

        $error = 0;
        //$message="";
        $Inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $Inscription);
        $form->handleRequest($request);
        try {
            if ($form->isSubmitted() && $form->isValid()) {
                //***********************************************CHECK COMMANDES SQL****************************************************
                $notAllowedCommands = array(
                    'truncate', 'use', 'delete', 'drop', 'select', 'show', 'insert', 'update', 'cmd', 'mysql', 'execute', 'database', 'script', 'table', 'create', 'alter', 'sql',
                );
                $t = $request->request->all()['inscription'];

                $post = array_map('strtolower', $t);

                if (count(array_intersect($notAllowedCommands, $post)) > 0) {

                    $this->addFlash('error', 'عفوا لم نتمكن من تسجيلك بالمناظرة، الرجاء التثبت جيداً من كل المعطيات.');
                    return $this->redirectToRoute('inscription_new', ['tokenConcours' => $concours->getToken(), 'token' => $grade->getToken()]);
                }

                //***********************************************Filter variable POST****************************************************

                $check_error = 0;

                $numbersFields = [
                    "specialite",
                    "grade",
                    "confirmGuide",
                    "confirmDecision",
                    "confirmProgramme",
                    "confirmFiche",
                    "nbEnfants",
                    "codeGouv",
                    "cin",
                    "villeNaissance",
                    "codeGouvAdresse",
                    "codePostal",
                    "telephoneFixe",
                    "telephonePortable",
                    "anneeDiplome",
                    "anneeEquivalence",
                ];

                $stringFields = [
                    "prenom",
                    "nom",
                    "prenomPere",
                    "prenomMere",
                    "nomPrenomConjoint",
                    "emploiConjoint",
                    "sexe",
                    "adresse",
                    "regionAdresse",
                    "nomDiplome",
                    "specialiteDiplome",
                ];

                $tableFieldsErrors = [];
                foreach ($request->request->all()['inscription'] as $key => $param) {

                    if ($key == "mail" && !filter_var($param, FILTER_VALIDATE_EMAIL)) {
                        $check_error++;
                        $tableFieldsErrors[$key] = $param;
                    }
                    if (in_array($key, $numbersFields) && $param != "" && !is_numeric($param)) {
                        $check_error++;
                        $tableFieldsErrors[$key] = $param;
                    }
                    if (in_array($key, $stringFields) && $param != "" && $this->isHTML($param)) {
                        $check_error++;
                        $tableFieldsErrors[$key] = $param;
                    }

                }

                $tabErrors = [];
                $villeNaissance = $GouvernoratRepository->findOneBy(['id' => $request->request->all()['inscription']['villeNaissance']])->getId();
                $codeGouvAdresse = $GouvernoratRepository->findOneBy(['id' => $request->request->all()['inscription']['codeGouvAdresse']])->getId();
                $Inscription->setVilleNaissance($villeNaissance);
                $Inscription->setCodeGouvAdresse($codeGouvAdresse);

                $Inscription->setGrade($grade->getId());

                $tab_moyenne = [];
                $tab_moyenne[] = (float) str_replace(',', '.', $request->request->all()['inscription']['moyenne1']);
                $tab_moyenne[] = (float) str_replace(',', '.', $request->request->all()['inscription']['moyenne2']);
                $tab_moyenne[] = (float) str_replace(',', '.', $request->request->all()['inscription']['moyenne3']);
                $tab_moyenne[] = (float) str_replace(',', '.', $request->request->all()['inscription']['moyenne4']);
              /*  $tab_moyenne[] = (float) str_replace(',', '.', $request->request->all()['inscription']['moyenne5']);*/
              $scoreTanfil = (float) str_replace(',', '.', $request->request->all()['inscription']['scoreTanfil']);
                /**************************************************CHECK LIST listNiveauxValides**********************************************************/
                $listNiveauxValides = ["1er cycle", "licence", "iset", "formation"];
                $niveau = $request->request->all()['inscription']['niveau'];

                if (in_array($niveau, $listNiveauxValides)) {
                    $libelleDiplome = $this->getLibelleDiplome($niveau, $grade->getId());
                    $moyenneGenerale = $this->calculMoyGenerale($niveau, $tab_moyenne);
                    $Inscription->setNiveauAffiche($libelleDiplome);
                } else {
                    $error++;
                    $tabErrors['niveau'] = $request->request->all()['inscription']['niveau'];
                }

                /**************************************************CHECK LIST mentionsBacValides**********************************************************/
           /*     $mentionsBacValides = ["متوسط", "قريب من الحسن أو فوق المتوسّط", "حسن", "حسن جدا"];
                if ($request->request->all()['inscription']['diplomeTanfil'] == "formation") {
                    $scoreTanfil = '0,5';
                } else {
                    if (in_array($request->request->all()['inscription']['scoreTanfil'], $mentionsBacValides)) {
                        $scoreTanfil = $this->calculScoreTanfil($request->request->all()['inscription']['scoreTanfil']);
                    } else {
                        $error++;
                        $tabErrors['scoreTanfil'] = $request->request->all()['inscription']['scoreTanfil'];
                    }
                }
              */
                /**************************************************CALCUL MOYENNE GENERALE &SCORE TOTAL******************************************************************/
                $Inscription->setMoyenneGenerale($moyenneGenerale);
                $Inscription->setScoreTanfil($scoreTanfil);
                $st = (float) str_replace(',', '.', $scoreTanfil);
                $mg = (float) str_replace(',', '.', $moyenneGenerale);
                $totalScore = number_format(((($mg * 2 ) + $st)/3), 3);/*moy generale modifiée */
                $Inscription->setTotalScore(str_replace('.', ',', $totalScore));

                /**************************************************CHECK LIST etatCivil******************************************************************/

                $etatCivilValides = ['أعزب', 'متزوج', 'مطلق', 'أرمل'];
                if (in_array($request->request->all()['inscription']['etatCivil'], $etatCivilValides)) {
                    if ($request->request->all()['inscription']['etatCivil'] == "أعزب") {
                        $Inscription->setNomPrenomConjoint(null);
                        $Inscription->setEmploiConjoint(null);
                        $Inscription->setNbEnfants(null);
                    }
                } else {
                    $error++;
                    $tabErrors['etatCivil'] = $request->request->all()['inscription']['etatCivil'];
                }
                /**************************************************CHECK LIST ETABLISSEMENTS***************************************************************/
                $typeEtablissementsValides = ['خاصّة', 'أجنبيّة', 'وطنية'];
                if (in_array($request->request->all()['inscription']['typeEtablissement'], $typeEtablissementsValides)) {

                    if ($request->request->all()['inscription']['typeEtablissement'] == "وطنية") {
                        $Inscription->setAnneeEquivalence('');
                    }
                } else {
                    $error++;
                    $tabErrors['typeEtablissement'] = $request->request->all()['inscription']['typeEtablissement'];
                }

                if ($error == 0 && $check_error == 0) {
                    //dd($Inscription);
                    $entityManager->persist($Inscription);
                    $entityManager->flush();
                    $entityManager->clear();

                    $villeNaissanceLIB = $GouvernoratRepository->findOneBy(['id' => $Inscription->getVilleNaissance()])->getLibelleGouv();
                    $codeGouvAdresseLIB = $GouvernoratRepository->findOneBy(['id' => $Inscription->getCodeGouvAdresse()])->getLibelleGouv();

                    return $this->render('inscription/imprimer.html.twig', [
                        'inscription' => $Inscription,
                        'grade' => $grade,
                        'villeNaissance' => $villeNaissanceLIB,
                        'codeGouvAdresse' => $codeGouvAdresseLIB,
                    ]);
                } else {
                    $this->addFlash('error', 'عفوا لم نتمكن من تسجيلك بالمناظرة، الرجاء التثبت جيداً من كل المعطيات.');

                }

            }
        } catch (UniqueConstraintViolationException $e) {

            $this->addFlash('error', "لا يمكن التسجيل أكثر من مرة واحدة بهذه المناظرة");
            return $this->redirectToRoute('inscription_new', ['tokenConcours' => $concours->getToken(), 'token' => $grade->getToken()]);

        }

        return $this->render('inscription/new.html.twig', [
            'form' => $form->createView(),
            'grade' => $grade,
        ]);
    }

    /**
     *  Form to print  inscription
     */
    #[Route('/concours/{tokenConcours}/grade/{token}/edition-inscription', methods: ['GET', 'POST'], name: 'inscription_edition')]
    public function editionInscription(Request $request, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours, #[MapEntity(mapping: ['token' => 'token'])] Grade $grade, InscriptionRepository $InscriptionRepository, GouvernoratRepository $GouvernoratRepository): Response
    {
        $success = 0;
        $Inscription = new Inscription();

        $form = $this->createForm(InscriptionEditionType::class, $Inscription);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dateCin = new \DateTime($request->request->all()['inscription_edition']['dateCin']);
            $dateNaissance = new \DateTime($request->request->all()['inscription_edition']['dateNaissance']);
            $searchInscription = $InscriptionRepository->findOneBy(['cin' => $request->request->all()['inscription_edition']['cin_search'],
                'dateCin' => $dateCin,
                'dateNaissance' => $dateNaissance, 'grade' => $grade->getId()]);

            if ($searchInscription) {
                $villeNaissance = $GouvernoratRepository->findOneBy(['id' => $searchInscription->getVilleNaissance()])->getLibelleGouv();
                $codeGouvAdresse = $GouvernoratRepository->findOneBy(['id' => $searchInscription->getCodeGouvAdresse()])->getLibelleGouv();
                return $this->render('inscription/imprimer.html.twig', [
                    'inscription' => $searchInscription,
                    'grade' => $grade,
                    'villeNaissance' => $villeNaissance,
                    'codeGouvAdresse' => $codeGouvAdresse,
                ]);

            } else {
                $this->addFlash('error', 'لم تقم بالتّسجيل بهذه المناظرة ');
                return $this->redirectToRoute('inscription_edition', ['tokenConcours' => $concours->getToken(), 'token' => $grade->getToken()]);
            }

        }
        return $this->render('inscription/edition.html.twig', [
            'form' => $form->createView(),
            'grade' => $grade,
            'success' => $success,
        ]);

    }
    /**
     *  Disable inscription
     */
    #[Route('/concours/{tokenConcours}/dev-desactiver-inscription/{token}', methods: ['GET', 'POST'], name: 'inscription_disable')]
    public function disableInscription(Request $request, EntityManagerInterface $entityManager, #[MapEntity(mapping: ['tokenConcours' => 'token'])] Concours $concours, #[MapEntity(mapping: ['token' => 'token'])] Inscription $inscription, InscriptionRepository $InscriptionRepository): Response
    {

        $inscriptionDisabled = new InscriptionDisabled();
        $cin = $inscription->getCin();
        $inscriptionDisabled->setToken($inscription->getToken());
        $inscriptionDisabled->setidDossier($inscription->getId());
        $inscriptionDisabled->setDateInscription($inscription->getDateInscription());

        $inscriptionDisabled->setCin($inscription->getCin());
        $inscriptionDisabled->setdateCin($inscription->getdateCin());

        $inscriptionDisabled->setNom($inscription->getNom());
        $inscriptionDisabled->setPrenom($inscription->getPrenom());
        $inscriptionDisabled->setNomJeunefille($inscription->getNomJeunefille());

        $inscriptionDisabled->setPrenomPere($inscription->getPrenomPere());
        $inscriptionDisabled->setPrenomMere($inscription->getPrenomMere());

        $inscriptionDisabled->setDateNaissance($inscription->getDateNaissance());
        $inscriptionDisabled->setVilleNaissance($inscription->getVilleNaissance());

        $inscriptionDisabled->setNomPrenomConjoint($inscription->getNomPrenomConjoint());
        $inscriptionDisabled->setEmploiConjoint($inscription->getEmploiConjoint());

        $inscriptionDisabled->setSexe($inscription->getSexe());
        $inscriptionDisabled->setEtatCivil($inscription->getEtatCivil());
        $inscriptionDisabled->setNbEnfants($inscription->getNbEnfants());

        $inscriptionDisabled->setCodeGouv(11);

        $inscriptionDisabled->setAdresse($inscription->getAdresse());
        $inscriptionDisabled->setRegionAdresse($inscription->getRegionAdresse());
        $inscriptionDisabled->setCodeGouvAdresse($inscription->getCodeGouvAdresse());
        $inscriptionDisabled->setCodePostal($inscription->getCodePostal());
        $inscriptionDisabled->setTelephoneFixe($inscription->getTelephoneFixe());
        $inscriptionDisabled->setTelephonePortable($inscription->getTelephonePortable());
        $inscriptionDisabled->setMail($inscription->getMail());

        $inscriptionDisabled->setNiveauAffiche($inscription->getNiveauAffiche());
        $inscriptionDisabled->setNiveau($inscription->getNiveau());
        $inscriptionDisabled->setNomDiplome($inscription->getNomDiplome());
        $inscriptionDisabled->setSpecialiteDiplome($inscription->getSpecialiteDiplome());
        $inscriptionDisabled->setTypeEtablissement($inscription->getTypeEtablissement());
        $inscriptionDisabled->setAnneDiplome($inscription->getAnneDiplome());
        $inscriptionDisabled->setAnneeEquivalence($inscription->getAnneeEquivalence());
        $inscriptionDisabled->setNomEtablissement($inscription->getNomEtablissement());

        $inscriptionDisabled->setMoyenne1($inscription->getMoyenne1());
        $inscriptionDisabled->setMoyenne2($inscription->getMoyenne2());
        $inscriptionDisabled->setMoyenne3($inscription->getMoyenne3());
        $inscriptionDisabled->setMoyenne4($inscription->getMoyenne4());
        $inscriptionDisabled->setMoyenne4($inscription->getMoyenne4());
        $inscriptionDisabled->setMoyenneGenerale($inscription->getMoyenneGenerale());
        $inscriptionDisabled->setDiplomeTanfil($inscription->getDiplomeTanfil());
        $inscriptionDisabled->setScoreTanfil($inscription->getScoreTanfil());
        $inscriptionDisabled->setTotalScore($inscription->getTotalScore());

        $inscriptionDisabled->setConfirmDecision($inscription->isConfirmFiche());
        $inscriptionDisabled->setConfirmFiche($inscription->isConfirmFiche());
        $inscriptionDisabled->setConfirmGuide($inscription->isConfirmGuide());
        $inscriptionDisabled->setConfirmProgramme($inscription->isConfirmProgramme());

        $inscriptionDisabled->setSpecialite($inscription->getSpecialite());
        $inscriptionDisabled->setGrade($inscription->getGrade());

        $inscriptionDisabled->setUser($this->getUser());
        $inscriptionDisabled->setMotifDesactivation('Probléme CIN bloquée .');

        $entityManager->persist($inscriptionDisabled);
        $entityManager->remove($inscription);

        $entityManager->flush();
        $entityManager->clear();

        $this->addFlash('success', "L'inscription dont le numéro CIN " . $cin . " est désactivée .");
        return $this->redirectToRoute('inscription_desactives_index', ['tokenConcours' => $concours->getToken()]);

    }

    /**
     * Ajax get specialities of grade
     */
    #[Route('/ajax-get-speci-grade', methods: ['POST'], name: 'inscription_grade_specialite')]
    public function getSpecialitesGrade(Request $request, GradeRepository $gradeRep): Response
    {
        $respone = [];
        $grade = $gradeRep->findOneBy(['id' => $request->request->get('grade')]);
        $specialites = $grade->getSpecialites();
        foreach ($specialites as $note) {
            $respone[] = array('id' => $note->getId(), 'libelle' => $note->getLibelle());
        }
        return new JsonResponse($respone);

    }

    /**
     * Ajax Calcul moyenne generale
     */
    #[Route('/ajax-calcul-moy-inscription', methods: ['GET', 'POST'], name: 'inscription_moyenne_generale')]
    public function ajaxMoyGenerale(Request $request): Response
    {

        $tab_moyenne[] = (float) str_replace(',', '.', $request->request->get('moyenne1'));
        $tab_moyenne[] = (float) str_replace(',', '.', $request->request->get('moyenne2'));
        $tab_moyenne[] = (float) str_replace(',', '.', $request->request->get('moyenne3'));
        $tab_moyenne[] = (float) str_replace(',', '.', $request->request->get('moyenne4'));
        $tab_moyenne[] = (float) str_replace(',', '.', $request->request->get('moyenne5'));
        $niveau = $request->request->get('niveau');
        $res = $this->calculMoyGenerale($niveau, $tab_moyenne);
        return new JsonResponse($res);

    }

    public function calculMoyGenerale($niveau, $tab_mayenne)
    {
        $somme = 0;
        $moyenne_generale = 0;
        if ($niveau == "iset") {
            $nb = 4;
        } elseif ($niveau == "licence") {
            $nb = 3;
        } elseif ($niveau == "1er cycle") {
            $nb = 2;
        } elseif ($niveau == "formation") {
            $nb = 4;
        }

        for ($i = 0; $i < $nb; $i++) {
            $somme += $tab_mayenne[$i];
        }
        $moyenne_generale = number_format(($somme) / $nb, 3);

        return str_replace('.', ',', $moyenne_generale);
    }

  /*  public function calculScoreTanfil($info)
    {
        $score = 0;
        if ($info == "متوسط") {
            $score = '0,5';
        } elseif ($info == "قريب من الحسن أو فوق المتوسّط") {
            $score = 2;
        } elseif ($info == "حسن") {
            $score = 3;
        } elseif ($info == "حسن جدا") {
            $score = 4;
        }

        return $score;
    }  */

    public function getLibelleDiplome($niveau, $idGrade)
    {
        //$idGrade==1===>ملحقين بالتفقد للمصالح الماليّـة
        // $idGrade==2===>عدول خزينة

        $libelleDiplome = "";
        if ($idGrade == 1) {
            if ($niveau == "iset") {
                $libelleDiplome = "شهادة الأستاذية على الأقل أو شهادة معادلة لها في إختصاص : ( علوم اقتصادية أو حقوق )";
            } elseif ($niveau == "licence") {
                $libelleDiplome = "شهادة الإجازة التطبيقية في نظام أمد على الأقل أو شهادة معادلة لها في إختصاص : (علوم اقتصادية أو حقوق)";
            } elseif ($niveau == "1er cycle") {
                $libelleDiplome = "الشهادة الجامعية للمرحلة الأولى من التعليم العالي على الأقل أو شهادة معادلة لها في إختصاص : (محاسبة أو جباية أو حقوق و علوم قانونية)";
            } elseif ($niveau == "formation") {
                $libelleDiplome = "شهادة تكوينية منظرة بالمستوى الرابع من سلم الوظائف  في إختصاص : (محاسبة أو جباية)";
            }

        }
        if ($idGrade == 6) {

            if ($niveau == "iset") {
                $libelleDiplome = "شهادة الأستاذية على الأقل أو شهادة معادلة لها في إختصاص : ( علوم اقتصادية أو حقوق )";
            } elseif ($niveau == "licence") {
                $libelleDiplome = "شهادة الإجازة التطبيقية في نظام أمد على الأقل أو شهادة معادلة لها في إختصاص : (علوم اقتصادية أو حقوق)";
            }

        }
        return $libelleDiplome;
    }

    /**
     * Func check if string contains tag html
     */
    public function isHTML($string)
    {
        return $string != strip_tags($string) ? true : false;
    }
}
