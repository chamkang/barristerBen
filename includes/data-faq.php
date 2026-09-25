<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * FREQUENTLY ASKED QUESTIONS
 * ---------------------------------------------------------------------------
 * Rendered as an accessible accordion on /faq.php and emitted as FAQPage
 * structured data, which is what makes the questions eligible to appear
 * directly in Google results. Answers may contain simple inline HTML.
 *
 * The French questions and answers are in data-faq.fr.php. Keep the two in
 * step when you add or change a question.
 * ---------------------------------------------------------------------------
 */

function faq_groups(): array
{
    if (is_fr()) {
        return require __DIR__ . '/data-faq.fr.php';
    }

    return [

        'Working with the firm' => [
            [
                'q' => 'How do I book a consultation with Fonju Law Firm?',
                'a' => 'Call <strong>+237 699 96 41 77</strong> or <strong>+237 676 37 11 80</strong>, send a message on WhatsApp, e-mail <strong>info@fonjulawfirm.com</strong>, or complete the enquiry form on our contact page. We aim to respond to every enquiry within one business day, and urgent matters — a vessel arrest, an arrest of a person, an imminent deadline — are handled the same day.',
            ],
            [
                'q' => 'What happens during the first consultation?',
                'a' => 'We listen first. You describe the situation, we ask questions, and by the end of the meeting you receive three things: our view of your legal position, the realistic options with their likely cost and timeline, and a clear recommendation. If we believe you do not need a lawyer, we will say so.',
            ],
            [
                'q' => 'How are your fees calculated?',
                'a' => 'We use hourly rates, fixed fees and retainers depending on the work. Transactional and advisory matters — incorporations, contracts, filings, due diligence — are usually quoted as a fixed fee so you know the cost before you commit. Litigation is normally billed on an agreed structure with defined stages. Whatever the model, you receive a written engagement letter setting out the fee, what it covers and what it excludes before work begins. We do not send surprise invoices.',
            ],
            [
                'q' => 'Do you work in English and French?',
                'a' => 'Yes. Cameroon operates a bijural system, with common law procedure in the North West and South West regions and civil law procedure elsewhere. Our team works in both English and French and is comfortable in both traditions, which matters when a matter crosses regions or involves foreign counterparties.',
            ],
            [
                'q' => 'Is my information kept confidential?',
                'a' => 'Yes. Communications with your lawyer are protected by professional secrecy under the rules governing advocates in Cameroon, and confidentiality is one of the obligations we take most seriously. Information you share with us in the course of seeking advice is not disclosed to any third party without your instruction, and that duty continues after the matter ends.',
            ],
            [
                'q' => 'Can you act for clients outside Douala?',
                'a' => 'Yes. Our office is in Douala, but we act for clients throughout Cameroon and appear before courts across the country. A great deal of advisory work is handled remotely by video call, e-mail and secure document exchange, and we travel for hearings and completions.',
            ],
        ],

        'Starting and running a business' => [
            [
                'q' => 'How long does it take to register a company in Cameroon?',
                'a' => 'Registration at the RCCM through a Centre de Formalités de Création d\'Entreprises can be completed quickly once the file is complete. The realistic timeline is driven by the preparatory work — deciding the corporate form, drafting the articles and shareholder arrangements, gathering and legalising identity documents, and depositing capital — and by any sector licence you need. For a straightforward SARL with documents in order, plan on a few weeks from first meeting to fully operational, including tax and CNPS registration.',
            ],
            [
                'q' => 'Which company form should I choose: SARL, SA or SAS?',
                'a' => 'The <strong>SARL</strong> suits most small and medium businesses: simple management, flexible capital, and it can be formed by a single member. The <strong>SA</strong> is required for certain regulated activities and expected by institutional investors, but carries higher capital and a formal board. The <strong>SAS</strong> offers the most contractual flexibility and is usually the best fit where outside investors are coming in. Choose with your two-year plan in mind — converting later costs time and can trigger tax consequences.',
            ],
            [
                'q' => 'Can a foreigner own 100% of a Cameroonian company?',
                'a' => 'In most sectors, yes — foreign nationals and foreign companies can hold the entire share capital of a Cameroonian company. Certain regulated sectors impose specific ownership, licensing or local participation requirements, so the position should be confirmed for your particular activity before you structure the investment.',
            ],
            [
                'q' => 'Do I really need a shareholder agreement?',
                'a' => 'If there is more than one shareholder, yes. The articles of association deal with the company; the shareholder agreement deals with the relationship between the owners — deadlock, funding obligations, exit, valuation, restrictive covenants and what happens if a founder leaves or dies. Two equal shareholders with no deadlock mechanism is the single most destructive structure we encounter.',
            ],
            [
                'q' => 'What is OHADA and why does it affect my contracts?',
                'a' => 'OHADA is a treaty organisation whose member states share a common set of business laws called Uniform Acts, covering companies, security, debt recovery, insolvency, arbitration and commercial contracts. Those Acts apply directly in Cameroon and override conflicting national law, and disputes about them can reach the supranational Common Court of Justice and Arbitration. In practice it means parts of your contract are governed by regional rather than purely national law — and that a clause choosing a foreign law for a matter OHADA reserves to itself may fail at enforcement.',
            ],
        ],

        'Property and land' => [
            [
                'q' => 'How do I verify that a land title in Cameroon is genuine?',
                'a' => 'The only reliable method is an official search at the Land Registry confirming the current registered holder, the parcel description and any registered encumbrances. Never rely on the document the seller shows you: forged and superseded certificates circulate widely. The search should be followed by a check that the seller is legally entitled to sell, an independent survey of the boundaries, and enquiries about pending litigation.',
            ],
            [
                'q' => 'What is the most common problem in Cameroonian land transactions?',
                'a' => 'A genuine title held by someone who cannot lawfully sell it. This arises with estates where one heir sells without the others, with married sellers where the matrimonial regime requires spousal consent, with expired or limited powers of attorney, and with land that has a customary history never converted into registered title. All four are detectable before a deposit is paid.',
            ],
            [
                'q' => 'Should I pay a deposit before due diligence is complete?',
                'a' => 'No. Payment should be staged against verified milestones: title search cleared, sale deed executed before a notary, transfer lodged for registration, and registration completed in your name. Holding back the final tranche until the certificate issues is the strongest protection available to a buyer.',
            ],
        ],

        'Employment and staff' => [
            [
                'q' => 'Can I dismiss an employee for misconduct in Cameroon?',
                'a' => 'Yes, but the procedure decides the outcome. The employee must be given written notice of the allegations, a genuine opportunity to respond at a minuted hearing, and the assistance the law permits. The employer must hold contemporaneous evidence of the conduct, apply the correct ground, and settle all final entitlements. Most employers who lose dismissal cases lose on procedure, not on the reason.',
            ],
            [
                'q' => 'What must I pay an employee on termination?',
                'a' => 'Depending on the ground and length of service: notice or payment in lieu, accrued but untaken leave, any severance due, outstanding salary and benefits, and a certificate of employment. CNPS declarations must be up to date. Withholding final entitlements as negotiating leverage converts a defensible dismissal into an indefensible one.',
            ],
            [
                'q' => 'Do I need a work permit to employ a foreign national?',
                'a' => 'Yes. Foreign employees require a visa endorsement of their employment contract and appropriate residence and work authorisation, and the employer carries the compliance exposure — not only the employee. We audit existing staff, regularise where possible and put a compliant onboarding process in place.',
            ],
            [
                'q' => 'Are non-compete clauses enforceable in Cameroon?',
                'a' => 'Restrictive covenants can be enforceable, but they are read narrowly. A clause is far more likely to hold if it is limited in duration, restricted to a defined geographic area and to activities that genuinely compete, and supported by a legitimate business interest such as confidential information or client relationships. Blanket clauses preventing any employment in a whole sector are rarely upheld.',
            ],
        ],

        'Disputes and litigation' => [
            [
                'q' => 'How long does litigation take in Cameroon?',
                'a' => 'It varies widely with the court, the complexity and whether the other side is engaging or delaying. A straightforward commercial claim at first instance is commonly measured in months to a couple of years, and appeals add materially to that. This is exactly why we assess every dispute against the cost and time of winning it, and why a well-negotiated settlement is often the better commercial outcome.',
            ],
            [
                'q' => 'Should my contract choose arbitration or the courts?',
                'a' => 'Choose the courts where the counterparty and its assets are in Cameroon and the claim is a straightforward debt — the OHADA recovery procedures are efficient and a judgment is directly enforceable. Choose arbitration where assets are abroad and enforcement will be needed there, where the subject matter is technical, or where confidentiality has real value. The enforcement point is usually decisive: an arbitral award travels internationally far more easily than a national judgment.',
            ],
            [
                'q' => 'I have a judgment but the debtor will not pay. What now?',
                'a' => 'Enforcement is a distinct phase with its own tools under the OHADA Uniform Act on Simplified Recovery Procedures and Measures of Execution — conservatory attachment, third-party garnishment of bank accounts and receivables, seizure and sale of movable and immovable assets. Success depends on identifying assets, so asset tracing frequently matters more than further litigation.',
            ],
            [
                'q' => 'Can a foreign judgment or arbitral award be enforced in Cameroon?',
                'a' => 'Arbitral awards benefit from the New York Convention and, within the OHADA space, from a streamlined recognition route — they are generally enforceable subject to limited grounds of challenge. Foreign court judgments face a more demanding exequatur process and depend on the applicable treaty position. This asymmetry is one of the strongest reasons to choose arbitration in cross-border contracts.',
            ],
        ],

        'Foreign clients and investors' => [
            [
                'q' => 'Do you act for clients based outside Cameroon?',
                'a' => 'Yes. A significant part of our practice serves clients from Europe, Asia, the Middle East and North America who are establishing or expanding operations in the CEMAC zone. We work by video call and secure document exchange, we are used to acting as local counsel alongside a client\'s home-country lawyers, and we report in the format your team needs.',
            ],
            [
                'q' => 'Can profits be repatriated out of Cameroon?',
                'a' => 'Yes — dividends, loan repayments, royalties and service fees can be remitted, but CEMAC foreign exchange regulation requires proper documentation and examines the substance of the underlying arrangement. The practical rules are: register the inbound investment properly, document shareholder loans and intra-group agreements from the outset, and be able to evidence that services actually charged for were actually provided.',
            ],
            [
                'q' => 'What investment incentives are available?',
                'a' => 'Cameroon\'s investment framework offers exemptions and reductions during an installation phase and, for qualifying projects, during operations. Benefits are granted by convention rather than automatically, and are tied to commitments on investment quantum, job creation and local sourcing. They are negotiated, so how the application is prepared and evidenced materially affects what you obtain — and unmet commitments can trigger clawback.',
            ],
            [
                'q' => 'What is the biggest legal risk foreign investors underestimate?',
                'a' => 'Legal foundations, as opposed to commercial opportunity. The issues that most often cause post-closing problems are land title defects, employee misclassification and CNPS arrears, unregistered or improperly assigned intellectual property, and undocumented related-party dealings. Every one of them is inexpensive to verify before signing and expensive to discover afterwards.',
            ],
        ],
    ];
}

/** Flat list of every question, for FAQPage structured data. */
function faq_flat(): array
{
    $flat = [];

    foreach (faq_groups() as $questions) {
        foreach ($questions as $item) {
            $flat[] = $item;
        }
    }

    return $flat;
}

/** A short selection for the home page. */
function faq_highlights(int $limit = 5): array
{
    return array_slice(faq_flat(), 0, $limit);
}
