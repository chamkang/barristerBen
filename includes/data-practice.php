<?php
declare(strict_types=1);

/**
 * ---------------------------------------------------------------------------
 * PRACTICE AREAS
 * ---------------------------------------------------------------------------
 * Each entry becomes a card on /practice-areas.php and its own SEO-indexed
 * page at /practice/{slug}. To add an area, copy a block and change the slug.
 *
 * Keys
 *   slug      URL segment (lowercase, hyphens only)
 *   title     H1 and card title
 *   group     Used for the filter chips on the practice-areas page
 *   icon      Any key from icon() in functions.php
 *   short     One-line card blurb (also the meta description fallback)
 *   intro     Opening paragraph of the detail page
 *   services  Bullet list of concrete deliverables
 *   sections  Sub-headings with body copy
 *   featured  Shown in the "flagship" grid on the home page
 * ---------------------------------------------------------------------------
 */

function practice_areas(): array
{
    return [

        // ------------------------------------------------ Corporate & Commercial
        [
            'slug'  => 'corporate-law',
            'title' => 'Corporate & Commercial Law',
            'group' => 'Corporate & Commercial',
            'icon'  => 'building',
            'featured' => true,
            'short' => 'Company formation, governance, restructuring and day-to-day commercial counsel under the OHADA Uniform Acts.',
            'intro' => 'Corporate law is the backbone of our practice. We incorporate, structure and advise companies operating in Cameroon and across the CEMAC region, from single-shareholder SARLs to listed groups and foreign subsidiaries. Our work is grounded in the OHADA Uniform Act on Commercial Companies and Economic Interest Groups, and in the practical reality of how registries, banks and regulators actually behave in Douala and Yaoundé.',
            'services' => [
                'Incorporation of SARL, SA, SAS and branch offices, including RCCM registration',
                'Shareholder agreements, joint ventures and economic interest groupings (GIE)',
                'Board and general meeting procedure, minutes and corporate secretarial support',
                'Mergers, acquisitions, share transfers and legal due diligence',
                'Corporate restructuring, capital increases and reductions, and share buy-backs',
                'Commercial contracts: supply, distribution, agency, franchise and licensing',
                'Standing outside general counsel retainers for companies without in-house lawyers',
            ],
            'sections' => [
                ['h' => 'Corporate governance that survives scrutiny', 'p' => 'Good governance rests on four pillars: transparency, accountability, responsibility and fairness. We advise on board composition, the separation of ownership and management, shareholder rights and reserved matters, related-party transactions and financial reporting obligations, so that your governance framework holds up when a lender, an investor or a court examines it.'],
                ['h' => 'Distressed transactions and restructuring', 'p' => 'A company does not stop facing risk once it is operational. Partnership breakdowns, breach of contract, employment disputes, fraud and unfair competition claims all arrive without warning. We structure transactions to keep them out of court, and where litigation is unavoidable we make sure the paper trail was built to win.'],
                ['h' => 'Franchise and licensing', 'p' => 'Franchising is a form of licensing, so the franchisor must be able to grant a clean right to operate under its marks. We negotiate royalty percentages, exclusivity, territory and term, and our intellectual property team verifies that every mark, know-how package and software licence in the deal is properly registered and transferable in the OAPI region.'],
                ['h' => 'Start-ups and emerging companies', 'p' => 'Founders need more than incorporation documents. We help early-stage companies choose a structure that will not have to be unwound at the first funding round, put founder vesting and IP assignment in place, prepare data rooms, and negotiate with investors. We act as a strategic partner from the idea stage through growth.'],
                ['h' => 'E-commerce and digital trade', 'p' => 'Selling online exposes a business to consumer protection rules, payment regulation, data security obligations and cross-border tax questions all at once. We draft terms of sale, privacy notices and platform agreements, and advise on compliance with Cameroonian electronic commerce and personal data legislation.'],
            ],
        ],

        [
            'slug'  => 'arbitration-and-adr',
            'title' => 'Arbitration & Alternative Dispute Resolution',
            'group' => 'Disputes & Advisory',
            'icon'  => 'scale',
            'featured' => true,
            'short' => 'CCJA and ad hoc arbitration, mediation and negotiated settlements that resolve disputes without years in court.',
            'intro' => 'For commercial parties, arbitration is often faster, more confidential and more enforceable across borders than national litigation. We advise on arbitration clauses before the dispute exists, and we act as counsel in arbitrations seated in the OHADA space and beyond, including proceedings under the Rules of the Common Court of Justice and Arbitration (CCJA) in Abidjan.',
            'services' => [
                'Drafting and stress-testing arbitration and dispute resolution clauses',
                'Counsel in CCJA, ICC, GICAM and ad hoc arbitrations',
                'Emergency and interim relief before national courts in support of arbitration',
                'Recognition and enforcement of foreign arbitral awards in Cameroon',
                'Commercial mediation and structured settlement negotiation',
                'Expert determination and dispute boards for construction and supply contracts',
            ],
            'sections' => [
                ['h' => 'Why the clause matters more than the dispute', 'p' => 'Most arbitration problems are drafting problems. A clause that names a non-existent institution, sets an impossible tribunal composition or contradicts the governing law clause can cost a year of jurisdictional argument. We write clauses that are boring, precise and enforceable.'],
                ['h' => 'Enforcement across the OHADA space', 'p' => 'An award is only worth what you can collect. We advise on the exequatur process, on identifying and attaching assets, and on the interaction between the OHADA Uniform Act on Arbitration, the New York Convention and Cameroonian civil procedure.'],
                ['h' => 'Settlement as a commercial decision', 'p' => 'We assess every dispute against the cost of winning it. Where a negotiated exit preserves a commercial relationship or releases cash faster than a judgment would, we say so early and negotiate hard for terms that actually get performed.'],
            ],
        ],

        [
            'slug'  => 'litigation-and-settlements',
            'title' => 'Litigation & Settlements',
            'group' => 'Disputes & Advisory',
            'icon'  => 'gavel',
            'featured' => true,
            'short' => 'Advocacy before Cameroonian courts at every level, from Courts of First Instance to the Supreme Court.',
            'intro' => 'Our advocates appear regularly before the Courts of First Instance, High Courts, Courts of Appeal, the Supreme Court and specialised administrative and labour benches. We handle commercial, civil, administrative and criminal matters, and we prepare each case on the assumption that it will be fought to judgment, which is usually the fastest way to a good settlement.',
            'services' => [
                'Commercial and contractual disputes, including debt recovery and enforcement',
                'Civil claims: property, succession, family and personal injury',
                'Administrative litigation against public bodies and regulators',
                'Criminal defence and representation of victims (partie civile)',
                'Provisional and conservatory measures, injunctions and asset seizure',
                'Appeals, cassation and constitutional questions',
                'Judgment enforcement, garnishment and execution proceedings',
            ],
            'sections' => [
                ['h' => 'Case strategy before the first filing', 'p' => 'We open every matter with a written assessment: the legal merits, the evidence you actually hold, the realistic timetable, the recovery prospects and the cost. You decide whether to fight, settle or walk away on the basis of numbers, not optimism.'],
                ['h' => 'Bilingual advocacy', 'p' => 'Cameroon operates a bijural system, with common law procedure in the North West and South West regions and civil law procedure elsewhere. Our team pleads in both English and French and is comfortable in either tradition, which matters when a dispute spans regions.'],
                ['h' => 'Enforcement is part of the case', 'p' => 'A judgment that cannot be executed is a receipt for legal fees. We plan enforcement from the outset, using conservatory attachment, third-party garnishment and the OHADA Uniform Act on Simplified Recovery Procedures and Measures of Execution.'],
            ],
        ],

        // ------------------------------------------------ Finance & Regulatory
        [
            'slug'  => 'investments-and-securities',
            'title' => 'Investments & Securities',
            'group' => 'Finance & Regulatory',
            'icon'  => 'spark',
            'featured' => false,
            'short' => 'Fund formation, capital raising, securities regulation and investor protection in the CEMAC market.',
            'intro' => 'We advise issuers, investors, fund managers and intermediaries on raising and deploying capital in Central Africa. That includes public offerings and private placements on the regional market supervised by COSUMAF, as well as private equity, venture and development finance transactions with foreign sponsors.',
            'services' => [
                'Fund formation, structuring, regulation and taxation',
                'Public offers, private placements and bond issues',
                'Securities regulatory compliance and disclosure obligations',
                'Investment agreements, term sheets and shareholder protections',
                'Due diligence for institutional and development finance investors',
                'Investor dispute resolution and minority shareholder remedies',
            ],
            'sections' => [
                ['h' => 'Structuring for the exit', 'p' => 'The time to think about how an investor leaves is before the money arrives. We build drag-along, tag-along, pre-emption and put-option mechanics that are enforceable under OHADA company law rather than copied from a foreign precedent that will not survive a Cameroonian court.'],
                ['h' => 'Fundraising documentation', 'p' => 'We prepare partnership agreements, subscription documents, management and compensation agreements, and close fund formation transactions, coordinating with tax advisers and auditors so that the structure works commercially as well as legally.'],
            ],
        ],

        [
            'slug'  => 'banking',
            'title' => 'Banking & Finance',
            'group' => 'Finance & Regulatory',
            'icon'  => 'shield',
            'featured' => false,
            'short' => 'Lending, security, banking regulation and COBAC compliance for lenders and borrowers alike.',
            'intro' => 'We act for banks, microfinance institutions, borrowers and guarantors on financing transactions and on the regulatory framework administered by COBAC and the BEAC. Our work covers the full lifecycle of a credit, from term sheet to security registration to enforcement.',
            'services' => [
                'Loan and facility agreements, syndicated and bilateral',
                'Security packages: mortgages, pledges, sureties and OHADA guarantees',
                'Registration and perfection of security at the RCCM',
                'Banking regulatory advice, licensing and COBAC compliance',
                'Anti-money-laundering and know-your-customer frameworks',
                'Debt restructuring, recovery and enforcement of security',
                'Microfinance and mobile money regulatory advice',
            ],
            'sections' => [
                ['h' => 'Security that is actually perfected', 'p' => 'The OHADA Uniform Act on Securities sets strict formalities and registration deadlines. A pledge that is not registered in time ranks behind creditors who did the paperwork. We manage perfection as a project with dates, not as an afterthought at signing.'],
                ['h' => 'Regulatory reality', 'p' => 'Prudential ratios, foreign exchange rules and the CEMAC exchange control regulation shape what a transaction can look like long before the lawyers reach the covenants. We flag those constraints in the first meeting.'],
            ],
        ],

        [
            'slug'  => 'financial-services',
            'title' => 'Financial Services & Fintech',
            'group' => 'Finance & Regulatory',
            'icon'  => 'globe',
            'featured' => false,
            'short' => 'Payment services, mobile money, digital lending and the licensing pathways that make them lawful.',
            'intro' => 'Financial services in Cameroon are being reshaped by mobile money, agency banking and digital credit. We help operators, banks and technology providers understand where they sit in the regulatory perimeter, obtain the right authorisations and design products that regulators will accept.',
            'services' => [
                'Payment service provider and e-money licensing strategy',
                'Partnership agreements between banks, telcos and fintech providers',
                'Consumer credit, digital lending and interest rate compliance',
                'Data protection and consent frameworks for financial data',
                'Agent network agreements and liability allocation',
                'Regulatory engagement with BEAC, COBAC and the Ministry of Finance',
            ],
            'sections' => [
                ['h' => 'Licence first, launch second', 'p' => 'The most expensive fintech mistake in the region is launching a product that turns out to require an authorisation the company does not hold. We map your product against the regulatory perimeter before you write the code.'],
                ['h' => 'Cross-border payments and FX', 'p' => 'CEMAC foreign exchange regulation governs repatriation, settlement and cross-border transfers. Products that move value across the CEMAC boundary need to be designed around those rules from the start.'],
            ],
        ],

        [
            'slug'  => 'insurance',
            'title' => 'Insurance Law',
            'group' => 'Finance & Regulatory',
            'icon'  => 'shield',
            'featured' => false,
            'short' => 'CIMA Code compliance, policy drafting, broking regulation and contested claims.',
            'intro' => 'Insurance in Cameroon is governed by the CIMA Code, a regional instrument applying across fourteen African states. We advise insurers, reinsurers, brokers and policyholders on product design, regulatory compliance and disputed claims.',
            'services' => [
                'Policy wording, endorsements and product approval under the CIMA Code',
                'Insurance and reinsurance broking regulation and licensing',
                'Claims handling, coverage opinions and subrogation',
                'Contested claim litigation and bad-faith allegations',
                'Marine, aviation, construction and professional indemnity cover',
                'Bancassurance and distribution agreements',
            ],
            'sections' => [
                ['h' => 'Coverage disputes turn on wording', 'p' => 'Most contested claims are decided on exclusions, conditions precedent and notification clauses rather than on the headline peril. We review wording with that in mind, both when drafting a policy and when defending or pursuing a claim under one.'],
                ['h' => 'Premium payment and the cash-before-cover rule', 'p' => 'The CIMA Code ties cover to premium payment in ways that surprise foreign insureds. We make sure clients understand exactly when their cover attaches.'],
            ],
        ],

        [
            'slug'  => 'tax-and-customs',
            'title' => 'Tax & Customs',
            'group' => 'Finance & Regulatory',
            'icon'  => 'doc',
            'featured' => false,
            'short' => 'Corporate tax structuring, VAT, transfer pricing, customs classification and tax dispute defence.',
            'intro' => 'Tax exposure is created by decisions taken long before a return is filed: how a group is structured, how contracts allocate risk, how goods are classified at the port. We advise on tax-efficient structures that stand up to audit, and we defend clients through the audit and litigation process.',
            'services' => [
                'Corporate income tax, VAT and withholding tax advice',
                'Transfer pricing documentation and intra-group agreements',
                'Double taxation treaty analysis and relief claims',
                'Tax audits, reassessments and administrative appeals',
                'Customs classification, valuation and duty relief',
                'Investment incentive regimes and negotiated tax conventions',
            ],
            'sections' => [
                ['h' => 'Structure before optimisation', 'p' => 'Aggressive optimisation on top of a weak structure fails at the first audit. We start with the commercial substance and build a position that can be documented and defended.'],
                ['h' => 'Surviving a reassessment', 'p' => 'Cameroonian tax procedure has short, strict deadlines for responding to a notice of reassessment. Missing one can forfeit arguments entirely. We manage the calendar and the correspondence.'],
            ],
        ],

        [
            'slug'  => 'bankruptcy-and-insolvency',
            'title' => 'Bankruptcy & Insolvency',
            'group' => 'Disputes & Advisory',
            'icon'  => 'scale',
            'featured' => false,
            'short' => 'Preventive settlement, judicial reorganisation, liquidation and creditor recovery under OHADA.',
            'intro' => 'The OHADA Uniform Act organising collective proceedings offers real tools for a business in difficulty, but only if they are used early. We advise directors, creditors and insolvency practitioners on preventive settlement (règlement préventif), judicial reorganisation (redressement judiciaire) and liquidation of assets.',
            'services' => [
                'Preventive settlement applications and conciliation with creditors',
                'Judicial reorganisation plans and continuation strategies',
                'Liquidation of assets and realisation of security',
                'Director liability and wrongful trading exposure',
                'Creditor claim filing, ranking and committee representation',
                'Cross-border insolvency and asset tracing',
            ],
            'sections' => [
                ['h' => 'Directors run out of options quietly', 'p' => 'By the time cash flow has failed, most preventive routes have closed and personal liability exposure has grown. We would rather have an early, confidential conversation than a late, expensive one.'],
                ['h' => 'Creditors: file properly or lose the claim', 'p' => 'Collective proceedings impose short claim-filing windows and strict proof requirements. We ensure claims are lodged, secured status is asserted and ranking is protected.'],
            ],
        ],

        // ------------------------------------------------ People & Innovation
        [
            'slug'  => 'labour-and-employment',
            'title' => 'Labour & Employment',
            'group' => 'People & Innovation',
            'icon'  => 'users',
            'featured' => true,
            'short' => 'Contracts, collective agreements, dismissals, expatriate staffing and labour inspectorate disputes.',
            'intro' => 'The Cameroonian Labour Code is protective of employees and procedurally demanding of employers. Most employer losses are procedural rather than substantive. We build employment documentation and dismissal processes that hold, and we represent both employers and employees in labour disputes.',
            'services' => [
                'Employment contracts, fixed-term and indefinite, and probation clauses',
                'Staff handbooks, internal rules (règlement intérieur) and disciplinary procedure',
                'Collective bargaining agreements and works council relations',
                'Redundancy, restructuring and economic dismissal procedures',
                'Expatriate work permits, visas and CNPS registration',
                'Labour inspectorate conciliation and labour court litigation',
                'Restrictive covenants, confidentiality and IP assignment by employees',
            ],
            'sections' => [
                ['h' => 'Dismissal is a procedure, not a decision', 'p' => 'A justified dismissal carried out without the required notice, hearing and inspectorate steps will still be found abusive. We take employers through the sequence in writing so the file is complete before anyone is told anything.'],
                ['h' => 'Social security and payroll exposure', 'p' => 'CNPS contributions, occupational risk cover and payroll tax create liabilities that surface years later during an inspection. We audit payroll classification and contractor arrangements before an inspector does.'],
                ['h' => 'Employees have rights worth asserting', 'p' => 'We also act for employees in unfair dismissal, unpaid entitlement and workplace harassment matters, and we pursue them through conciliation and the labour courts.'],
            ],
        ],

        [
            'slug'  => 'intellectual-property',
            'title' => 'Intellectual Property',
            'group' => 'People & Innovation',
            'icon'  => 'spark',
            'featured' => true,
            'short' => 'OAPI trade marks, patents and designs, copyright, trade secrets and enforcement against counterfeits.',
            'intro' => 'Cameroon is a member of the African Intellectual Property Organisation (OAPI), which means a single filing can secure protection across seventeen member states. We handle registration, portfolio management, licensing and enforcement, and we act quickly against counterfeiting and passing off.',
            'services' => [
                'OAPI trade mark, patent, utility model and industrial design filings',
                'Portfolio management, renewals, oppositions and cancellations',
                'Copyright protection, collective management and author contracts',
                'Trade secret and know-how protection frameworks',
                'IP licensing, assignment and technology transfer agreements',
                'Anti-counterfeiting: seizure, customs recordal and infringement actions',
                'Domain name and brand protection online',
            ],
            'sections' => [
                ['h' => 'One filing, seventeen countries', 'p' => 'The OAPI system is a genuine commercial advantage for regional brands, but it is unforgiving about classification and priority dates. We prepare specifications with an eye on where the business will be in five years, not only where it is now.'],
                ['h' => 'Enforcement that changes behaviour', 'p' => 'Counterfeiting responds to consequences. We combine customs recordal, seizure applications and civil infringement actions, and we advise on when a criminal complaint adds leverage.'],
                ['h' => 'IP inside deals', 'p' => 'In acquisitions and financings, IP is often the asset that is assumed rather than verified. We audit chain of title, employee assignments and licence assignability before the money moves.'],
            ],
        ],

        [
            'slug'  => 'immigration-and-naturalisation',
            'title' => 'Immigration & Naturalisation',
            'group' => 'People & Innovation',
            'icon'  => 'globe',
            'featured' => false,
            'short' => 'Visas, residence permits, work authorisation, naturalisation and corporate mobility programmes.',
            'intro' => 'We assist individuals and employers with entry, stay and work authorisation in Cameroon, and with the naturalisation process. For corporate clients we run mobility programmes covering assignment documentation, permits and dependants.',
            'services' => [
                'Short-stay, business and long-stay visa applications',
                'Residence permits (carte de séjour) and renewals',
                'Work authorisation and employment contract visa endorsement',
                'Investor and entrepreneur immigration pathways',
                'Naturalisation and citizenship applications',
                'Family reunification and dependant permits',
                'Corporate mobility policy and compliance audits',
            ],
            'sections' => [
                ['h' => 'Documentation is the whole case', 'p' => 'Immigration files fail on missing or improperly legalised documents far more often than on eligibility. We give clients a precise checklist, verify each document before submission and follow the file through.'],
                ['h' => 'Employer compliance', 'p' => 'Employing a foreign national without proper authorisation exposes the employer, not only the employee. We audit existing staff, regularise where possible and put a compliant onboarding process in place.'],
            ],
        ],

        [
            'slug'  => 'information-technology-and-telecommunications',
            'title' => 'Technology, Data & Telecoms',
            'group' => 'People & Innovation',
            'icon'  => 'globe',
            'featured' => true,
            'short' => 'Software and SaaS contracts, personal data protection, cybersecurity, licensing and telecoms regulation.',
            'intro' => 'Technology raises legal questions faster than legislation answers them. We advise technology companies, and companies that depend on technology, on contracting, personal data, cybersecurity obligations and telecommunications licensing under the supervision of the ART and the ANTIC.',
            'services' => [
                'Software development, SaaS, hosting and reseller agreements',
                'Personal data protection policies, notices and processing agreements',
                'Cybersecurity compliance and incident response planning',
                'Telecommunications licensing and interconnection agreements',
                'Electronic signature, electronic evidence and digital contracting',
                'Technology transfer, escrow and open source compliance',
                'Platform terms of service, acceptable use and content moderation policies',
            ],
            'sections' => [
                ['h' => 'Data protection is now a commercial gate', 'p' => 'Enterprise customers and foreign partners increasingly refuse to contract without adequate data protection terms. Getting your processing basis, notices and transfer mechanics right is a sales enabler, not just a compliance cost.'],
                ['h' => 'Contracting for software that does not exist yet', 'p' => 'Development contracts fail on scope, acceptance and IP ownership. We write acceptance criteria and change control that survive the moment the project runs late.'],
            ],
        ],

        [
            'slug'  => 'igaming-and-betting',
            'title' => 'iGaming & Betting Regulation',
            'group' => 'People & Innovation',
            'icon'  => 'spark',
            'featured' => false,
            'short' => 'Licensing, compliance and structuring for online gaming, sports betting and lottery operators in Central Africa.',
            'intro' => 'Digital gaming legislation across Central Africa is evolving quickly, and operators are frequently asked to comply with rules that were written for land-based venues. Fonju Law Firm has built a dedicated iGaming consultancy practice to help operators, platform providers and payment partners enter the market lawfully and stay there.',
            'services' => [
                'Gaming and betting licence applications and renewals',
                'Regulatory gap analysis for operators entering the CEMAC market',
                'Player terms, responsible gaming and age verification frameworks',
                'Payment, settlement and anti-money-laundering compliance for operators',
                'Platform, aggregator and content supply agreements',
                'Advertising, sponsorship and marketing compliance',
                'Regulator engagement and enforcement defence',
            ],
            'sections' => [
                ['h' => 'A market that rewards early compliance', 'p' => 'Operators who engage with the regulator before launching consistently secure better terms than those who regularise after an enforcement action. We track legislative developments continuously so our advice reflects the position this quarter, not last year.'],
                ['h' => 'Payments are the pressure point', 'p' => 'Gaming operators live or die on their ability to accept deposits and pay winnings. We structure payment arrangements with banks, mobile money providers and aggregators so that the flow of funds is defensible under both gaming and financial regulation.'],
            ],
        ],

        // ------------------------------------------------ Industry & Infrastructure
        [
            'slug'  => 'real-estate-and-property',
            'title' => 'Real Estate & Property',
            'group' => 'Industry & Infrastructure',
            'icon'  => 'building',
            'featured' => false,
            'short' => 'Land title verification, acquisitions, leases, construction contracts and property disputes.',
            'intro' => 'Land is the most commonly disputed asset in Cameroon, and the most commonly mis-sold. We verify title before money moves, structure acquisitions and developments, and litigate when title, boundaries or possession are contested.',
            'services' => [
                'Land title (titre foncier) verification and due diligence',
                'Sale, purchase and transfer of land and buildings',
                'Commercial and residential leases, and lease disputes',
                'Property development, construction and contractor agreements',
                'Land registration, subdivision and conversion of customary rights',
                'Expropriation for public purpose and compensation claims',
                'Boundary, possession and co-ownership disputes',
            ],
            'sections' => [
                ['h' => 'Verify the title, then verify the seller', 'p' => 'A genuine title held by someone who is not entitled to sell is the most common trap in Cameroonian property transactions. We check the register, the chain of transmission, the matrimonial and succession position of the seller, and any encumbrances, before a deposit is paid.'],
                ['h' => 'Development and construction', 'p' => 'We prepare development agreements, contractor and consultant appointments, and payment and defects regimes, and we advise on permitting and on liability for construction defects.'],
            ],
        ],

        [
            'slug'  => 'maritime-and-shipping',
            'title' => 'Maritime & Shipping',
            'group' => 'Industry & Infrastructure',
            'icon'  => 'globe',
            'featured' => true,
            'short' => 'Charterparties, cargo claims, vessel arrest, port operations and marine casualty response in the Gulf of Guinea.',
            'intro' => 'Douala is the principal port of the CEMAC hinterland, serving Cameroon, Chad and the Central African Republic. Our maritime lawyers provide a comprehensive service to the shipping industry, with a deep understanding of how the sector actually works in the region: the Merchant Marine Community Code, port practice, and the commercial realities of freight, forwarding, agency, cargo handling, container depots, storage and warehousing.',
            'services' => [
                'Charterparties, bills of lading and contracts of affreightment',
                'Cargo claims, shortage, damage and misdelivery disputes',
                'Vessel arrest and release, and security for maritime claims',
                'Ship registration, mortgages and sale and purchase',
                'Collision, salvage, general average and marine casualty response',
                'Port services, terminal and stevedoring agreements',
                'Freight forwarding, agency and logistics contracts',
                'Marine insurance and P&I correspondence',
            ],
            'sections' => [
                ['h' => 'Arrest as leverage', 'p' => 'The credible threat of arrest in Douala concentrates minds quickly. We advise on whether a claim is maritime in nature, prepare the application, and act on urgent instructions including outside business hours.'],
                ['h' => 'Cargo interests and carriers', 'p' => 'We act on both sides of cargo disputes. That gives us a realistic view of where a claim will settle and of the time bars, notification requirements and package limitations that decide many of them before the merits are reached.'],
            ],
        ],

        [
            'slug'  => 'aviation',
            'title' => 'Aviation',
            'group' => 'Industry & Infrastructure',
            'icon'  => 'globe',
            'featured' => false,
            'short' => 'Aircraft leasing and finance, operator licensing, regulatory compliance and passenger claims.',
            'intro' => 'We advise airlines, lessors, ground handlers and financiers on aviation matters in Cameroon, including registration and deregistration of aircraft, the Cape Town Convention framework, operator certification and the civil aviation regulatory regime supervised by the CCAA.',
            'services' => [
                'Aircraft operating and finance leases, and lease enforcement',
                'Aircraft registration, deregistration and IDERA support',
                'Air operator certification and regulatory licensing',
                'Ground handling, maintenance and interline agreements',
                'Passenger and cargo liability claims under the Montreal Convention',
                'Airport concession and infrastructure agreements',
            ],
            'sections' => [
                ['h' => 'Repossession planning', 'p' => 'Lessors care about one question above all: can the aircraft be recovered if the lessee defaults. We advise on the practical deregistration and export route and on the documentation that makes it work under pressure.'],
            ],
        ],

        [
            'slug'  => 'transport-and-logistics',
            'title' => 'Transport & Logistics',
            'group' => 'Industry & Infrastructure',
            'icon'  => 'globe',
            'featured' => false,
            'short' => 'Road and rail carriage, corridor transit, warehousing, customs clearance and freight liability.',
            'intro' => 'The Douala–NDjamena and Douala–Bangui corridors carry the trade of three countries. We advise carriers, shippers, forwarders and warehouse operators on the contracts, liability regimes and transit formalities that govern the movement of goods across the region.',
            'services' => [
                'Carriage of goods by road contracts and the OHADA transport regime',
                'Freight forwarding, consolidation and multimodal transport documents',
                'Transit, corridor and customs clearance arrangements',
                'Warehousing, bonded storage and inventory financing',
                'Cargo loss, damage and delay claims',
                'Fleet operations, driver employment and road safety compliance',
            ],
            'sections' => [
                ['h' => 'Who bears the loss, and when', 'p' => 'Liability in a multimodal movement shifts between parties at points that are rarely defined clearly in the paperwork. We align the contracts across the chain so a loss does not become an argument about which document governs.'],
            ],
        ],

        [
            'slug'  => 'mining-and-energy',
            'title' => 'Mining & Energy',
            'group' => 'Industry & Infrastructure',
            'icon'  => 'spark',
            'featured' => false,
            'short' => 'Exploration and mining titles, petroleum contracts, power projects, renewables and environmental compliance.',
            'intro' => 'Cameroon holds significant mineral, hydrocarbon and hydro resources, and the legal framework governing them combines the Mining Code, the Petroleum Code, the Electricity Law and a demanding environmental regime. We advise investors, operators and contractors from licence application through development to decommissioning.',
            'services' => [
                'Exploration permits, mining licences and artisanal authorisation',
                'Mining conventions and negotiations with the State',
                'Petroleum production sharing and service contracts',
                'Power purchase agreements and independent power projects',
                'Renewable energy, solar and mini-grid project development',
                'Environmental and social impact assessment compliance',
                'Local content, community relations and CSR agreements',
                'Mining and energy sector disputes',
            ],
            'sections' => [
                ['h' => 'The licence is the beginning', 'p' => 'Holding a title is not the same as being able to operate on it. Surface rights, community agreements, environmental permits and local content commitments all have to be secured in parallel, and a gap in any of them can stop a project.'],
                ['h' => 'Environmental and social exposure', 'p' => 'Lenders and offtakers now diligence environmental and social performance as hard as they diligence title. We build compliance that satisfies both the Cameroonian regulator and international finance standards.'],
            ],
        ],

        [
            'slug'  => 'health-care',
            'title' => 'Health Care & Life Sciences',
            'group' => 'Industry & Infrastructure',
            'icon'  => 'shield',
            'featured' => false,
            'short' => 'Clinic and pharmaceutical regulation, medical liability, product approval and health data protection.',
            'intro' => 'We advise hospitals, clinics, pharmaceutical distributors, medical device suppliers and health technology companies on regulatory approval, professional liability and the handling of sensitive health data.',
            'services' => [
                'Health facility licensing and professional regulation',
                'Pharmaceutical and medical device registration and distribution',
                'Medical negligence claims, defence and professional discipline',
                'Clinical trial agreements and research ethics compliance',
                'Health data protection and patient confidentiality',
                'Health insurance, mutual and third-party payer arrangements',
                'Public health procurement and donor-funded programmes',
            ],
            'sections' => [
                ['h' => 'Consent, records and liability', 'p' => 'In most medical claims the outcome turns on the quality of the consent process and the clinical record. We help institutions build documentation practice that protects clinicians and patients alike.'],
            ],
        ],

        [
            'slug'  => 'media-sports-and-creative-industry',
            'title' => 'Media, Sports & Creative Industry',
            'group' => 'People & Innovation',
            'icon'  => 'star',
            'featured' => false,
            'short' => 'Artist and athlete representation, image rights, broadcasting, sponsorship and content licensing.',
            'intro' => 'Cameroon produces exceptional athletic and creative talent, and too much of it is contracted on terms that give away value permanently. We act for artists, musicians, athletes, clubs, agents, producers and broadcasters, and we negotiate deals that leave the talent owning what it created.',
            'services' => [
                'Recording, publishing, distribution and management agreements',
                'Player contracts, transfers, agency and image rights',
                'Sponsorship, endorsement and brand ambassador agreements',
                'Broadcasting, streaming and content licensing',
                'Film and television production, financing and clearance',
                'Defamation, privacy and press regulation',
                'Sports governance, disciplinary and eligibility disputes',
            ],
            'sections' => [
                ['h' => 'Own your catalogue', 'p' => 'The single most valuable clause in a creative contract is the one that says who owns the work and for how long. We negotiate reversion, territory and term rather than accepting perpetual worldwide assignments as standard.'],
                ['h' => 'Athletes and mobility', 'p' => 'Transfers involving Cameroonian athletes engage club regulations, national federation rules, immigration and tax all at once. We coordinate the whole file so a move does not collapse on a technicality.'],
            ],
        ],
    ];
}

/** Look up a single practice area by slug. */
function practice_area(string $slug): ?array
{
    foreach (practice_areas() as $area) {
        if ($area['slug'] === $slug) {
            return $area;
        }
    }

    return null;
}

/** Distinct group names, in the order they first appear. */
function practice_groups(): array
{
    $groups = [];

    foreach (practice_areas() as $area) {
        if (!in_array($area['group'], $groups, true)) {
            $groups[] = $area['group'];
        }
    }

    sort($groups);

    return $groups;
}

function featured_practice_areas(): array
{
    return array_values(array_filter(practice_areas(), static fn(array $a): bool => !empty($a['featured'])));
}
