<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * INTERNATIONAL CLIENTS PAGE — content in both languages
 * ---------------------------------------------------------------------------
 * Rendered by includes/international-page.php for /international-clients and
 * /fr/international-clients. Written for people outside Cameroon: foreign
 * companies, investors, traders, individuals and the Cameroonian diaspora.
 * The wording follows what they actually search for (see the SEO plan).
 * ---------------------------------------------------------------------------
 */

function international_content(): array
{
    return is_fr() ? international_fr() : international_en();
}

function international_en(): array
{
    return [
        'title'       => 'Lawyer in Cameroon for Foreign Companies & Individuals | Fonju Law Firm',
        'description' => 'English- and French-speaking lawyers in Douala for foreign companies, investors, individuals and Cameroonians abroad. Remote from start to finish, fees agreed in writing.',
        'crumb'       => 'International clients',
        'eyebrow'     => 'International clients',
        'h1'          => 'Your lawyer in Cameroon,<br>wherever you are',
        'lede'        => 'For foreign companies, investors, traders, individuals and Cameroonians abroad. We advise in English or French, handle the matter on the ground in Cameroon, and report to you wherever you are, with the fee agreed in writing before we start.',

        'who_eyebrow' => 'Who we act for',
        'who_h2'      => 'Clients who need a lawyer <span class="accent">in Cameroon</span>, not necessarily in Cameroon themselves',
        'who' => [
            ['icon' => 'building', 'h' => 'Companies entering Cameroon or CEMAC', 'p' => 'Subsidiary or branch, company formation, sector licences, agreements with local distributors and agents, and hiring local and expatriate staff.'],
            ['icon' => 'scale',    'h' => 'Investors and lenders', 'p' => 'Due diligence on Cameroonian companies, partners and land; structuring the investment; repatriating profits; taking security over assets.'],
            ['icon' => 'globe',    'h' => 'Businesses trading with Cameroon', 'p' => 'Imports through the Port of Douala, customs disputes, recovering unpaid invoices from Cameroonian customers, arbitration and enforcement.'],
            ['icon' => 'users',    'h' => 'Individuals and families abroad', 'p' => 'Buying land or property, checking a title before paying anything, inheritance, powers of attorney, and cases before Cameroonian courts.'],
        ],

        'ask_eyebrow' => 'What foreign clients ask us most',
        'ask_h2'      => 'Start with your question',
        'ask' => [
            ['q' => 'Setting up a company or subsidiary in Cameroon', 'href' => 'practice-area.php?area=corporate-law', 'more' => 'post.php?p=registering-a-company-in-cameroon'],
            ['q' => 'Buying land or property as a foreigner or from abroad', 'href' => 'practice-area.php?area=real-estate-and-property', 'more' => 'post.php?p=buying-land-in-cameroon-checklist'],
            ['q' => 'Work permits and visas for staff', 'href' => 'practice-area.php?area=immigration-and-naturalisation'],
            ['q' => 'Customs clearance and disputes at the Port of Douala', 'href' => 'practice-area.php?area=tax-and-customs'],
            ['q' => 'Recovering money owed by a Cameroonian company', 'href' => 'practice-area.php?area=litigation-and-settlements'],
            ['q' => 'Arbitration, and enforcing a foreign judgment or award', 'href' => 'practice-area.php?area=arbitration-and-adr', 'more' => 'post.php?p=arbitration-or-court-cameroon'],
            ['q' => 'Protecting a trade mark in Cameroon and 16 other OAPI states', 'href' => 'practice-area.php?area=intellectual-property', 'more' => 'post.php?p=oapi-trade-mark-guide'],
            ['q' => 'Investing in Cameroon and taking profits out', 'href' => 'practice-area.php?area=investments-and-securities', 'more' => 'post.php?p=foreign-investment-in-cameroon'],
        ],
        'ask_more'    => 'Read our guide',

        'how_eyebrow' => 'Working with us from abroad',
        'how_h2'      => 'How a matter runs when you are not in Cameroon',
        'how' => [
            ['h' => 'Tell us what has happened', 'p' => 'By e-mail, WhatsApp or the enquiry form, in English or French. We reply within one business day.'],
            ['h' => 'A first call', 'p' => 'By video or phone, at a time that suits your time zone. We explain the options, the likely timetable and the cost.'],
            ['h' => 'Everything agreed in writing', 'p' => 'An engagement letter sets out the work, the fee and how to pay it before anything starts. No surprise invoices.'],
            ['h' => 'We act on the ground', 'p' => 'Registry searches, filings, meetings and hearings in Cameroon. We tell you exactly which documents we need, whether they must be certified or legalised in your country, and how to send them.'],
            ['h' => 'Written updates at every stage', 'p' => 'You always know where the matter stands. Where you have lawyers at home, we work alongside them.'],
        ],

        'fraud_h2'    => 'If you have been defrauded by someone in Cameroon',
        'fraud' => [
            'People abroad sometimes contact us after paying for land, goods, a business opportunity or a relationship that turned out not to exist. We can advise on filing a criminal complaint in Cameroon and give you an honest view of the chances of recovering money.',
            'Be very careful with anyone, including people who claim to be lawyers, police officers or officials, who guarantees that your money will be recovered in exchange for an upfront fee. That is a common second fraud. Before paying any lawyer, check that they are registered with the Cameroon Bar Association, and ask for a written engagement letter.',
        ],

        'faq_eyebrow' => 'Questions',
        'faq_h2'      => 'Common questions from clients abroad',
        'faq' => [
            ['q' => 'Can you act for me if I am not in Cameroon?', 'a' => 'Yes. Most of our international clients never need to travel. We meet by video or phone and exchange documents electronically. Where a signature or an original document is needed, we explain how to provide it from abroad, often through a power of attorney.'],
            ['q' => 'Do you work in English?', 'a' => 'Yes. We work in English and French, the two official languages of Cameroon, and can advise, draft and correspond in either. Cameroon’s legal system is itself bilingual and bijural, combining common law and civil law traditions.'],
            ['q' => 'How are your fees set and paid?', 'a' => 'Before any work starts, you receive a written engagement letter with the fee, what it covers and how to pay it. Defined work, such as forming a company or checking a land title, is usually a fixed fee; disputes are billed in agreed stages.'],
            ['q' => 'Can a foreigner own a company in Cameroon?', 'a' => 'In most sectors, yes. The OHADA company law that applies in Cameroon does not reserve shareholding to nationals. Some regulated activities have their own licensing or ownership conditions, which we check at the start.'],
            ['q' => 'Can a foreigner buy land in Cameroon?', 'a' => 'Foreigners can acquire rights over land in Cameroon, but the rules and approvals are not the same as for nationals, and the right approach depends on what you plan to do with the land. We check this, and the title itself, before any deposit is paid.'],
        ],

        'cta_h2'      => 'Tell us what you need in Cameroon',
        'cta_p'       => 'Describe the situation in a few lines. We reply within one business day with our view, the options and the likely cost.',
        'wa_text'     => 'Hello Fonju Law Firm, I am contacting you from abroad about a matter in Cameroon.',
    ];
}

function international_fr(): array
{
    return [
        'title'       => 'Avocat au Cameroun pour étrangers, entreprises et diaspora | Cabinet Fonju',
        'description' => 'Avocats à Douala, francophones et anglophones, pour entreprises étrangères, investisseurs, particuliers et Camerounais de l’étranger. Tout à distance, honoraires fixés par écrit.',
        'crumb'       => 'Clients internationaux',
        'eyebrow'     => 'Clients internationaux',
        'h1'          => 'Votre avocat au Cameroun,<br>où que vous soyez',
        'lede'        => 'Pour les entreprises étrangères, les investisseurs, les commerçants, les particuliers et les Camerounais de l’étranger. Nous conseillons en français ou en anglais, nous agissons sur place au Cameroun et vous rendons compte où que vous soyez, avec des honoraires fixés par écrit avant de commencer.',

        'who_eyebrow' => 'Pour qui nous agissons',
        'who_h2'      => 'Des clients qui ont besoin d’un avocat <span class="accent">au Cameroun</span>, sans forcément y être',
        'who' => [
            ['icon' => 'building', 'h' => 'Entreprises qui s’implantent au Cameroun ou en zone CEMAC', 'p' => 'Filiale ou succursale, création de société, agréments sectoriels, contrats avec distributeurs et agents locaux, recrutement de personnel local et expatrié.'],
            ['icon' => 'scale',    'h' => 'Investisseurs et prêteurs', 'p' => 'Audit juridique de sociétés, de partenaires et de terrains camerounais ; structuration de l’investissement ; rapatriement des bénéfices ; sûretés.'],
            ['icon' => 'globe',    'h' => 'Entreprises qui commercent avec le Cameroun', 'p' => 'Importations par le port de Douala, litiges douaniers, recouvrement de factures impayées auprès de clients camerounais, arbitrage et exécution.'],
            ['icon' => 'users',    'h' => 'Particuliers et familles à l’étranger', 'p' => 'Achat d’un terrain ou d’un bien, vérification du titre foncier avant tout paiement, succession, procurations, procédures devant les juridictions camerounaises.'],
        ],

        'ask_eyebrow' => 'Les questions les plus fréquentes',
        'ask_h2'      => 'Partez de votre question',
        'ask' => [
            ['q' => 'Créer une société ou une filiale au Cameroun', 'href' => 'practice-area.php?area=corporate-law', 'more' => 'post.php?p=creer-une-societe-au-cameroun'],
            ['q' => 'Acheter un terrain ou un bien en étant étranger ou depuis l’étranger', 'href' => 'practice-area.php?area=real-estate-and-property', 'more' => 'post.php?p=acheter-un-terrain-au-cameroun'],
            ['q' => 'Permis de travail et visas pour le personnel', 'href' => 'practice-area.php?area=immigration-and-naturalisation'],
            ['q' => 'Dédouanement et litiges au port de Douala', 'href' => 'practice-area.php?area=tax-and-customs'],
            ['q' => 'Recouvrer une créance sur une société camerounaise', 'href' => 'practice-area.php?area=litigation-and-settlements'],
            ['q' => 'Arbitrage, et exécution d’un jugement ou d’une sentence étrangère', 'href' => 'practice-area.php?area=arbitration-and-adr', 'more' => 'post.php?p=arbitrage-ou-tribunaux-au-cameroun'],
            ['q' => 'Protéger une marque au Cameroun et dans les 16 autres États OAPI', 'href' => 'practice-area.php?area=intellectual-property', 'more' => 'post.php?p=deposer-une-marque-oapi'],
            ['q' => 'Investir au Cameroun et rapatrier les bénéfices', 'href' => 'practice-area.php?area=investments-and-securities', 'more' => 'post.php?p=investir-au-cameroun'],
        ],
        'ask_more'    => 'Lire notre guide',

        'how_eyebrow' => 'Travailler avec nous depuis l’étranger',
        'how_h2'      => 'Comment se déroule un dossier quand vous n’êtes pas au Cameroun',
        'how' => [
            ['h' => 'Expliquez-nous la situation', 'p' => 'Par e-mail, WhatsApp ou le formulaire, en français ou en anglais. Nous répondons sous un jour ouvré.'],
            ['h' => 'Un premier échange', 'p' => 'En visioconférence ou par téléphone, à une heure adaptée à votre fuseau horaire. Nous présentons les options, le calendrier probable et le coût.'],
            ['h' => 'Tout est fixé par écrit', 'p' => 'Une convention d’honoraires précise la mission, les honoraires et les modalités de paiement avant tout commencement. Aucune facture surprise.'],
            ['h' => 'Nous agissons sur place', 'p' => 'Recherches à la conservation foncière, formalités, réunions et audiences au Cameroun. Nous vous indiquons précisément les documents nécessaires, s’ils doivent être certifiés ou légalisés dans votre pays, et comment les envoyer.'],
            ['h' => 'Un compte rendu écrit à chaque étape', 'p' => 'Vous savez toujours où en est votre dossier. Si vous avez un avocat dans votre pays, nous travaillons avec lui.'],
        ],

        'fraud_h2'    => 'Si vous avez été victime d’une escroquerie au Cameroun',
        'fraud' => [
            'Des personnes à l’étranger nous contactent parfois après avoir payé pour un terrain, des marchandises, une affaire ou une relation qui n’existaient pas. Nous pouvons vous conseiller sur le dépôt d’une plainte au Cameroun et vous donner un avis honnête sur les chances de récupérer les fonds.',
            'Méfiez-vous de quiconque, y compris de personnes se présentant comme avocats, policiers ou fonctionnaires, qui vous garantit la récupération de votre argent contre un paiement d’avance. C’est une seconde escroquerie fréquente. Avant de payer un avocat, vérifiez son inscription au Barreau du Cameroun et demandez une convention d’honoraires écrite.',
        ],

        'faq_eyebrow' => 'Questions',
        'faq_h2'      => 'Questions fréquentes des clients à l’étranger',
        'faq' => [
            ['q' => 'Pouvez-vous agir pour moi si je ne suis pas au Cameroun ?', 'a' => 'Oui. La plupart de nos clients internationaux n’ont jamais besoin de se déplacer. Nous échangeons par visioconférence ou par téléphone, et les documents circulent par voie électronique. Lorsqu’une signature ou un original est nécessaire, nous expliquons comment le fournir depuis l’étranger, souvent au moyen d’une procuration.'],
            ['q' => 'Travaillez-vous en anglais ?', 'a' => 'Oui. Nous travaillons en français et en anglais, les deux langues officielles du Cameroun, et pouvons conseiller, rédiger et correspondre dans l’une ou l’autre. Le système juridique camerounais est lui-même bilingue et bijuridique, associant common law et droit civil.'],
            ['q' => 'Comment vos honoraires sont-ils fixés et réglés ?', 'a' => 'Avant tout commencement, vous recevez une convention d’honoraires écrite indiquant le montant, ce qu’il couvre et les modalités de paiement. Les missions définies, comme la création d’une société ou la vérification d’un titre foncier, font généralement l’objet d’un forfait ; les contentieux sont facturés par étapes convenues.'],
            ['q' => 'Un étranger peut-il détenir une société au Cameroun ?', 'a' => 'Dans la plupart des secteurs, oui. Le droit OHADA des sociétés applicable au Cameroun ne réserve pas la qualité d’associé aux nationaux. Certaines activités réglementées ont leurs propres conditions d’agrément ou de détention, que nous vérifions dès le départ.'],
            ['q' => 'Un étranger peut-il acheter un terrain au Cameroun ?', 'a' => 'Un étranger peut acquérir des droits sur un terrain au Cameroun, mais les règles et autorisations ne sont pas les mêmes que pour un national, et la bonne démarche dépend de l’usage prévu. Nous le vérifions, ainsi que le titre foncier lui-même, avant tout versement d’acompte.'],
        ],

        'cta_h2'      => 'Dites-nous ce dont vous avez besoin au Cameroun',
        'cta_p'       => 'Décrivez la situation en quelques lignes. Nous répondons sous un jour ouvré avec notre analyse, les options et le coût probable.',
        'wa_text'     => 'Bonjour Cabinet Fonju, je vous contacte depuis l’étranger au sujet d’une affaire au Cameroun.',
    ];
}
