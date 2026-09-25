<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * LEGAL TEAM
 * ---------------------------------------------------------------------------
 * >>> ACTION REQUIRED <<<
 * Only the first entry (the founder) is taken from the firm's existing site.
 * The remaining entries are STRUCTURAL PLACEHOLDERS so the page renders in
 * full — replace the names, titles, bios, e-mail addresses and LinkedIn URLs
 * with the firm's real team before the site goes live, or delete the entries
 * you do not need. The page and its Person structured data adapt automatically.
 *
 * Photos: drop a square JPG (at least 800x800) into /assets/img/team/ and set
 * 'photo' to the file name. Leave 'photo' empty and an elegant monogram card
 * is generated instead, so no image ever appears broken.
 *
 * French: each member has an 'fr' entry with the translated role, focus,
 * languages and biography, used on the French site. Update it alongside the
 * English text.
 * ---------------------------------------------------------------------------
 */

function team_members(): array
{
    return array_map(static function (array $m): array {
        $fr = $m['fr'] ?? [];
        unset($m['fr']);

        return is_fr() ? array_replace($m, $fr) : $m;
    }, team_members_all());
}

function team_members_all(): array
{
    return [
        [
            'slug'      => 'fonju-bernard',
            'name'      => 'Bar. Fonju Bernard',
            'role'      => 'Founder & Managing Partner',
            'photo'     => '',                          // e.g. 'fonju-bernard.jpg'
            'email'     => 'fonjubernard@fonjulawfirm.com',
            'linkedin'  => '',
            'languages' => ['English', 'French'],
            'focus'     => ['Corporate & Commercial Law', 'iGaming & Betting Regulation', 'Investments & Securities'],
            'bio'       => 'Bar. Fonju Bernard founded Fonju Law Firm on a simple conviction: that specialised legal services deliver superior results. He leads the firm\'s corporate and commercial practice, advising local and international businesses on structuring, governance, investment and regulatory strategy across the CEMAC region. He has built a particular reputation in iGaming and digital gaming consultancy, an area where regulation in Central Africa is moving faster than most operators can follow.',
            'bio2'      => 'He is admitted to practise in the Republic of Cameroon and works in both English and French, moving comfortably between the common law and civil law traditions that coexist in Cameroon\'s bijural system. Clients describe his approach as direct: an early, honest assessment of what a matter is worth, followed by disciplined execution.',
            'placeholder' => false,
            'fr' => [
                'name'      => 'Me Fonju Bernard',
                'role'      => 'Fondateur et associé gérant',
                'languages' => ['Anglais', 'Français'],
                'focus'     => ['Droit des sociétés et droit commercial', 'Jeux en ligne et paris', 'Investissements et valeurs mobilières'],
                'bio'       => 'Me Fonju Bernard a fondé le cabinet Fonju sur une conviction simple : des services juridiques spécialisés produisent de meilleurs résultats. Il dirige la pratique de droit des sociétés et de droit commercial du cabinet et conseille des entreprises locales et internationales en matière de structuration, de gouvernance, d’investissement et de stratégie réglementaire dans toute la zone CEMAC. Il s’est forgé une réputation particulière dans le conseil en jeux en ligne et jeux numériques, un domaine où la réglementation évolue en Afrique centrale plus vite que la plupart des opérateurs ne peuvent la suivre.',
                'bio2'      => 'Il est habilité à exercer en République du Cameroun et travaille en anglais comme en français, passant aisément de la common law au droit civil, les deux traditions qui coexistent dans le système bijuridique camerounais. Ses clients décrivent une approche directe : une évaluation précoce et franche de ce que vaut un dossier, suivie d’une exécution rigoureuse.',
            ],
        ],

        // ------------------------------------------------------ PLACEHOLDER
        [
            'slug'      => 'partner-litigation',
            'name'      => 'Partner — Dispute Resolution',
            'role'      => 'Partner, Litigation & Arbitration',
            'photo'     => '',
            'email'     => 'info@fonjulawfirm.com',
            'linkedin'  => '',
            'languages' => ['English', 'French'],
            'focus'     => ['Litigation & Settlements', 'Arbitration & ADR', 'Bankruptcy & Insolvency'],
            'bio'       => 'Leads the firm\'s contentious practice, appearing before the Courts of First Instance, High Courts, Courts of Appeal and the Supreme Court, and acting as counsel in CCJA and ad hoc arbitrations.',
            'bio2'      => 'Replace this placeholder with the real partner\'s biography, qualifications, bar admission and notable matters.',
            'placeholder' => true,
            'fr' => [
                'name'      => 'Associé — Contentieux',
                'role'      => 'Associé, contentieux et arbitrage',
                'languages' => ['Anglais', 'Français'],
                'focus'     => ['Contentieux et transactions', 'Arbitrage et MARD', 'Entreprises en difficulté'],
                'bio'       => 'Dirige la pratique contentieuse du cabinet, plaide devant les tribunaux de première instance, les tribunaux de grande instance, les cours d’appel et la Cour suprême, et intervient comme conseil dans des arbitrages CCJA et ad hoc.',
                'bio2'      => 'Remplacez ce profil provisoire par la biographie, les diplômes, l’inscription au barreau et les dossiers marquants de l’associé.',
            ],
        ],

        [
            'slug'      => 'senior-associate-corporate',
            'name'      => 'Senior Associate — Corporate',
            'role'      => 'Senior Associate, Corporate & Finance',
            'photo'     => '',
            'email'     => 'info@fonjulawfirm.com',
            'linkedin'  => '',
            'languages' => ['English', 'French'],
            'focus'     => ['Banking & Finance', 'Corporate & Commercial Law', 'Tax & Customs'],
            'bio'       => 'Advises banks, borrowers and corporate clients on financing, security packages, company formation and cross-border transactions in the OHADA space.',
            'bio2'      => 'Replace this placeholder with the real associate\'s biography and qualifications.',
            'placeholder' => true,
            'fr' => [
                'name'      => 'Collaborateur senior — Droit des affaires',
                'role'      => 'Collaborateur senior, droit des affaires et financement',
                'languages' => ['Anglais', 'Français'],
                'focus'     => ['Banque et financement', 'Droit des sociétés et droit commercial', 'Fiscalité et douane'],
                'bio'       => 'Conseille banques, emprunteurs et entreprises en matière de financements, de sûretés, de constitution de sociétés et d’opérations transfrontalières dans l’espace OHADA.',
                'bio2'      => 'Remplacez ce profil provisoire par la biographie et les diplômes du collaborateur.',
            ],
        ],

        [
            'slug'      => 'associate-ip-tech',
            'name'      => 'Associate — IP & Technology',
            'role'      => 'Associate, Intellectual Property & Technology',
            'photo'     => '',
            'email'     => 'info@fonjulawfirm.com',
            'linkedin'  => '',
            'languages' => ['English', 'French'],
            'focus'     => ['Intellectual Property', 'Technology, Data & Telecoms', 'Media, Sports & Creative Industry'],
            'bio'       => 'Handles OAPI trade mark and design filings, technology contracting, data protection compliance and enforcement against counterfeiting.',
            'bio2'      => 'Replace this placeholder with the real associate\'s biography and qualifications.',
            'placeholder' => true,
            'fr' => [
                'name'      => 'Collaborateur — PI et technologies',
                'role'      => 'Collaborateur, propriété intellectuelle et technologies',
                'languages' => ['Anglais', 'Français'],
                'focus'     => ['Propriété intellectuelle', 'Technologies, données et télécoms', 'Médias, sport et industries créatives'],
                'bio'       => 'Gère les dépôts OAPI de marques et de dessins, les contrats technologiques, la conformité en matière de données personnelles et la lutte contre la contrefaçon.',
                'bio2'      => 'Remplacez ce profil provisoire par la biographie et les diplômes du collaborateur.',
            ],
        ],
    ];
}

/** Initials used for the generated monogram avatar. */
function member_initials(string $name): string
{
    $clean = trim(preg_replace('/^(Bar\.|Me\.|Me(?=\s)|Mr\.|Mrs\.|Ms\.|Dr\.)\s*/u', '', $name));
    $parts = preg_split('/[\s\-—]+/u', $clean) ?: [];
    $parts = array_values(array_filter($parts, static fn(string $p): bool => $p !== '' && ctype_alpha($p[0])));

    if ($parts === []) {
        return 'FL';
    }

    $first = mb_strtoupper(mb_substr($parts[0], 0, 1));
    $last  = count($parts) > 1 ? mb_strtoupper(mb_substr(end($parts), 0, 1)) : '';

    return $first . $last;
}
