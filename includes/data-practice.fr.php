<?php
declare(strict_types=1);

/**
 * French text of each practice area, keyed by slug (see data-practice.php).
 * Any field left out falls back to the English version.
 */
return [

    'corporate-law' => [
        'title' => 'Droit des sociétés et droit commercial',
        'group' => 'Droit des affaires',
        'short' => 'Constitution de sociétés, gouvernance, restructurations et conseil commercial au quotidien, dans le cadre des Actes uniformes OHADA.',
        'intro' => 'Le droit des sociétés est le socle de notre pratique. Nous constituons, structurons et conseillons des sociétés opérant au Cameroun et dans l’ensemble de la zone CEMAC, de la SARL unipersonnelle au groupe coté en passant par les filiales de groupes étrangers. Notre travail s’appuie sur l’Acte uniforme OHADA relatif au droit des sociétés commerciales et du groupement d’intérêt économique, et sur la réalité concrète du fonctionnement des greffes, des banques et des régulateurs à Douala et à Yaoundé.',
        'services' => [
            'Constitution de SARL, SA, SAS et succursales, y compris l’immatriculation au RCCM',
            'Pactes d’associés, coentreprises et groupements d’intérêt économique (GIE)',
            'Fonctionnement du conseil et des assemblées, procès-verbaux et secrétariat juridique',
            'Fusions, acquisitions, cessions de parts et d’actions, et audits juridiques',
            'Restructurations, augmentations et réductions de capital, rachats d’actions',
            'Contrats commerciaux : fourniture, distribution, agence, franchise et licence',
            'Mission de direction juridique externalisée pour les entreprises sans juriste interne',
        ],
        'sections' => [
            ['h' => 'Une gouvernance qui résiste à l’examen', 'p' => 'Une bonne gouvernance repose sur quatre piliers : transparence, responsabilité, redevabilité et équité. Nous conseillons sur la composition du conseil, la séparation entre propriété et direction, les droits des actionnaires et les décisions réservées, les conventions réglementées et les obligations d’information financière, afin que votre cadre de gouvernance tienne lorsqu’un prêteur, un investisseur ou un juge l’examine.'],
            ['h' => 'Opérations en difficulté et restructurations', 'p' => 'Une société ne cesse pas d’être exposée aux risques une fois en activité. Rupture entre associés, inexécution contractuelle, litiges sociaux, fraude et concurrence déloyale surviennent sans prévenir. Nous structurons les opérations pour les tenir éloignées du prétoire et, lorsque le procès est inévitable, nous veillons à ce que le dossier ait été constitué pour gagner.'],
            ['h' => 'Franchise et licence', 'p' => 'La franchise est une forme de licence : le franchiseur doit donc pouvoir concéder un droit d’exploitation incontestable sur ses marques. Nous négocions redevances, exclusivité, territoire et durée, et notre équipe de propriété intellectuelle vérifie que chaque marque, savoir-faire et licence de logiciel de l’opération est régulièrement enregistré et transmissible dans l’espace OAPI.'],
            ['h' => 'Start-up et jeunes entreprises', 'p' => 'Les fondateurs ont besoin de plus que des statuts. Nous aidons les jeunes entreprises à choisir une structure qu’il ne faudra pas défaire au premier tour de financement, à organiser l’acquisition progressive des droits des fondateurs et la cession de la propriété intellectuelle, à préparer leur data room et à négocier avec les investisseurs. Nous les accompagnons comme partenaire stratégique, de l’idée à la croissance.'],
            ['h' => 'Commerce électronique et numérique', 'p' => 'Vendre en ligne expose une entreprise, en même temps, aux règles de protection des consommateurs, à la réglementation des paiements, aux obligations de sécurité des données et aux questions fiscales transfrontalières. Nous rédigeons conditions générales de vente, politiques de confidentialité et contrats de plateforme, et conseillons sur la conformité à la législation camerounaise sur le commerce électronique et les données personnelles.'],
        ],
    ],

    'arbitration-and-adr' => [
        'title' => 'Arbitrage et modes alternatifs de règlement des différends',
        'group' => 'Contentieux et conseil',
        'short' => 'Arbitrage CCJA et ad hoc, médiation et transactions qui règlent les litiges sans des années de procédure.',
        'intro' => 'Pour des opérateurs économiques, l’arbitrage est souvent plus rapide, plus confidentiel et plus facile à exécuter à l’étranger qu’un procès devant les juridictions nationales. Nous conseillons sur les clauses compromissoires avant que le litige ne naisse, et nous intervenons comme conseil dans des arbitrages siégeant dans l’espace OHADA et au-delà, notamment selon le Règlement de la Cour Commune de Justice et d’Arbitrage (CCJA) d’Abidjan.',
        'services' => [
            'Rédaction et vérification des clauses d’arbitrage et de règlement des différends',
            'Conseil dans les arbitrages CCJA, CCI, GICAM et ad hoc',
            'Mesures urgentes et provisoires devant le juge étatique en appui de l’arbitrage',
            'Reconnaissance et exequatur des sentences arbitrales étrangères au Cameroun',
            'Médiation commerciale et négociation structurée de transactions',
            'Expertise contractuelle et comités de règlement des différends pour les marchés de construction et de fourniture',
        ],
        'sections' => [
            ['h' => 'La clause compte plus que le litige', 'p' => 'La plupart des difficultés d’arbitrage sont des problèmes de rédaction. Une clause qui désigne une institution inexistante, prévoit une composition du tribunal impossible ou contredit la clause de droit applicable peut coûter une année de débats sur la compétence. Nous écrivons des clauses sans surprise, précises et exécutoires.'],
            ['h' => 'L’exécution dans l’espace OHADA', 'p' => 'Une sentence ne vaut que ce que l’on peut recouvrer. Nous conseillons sur la procédure d’exequatur, l’identification et la saisie des actifs, et l’articulation entre l’Acte uniforme relatif au droit de l’arbitrage, la Convention de New York et la procédure civile camerounaise.'],
            ['h' => 'La transaction, une décision commerciale', 'p' => 'Nous évaluons chaque litige au regard du coût de la victoire. Lorsqu’une sortie négociée préserve une relation commerciale ou libère des liquidités plus vite qu’un jugement, nous le disons tôt et négocions fermement des termes qui seront effectivement exécutés.'],
        ],
    ],

    'litigation-and-settlements' => [
        'title' => 'Contentieux et transactions',
        'group' => 'Contentieux et conseil',
        'short' => 'Plaidoirie devant les juridictions camerounaises à tous les degrés, du tribunal de première instance à la Cour suprême.',
        'intro' => 'Nos avocats plaident régulièrement devant les tribunaux de première instance, les tribunaux de grande instance, les cours d’appel, la Cour suprême ainsi que les juridictions administratives et sociales. Nous traitons des affaires commerciales, civiles, administratives et pénales, et préparons chaque dossier comme s’il devait aller jusqu’au jugement, ce qui est souvent le chemin le plus court vers une bonne transaction.',
        'services' => [
            'Litiges commerciaux et contractuels, y compris recouvrement de créances et exécution',
            'Contentieux civil : biens, successions, famille et dommages corporels',
            'Contentieux administratif contre les personnes publiques et les régulateurs',
            'Défense pénale et assistance des victimes (constitution de partie civile)',
            'Mesures provisoires et conservatoires, référés et saisies',
            'Appels, pourvois en cassation et questions constitutionnelles',
            'Exécution des décisions, saisies-attributions et voies d’exécution',
        ],
        'sections' => [
            ['h' => 'Une stratégie avant la première assignation', 'p' => 'Nous ouvrons chaque dossier par une analyse écrite : le fond du droit, les preuves dont vous disposez réellement, le calendrier réaliste, les perspectives de recouvrement et le coût. Vous décidez de plaider, de transiger ou de renoncer sur la base de chiffres, non d’optimisme.'],
            ['h' => 'Une plaidoirie bilingue', 'p' => 'Le Cameroun connaît un système bijuridique : procédure de common law dans les régions du Nord-Ouest et du Sud-Ouest, procédure de droit civil ailleurs. Notre équipe plaide en anglais comme en français et maîtrise les deux traditions, ce qui compte lorsqu’un litige s’étend sur plusieurs régions.'],
            ['h' => 'L’exécution fait partie du procès', 'p' => 'Un jugement qui ne peut être exécuté n’est qu’un reçu d’honoraires. Nous préparons l’exécution dès le départ, au moyen des saisies conservatoires, des saisies-attributions et de l’Acte uniforme OHADA portant organisation des procédures simplifiées de recouvrement et des voies d’exécution.'],
        ],
    ],

    'investments-and-securities' => [
        'title' => 'Investissements et valeurs mobilières',
        'group' => 'Finance et réglementation',
        'short' => 'Constitution de fonds, levées de capitaux, réglementation boursière et protection des investisseurs sur le marché CEMAC.',
        'intro' => 'Nous conseillons émetteurs, investisseurs, gestionnaires de fonds et intermédiaires sur la levée et le déploiement de capitaux en Afrique centrale. Cela comprend les offres au public et les placements privés sur le marché financier régional supervisé par la COSUMAF, ainsi que les opérations de capital-investissement, de capital-risque et de financement du développement avec des sponsors étrangers.',
        'services' => [
            'Constitution, structuration, réglementation et fiscalité des fonds',
            'Offres au public, placements privés et émissions obligataires',
            'Conformité à la réglementation boursière et obligations d’information',
            'Accords d’investissement, lettres d’intention et protections des actionnaires',
            'Audits pour investisseurs institutionnels et bailleurs de fonds de développement',
            'Règlement des litiges d’investisseurs et recours des actionnaires minoritaires',
        ],
        'sections' => [
            ['h' => 'Structurer en pensant à la sortie', 'p' => 'C’est avant l’arrivée des fonds qu’il faut prévoir comment l’investisseur sortira. Nous bâtissons des clauses de sortie forcée, de sortie conjointe, de préemption et d’option de vente exécutoires selon le droit OHADA des sociétés, plutôt que copiées d’un modèle étranger qui ne résistera pas devant un juge camerounais.'],
            ['h' => 'Documentation de levée de fonds', 'p' => 'Nous préparons les statuts et pactes de fonds, les bulletins de souscription, les contrats de gestion et de rémunération, et finalisons la constitution des fonds en coordination avec les conseils fiscaux et les auditeurs, pour que la structure fonctionne commercialement autant que juridiquement.'],
        ],
    ],

    'banking' => [
        'title' => 'Banque et financement',
        'group' => 'Finance et réglementation',
        'short' => 'Crédits, sûretés, réglementation bancaire et conformité COBAC, pour les prêteurs comme pour les emprunteurs.',
        'intro' => 'Nous intervenons pour des banques, des établissements de microfinance, des emprunteurs et des garants dans les opérations de financement et sur le cadre réglementaire administré par la COBAC et la BEAC. Notre travail couvre toute la vie d’un crédit, de la lettre d’offre à l’inscription des sûretés et jusqu’à leur réalisation.',
        'services' => [
            'Conventions de crédit et de facilités, syndiquées et bilatérales',
            'Sûretés : hypothèques, nantissements, gages, cautionnements et garanties OHADA',
            'Inscription et opposabilité des sûretés au RCCM',
            'Conseil réglementaire bancaire, agréments et conformité COBAC',
            'Dispositifs de lutte contre le blanchiment et de connaissance du client',
            'Restructuration de dettes, recouvrement et réalisation des sûretés',
            'Conseil réglementaire en microfinance et monnaie mobile',
        ],
        'sections' => [
            ['h' => 'Des sûretés réellement opposables', 'p' => 'L’Acte uniforme OHADA portant organisation des sûretés impose des formalités et des délais d’inscription stricts. Un nantissement inscrit trop tard est primé par les créanciers qui ont fait les formalités. Nous gérons l’opposabilité comme un projet daté, et non comme une formalité de fin de signature.'],
            ['h' => 'La réalité réglementaire', 'p' => 'Les ratios prudentiels, les règles de change et la réglementation des changes CEMAC déterminent la forme d’une opération bien avant que les avocats n’abordent les engagements. Nous signalons ces contraintes dès la première réunion.'],
        ],
    ],

    'financial-services' => [
        'title' => 'Services financiers et fintech',
        'group' => 'Finance et réglementation',
        'short' => 'Services de paiement, monnaie mobile, crédit numérique et agréments qui les rendent licites.',
        'intro' => 'Les services financiers au Cameroun sont transformés par la monnaie mobile, la banque par agents et le crédit numérique. Nous aidons opérateurs, banques et fournisseurs de technologie à situer leur activité dans le périmètre réglementaire, à obtenir les bonnes autorisations et à concevoir des produits que les régulateurs accepteront.',
        'services' => [
            'Stratégie d’agrément en tant que prestataire de services de paiement et émetteur de monnaie électronique',
            'Partenariats entre banques, opérateurs de télécommunications et fintech',
            'Crédit à la consommation, crédit numérique et conformité aux taux d’intérêt',
            'Protection des données et recueil du consentement pour les données financières',
            'Contrats de réseaux d’agents et répartition des responsabilités',
            'Relations avec la BEAC, la COBAC et le ministère des Finances',
        ],
        'sections' => [
            ['h' => 'L’agrément d’abord, le lancement ensuite', 'p' => 'L’erreur la plus coûteuse des fintech de la région consiste à lancer un produit qui exige en réalité une autorisation que la société ne détient pas. Nous situons votre produit dans le périmètre réglementaire avant que vous n’écriviez la première ligne de code.'],
            ['h' => 'Paiements transfrontaliers et change', 'p' => 'La réglementation des changes de la CEMAC encadre les rapatriements, les règlements et les transferts transfrontaliers. Les produits qui font circuler de la valeur au-delà de la zone CEMAC doivent être conçus autour de ces règles dès le départ.'],
        ],
    ],

    'insurance' => [
        'title' => 'Droit des assurances',
        'group' => 'Finance et réglementation',
        'short' => 'Conformité au Code CIMA, rédaction de polices, réglementation du courtage et sinistres contestés.',
        'intro' => 'Au Cameroun, l’assurance est régie par le Code CIMA, instrument régional applicable dans quatorze États africains. Nous conseillons assureurs, réassureurs, courtiers et assurés sur la conception des produits, la conformité réglementaire et les sinistres contestés.',
        'services' => [
            'Rédaction des polices, avenants et visa des produits au titre du Code CIMA',
            'Réglementation et agrément du courtage d’assurance et de réassurance',
            'Gestion des sinistres, avis de garantie et recours subrogatoires',
            'Contentieux des sinistres contestés et allégations de mauvaise foi',
            'Assurances maritime, aviation, construction et responsabilité civile professionnelle',
            'Bancassurance et accords de distribution',
        ],
        'sections' => [
            ['h' => 'Les litiges de garantie se jouent sur la rédaction', 'p' => 'La plupart des sinistres contestés se tranchent sur les exclusions, les conditions de garantie et les clauses de déclaration, plutôt que sur le risque principal. Nous lisons les polices dans cet esprit, qu’il s’agisse de les rédiger ou de défendre ou poursuivre une réclamation.'],
            ['h' => 'Paiement de la prime et règle « pas de prime, pas de garantie »', 'p' => 'Le Code CIMA subordonne la garantie au paiement de la prime d’une manière qui surprend les assurés étrangers. Nous veillons à ce que nos clients sachent exactement à quel moment leur couverture prend effet.'],
        ],
    ],

    'tax-and-customs' => [
        'title' => 'Fiscalité et douane',
        'group' => 'Finance et réglementation',
        'short' => 'Structuration fiscale des entreprises, TVA, prix de transfert, classement tarifaire et défense en contentieux fiscal.',
        'intro' => 'Le risque fiscal naît de décisions prises bien avant le dépôt d’une déclaration : la structure d’un groupe, la répartition des risques dans les contrats, le classement des marchandises au port. Nous conseillons des structures fiscalement efficaces qui résistent au contrôle, et accompagnons nos clients tout au long des contrôles et du contentieux.',
        'services' => [
            'Impôt sur les sociétés, TVA et retenues à la source',
            'Documentation des prix de transfert et conventions intragroupe',
            'Analyse des conventions fiscales et demandes d’élimination de la double imposition',
            'Contrôles fiscaux, redressements et recours administratifs',
            'Classement tarifaire, valeur en douane et régimes d’exonération',
            'Régimes d’incitation à l’investissement et conventions fiscales négociées',
        ],
        'sections' => [
            ['h' => 'La structure avant l’optimisation', 'p' => 'Une optimisation agressive posée sur une structure fragile échoue au premier contrôle. Nous partons de la substance économique et bâtissons une position documentée et défendable.'],
            ['h' => 'Faire face à un redressement', 'p' => 'La procédure fiscale camerounaise impose des délais courts et stricts pour répondre à une notification de redressement. En manquer un peut faire perdre des arguments entiers. Nous gérons le calendrier et la correspondance.'],
        ],
    ],

    'bankruptcy-and-insolvency' => [
        'title' => 'Entreprises en difficulté et procédures collectives',
        'group' => 'Contentieux et conseil',
        'short' => 'Règlement préventif, redressement judiciaire, liquidation des biens et recouvrement des créanciers selon le droit OHADA.',
        'intro' => 'L’Acte uniforme OHADA portant organisation des procédures collectives d’apurement du passif offre de véritables outils à l’entreprise en difficulté, à condition de les utiliser tôt. Nous conseillons dirigeants, créanciers et mandataires sur le règlement préventif, le redressement judiciaire et la liquidation des biens.',
        'services' => [
            'Requêtes en règlement préventif et conciliation avec les créanciers',
            'Plans de redressement judiciaire et stratégies de continuation',
            'Liquidation des biens et réalisation des sûretés',
            'Responsabilité des dirigeants et comblement du passif',
            'Déclaration, rang et représentation des créances',
            'Insolvabilité transfrontalière et recherche d’actifs',
        ],
        'sections' => [
            ['h' => 'Les options des dirigeants disparaissent sans bruit', 'p' => 'Quand la trésorerie a lâché, la plupart des voies préventives sont fermées et l’exposition personnelle des dirigeants a grandi. Nous préférons une conversation précoce et confidentielle à une conversation tardive et coûteuse.'],
            ['h' => 'Créanciers : déclarez correctement ou perdez votre créance', 'p' => 'Les procédures collectives imposent des délais de déclaration courts et des exigences de preuve strictes. Nous veillons à ce que les créances soient déclarées, les sûretés invoquées et le rang préservé.'],
        ],
    ],

    'labour-and-employment' => [
        'title' => 'Droit du travail',
        'group' => 'Personnes et innovation',
        'short' => 'Contrats, conventions collectives, licenciements, personnel expatrié et litiges devant l’inspection du travail.',
        'intro' => 'Le Code du travail camerounais protège les salariés et impose aux employeurs des procédures exigeantes. La plupart des employeurs perdent sur la forme plutôt que sur le fond. Nous construisons une documentation sociale et des procédures de licenciement qui tiennent, et représentons employeurs comme salariés dans les litiges du travail.',
        'services' => [
            'Contrats de travail à durée déterminée et indéterminée, clauses d’essai',
            'Règlement intérieur, notes de service et procédure disciplinaire',
            'Conventions collectives et relations avec les délégués du personnel',
            'Licenciements pour motif économique et restructurations',
            'Permis de travail, visas et immatriculation CNPS des expatriés',
            'Conciliation devant l’inspection du travail et contentieux devant le tribunal du travail',
            'Clauses de non-concurrence, de confidentialité et cession de la propriété intellectuelle des salariés',
        ],
        'sections' => [
            ['h' => 'Le licenciement est une procédure, pas une décision', 'p' => 'Un licenciement justifié mais conduit sans le préavis, l’entretien et les démarches auprès de l’inspection requis sera tout de même jugé abusif. Nous guidons l’employeur étape par étape, par écrit, pour que le dossier soit complet avant toute annonce.'],
            ['h' => 'Sécurité sociale et risques liés à la paie', 'p' => 'Les cotisations CNPS, la couverture des risques professionnels et les prélèvements sur salaires créent des passifs qui ressurgissent des années plus tard lors d’un contrôle. Nous auditons la qualification des salariés et des prestataires avant que l’inspecteur ne le fasse.'],
            ['h' => 'Les salariés ont des droits à faire valoir', 'p' => 'Nous intervenons aussi pour des salariés en matière de licenciement abusif, de droits impayés et de harcèlement au travail, en conciliation comme devant le tribunal du travail.'],
        ],
    ],

    'intellectual-property' => [
        'title' => 'Propriété intellectuelle',
        'group' => 'Personnes et innovation',
        'short' => 'Marques, brevets et dessins OAPI, droit d’auteur, secrets d’affaires et lutte contre la contrefaçon.',
        'intro' => 'Le Cameroun est membre de l’Organisation Africaine de la Propriété Intellectuelle (OAPI) : un seul dépôt peut ainsi protéger un droit dans dix-sept États membres. Nous assurons les dépôts, la gestion de portefeuille, les licences et la défense des droits, et agissons rapidement contre la contrefaçon et le parasitisme.',
        'services' => [
            'Dépôts OAPI de marques, brevets, modèles d’utilité et dessins et modèles industriels',
            'Gestion de portefeuille, renouvellements, oppositions et radiations',
            'Protection du droit d’auteur, gestion collective et contrats d’auteur',
            'Protection des secrets d’affaires et du savoir-faire',
            'Licences, cessions et contrats de transfert de technologie',
            'Lutte anti-contrefaçon : saisies, surveillance douanière et actions en contrefaçon',
            'Noms de domaine et protection des marques en ligne',
        ],
        'sections' => [
            ['h' => 'Un dépôt, dix-sept pays', 'p' => 'Le système OAPI est un réel avantage commercial pour les marques régionales, mais il ne pardonne rien en matière de classification et de dates de priorité. Nous rédigeons les libellés en pensant à ce que sera l’entreprise dans cinq ans, pas seulement à ce qu’elle est aujourd’hui.'],
            ['h' => 'Une défense qui change les comportements', 'p' => 'La contrefaçon recule devant les conséquences. Nous combinons surveillance douanière, requêtes en saisie et actions civiles en contrefaçon, et conseillons sur l’opportunité d’une plainte pénale pour renforcer le rapport de force.'],
            ['h' => 'La propriété intellectuelle dans les opérations', 'p' => 'Dans les acquisitions et les financements, la propriété intellectuelle est souvent l’actif que l’on suppose au lieu de le vérifier. Nous contrôlons la chaîne des droits, les cessions consenties par les salariés et la cessibilité des licences avant que les fonds ne circulent.'],
        ],
    ],

    'immigration-and-naturalisation' => [
        'title' => 'Immigration et naturalisation',
        'group' => 'Personnes et innovation',
        'short' => 'Visas, titres de séjour, autorisations de travail, naturalisation et programmes de mobilité d’entreprise.',
        'intro' => 'Nous accompagnons particuliers et employeurs pour l’entrée, le séjour et l’autorisation de travail au Cameroun, ainsi que dans la procédure de naturalisation. Pour nos clients entreprises, nous gérons des programmes de mobilité couvrant les documents d’expatriation, les titres et les membres de la famille.',
        'services' => [
            'Demandes de visas de court séjour, d’affaires et de long séjour',
            'Cartes de séjour et renouvellements',
            'Autorisations de travail et visa des contrats de travail',
            'Parcours d’immigration pour investisseurs et entrepreneurs',
            'Demandes de naturalisation et de nationalité',
            'Regroupement familial et titres des membres de la famille',
            'Politique de mobilité d’entreprise et audits de conformité',
        ],
        'sections' => [
            ['h' => 'Le dossier fait l’affaire', 'p' => 'Les dossiers d’immigration échouent bien plus souvent pour des pièces manquantes ou mal légalisées que pour des questions d’éligibilité. Nous remettons à nos clients une liste précise, vérifions chaque pièce avant le dépôt et suivons le dossier jusqu’au bout.'],
            ['h' => 'La conformité de l’employeur', 'p' => 'Employer un étranger sans autorisation régulière expose l’employeur, pas seulement le salarié. Nous auditons le personnel existant, régularisons lorsque c’est possible et mettons en place un processus d’accueil conforme.'],
        ],
    ],

    'information-technology-and-telecommunications' => [
        'title' => 'Technologies, données et télécommunications',
        'group' => 'Personnes et innovation',
        'short' => 'Contrats de logiciels et SaaS, protection des données personnelles, cybersécurité, licences et réglementation des télécoms.',
        'intro' => 'La technologie soulève des questions juridiques plus vite que la loi n’y répond. Nous conseillons les entreprises technologiques, et celles qui dépendent de la technologie, sur leurs contrats, les données personnelles, leurs obligations de cybersécurité et les licences de télécommunications, sous la supervision de l’ART et de l’ANTIC.',
        'services' => [
            'Contrats de développement logiciel, SaaS, hébergement et revente',
            'Politiques de protection des données, mentions d’information et contrats de sous-traitance',
            'Conformité en cybersécurité et plans de réponse aux incidents',
            'Licences de télécommunications et conventions d’interconnexion',
            'Signature électronique, preuve électronique et contrats numériques',
            'Transfert de technologie, entiercement de code et conformité open source',
            'Conditions d’utilisation de plateformes, charte d’usage et politiques de modération',
        ],
        'sections' => [
            ['h' => 'La protection des données est devenue une condition commerciale', 'p' => 'Grands comptes et partenaires étrangers refusent de plus en plus de contracter sans clauses adéquates de protection des données. Bien définir votre base légale, vos mentions d’information et vos mécanismes de transfert est un levier de vente, pas seulement un coût de conformité.'],
            ['h' => 'Contracter pour un logiciel qui n’existe pas encore', 'p' => 'Les contrats de développement échouent sur le périmètre, la recette et la propriété intellectuelle. Nous rédigeons des critères de recette et une gestion des changements qui résistent au moment où le projet prend du retard.'],
        ],
    ],

    'igaming-and-betting' => [
        'title' => 'Jeux en ligne et paris',
        'group' => 'Personnes et innovation',
        'short' => 'Agréments, conformité et structuration pour les opérateurs de jeux en ligne, de paris sportifs et de loteries en Afrique centrale.',
        'intro' => 'La législation sur les jeux numériques évolue rapidement en Afrique centrale, et les opérateurs doivent souvent se conformer à des règles écrites pour des établissements physiques. Le cabinet Fonju a développé une activité de conseil dédiée aux jeux en ligne pour aider opérateurs, fournisseurs de plateformes et partenaires de paiement à entrer légalement sur le marché et à y rester.',
        'services' => [
            'Demandes et renouvellements d’agréments de jeux et de paris',
            'Analyse des écarts réglementaires pour les opérateurs entrant sur le marché CEMAC',
            'Conditions joueurs, jeu responsable et vérification de l’âge',
            'Conformité des paiements, des règlements et de la lutte anti-blanchiment',
            'Contrats de plateforme, d’agrégation et de fourniture de contenus',
            'Conformité de la publicité, du parrainage et du marketing',
            'Relations avec le régulateur et défense en cas de sanctions',
        ],
        'sections' => [
            ['h' => 'Un marché qui récompense la conformité précoce', 'p' => 'Les opérateurs qui dialoguent avec le régulateur avant leur lancement obtiennent systématiquement de meilleures conditions que ceux qui se régularisent après une sanction. Nous suivons l’évolution législative en continu afin que nos conseils reflètent la situation de ce trimestre, et non de l’an dernier.'],
            ['h' => 'Les paiements, point de tension', 'p' => 'Un opérateur de jeux vit ou meurt de sa capacité à encaisser les dépôts et à payer les gains. Nous structurons les flux avec les banques, les opérateurs de monnaie mobile et les agrégateurs de sorte qu’ils soient défendables au regard de la réglementation des jeux comme de la réglementation financière.'],
        ],
    ],

    'real-estate-and-property' => [
        'title' => 'Immobilier et foncier',
        'group' => 'Industrie et infrastructures',
        'short' => 'Vérification des titres fonciers, acquisitions, baux, contrats de construction et litiges immobiliers.',
        'intro' => 'La terre est l’actif le plus souvent disputé au Cameroun, et le plus souvent mal vendu. Nous vérifions le titre avant que les fonds ne circulent, structurons acquisitions et programmes immobiliers, et plaidons lorsque le titre, les limites ou la possession sont contestés.',
        'services' => [
            'Vérification des titres fonciers et audits préalables',
            'Vente, achat et mutation de terrains et d’immeubles',
            'Baux commerciaux et d’habitation, et contentieux locatif',
            'Promotion immobilière, construction et contrats d’entreprise',
            'Immatriculation foncière, morcellement et conversion des droits coutumiers',
            'Expropriation pour cause d’utilité publique et indemnisation',
            'Litiges de bornage, de possession et d’indivision',
        ],
        'sections' => [
            ['h' => 'Vérifier le titre, puis vérifier le vendeur', 'p' => 'Un titre authentique détenu par une personne qui n’a pas le droit de vendre est le piège le plus courant des transactions immobilières au Cameroun. Nous consultons le livre foncier, la chaîne des mutations, la situation matrimoniale et successorale du vendeur et les éventuelles charges, avant tout versement d’acompte.'],
            ['h' => 'Promotion et construction', 'p' => 'Nous préparons les contrats de promotion, les marchés d’entreprise et de maîtrise d’œuvre, les régimes de paiement et de garantie des défauts, et conseillons sur les autorisations et la responsabilité des constructeurs.'],
        ],
    ],

    'maritime-and-shipping' => [
        'title' => 'Droit maritime et transport maritime',
        'group' => 'Industrie et infrastructures',
        'short' => 'Affrètements, litiges sur marchandises, saisie de navires, opérations portuaires et sinistres maritimes dans le golfe de Guinée.',
        'intro' => 'Douala est le principal port de l’hinterland CEMAC et dessert le Cameroun, le Tchad et la République centrafricaine. Nos avocats maritimistes offrent un service complet au secteur, avec une connaissance fine de son fonctionnement dans la région : le Code communautaire de la marine marchande, les usages portuaires et les réalités commerciales du fret, du transit, de la consignation, de la manutention, des parcs à conteneurs, du stockage et de l’entreposage.',
        'services' => [
            'Chartes-parties, connaissements et contrats de tonnage',
            'Réclamations sur marchandises : manquants, avaries et erreurs de livraison',
            'Saisie conservatoire et mainlevée de navires, garanties des créances maritimes',
            'Immatriculation, hypothèques, vente et achat de navires',
            'Abordage, assistance, avarie commune et sinistres maritimes',
            'Services portuaires, contrats de terminal et de manutention',
            'Contrats de transit, de consignation et de logistique',
            'Assurance maritime et correspondance P&I',
        ],
        'sections' => [
            ['h' => 'La saisie comme moyen de pression', 'p' => 'La menace crédible d’une saisie à Douala fait réfléchir vite. Nous vérifions la nature maritime de la créance, préparons la requête et agissons sur instructions urgentes, y compris en dehors des heures ouvrables.'],
            ['h' => 'Intérêts cargaison et transporteurs', 'p' => 'Nous intervenons des deux côtés des litiges sur marchandises. Cela nous donne une vision réaliste du niveau de transaction d’une réclamation, et des délais de prescription, des exigences de réserves et des limitations par colis qui en tranchent beaucoup avant même l’examen au fond.'],
        ],
    ],

    'aviation' => [
        'title' => 'Aviation',
        'group' => 'Industrie et infrastructures',
        'short' => 'Location et financement d’aéronefs, agréments d’exploitants, conformité réglementaire et réclamations de passagers.',
        'intro' => 'Nous conseillons compagnies aériennes, loueurs, prestataires d’assistance au sol et financeurs sur les questions aéronautiques au Cameroun : immatriculation et radiation des aéronefs, cadre de la Convention du Cap, certification des exploitants et régime réglementaire de l’aviation civile supervisé par l’Autorité aéronautique (CCAA).',
        'services' => [
            'Locations simples et financières d’aéronefs, et exécution des baux',
            'Immatriculation, radiation des aéronefs et mise en œuvre des IDERA',
            'Certificat de transporteur aérien et agréments réglementaires',
            'Contrats d’assistance au sol, de maintenance et d’interligne',
            'Responsabilité envers passagers et marchandises selon la Convention de Montréal',
            'Concessions aéroportuaires et contrats d’infrastructure',
        ],
        'sections' => [
            ['h' => 'Préparer la reprise de l’appareil', 'p' => 'Les loueurs se posent avant tout une question : l’aéronef pourra-t-il être récupéré en cas de défaillance du preneur ? Nous conseillons sur la procédure concrète de radiation et d’exportation, et sur la documentation qui la rend efficace sous pression.'],
        ],
    ],

    'transport-and-logistics' => [
        'title' => 'Transport et logistique',
        'group' => 'Industrie et infrastructures',
        'short' => 'Transport routier et ferroviaire, transit par les corridors, entreposage, dédouanement et responsabilité du transporteur.',
        'intro' => 'Les corridors Douala–N’Djamena et Douala–Bangui portent le commerce de trois pays. Nous conseillons transporteurs, chargeurs, transitaires et entrepositaires sur les contrats, les régimes de responsabilité et les formalités de transit qui encadrent la circulation des marchandises dans la région.',
        'services' => [
            'Contrats de transport de marchandises par route et régime OHADA du transport',
            'Transit, groupage et documents de transport multimodal',
            'Transit, corridors et opérations de dédouanement',
            'Entreposage, magasins sous douane et financement sur stocks',
            'Réclamations pour perte, avarie et retard',
            'Exploitation de flottes, emploi des chauffeurs et sécurité routière',
        ],
        'sections' => [
            ['h' => 'Qui supporte la perte, et à quel moment', 'p' => 'Dans un transport multimodal, la responsabilité passe d’un intervenant à l’autre à des moments rarement définis clairement dans les documents. Nous harmonisons les contrats tout au long de la chaîne pour qu’une perte ne devienne pas un débat sur le document applicable.'],
        ],
    ],

    'mining-and-energy' => [
        'title' => 'Mines et énergie',
        'group' => 'Industrie et infrastructures',
        'short' => 'Titres miniers d’exploration et d’exploitation, contrats pétroliers, projets électriques, renouvelables et conformité environnementale.',
        'intro' => 'Le Cameroun dispose d’importantes ressources minières, pétrolières et hydroélectriques, encadrées par le Code minier, le Code pétrolier, la loi régissant le secteur de l’électricité et un régime environnemental exigeant. Nous conseillons investisseurs, opérateurs et sous-traitants, de la demande de titre au développement et jusqu’à la fermeture.',
        'services' => [
            'Permis de recherche, permis d’exploitation et autorisations artisanales',
            'Conventions minières et négociations avec l’État',
            'Contrats de partage de production et de services pétroliers',
            'Contrats d’achat d’électricité et projets de producteurs indépendants',
            'Énergies renouvelables, projets solaires et mini-réseaux',
            'Conformité aux études d’impact environnemental et social',
            'Contenu local, relations avec les communautés et accords RSE',
            'Litiges des secteurs minier et énergétique',
        ],
        'sections' => [
            ['h' => 'Le titre n’est qu’un début', 'p' => 'Détenir un titre ne signifie pas pouvoir l’exploiter. Droits de surface, accords avec les communautés, permis environnementaux et engagements de contenu local doivent être obtenus en parallèle, et une lacune sur l’un d’eux peut arrêter un projet.'],
            ['h' => 'L’exposition environnementale et sociale', 'p' => 'Les prêteurs et les acheteurs examinent désormais la performance environnementale et sociale avec la même rigueur que le titre. Nous bâtissons une conformité qui satisfait à la fois le régulateur camerounais et les standards de la finance internationale.'],
        ],
    ],

    'health-care' => [
        'title' => 'Santé et sciences de la vie',
        'group' => 'Industrie et infrastructures',
        'short' => 'Réglementation des cliniques et du médicament, responsabilité médicale, homologation des produits et protection des données de santé.',
        'intro' => 'Nous conseillons hôpitaux, cliniques, distributeurs pharmaceutiques, fournisseurs de dispositifs médicaux et entreprises de santé numérique sur les autorisations réglementaires, la responsabilité professionnelle et le traitement des données de santé.',
        'services' => [
            'Autorisation des établissements de santé et réglementation des professions',
            'Enregistrement et distribution des médicaments et dispositifs médicaux',
            'Réclamations pour faute médicale, défense et procédures disciplinaires',
            'Conventions d’essais cliniques et conformité éthique de la recherche',
            'Protection des données de santé et secret médical',
            'Assurance maladie, mutuelles et tiers payant',
            'Marchés publics de santé et programmes financés par des bailleurs',
        ],
        'sections' => [
            ['h' => 'Consentement, dossier médical et responsabilité', 'p' => 'Dans la plupart des litiges médicaux, l’issue dépend de la qualité du recueil du consentement et du dossier médical. Nous aidons les établissements à mettre en place une pratique documentaire qui protège autant les soignants que les patients.'],
        ],
    ],

    'media-sports-and-creative-industry' => [
        'title' => 'Médias, sport et industries créatives',
        'group' => 'Personnes et innovation',
        'short' => 'Représentation d’artistes et de sportifs, droit à l’image, diffusion, parrainage et licences de contenus.',
        'intro' => 'Le Cameroun produit des talents sportifs et créatifs exceptionnels, dont trop sont engagés à des conditions qui cèdent leur valeur pour toujours. Nous intervenons pour des artistes, musiciens, sportifs, clubs, agents, producteurs et diffuseurs, et négocions des contrats qui laissent le talent propriétaire de ce qu’il a créé.',
        'services' => [
            'Contrats d’enregistrement, d’édition, de distribution et de management',
            'Contrats de joueurs, transferts, agents et droit à l’image',
            'Parrainage, contrats de promotion et d’ambassadeur de marque',
            'Diffusion, streaming et licences de contenus',
            'Production cinématographique et audiovisuelle, financement et libération des droits',
            'Diffamation, vie privée et réglementation de la presse',
            'Gouvernance sportive, litiges disciplinaires et d’éligibilité',
        ],
        'sections' => [
            ['h' => 'Restez propriétaire de votre catalogue', 'p' => 'La clause la plus précieuse d’un contrat créatif est celle qui dit à qui appartient l’œuvre et pour combien de temps. Nous négocions retour des droits, territoire et durée, plutôt que d’accepter comme allant de soi des cessions mondiales et perpétuelles.'],
            ['h' => 'Sportifs et mobilité', 'p' => 'Les transferts de sportifs camerounais font intervenir à la fois les règlements des clubs, les règles des fédérations nationales, l’immigration et la fiscalité. Nous coordonnons l’ensemble du dossier pour qu’un transfert n’échoue pas sur un détail technique.'],
        ],
    ],
];
