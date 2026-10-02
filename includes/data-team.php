<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * LEGAL TEAM
 * ---------------------------------------------------------------------------
 * The firm's team, as listed on its letterhead. Biographies are deliberately
 * short and factual; extend them (qualifications, languages, areas of focus,
 * notable matters) as each member provides them. 'focus' and 'languages' may
 * be left empty; the card then simply omits them.
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
            'name'      => 'Bar. Fonju Bernard Fuelancha',
            'role'      => 'Founder & Managing Partner',
            'photo'     => 'fonju-bernard-fuelancha.jpg', // assets/img/team/
            'email'     => 'fonjubernard@fonjulawfirm.com',
            'linkedin'  => '',
            'languages' => ['English', 'French'],
            'focus'     => ['Corporate & Commercial Law', 'iGaming & Betting Regulation', 'Investments & Securities'],
            'bio'       => 'Bar. Fonju Bernard Fuelancha, an Advocate at the Cameroon Bar and a former legal assistant at the International Criminal Tribunal for Rwanda (United Nations), founded Fonju & Partners Law Firm on a simple conviction: that specialised legal services deliver superior results. He leads the firm\'s corporate and commercial practice, advising local and international businesses on structuring, governance, investment and regulatory strategy across the CEMAC region. He has built a particular reputation in iGaming and digital gaming consultancy, an area where regulation in Central Africa is moving faster than most operators can follow.',
            'bio2'      => 'He is an Advocate at the Cameroon Bar (registration no. 00105A0029) and a former legal assistant at the International Criminal Tribunal for Rwanda (United Nations). He works in both English and French, moving comfortably between the common law and civil law traditions that coexist in Cameroon\'s bijural system. Clients describe his approach as direct: an early, honest assessment of what a matter is worth, followed by disciplined execution.',
            'placeholder' => false,
            'fr' => [
                'name'      => 'Me Fonju Bernard Fuelancha',
                'role'      => 'Fondateur et associé gérant',
                'languages' => ['Anglais', 'Français'],
                'focus'     => ['Droit des sociétés et droit commercial', 'Jeux en ligne et paris', 'Investissements et valeurs mobilières'],
                'bio'       => 'Avocat au Barreau du Cameroun et ancien assistant juridique au Tribunal pénal international pour le Rwanda (Nations unies), Me Fonju Bernard Fuelancha a fondé le cabinet Fonju & Partners sur une conviction simple : des services juridiques spécialisés produisent de meilleurs résultats. Il dirige la pratique de droit des sociétés et de droit commercial du cabinet et conseille des entreprises locales et internationales en matière de structuration, de gouvernance, d’investissement et de stratégie réglementaire dans toute la zone CEMAC. Il s’est forgé une réputation particulière dans le conseil en jeux en ligne et jeux numériques, un domaine où la réglementation évolue en Afrique centrale plus vite que la plupart des opérateurs ne peuvent la suivre.',
                'bio2'      => 'Avocat au Barreau du Cameroun (matricule 00105A0029) et ancien assistant juridique au Tribunal pénal international pour le Rwanda (Nations unies), il travaille en anglais comme en français, passant aisément de la common law au droit civil, les deux traditions qui coexistent dans le système bijuridique camerounais. Ses clients décrivent une approche directe : une évaluation précoce et franche de ce que vaut un dossier, suivie d’une exécution rigoureuse.',
            ],
        ],

        // ---------------------------------------------------------- ADVOCATES
        [
            'slug'      => 'ndadem-nestor',
            'name'      => 'Bar. Ndadem Nestor',
            'role'      => 'Advocate',
            'photo'     => '',
            'email'     => '',
            'linkedin'  => '',
            'languages' => [],
            'focus'     => [],
            'bio'       => 'Advocate at the Cameroon Bar and a member of the firm’s legal team.',
            'bio2'      => '',
            'placeholder' => false,
            'fr' => [
                'name'      => 'Me Ndadem Nestor',
                'role'      => 'Avocat',
                'bio'       => 'Avocat au Barreau du Cameroun, membre de l’équipe juridique du cabinet.',
            ],
        ],

        // --------------------------------------------------- TRAINEE ADVOCATES
        [
            'slug'      => 'bama-gwate-emmanuel-blaise',
            'name'      => 'Bama Gwate Emmanuel Blaise',
            'role'      => 'Trainee Advocate',
            'photo'     => '',
            'email'     => '',
            'linkedin'  => '',
            'languages' => [],
            'focus'     => [],
            'bio'       => 'Trainee advocate at the Cameroon Bar, completing pupillage with the firm.',
            'bio2'      => '',
            'placeholder' => false,
            'fr' => [
                'name'      => 'Bama Gwate Emmanuel Blaise',
                'role'      => 'Avocat stagiaire',
                'bio'       => 'Avocat stagiaire au Barreau du Cameroun, effectue son stage au sein du cabinet.',
            ],
        ],
        [
            'slug'      => 'lontsi-douanla-nina',
            'name'      => 'Lontsi Douanla Nina, épse Mely',
            'role'      => 'Trainee Advocate',
            'photo'     => '',
            'email'     => '',
            'linkedin'  => '',
            'languages' => [],
            'focus'     => [],
            'bio'       => 'Trainee advocate at the Cameroon Bar, completing pupillage with the firm.',
            'bio2'      => '',
            'placeholder' => false,
            'fr' => [
                'name'      => 'Lontsi Douanla Nina, épse Mely',
                'role'      => 'Avocate stagiaire',
                'bio'       => 'Avocate stagiaire au Barreau du Cameroun, effectue son stage au sein du cabinet.',
            ],
        ],

        // ---------------------------------------------------- LEGAL ASSISTANTS
        [
            'slug'      => 'dina-jeannette-chantal',
            'name'      => 'Dina Jeannette Chantal',
            'role'      => 'Legal Assistant',
            'photo'     => '',
            'email'     => '',
            'linkedin'  => '',
            'languages' => [],
            'focus'     => [],
            'bio'       => 'Supports the firm’s lawyers on legal research, drafting and the management of case files.',
            'bio2'      => '',
            'placeholder' => false,
            'fr' => [
                'name'      => 'Dina Jeannette Chantal',
                'role'      => 'Assistante juridique',
                'bio'       => 'Assiste les avocats du cabinet dans la recherche juridique, la rédaction et le suivi des dossiers.',
            ],
        ],
        [
            'slug'      => 'monguele-dooh-isabelle',
            'name'      => 'Monguele Dooh Isabelle',
            'role'      => 'Legal Assistant',
            'photo'     => '',
            'email'     => '',
            'linkedin'  => '',
            'languages' => [],
            'focus'     => [],
            'bio'       => 'Supports the firm’s lawyers on legal research, drafting and the management of case files.',
            'bio2'      => '',
            'placeholder' => false,
            'fr' => [
                'name'      => 'Monguele Dooh Isabelle',
                'role'      => 'Assistante juridique',
                'bio'       => 'Assiste les avocats du cabinet dans la recherche juridique, la rédaction et le suivi des dossiers.',
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
