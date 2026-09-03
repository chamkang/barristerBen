<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * INSIGHTS / BLOG
 * ---------------------------------------------------------------------------
 * Add a new article by copying a block and changing the slug. Articles are
 * sorted newest first automatically. Keep 'body' as simple HTML: h2, h3, p,
 * ul/li, blockquote and strong are all styled by the stylesheet.
 *
 * Every article renders BlogPosting structured data, a canonical URL, an
 * Open Graph card and a breadcrumb trail, so new posts are indexable with
 * no extra work.
 * ---------------------------------------------------------------------------
 */

function blog_posts(): array
{
    $posts = [

        [
            'slug'     => 'registering-a-company-in-cameroon',
            'title'    => 'Registering a Company in Cameroon: What the Process Actually Looks Like',
            'category' => 'Corporate',
            'author'   => 'Bar. Fonju Bernard',
            'date'     => '2026-08-18',
            'updated'  => '2026-08-18',
            'featured' => true,
            'tags'     => ['Company formation', 'OHADA', 'RCCM', 'Start-ups'],
            'excerpt'  => 'The official timeline says a few days. The realistic timeline depends on decisions you make before you ever reach the registry. Here is the sequence that works.',
            'body' => <<<'HTML'
<p>Most guides to incorporating in Cameroon describe the counter you file at. Very few describe the choices that determine whether the company you register is the company you actually needed. This note covers both.</p>

<h2>Choose the vehicle before you choose the name</h2>
<p>The OHADA Uniform Act on Commercial Companies gives you several options, and the difference between them is not cosmetic.</p>
<ul>
  <li><strong>SARL (limited liability company)</strong> — the default for small and medium businesses. It can be formed by a single member, capital is flexible, and management is simple. Share transfers are restricted, which is a feature if you want control and a problem if you plan to bring in investors quickly.</li>
  <li><strong>SA (public limited company)</strong> — required for regulated activities such as banking and insurance, and expected by institutional investors. It carries a higher minimum capital and a formal board structure.</li>
  <li><strong>SAS (simplified joint-stock company)</strong> — the most flexible vehicle for investor-backed businesses. Governance is largely contractual, which suits founders and funds that want bespoke rights.</li>
  <li><strong>Branch office</strong> — a foreign company can operate through a branch, but a branch has a limited authorised life before it must generally be converted into a company, and it does not ring-fence liability.</li>
</ul>
<p>Choosing the wrong vehicle is recoverable, but conversion costs time and money and often triggers tax consequences. Decide with the two-year plan in mind.</p>

<h2>The filing sequence</h2>
<p>Once the vehicle is chosen, the mechanics follow a predictable order:</p>
<ul>
  <li>Reserve the company name and confirm it does not conflict with an existing OAPI trade mark.</li>
  <li>Draft and execute the articles of association, together with the appointment of the manager or directors.</li>
  <li>Deposit share capital and obtain the bank certificate, where the chosen form requires it.</li>
  <li>Register with the Registre du Commerce et du Crédit Mobilier (RCCM) through the relevant Centre de Formalités de Création d'Entreprises.</li>
  <li>Obtain the taxpayer number (NIU) and register for VAT where applicable.</li>
  <li>Register with the CNPS as an employer before the first employee starts.</li>
  <li>Obtain any sector-specific licence — this is the step that most often delays a launch.</li>
</ul>

<h2>The three mistakes we are most often asked to fix</h2>
<h3>1. Articles copied from another jurisdiction</h3>
<p>Foreign-drafted articles frequently contain provisions that are simply void under the Uniform Act, or that omit mandatory clauses. The registry may accept them; a court later will not.</p>

<h3>2. No shareholder agreement</h3>
<p>Two founders with equal shares and no deadlock mechanism is the most reliably destructive structure in business. Deal with deadlock, exit, valuation and restrictive covenants while everyone is still friendly.</p>

<h3>3. Intellectual property left with the founder</h3>
<p>If the software, brand or design was created before incorporation, it belongs to the person who created it until it is formally assigned. Investors will find this in diligence. Assign it at formation.</p>

<h2>What to prepare before your first meeting with a lawyer</h2>
<p>Bring the shareholding split, the identity documents of each shareholder and manager, a description of the actual activity, the intended registered office, and the answer to one question: who decides when the shareholders disagree. Everything else can be built from there.</p>
HTML,
        ],

        [
            'slug'     => 'ohada-explained-for-business',
            'title'    => 'OHADA Explained: The Legal Framework Behind Every Cameroonian Business Deal',
            'category' => 'Regulatory',
            'author'   => 'Fonju Law Firm',
            'date'     => '2026-08-05',
            'updated'  => '2026-08-05',
            'featured' => true,
            'tags'     => ['OHADA', 'CEMAC', 'Commercial law', 'Cross-border'],
            'excerpt'  => 'Seventeen countries, one commercial code and a supranational court that can overturn your national judgment. A practical orientation for foreign and local businesses.',
            'body' => <<<'HTML'
<p>Businesses arriving in Cameroon often assume they are dealing with a single national legal system. In commercial matters, they are not. A large part of the law that governs their contracts, their security, their company and their insolvency comes from OHADA — the Organisation for the Harmonisation of Business Law in Africa.</p>

<h2>What OHADA actually is</h2>
<p>OHADA is a treaty organisation whose member states have adopted a common set of business laws known as Uniform Acts. These Uniform Acts apply directly in each member state and, importantly, they override conflicting national legislation. For a business, that has three practical consequences.</p>
<ul>
  <li>The rules on companies, security, debt recovery, insolvency and commercial contracts are broadly the same in Douala as they are in Abidjan, Dakar or Libreville.</li>
  <li>A judgment of a national court applying a Uniform Act can be reviewed by a supranational court, the Common Court of Justice and Arbitration (CCJA).</li>
  <li>Precedents and commentary from other member states are genuinely relevant to a Cameroonian dispute.</li>
</ul>

<h2>The Uniform Acts that matter most in practice</h2>
<h3>Commercial companies and economic interest groups</h3>
<p>This is the corporate code: formation, capital, governance, shareholder rights, mergers, dissolution. It is prescriptive, and clauses that contradict it are unenforceable however carefully negotiated.</p>

<h3>Securities</h3>
<p>Pledges, mortgages, sureties, retention of title and the registration formalities that perfect them. Registration deadlines are short and the consequence of missing one is loss of priority.</p>

<h3>Simplified recovery procedures and measures of execution</h3>
<p>This is how a creditor actually gets paid — injunction to pay, conservatory attachment, garnishment, seizure and sale. Any credit decision in the region should be taken with this Act in mind.</p>

<h3>Collective proceedings for the discharge of liabilities</h3>
<p>Preventive settlement, judicial reorganisation and liquidation. It also creates real personal exposure for directors who continue trading a failing company.</p>

<h3>Arbitration</h3>
<p>Together with the CCJA Arbitration Rules, this provides a regional arbitration framework and a route to enforcement across all member states.</p>

<h2>OHADA is not everything</h2>
<p>It is equally important to know what OHADA does <em>not</em> cover. Employment relations are governed by the Cameroonian Labour Code. Tax is national. Land tenure is national. Insurance is governed by the CIMA Code, banking by COBAC and BEAC rules, and intellectual property by the OAPI framework. A transaction of any size touches several of these regimes at once, and they do not always point in the same direction.</p>

<blockquote>The single most common error we see in foreign-drafted contracts is a governing law clause that selects a foreign law for a matter that OHADA reserves to itself. The clause does not fail loudly. It fails at enforcement.</blockquote>

<h2>What this means for your contracts</h2>
<p>Before signing anything substantial in Cameroon, confirm three things: which regime governs the subject matter, whether your chosen governing law and forum are actually available for it, and whether any security you are taking has been perfected in the manner the Uniform Act requires. Those three checks prevent most of the disputes we are later asked to litigate.</p>
HTML,
        ],

        [
            'slug'     => 'buying-land-in-cameroon-checklist',
            'title'    => 'Buying Land in Cameroon: Seven Checks Before You Pay a Deposit',
            'category' => 'Real Estate',
            'author'   => 'Fonju Law Firm',
            'date'     => '2026-07-22',
            'updated'  => '2026-07-22',
            'featured' => true,
            'tags'     => ['Land title', 'Property', 'Due diligence'],
            'excerpt'  => 'Land is the most disputed asset in Cameroon and the most frequently mis-sold. Almost every failure traces back to a check that was skipped before the deposit.',
            'body' => <<<'HTML'
<p>We are asked to rescue land transactions more often than any other kind. The pattern is remarkably consistent: a deposit paid on trust, a title document that was never verified at the registry, and a seller who was not entitled to sell. Here is the diligence that prevents it.</p>

<h2>1. Verify the title at the registry, not in the seller's hand</h2>
<p>A land certificate (titre foncier) is a public record. Forged and superseded documents circulate widely. The only meaningful verification is an official search at the Land Registry confirming the current registered holder, the parcel description and any registered encumbrances.</p>

<h2>2. Confirm the seller is the registered holder — or properly authorised</h2>
<p>A genuine title held by a person who cannot lawfully sell it is the classic trap. If the seller is acting under a power of attorney, verify the instrument, its scope and whether it is still in force. If the seller is a company, check that the person signing has authority under the articles and a valid resolution.</p>

<h2>3. Check the matrimonial and succession position</h2>
<p>Land acquired during a marriage may require spousal consent depending on the matrimonial regime. Land forming part of an estate cannot be sold by one heir alone. Both issues surface years later, usually when the buyer starts building.</p>

<h2>4. Look for encumbrances and litigation</h2>
<p>Mortgages, easements, pending expropriation and existing litigation are all capable of destroying the value of a purchase. Registered charges appear on the search; pending disputes often do not, so ask directly and record the answer in the contract.</p>

<h2>5. Walk the boundaries with a surveyor</h2>
<p>Registered dimensions and physical occupation diverge frequently. Commission an independent survey and physically identify the beacons. If someone is farming or living on the land, resolve that before completion, not after.</p>

<h2>6. Understand the customary layer</h2>
<p>Much land in Cameroon has a customary history that has not been fully converted into registered title. A sale endorsed by a family head without registration does not transfer registered ownership. Where customary rights are involved, the path to a clean title needs to be mapped and costed before you commit.</p>

<h2>7. Structure the payment</h2>
<p>Never pay the full price against a promise. Payment should be staged against verified milestones: title search cleared, sale deed executed before a notary, transfer lodged for registration, and registration completed. Hold the final tranche until the certificate issues in your name.</p>

<h2>The cost of doing this properly</h2>
<p>Full diligence on a residential plot typically costs a small fraction of the purchase price and takes two to four weeks. The alternative is a claim that takes years and frequently recovers nothing, because the seller has spent the money. This is the clearest example in Cameroonian practice of legal fees paying for themselves.</p>
HTML,
        ],

        [
            'slug'     => 'dismissing-an-employee-in-cameroon',
            'title'    => 'Dismissing an Employee in Cameroon: The Procedure That Protects the Employer',
            'category' => 'Employment',
            'author'   => 'Fonju Law Firm',
            'date'     => '2026-07-09',
            'updated'  => '2026-07-09',
            'featured' => false,
            'tags'     => ['Labour Code', 'Dismissal', 'HR compliance', 'CNPS'],
            'excerpt'  => 'Employers rarely lose dismissal cases because the reason was bad. They lose because the procedure was incomplete. The file has to be finished before anyone is told anything.',
            'body' => <<<'HTML'
<p>The Cameroonian Labour Code protects employees, and labour courts apply it strictly. In our experience, the great majority of employer losses are procedural. The reason for dismissal was defensible; the process was not documented.</p>

<h2>Establish the ground honestly</h2>
<p>There is a real difference between dismissal for misconduct, dismissal for professional inadequacy and economic dismissal following restructuring. Each carries different notice, consultation and compensation consequences. Choosing the label that feels convenient rather than the one that is accurate is the first error, and it is very difficult to correct later.</p>

<h2>Build the file before the meeting</h2>
<p>By the time an employee is invited to a disciplinary hearing, the employer should already hold contemporaneous evidence of the conduct or performance issue: warnings, instructions given, incident reports, and any prior remedial steps. A dismissal supported only by a manager's recollection is a dismissal that will be found abusive.</p>

<h2>Respect the hearing</h2>
<p>The employee must be told what is alleged, given a genuine opportunity to respond, and permitted the assistance the law allows. The hearing must be minuted. A hearing conducted as a formality after the decision has been taken is worse than no hearing at all, because the minutes will show it.</p>

<h2>Notice, entitlements and the final account</h2>
<p>On termination, the employer must settle notice or payment in lieu, accrued leave, any severance due on the applicable ground, and outstanding salary, and must issue a certificate of employment. CNPS declarations must be brought up to date. Withholding final entitlements as leverage in a dispute converts a defensible dismissal into an indefensible one.</p>

<h2>Economic dismissal has extra steps</h2>
<p>Redundancy on economic grounds requires consultation with staff representatives, engagement with the labour inspectorate, application of the selection criteria the law provides, and consideration of alternatives to dismissal. Skipping the inspectorate stage is the most common failure and it is fatal.</p>

<h2>Before conciliation</h2>
<p>Labour disputes pass through the inspectorate for conciliation before they reach court. That stage is an opportunity, not an obstacle. An employer arriving with a complete, coherent file settles on far better terms than one arriving with an explanation.</p>

<blockquote>A practical test: if the entire dismissal file were handed to a labour court judge with no oral explanation, would it stand on its own? If not, the process is not finished.</blockquote>

<h2>For employees</h2>
<p>The same rules cut both ways. If you were dismissed without a hearing, without written reasons, or without your final entitlements, you have grounds worth assessing. Time limits apply, so seek advice quickly rather than after the fact.</p>
HTML,
        ],

        [
            'slug'     => 'oapi-trade-mark-guide',
            'title'    => 'One Filing, Seventeen Countries: A Practical Guide to OAPI Trade Marks',
            'category' => 'Intellectual Property',
            'author'   => 'Fonju Law Firm',
            'date'     => '2026-06-25',
            'updated'  => '2026-06-25',
            'featured' => false,
            'tags'     => ['OAPI', 'Trade marks', 'Brand protection', 'Counterfeiting'],
            'excerpt'  => 'Cameroonian businesses have access to a regional registration system that is genuinely powerful and consistently underused. Here is how to use it well.',
            'body' => <<<'HTML'
<p>Cameroon is a member of the African Intellectual Property Organisation (OAPI). Under that system there is no separate national trade mark register: a single OAPI registration covers all member states simultaneously. For a business with regional ambitions this is a substantial advantage, and it is available for a fraction of what equivalent protection costs elsewhere.</p>

<h2>What can be registered</h2>
<p>Word marks, logos, combined marks, slogans in some circumstances, and increasingly non-traditional signs. The mark must be distinctive for the goods or services claimed, and must not conflict with an earlier right. Descriptive marks — naming what the product is — are refused or, worse, registered and then unenforceable against competitors using the ordinary word.</p>

<h2>Get the specification right</h2>
<p>Registration is granted for specified classes of goods and services under the Nice Classification. Two errors are common:</p>
<ul>
  <li><strong>Filing too narrowly</strong>, covering only today's products, so a competitor can lawfully use your brand on the adjacent category you launch next year.</li>
  <li><strong>Filing a copy-paste list</strong> of everything, which invites opposition and can expose the registration to cancellation for non-use.</li>
</ul>
<p>The right specification describes the business you will plausibly be operating within five years.</p>

<h2>Search before you file</h2>
<p>A pre-filing availability search is inexpensive relative to a rebrand. It should cover identical and confusingly similar marks in the relevant and neighbouring classes, and it should be run before you commission packaging, signage or a domain purchase.</p>

<h2>Renewal and use</h2>
<p>Registrations run for ten years and are renewable indefinitely. They are also vulnerable to cancellation if the mark has not been genuinely used. Keep dated evidence of use — invoices, packaging, advertising — in a file that can be produced years later.</p>

<h2>Enforcement</h2>
<p>Registration is the precondition, not the remedy. Effective enforcement in the region usually combines several tools:</p>
<ul>
  <li>Customs recordal, so counterfeit consignments can be intercepted at the port.</li>
  <li>Seizure (saisie-contrefaçon) to secure evidence before the infringer can disperse stock.</li>
  <li>Civil infringement proceedings for injunctive relief and damages.</li>
  <li>Criminal complaint where the scale of counterfeiting justifies it.</li>
</ul>

<h2>Do not forget the company name</h2>
<p>Registering a company name at the RCCM does not give you trade mark rights, and holding a trade mark does not guarantee the company name is available. Both need to be checked, and the trade mark search should be done before the company is incorporated, not after the signage is printed.</p>
HTML,
        ],

        [
            'slug'     => 'arbitration-or-court-cameroon',
            'title'    => 'Arbitration or Court? Choosing a Dispute Resolution Clause That Works',
            'category' => 'Dispute Resolution',
            'author'   => 'Fonju Law Firm',
            'date'     => '2026-06-10',
            'updated'  => '2026-06-10',
            'featured' => false,
            'tags'     => ['Arbitration', 'CCJA', 'Contracts', 'Enforcement'],
            'excerpt'  => 'The dispute resolution clause is negotiated last, in five minutes, by tired people. It then determines the entire economics of any dispute that follows.',
            'body' => <<<'HTML'
<p>Nearly every contract we review has a dispute resolution clause that was copied from an earlier deal. When a dispute arises, that clause decides where you fight, how long it takes, what it costs and whether the outcome can be enforced against assets. It deserves more than five minutes.</p>

<h2>When national courts are the right answer</h2>
<p>Litigation in the Cameroonian courts is the sensible default where the counterparty and its assets are all in Cameroon, the amounts do not justify arbitration costs, or the likely dispute is a straightforward debt claim. The OHADA simplified recovery procedures are efficient for undisputed debts, and a court judgment is directly enforceable without an additional recognition step.</p>

<h2>When arbitration earns its cost</h2>
<p>Arbitration tends to be worth it where:</p>
<ul>
  <li>the counterparty or its assets sit outside Cameroon, and enforcement will be needed abroad;</li>
  <li>the subject matter is technical and a specialist tribunal is preferable to a generalist judge;</li>
  <li>confidentiality has real commercial value;</li>
  <li>the parties want a single forum for a multi-party, multi-country project.</li>
</ul>
<p>The enforcement point is usually decisive. An arbitral award benefits from the New York Convention in over 170 states, and from the OHADA framework across member states. A national judgment travels far less easily.</p>

<h2>The CCJA option</h2>
<p>The Common Court of Justice and Arbitration administers arbitration under its own rules, and an award rendered under those rules has a streamlined enforcement route throughout the OHADA space. For regional contracts it is often a better fit — and considerably cheaper — than defaulting to a European institution.</p>

<h2>How clauses fail</h2>
<h3>Naming an institution that does not exist</h3>
<p>Approximations of institution names are surprisingly common and cause months of jurisdictional argument.</p>

<h3>Contradicting yourself</h3>
<p>A clause that submits disputes to arbitration and then confers exclusive jurisdiction on a named court is not a clause; it is a future application.</p>

<h3>Ignoring the seat</h3>
<p>The seat determines the supervisory court, the availability of interim relief and the grounds for setting aside an award. It is not the same as the venue for hearings, and it should be chosen deliberately.</p>

<h3>Over-engineering the tribunal</h3>
<p>Three arbitrators on a contract worth a modest sum is a clause that makes disputes uneconomic to pursue. Match the machinery to the value.</p>

<h2>A workable default</h2>
<p>For most CEMAC commercial contracts of moderate value, a sole arbitrator, a seat within the OHADA space, proceedings in the language of the contract, and a short mandatory negotiation window before commencement produces a clause that is fast, enforceable and proportionate. Whatever you choose, choose it consciously.</p>
HTML,
        ],

        [
            'slug'     => 'foreign-investment-in-cameroon',
            'title'    => 'Foreign Investment in Cameroon: Structures, Incentives and Getting Profits Out',
            'category' => 'Investment',
            'author'   => 'Bar. Fonju Bernard',
            'date'     => '2026-05-28',
            'updated'  => '2026-05-28',
            'featured' => false,
            'tags'     => ['FDI', 'Investment incentives', 'CEMAC', 'Repatriation'],
            'excerpt'  => 'Investors ask about incentives first. They should ask about repatriation first, because that is the constraint that shapes the whole structure.',
            'body' => <<<'HTML'
<p>Cameroon is the largest economy in the CEMAC zone and the gateway to a hinterland of landlocked markets. For foreign investors the legal questions cluster into three: what vehicle to use, what incentives are available, and how returns are lawfully taken out. The third question should be asked first, because it constrains the answers to the other two.</p>

<h2>Choosing the vehicle</h2>
<p>Foreign investors typically use a locally incorporated subsidiary, a branch, or a joint venture with a Cameroonian partner. A subsidiary ring-fences liability, has a clean tax identity and is the structure lenders and counterparties expect. A branch avoids some formation steps but does not separate liability and has a limited authorised life. A joint venture brings local knowledge and, in some sectors, is effectively required — but it needs a shareholder agreement that deals honestly with deadlock, funding defaults and exit.</p>

<h2>Incentives</h2>
<p>Cameroon's investment incentive framework offers exemptions and reductions during an installation phase and, for qualifying projects, during operation. Benefits are typically tied to commitments on investment quantum, job creation and local sourcing, and are granted by convention rather than automatically. Two practical points:</p>
<ul>
  <li>Incentives are negotiated. What you obtain depends heavily on how the application is prepared and evidenced.</li>
  <li>Incentives carry obligations. Failing to meet the committed thresholds can trigger clawback, so the commitments in the file must match what the business will actually do.</li>
</ul>

<h2>Repatriation and exchange control</h2>
<p>CEMAC foreign exchange regulation governs transfers out of the zone, and it has become materially stricter. Dividends, loan repayments, royalties and management fees are all remittable, but each requires proper documentation, and each is examined for substance.</p>
<p>The practical consequences are worth stating plainly:</p>
<ul>
  <li>Register the inbound investment properly. Money that arrives undocumented is difficult to send back out.</li>
  <li>Intra-group service and royalty arrangements must be supported by real agreements and evidence of actual services, or they will be challenged on both exchange control and transfer pricing grounds.</li>
  <li>Shareholder loans should be documented from the outset, with terms that survive scrutiny on interest rate and thin capitalisation.</li>
</ul>

<h2>Sector authorisations</h2>
<p>Mining, petroleum, electricity, banking, insurance, telecommunications, gaming, health and transport all require sector authorisation in addition to company registration. Timelines for those authorisations, not incorporation, drive the project schedule.</p>

<h2>The diligence investors under-do</h2>
<p>In our experience, incoming investors diligence the commercial opportunity thoroughly and the legal foundations lightly. The items that most often cause post-closing problems are land title, employee classification and CNPS arrears, unregistered intellectual property, and undocumented related-party dealings. Each is cheap to check before signing and expensive to discover afterwards.</p>
HTML,
        ],

        [
            'slug'     => 'data-protection-cameroon-business',
            'title'    => 'Data Protection for Cameroonian Businesses: Where to Start',
            'category' => 'Technology',
            'author'   => 'Fonju Law Firm',
            'date'     => '2026-05-14',
            'updated'  => '2026-05-14',
            'featured' => false,
            'tags'     => ['Data protection', 'Privacy', 'Cybersecurity', 'Compliance'],
            'excerpt'  => 'Enterprise customers and foreign partners now refuse to contract without adequate data terms. Compliance has quietly become a sales requirement.',
            'body' => <<<'HTML'
<p>Personal data obligations in Cameroon arise from cybersecurity and electronic communications legislation, from sector rules in banking, telecoms and health, and increasingly from the contracts that customers and foreign partners insist on. Whatever the source, the practical starting point is the same.</p>

<h2>Step one: know what you hold</h2>
<p>Almost no organisation can answer, on request, what personal data it holds, where it is stored, who has access and why. Build a simple register: category of data, source, purpose, storage location, retention period, who it is shared with. This single document drives every other step and is the first thing a regulator or enterprise customer will ask for.</p>

<h2>Step two: state your basis and your purpose</h2>
<p>Data should be collected for a specified purpose and used for that purpose. Where consent is your basis, it must be informed, specific and capable of being withdrawn — a pre-ticked box or a term buried in general conditions is not consent. Where you rely on contract necessity or legal obligation, say so.</p>

<h2>Step three: publish a notice people can actually read</h2>
<p>A privacy notice written to be understood is more defensible than one written to be comprehensive. It should say who you are, what you collect, why, who you share it with, how long you keep it, whether it leaves the country, and how someone exercises their rights.</p>

<h2>Step four: fix the contracts</h2>
<p>Every vendor that touches personal data on your behalf — payroll bureau, cloud host, marketing agency, call centre — needs a written processing agreement covering purpose limitation, confidentiality, security, sub-processing, breach notification and deletion on termination. This is the gap we find most often in diligence.</p>

<h2>Step five: cross-border transfers</h2>
<p>Most Cameroonian businesses now use cloud services hosted abroad. Transfers are not prohibited, but they need to be identified, documented and supported by contractual safeguards. Discovering during a tender that your core systems export data with no documented basis is an avoidable problem.</p>

<h2>Step six: prepare for the incident</h2>
<p>Decide now who is called, in what order, when a breach is detected. An incident response plan of two pages that people have actually read beats a forty-page policy nobody has opened. Record decisions during an incident contemporaneously; that record is the evidence of reasonable behaviour afterwards.</p>

<h2>Why this is commercially urgent</h2>
<p>Data protection has moved from a compliance topic to a procurement gate. Multinational customers, development finance institutions and foreign platform partners will not onboard a supplier who cannot answer their data questionnaire. The organisations that did this work early are winning contracts because of it.</p>
HTML,
        ],

        [
            'slug'     => 'igaming-regulation-central-africa',
            'title'    => 'iGaming in Central Africa: What Operators Should Expect from the Regulator',
            'category' => 'iGaming',
            'author'   => 'Bar. Fonju Bernard',
            'date'     => '2026-04-30',
            'updated'  => '2026-04-30',
            'featured' => false,
            'tags'     => ['iGaming', 'Betting', 'Licensing', 'AML'],
            'excerpt'  => 'Online gaming is growing faster than the legislation written to govern it. Operators who engage early consistently secure better terms than those who regularise later.',
            'body' => <<<'HTML'
<p>Sports betting and online gaming have grown rapidly across Central Africa, largely on the back of mobile money. The regulatory framework has been catching up, often by applying rules designed for land-based venues to digital operations. Operators entering the market need to understand both what the rules say and how they are being applied.</p>

<h2>Start with the perimeter question</h2>
<p>Before anything else, establish precisely which of your activities require authorisation: taking bets, operating games of chance, supplying platform technology, aggregating content, processing player funds, or marketing. These are treated differently, and a supplier who assumes it is outside the perimeter because it does not hold player funds is making an assumption worth testing.</p>

<h2>Licensing in practice</h2>
<p>Applications generally require evidence of corporate substance, fit-and-proper assessment of beneficial owners and directors, technical certification of the platform and random number generation, financial standing, and a compliance framework covering anti-money-laundering, responsible gaming and player protection. Preparing that file well is most of the work; the review itself is comparatively predictable.</p>

<h2>Payments are the real pressure point</h2>
<p>An operator lives or dies on its ability to take deposits and pay winnings. Bank and mobile money partners apply their own risk assessment, and they will withdraw service quickly if a licence position is unclear. Payment arrangements need to be defensible under gaming regulation, financial services regulation and CEMAC exchange control simultaneously.</p>

<h2>Anti-money-laundering</h2>
<p>Gaming is a recognised money-laundering risk sector. Expect obligations covering customer identification, source of funds enquiry above thresholds, transaction monitoring, suspicious transaction reporting and record retention. Building this into onboarding from launch is far cheaper than retrofitting it after an inspection.</p>

<h2>Responsible gaming and advertising</h2>
<p>Age verification, self-exclusion, deposit limits and clear odds disclosure are becoming standard expectations. Advertising rules — particularly around targeting minors, promises of income and celebrity endorsement — are tightening across the region. Marketing that is acceptable in one jurisdiction can trigger enforcement in another.</p>

<h2>Tax</h2>
<p>Gaming taxation may be assessed on turnover, on gross gaming revenue, or on player winnings, with withholding obligations attached. The basis chosen has a dramatic effect on unit economics, and it should be modelled before market entry rather than discovered afterwards.</p>

<blockquote>Our consistent advice to operators: engage the regulator before you launch. The commercial terms available to an applicant are materially better than those available to a business being regularised after an enforcement action.</blockquote>
HTML,
        ],
    ];

    usort($posts, static fn(array $a, array $b): int => strcmp($b['date'], $a['date']));

    return $posts;
}

function blog_post(string $slug): ?array
{
    foreach (blog_posts() as $post) {
        if ($post['slug'] === $slug) {
            return $post;
        }
    }

    return null;
}

function blog_categories(): array
{
    $cats = [];

    foreach (blog_posts() as $post) {
        $cats[$post['category']] = ($cats[$post['category']] ?? 0) + 1;
    }

    ksort($cats);

    return $cats;
}

/** Up to $limit other posts, preferring the same category. */
function related_posts(array $post, int $limit = 3): array
{
    $same  = [];
    $other = [];

    foreach (blog_posts() as $candidate) {
        if ($candidate['slug'] === $post['slug']) {
            continue;
        }

        if ($candidate['category'] === $post['category']) {
            $same[] = $candidate;
        } else {
            $other[] = $candidate;
        }
    }

    return array_slice(array_merge($same, $other), 0, $limit);
}
