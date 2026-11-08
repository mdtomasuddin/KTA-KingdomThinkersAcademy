# KTA Plus Platform Development Handover

## *Platform logic  Recorded changes  Team recovery priorities*

Prepared for Masum, Tofayel, Badhon and the replacement development team

Product decision owner  Kale Kneale

Revision 3.2  \|  Oct 5, 2026

This handover explains how KTA+ connects learning, marketplace transactions, educator operations and organisation delivery. It preserves dated decisions, identifies conflicts and gives the team concrete workflows to demonstrate before production acceptance.

Start with Revision 3 key decisions, then roles, token policy and dated build status. Use the decision register to resolve commercial and permission rules, and the acceptance scenarios to review the actual build.

# **Contents**

[Purpose and immediate priorities](#bookmark=id.51sk87jwnaps)

[Revision 3 Key decisions now established](#bookmark=id.ckf9mivpmevh)

[1 The product and its connected parts](#bookmark=id.nfwczbm9mneh)

[2 People roles and access boundaries](#bookmark=id.ybu3y3skq3v0)

[3 Family onboarding and the parent dashboard](#bookmark=id.6dgtgi59b5db)

[4 The shared course and content system](#bookmark=id.v2p8u3nptmyl)

[5 Premium programs and package logic](#bookmark=id.7oyux1oaf086)

[6 Program Summary and the inquiry framework](#bookmark=id.oii9lh2om1xi)

[7 iProject International in detail](#bookmark=id.175gfxllaaqo)

[8 Marketplace listings resources and licensing](#bookmark=id.rhj05rr11st7)

[9 Subscriptions tokens expiry and reactivation](#bookmark=id.7jmb6l8jisi3)

[10 Payments enrolments and educator payouts](#bookmark=id.vmwucmsy3dcb)

[11 Teacher Module and Compliance Hub](#bookmark=id.moldpyz05ip0)

[12 Co-op workflows and group licences](#bookmark=id.yhpy1jewvv5x)

[13 Micro-school workflows — authoritative v1](#bookmark=id.i7ye4u3tte6w)

[14 KTA Plus Institute and educator recognition](#bookmark=id.cgqr3erav2bt)

[15 Scheduling session records and notifications](#bookmark=id.7q0qawytl88x)

[16 Existing tools integrations and migration](#bookmark=id.t0kjwpmn59b5)

[17 Proposed domain model and lifecycle contracts](#bookmark=id.y56ufydnaa6o)

[18 Implementation invariants and failure handling](#bookmark=id.56mm8a5l0p2q)

[19 Dated development progress and verification needs](#bookmark=id.1xfut6a7x7ss)

[20 Change history the team must preserve](#bookmark=id.oxnpjyxvdzky)

[21 Decisions required before production acceptance](#bookmark=id.l4l719iu2mmq)

[22 Repository infrastructure and knowledge recovery](#bookmark=id.cj6tdqfyqnu3)

[23 Acceptance scenarios and demonstration order](#bookmark=id.jb6dtgwnb1e7)

[24 Team working agreement and near term roadmap](#bookmark=id.r7kpfnsr6ch9)

[25 Source register and review coverage](#bookmark=id.xb75y73azayc)

[26 Full SaaS scope reconciliation](#bookmark=id.tp0f6a8zl2no)

[27 Initial project overview review](#bookmark=id.2o7rfuo00lsp)

[28 Robin May 26 delivery baseline](#bookmark=id.emwejqtqdywo)

[Appendix KTA Plus file inventory](#bookmark=id.pjd5m98vqses)

[Appendix Original records needed for final reconciliation](#bookmark=id.fshtn66i0grj)

# **Purpose and immediate priorities**

Prepared for Masum, Tofayel, Badhon and the replacement development team, with Kale Kneale as product decision owner. Reference date Oct 5, 2026\. Revision 3.1 adds review of the initial journey overview alongside the full SaaS scope and the developers' January 7 curriculum explanation, while preserving the later v1 decisions and separate premium/token subscriptions.

KTA+ brings family accounts, learning programs, an educator marketplace, resources, token purchasing, community learning and organisation delivery into one ecosystem. The team needs to preserve the relationships between these features as it takes over Robin's work. A working dashboard is only one part of completion: permissions, purchased access, teaching workflows, reporting and settlement must work together.

The immediate sequence recorded in the September handover discussion is Teacher Module, payouts, Compliance Hub and settings. Recover the current repository and deployment knowledge first, then verify each of those modules against real end-to-end examples. Existing resource management, courses/programs and the parent, teacher, student and admin dashboards were reported as completed. These are reported statuses, not acceptance results. \[H17\]

The central product distinctions are family versus student identity; marketplace purchases versus premium program enrolment; reusable curriculum versus its delivery to a cohort; marketplace revenue share versus contracted program educator fees; and platform access versus permission to use content with a group. These distinctions should appear in the data model and backend checks, not merely in navigation labels.

## **Evidence labels used throughout**

| Label | Meaning | How the team should use it |
| ----- | :---- | :---- |
| Authoritative v1 clarification | Explicit correspondence supplied by Kale and designated final for v1 | Apply to the stated scope; retire conflicting older proposals |
| Recorded requirement | An explicit user instruction recovered from dated prior discussions | Preserve unless Kale records a later change |
| Historical draft | An earlier assistant-generated specification or suggested response | Review as design context; do not treat as signed approval |
| Reported progress | A development status recorded in correspondence or prior discussion | Verify with repository evidence and a workflow demonstration |
| Current public copy | Information visible on the pricing page on Oct 5, 2026 | Reconcile with checkout configuration and approved product rules |
| Proposed engineering design | Implementation guidance developed for this handover | Review against existing code before adoption |
| Decision needed | A conflict, missing rule or unanswered clarification | Record owner, answer, date and affected modules |

The source register at the end identifies the evidence behind each reference. Dated historical drafts remain labelled even when their design is useful. The engineering sections describe a proposed implementation contract; they do not claim to reproduce Robin's actual schema or APIs.

# **Revision 3 Key decisions now established**

The earlier update incorporated two primary sources: the full 4484-line developer correspondence supplied as Pasted text.txt \[N01\], and Kale's additional program, educator, co-op visibility and micro-school clarifications supplied with this update \[N02\]. N01 contains dated messages from May through 5 October, with explicit 2026 references; N02 contains several undated v1 statements and a section marked 15 June. Undated statements are recorded as supplied on 5 October, without inventing their original send dates.

## **Authority and supersession**

Apply statements explicitly designated final or authoritative for v1 within their stated scope. The final provider clarification excludes external organisations, superseding the older micro-school flow's phrase third-party marketplace programs: in v1 this means approved courses/resources from independent educators already on KTA+. It does not create an external provider onboarding route. Marketplace educators are not KTA+ employees or platform-owned content creators merely because their products are approved.

The final micro-school curriculum rule excludes school-local authoring and uploading. This retires the recommended Content Specialist role's upload capability inside a micro-school. It does not remove the separately authorised platform educator's marketplace builder or the AdminTeacher premium builder. A person with both roles must use the appropriate context and permission.

| Area | Clarified rule | Impact on the build |
| ----- | :---- | :---- |
| Family premium and tokens | Premium enrolment and optional token subscription coexist independently | No token payment for premium; separate billing and cancellation |
| Program providers | KTA+ Premium and approved independent platform educators only; no external organisations in v1 | No external provider entity or submission route required for v1 |
| Micro-school premium access | All available KTA+ Premium Programs included; no extra purchase to enable | Subscription entitlement precedes local enablement and class assignment |
| Micro-school marketplace access | Each course/resource bought separately by school admin | Purchase unlocks access; enablement is a separate school action |
| Curriculum | Centrally maintained and read-only within micro-schools | Local staff can facilitate, pace and report, but cannot alter structure |
| Micro-school billing | Owner pays KTA+ B2B subscription; tuition and local teacher pay remain external | No platform tuition collection, split, escrow or local teacher payroll in v1 |
| Self-paced creation | Convert a completed group live course OR start a new blank course | Direct creation must not require a prior live cohort |
| Educator identity | Approval, educator type and certification are independent | Separate state records, controls and visible badges |
| Co-op visibility | Public, Unlisted or Invite-Only; all joining approval-based | Discoverability never grants member or child-data access |
| Program Summary | Course-specific for premium KTA/iProject; ordinary marketplace self-paced courses do not need it | Course summary before modules in the authoring sequence |
| Geography | Co-ops AU and US; micro-schools US only | Region-aware onboarding and frontend offerings |

## **How the micro-school pieces work together**

Platform-level educator eligibility makes an educator available for consideration. The micro-school admin chooses and links the educator, then assigns that educator to a class instance. The school subscription provides premium curriculum entitlement; a separate school purchase provides marketplace entitlement. Enabling an entitled program exposes it for school use. A class instance links the approved program to teacher, schedule and enrolled students. Teacher, parent and student dashboards display only the records allowed by those relationships. Tuition and local teacher wages sit outside this transaction chain. \[N02\]

Optional KTA+ Premium Educator support is a separate program service arrangement with KTA+/TTN LLC. Such educators are assigned to the premium program and are not automatically staff of the micro-school. The dashboard should direct enquiries to admin@thetransformationnetwork.us; that contact instruction does not establish a new checkout, fee or automatic staffing allocation. \[N02\]

## **Remaining conflicts within the new material**

The authoritative micro-school dashboard defines fixed v1 roles Admin, Teacher and Parent. The recommended onboarding model suggests additional Lead, Assistant, Content Specialist and Coordinator roles. Treat those additional role names as recommendations pending scope confirmation; do not silently build a second school admin role. The final read-only curriculum rule already resolves the suggested local Content Specialist upload right: exclude it.

The recommended model allows teacher applications as a secondary path, while the definitive flow describes admin invitations. A teacher application, if retained, must be a pending request requiring school approval and cannot self-assign a teacher. Confirm whether this secondary entry path is required for launch.

The guidance says assistants may have configurable clearance, but also requires clearance whenever a person has direct child interaction, including feedback or messaging. Interactive duties must trigger the clearance gate regardless of an Assistant label. The exact policy, evidence requirements, expiry behaviour and non-interactive access remain to be approved by the policy owner. These are product requirements and proposals, not a legal assurance.

Micro-school family approval and external tuition are both described as access conditions, but the later detailed flow activates the family upon approval. KTA+ does not observe tuition automatically. Confirm whether school admins manually attest payment/enrolment before activation or whether approval alone activates platform membership. Student approval and class enrolment remain separate subsequent actions.

Some micro-school wording says all premium programs are available platform-wide, while July correspondence restricts KTA courses by AU/US/Global. Preserve geography restrictions for direct family KTA enrolments. Confirm whether all available for a US micro-school means all US/Global eligible premium courses or overrides those course-level restrictions. Do not silently override regional rules.

Premium KTA was confirmed on 14 July to support Group Live, Self-Paced, One-to-One, Co-op and Micro School types. The 17 August answer excludes Program Summary for self-paced marketplace courses and reserves it for premium KTA/iProject. Do not apply that exclusion to every self-paced premium course; confirm the precise builder flag for premium self-paced delivery. \[N01\]

## **Immediate work for the replacement team**

Use the dated progress ledger in Section 19 to identify what was reported as API work, page development, design-only work or deferred work. Replay the referenced demonstrations and map each claim to current commits and deployed behaviour. Prove the premium and marketplace authoring paths, school entitlement/enablement/classes, independent educator statuses and payment separation before declaring the corresponding modules complete.

The 5 October record confirms a 42-minute meeting occurred. It contains no transcript or written recap of that call. Obtain its decisions, owners and roadmap; the fact that a meeting occurred does not establish its outcomes. \[N01\]

# **1 The product and its connected parts**

KTA+ is the platform brand. Kingdom Thinkers Academy, iProject International and Thinkers Academy are distinct learning offerings delivered through the wider ecosystem. A platform account should allow a family to discover all of them, while the actual rights granted depend on the family's enrolments, purchases and organisation memberships. \[H01, H14\]

| Component | Purpose | Main relationship |
| :---- | :---- | :---- |
| Family account | Parent identity, children, consent, purchases and visibility | Connects guardians to learners and their access |
| Marketplace | Discover independent courses, live classes, mentoring and resources | Connects approved sellers to licensed purchases |
| Token wallet | Record grants, purchases, spending, expiry and reactivation | Funds eligible marketplace transactions |
| Premium programs | Structured KTA, mentored iProject and tutoring enrolments | Grants program and session access under a separate package |
| Course system | Modules, lessons, blocks, tasks and learning materials | Provides reusable content and delivery structure |
| Educator system | Approval, authoring, teaching, communication and earnings | Connects educator permissions to assignments and offers |
| Co-op and micro-school tools | Deliver licensed content to approved groups | Adds organisation scope, seats and local coordination |
| Compliance Hub | Store and review educator and organisation requirements | Controls approval and permitted activity |
| KTA+ Institute | Future educator development and verification pathway | Can add credentials to educator profiles |
| Administration | Configure, review, moderate, reconcile and support | Oversees the ecosystem without merging its distinct roles |

A practical connection example: a parent enrols a child in a KTA cohort. The enrolment connects the child to the assigned educator, live timetable, included materials, submissions and summaries. The same parent may separately purchase a marketplace resource using the family wallet. That resource purchase should not alter the child's premium enrolment or pay the cohort educator a marketplace commission.

A second example: a co-op coordinator selects an included KTA unit and separately buys a teacher's group-licensed marketplace course. Both can appear in the co-op's learning area, but one access right comes from the organisation plan and the other from a specific licence purchase. A plan upgrade must not silently give away third-party content. \[H09\]

## **Ownership and operating context**

Earlier IP work identifies KTA Group Australia Pty Ltd as the intended platform/IP owner. A December 2025 instruction separates TTN Charity from KTA+ operations, approvals, governance, payments and moderation, with TTN LLC in the US identified as global network approval/compliance authority. Later 2026 discussions considered retaining legacy Australian IP and owning newly developed IP in a US company. These conversations do not establish that a legal transfer was executed. \[H10, H19\]

The 2026 Australian educator contract names TTN Ltd as the contracting party for its educational services. That program relationship must not be mistaken for permission to give the charity global KTA+ platform administration. Store the relevant contracting entity and content owner explicitly. Kale must confirm the current entity responsible for each transaction stream and each approval role before production payment routing is finalised. \[D02\]

# **2 People roles and access boundaries**

Recorded roles include Parent, Student, Program Teacher, Independent Teacher, Co-op Leader and Micro-school Leader, alongside platform administration. One person may hold multiple roles, but each action needs the appropriate role and scope. \[H03, H07\]

| Role | Permitted scope | Boundary to preserve |
| ----- | :---- | :---- |
| Parent or guardian | Own family, child profiles, consent, purchases, progress and approved communications | No access to another family's child data |
| Student | Own approved learning, tasks, resources, sessions and submissions | No adult purchasing, global administration or consent override |
| Program educator | Assigned cohorts or students, program content and reporting | No platform-wide family or billing access |
| Marketplace educator | Own listings, approved authoring, teaching and seller records | Publication depends on content and seller approval |
| Hybrid educator | Both educator contexts when authorised | Earnings and permissions remain separated by engagement |
| Co-op main coordinator | Own group, invitations, licensed purchases and coordination | No login as a child or replacement of parental consent |
| Assistant coordinator | Configurable subset of organisation functions | Main coordinator status is not implied |
| Micro-school administrator | Own school roster, staff invitations, class assignment and billing | No global publishing right unless separately approved as an educator |
| Micro-school teacher | Assigned class instances and learners | No school admissions, billing or staff administration |
| Reviewer or compliance officer | Assigned review queue and evidence | No unrelated payout or student-data access by default |
| Platform administrator | Explicit operational permissions | Sensitive changes require an audit trail |

Recorded requirement: students have parent-created sub-accounts; co-op and micro-school enrolments retain parent accounts and consent. Organisation leaders can coordinate learning but cannot bypass guardian decisions. \[H03\]

Proposed engineering design: represent family membership, guardianship, educator assignments and organisation membership as explicit relationships. Do not rely on a single broad teacher role or a frontend dashboard switch. Each API request should check the actor, target learner, organisation, assignment and current access right.

An educator who is also a parent should see their own child in parent context and assigned learners in educator context. The relationship that permits access should be visible in logs. Removing the teaching assignment should remove educator access while preserving their ordinary parent access.

# **3 Family onboarding and the parent dashboard**

The historical parent-dashboard design covers child profiles, consent and revocation, progress, attendance, messaging controls, billing, safety reporting and data requests. The proposed US onboarding flow was parent account, child details, age-sensitive verification, consent and then learning access. The legal implementation of verification and disclosures must follow the policies approved for the launch; this handover does not substitute for those policies. \[H02\]

Proposed onboarding workflow:

1\. The adult creates or verifies their account and identifies their country and preferred timezone.

2\. The parent adds a learner with the details necessary for placement and approved consent handling.

3\. The system records the guardian relationship and relevant consent version.

4\. The family chooses a marketplace purchase, premium program or organisation invitation.

5\. Required placement, payment and approval steps are completed for that route.

6\. The child receives the corresponding access; the parent sees the timetable, materials and next actions.

The parent dashboard should explain the reason a child can access a program: active enrolment, individual purchase or licensed organisation assignment. It should distinguish a submitted application from a confirmed place. Existing operational enrolment copy says families' details are checked before payment and placement are confirmed. Do not equate submission of a form with active paid enrolment. \[H18\]

Recommended dashboard sections are child switcher, upcoming sessions, enrolled programs, purchases, wallet balance and expiry, learning updates, consent, billing and organisation invitations. The actual implementation status of each section needs demonstration.

Recorded presentation preference for parent summaries: parent action steps first, student next steps second, then the full summary. This should influence how a summary is displayed and emailed. A technical developer view should not be exposed to parents. \[H18\]

# **4 The shared course and content system**

The January 7 developer explanation specifies Course → Weeks → Lessons → Blocks for KTA and iProject, and Course → Modules → Lessons → Blocks for independent Group Live courses. Weeks and modules are program-specific labels within a shared hierarchy. Thinkers Academy and independent 1:1 tutoring share the tutoring workflow. \[N05\] The earlier full SaaS scope describes Course, Modules, Lessons and Blocks generically. \[N04\] It was intended to support marketplace educators, premium programs, co-ops and micro-schools, with live, self-paced and hybrid delivery. Assessments, resources, publishing review, versioning, attendance and certificates were included in the earlier specification; their current delivery status is unknown. \[H01, N04\]

The shared structure matters because the same instructional content may be delivered privately, sold independently or licensed to an organisation. Rebuilding unrelated builders for each route creates inconsistent editing, access and reporting.

## **Content and delivery must be separate**

A course or curriculum is the reusable teaching material. A cohort or class instance is a particular delivery with an educator, learners, dates and session times. An enrolment connects a learner to that delivery. A purchase or licence grants access to an offer. These are separate concepts even if the existing application uses different names.

Proposed example: a ten-week KTA curriculum can have an October cohort and a later cohort. Editing the later version should not unexpectedly change archived submissions or the evidence of what the October students received. A co-op can use licensed curriculum in its own local class instance without obtaining ownership of the underlying material.

## **Delivery modes**

| Mode | Core behaviour | Important distinction |
| ----- | :---- | :---- |
| Self-paced | Prebuilt content, tasks and progress without scheduled live teaching | Marketplace uses ordinary course information; premium self-paced summary needs confirmation |
| Live group class | Scheduled sessions, capacity, enrolment and attendance | Module content may accompany live teaching |
| One-to-one | Assigned educator and learner, booked sessions and feedback | A simplified content structure may be appropriate |
| Hybrid | Live delivery plus independent content and submissions | Preserve both progress and session evidence |
| Licensed local delivery | Approved content used inside a co-op or micro-school | Licence scope and local assignments control access |

The November and December 2025 drafts describe text, file and link submissions, review comments, progress states and optional certificates. These are historical design intentions, not proof that they were all approved or built. \[H06\]

## **Two self-paced creation paths**

Creators must be offered Convert Existing Live Course and Create New Self-Paced Course. Conversion selects a previously completed Group Live Course and reuses its lessons, recordings, resources and structure. Direct creation starts blank and supports modules, lessons, videos, downloads, quizzes, assignments and resources without any live sessions. Both routes lead to the marketplace publication and approval flow. Direct creation is required even for independent creators who never teach live. \[N02\]

The developer reported the two-path design updated on 30 June; self-paced page updates on 12 July; and self-paced builder pages on 14 July. Kale positively reviewed the adjusted self-paced flow on 13 July. These establish an acknowledged requirement and reported UI progress, not proof that recording conversion, media rights, quizzes, assignments, checkout and access all work end-to-end. \[N01\]

Proposed engineering checks: conversion creates a distinct self-paced product, preserves the source cohort, and does not expose student recordings or private discussion without the approved rights/consent. New-course creation never requires a cohort identifier. Publishing directly means no prerequisite live cohort; KTA+ review still applies.

## **Text Box and category improvements**

Kale requested rich formatting including bold, italic, underline, headings, sizes, lists, links and images. On 30 June the developer reported a rich editor but explicitly excluded embedded images/video because separate media blocks existed. Kale accepted the demonstrated editor on 1 July; on 1 August the developer again demonstrated underline, bold and links. Embedded media in Text Box remains deferred/unconfirmed, rather than a demonstrated completed feature. The precise editor package is not established by the messages. \[N01\]

Subject taxonomy is now an acknowledged requirement with reported delivery: admin-configurable subjects promised 30 June; expanded subjects and multi-select requested and acknowledged 27 July; admin-added subjects and multi-selection reported developed 30 July. The 18 July recap removes the separate Category field and keeps Subject; 26 July reports that change delivered. Use subjects as discovery tags and keep delivery mode, geography and licence scope separate. Verify the actual admin CRUD and multi-select persistence. \[N01\]

Proposed engineering design: render and sanitise rich content consistently in preview, published lessons and mobile delivery. Existing saved content must survive editor changes. Test separate image/video blocks and formatted text; do not require embedded Text Box media to pass the confirmed current editor scope.

## **Desktop and mobile authoring**

Recorded requirement from September 2025: course, module and bundle creation is desktop-only. The mobile app focuses on delivery, announcements, resources, rosters, submissions and messaging. Web-first and later mobile delivery were historical phase intentions; the current stack and mobile schedule require verification. \[H07, H01\]

# **5 Premium programs and package logic**

The ecosystem includes Kingdom Thinkers Academy, iProject International and Thinkers Academy. Premium program enrolment and billing remain separate from tokens. Parents enrolled in premium programs may additionally subscribe to a token plan using the same account. Tokens do not pay for or unlock premium enrolment. \[N03\] The late August 2026 ecosystem description again separates token-based experiences from paid premium programs. \[H14\]

| Program | Learning model | Required product distinction |
| ----- | :---- | :---- |
| Kingdom Thinkers Academy | Age-based, biblically grounded inquiry cycles with live classes and materials | Package benefits, cohort access and optional individual sessions |
| iProject International | Interest-driven, academically rigorous project learning with personalised mentoring or group pathways | Custom project, existing project, pathway cohort and DIY content are different offers |
| Thinkers Academy | Subject-specific online tutoring | Session entitlement and booking differ from a curriculum licence |

Current KTA operational packages are Explorer, Adventure and Journey. Explorer provides the live group foundation; Adventure adds one personalised session; Journey adds two. Session duration may be adjusted for younger learners. The October parent correspondence gives Australian weekly figures of \$60, \$139 and \$195, subject to a customised quote for shorter individual sessions. These are operational context, not a complete global price catalogue. \[H18\]

Proposed engineering design: a package should define its included benefits separately from its billing cadence. A weekly, fortnightly, monthly or term charge must not accidentally multiply the number of included weekly sessions. Store a child's cohort membership and one-to-one entitlement separately so a rescheduled mentoring appointment does not alter the group enrolment.

## **Premium authoring and course geography**

The 4–5 June correction moves all course authoring to platform Teacher/AdminTeacher dashboards, rather than a curriculum editor in the backend admin panel. Super Admin creates the AdminTeacher account; that user signs in through frontend login and is routed to its dashboard. Authorised premium creators use the shared Course Builder. School delivery teachers do not obtain those authoring rights automatically. \[N01\]

The 18 July recap specifies 1–12-week duration, manually entered token price, pricing-guide popup, Subject without Category, and course country USA/AU/Global. It also requests KTA themes, editable program logo/banner/video/sample curriculum, Big Picture content, course resources, weekly icons, removing quick links and student to-dos on course detail pages. The 26 July update reports several builder changes delivered; remaining details require verification against the dated ledger.

Both AU and US parents may discover all marketplace courses regardless of course country. Both see the three premium program families. Direct KTA access is restricted: US parents get USA/Global courses; AU parents get AU/Global courses. Do not use the marketplace geographic tag as an enrolment exclusion when these rules say cross-region access is allowed. Whether this extends identically to school premium access remains open. \[N01\]

The 20–21 May exchange approved dedicated details pages for each KTA course, with program information, overview, curriculum and that course's subscription plans. Remove the ambiguous standalone subscription section from the KTA overview page. The same detail-led enrolment flow was proposed for iProject and approved in the exchange. Keep family paid enrolment separate from school-included curriculum use.

## **Premium access and marketplace access**

Recorded preference from March 2026: premium-enrolled families should be able to use the marketplace without purchasing a second plan. That establishes the need for an account/access relationship, but does not determine how many promotional tokens they receive. A prior suggestion of 50 onboarding tokens and 20 monthly tokens was a proposal. Do not implement those quantities as approved pricing. \[H11\]

Confirmed: premium parents may add a separate token subscription. Premium enrolment does not require that subscription, and a token plan does not include premium enrolment. Additional benefits or promotional grants remain undecided; do not assume free tokens. Keep billing, cancellation and access entitlements independent. \[N03\]

# **6 Program Summary and the inquiry framework**

Program Summary is the structured overview of a premium learning program. It should explain the inquiry and its intended learning, not simply repeat a short marketplace description.

Kale explicitly requested the following course-specific fields on 27 July and reiterated them on 3 August. On 4 August the developer reported the nine listed summary sections fully editable. The learning-stage display and weekly images still need demonstration. \[N01\]

| Field | Purpose |
| ----- | :---- |
| Big Picture Statement | Explain the enduring inquiry and significance |
| Key Concepts | Identify the ideas learners will repeatedly connect |
| Key Questions | Guide inquiry and discussion |
| Key Vocabulary | Support disciplinary and conceptual language |
| Success Criteria | Make intended learning visible |
| Final Product Options | Explain possible evidence and audience |
| Universal Skills | Identify transferable capabilities |
| Checkpoints | Locate review and progress moments |
| Kingdom Themes | Identify the relevant thematic framework |
| Inquiry stages | Organise Wonder, Seek, Discover, Connect, Share and Grow |

The stage names are meaningful learning structures. They should be editable within a program rather than forced to occupy equal amounts of time. A ten-week cycle can spend multiple weeks investigating and revising, while final sharing and growth reflection occur later. Preserve the selected sequence and any program-specific mapping to weeks.

The 23 July exchange initially confirmed one shared summary across KTA courses. Later correspondence supersedes that: on 12 August the developer reported moving summary from program to course so each KTA course has its own content; on 20 August the course-level Summary/Overview setup was reported delivered. Kale then requested Summary before module creation, with modules the final step; the developer acknowledged the change. Do not retain the earlier program-global summary rule. \[N01\]

On 17 August Kale explicitly answered: marketplace self-paced courses do not need the premium Program Summary; premium Kingdom Thinkers Academy and iProject use it; marketplace Resources use tokens. The developer acknowledged receiving the clarification and would review it with the team. This replaces the first handover's uncertainty about whether that answer was sent. The premium self-paced summary edge case remains in the decision register. \[N01\]

Proposed engineering design: configure summary requirements by premium/marketplace program context and course type. Keep ordinary marketplace self-paced syllabus information. Session reports remain separate from Program Summary. The AdminTeacher should manage course-specific overview, welcome content, downloads, resources and summary without developer changes. \[N01\]

Kale requested renaming the Premium Programs filter tab KTA+ to Kingdom Thinkers Academy on 27 July; the developer acknowledged the requested updates. KTA+ remains the platform brand. Verify the rename without concealing iProject or Thinkers Academy. \[N01\]

# **7 iProject International in detail**

The directly reviewed iProject master prompt describes a learner-responsive project experience integrating academic foundations, inquiry, agency, real audience, critique, revision, transfer and portfolio evidence. It is a curriculum design document rather than a database specification. Its learning logic informs what the platform needs to support. \[D03\]

The key principle is personalising the pathway while preserving the learner's entitlement to substantial learning. The project should create reasons to read, write, investigate, measure and think. A final product alone is insufficient evidence of the learning process.

## **Learner profile and project design**

The source includes learner name, age/year level, literacy and mathematics needs, strengths, challenges, interests, prior knowledge, independence, confidence, technology/materials, delivery mode and session frequency. It also includes student voice and parent/mentor priorities. These should inform a project brief and learning plan, with sensitive information visible only to authorised people. \[D03\]

The master prompt describes solo mentoring, small-group collaborative learning, group-plus-individual hybrid delivery, international cohorts and short project sprints. These are curriculum options; they do not establish that all five are within the currently contracted platform scope.

The source also distinguishes Kingdom Integration, Faith-Informed Learning and Universal Inquiry worldview modes. Academic expectations remain rigorous across all three. Avoid inferring a student's religious commitment from a program title. The platform field, if implemented, should store the agreed program mode and approved learning materials. \[D03\]

## **Proposed end-to-end project workflow**

1\. Parent enquiry and learner profile identify interests, learning needs and availability.

2\. An authorised educator prepares or selects the project brief, question, learning goals and intended product.

3\. Parent and learner review the direction; any necessary placement or commercial approval is recorded.

4\. Confirmed enrolment assigns the educator, delivery mode, dates, sessions and content.

5\. The learner investigates and creates, using a sequence of lessons, activities, resources and milestones.

6\. Work is submitted as files, text, links or approved media; feedback and revised versions remain connected.

7\. Session summaries tell parents what was learned, next actions and support needed.

8\. The learner shares or defends the final product and reflects on growth.

9\. The portfolio preserves process evidence, learning outcomes and revisions for review or export.

This workflow is proposed engineering design. The original iProject approval states and matching rules were not recovered. Review Robin's initial implementation before adding screens or changing its lifecycle.

## **Personalised project and pathway cohort**

A custom project belongs to a learner and can have an individual plan. A Pathways cohort shares a broad challenge but preserves each student's own work, feedback and portfolio. Do not make every participant edit the same private submission record. Group resources can be shared while individual evidence remains separate.

The October operational examples include business projects, research investigations and a Crime, Justice and Investigation pathway. These illustrate why the platform needs flexible project briefs rather than subject-specific hardcoded forms. They do not justify building separate software modules for each topic. \[H18\]

## **Essential learning records**

Proposed records include learner profile, project brief/version, driving question, learning outcomes, curriculum links, weekly focus, milestone, evidence submission, feedback, revised submission, session summary, final product and reflection. Keep a reference to the original assignment and its content version. A student's exported portfolio should identify which evidence demonstrates which outcome rather than being a folder of unlabelled downloads.

Marketplace publication of a student's final product is a separate workflow. Completion of an iProject should never automatically publish the learner's identity, work or images. Any future student-created resource sale needs approved consent, content rights and a seller/payment model.

On 24 August the developer reported mentor-list APIs, parent iProject request submission/list APIs, teacher request list/detail APIs and child-specific iProject course creation from a parent request. The same message explicitly says iProject was not complete. Kale watched and appreciated the demonstration on 27 August. Verify the remaining request, assignment, delivery, payment and completion journey; positive feedback is not final module acceptance. \[N01\]

# **8 Marketplace listings resources and licensing**

Earlier marketplace drafts modelled discovery on clear course cards and detailed product pages with educator information, vetting badges, age, subjects, schedule, syllabus, requirements, parental guidance, reviews and price/access information. \[H01\]

Recorded requirement from December 19: teacher publishing must identify Parent License Only, Co-op Group License Available or Both. Co-op availability is not automatic. A micro-school group licence also needs explicit permitted scope. \[H09\]

Proposed listing fields include seller, product type, delivery mode, title, description, learner age, subjects, timezone and schedule where applicable, capacity, prerequisites, content preview, licence options, resource inclusions, token/cash eligibility and review status. Publishing review should validate that the offer is coherent: a self-paced resource should not promise scheduled mentoring unless that mentoring is actually included.

## **Included material and standalone resources**

A workbook or file can be included with an enrolment and also offered separately. Store the entitlement rule rather than charging twice. A learner enrolled in the appropriate program should access its included resource without a second wallet debit. A different family buying it independently receives only the rights granted by that listing.

The May meeting recap states marketplace uses tokens and premium programs use Stripe. Kale explicitly confirmed token-only marketplace Resources on 17 August and requested removal of the marketplace resource ESA feature on 18 September. The July recap removes ESA from marketplace courses, reported delivered on 26 July. Treat these as marketplace product rules; they do not remove ESA eligibility arrangements from separately operated US premium programs. Exact token pricing, group licence quantities and seller settlement still require commercial confirmation. \[N01\]

## **Digital download editions**

Recorded accepted launch pricing from July 22 uses Student, Family and Educator editions. These are digital product editions, not Family Flex memberships or educator employment tiers. \[H16, D04\]

| Download edition | USD | AUD | Historical inclusion design |
| ----- | :---- | :---- | :---- |
| Student | 59 | 89 | Student workbook |
| Family | 119 | 179 | Workbook plus parent/teacher guide, plans, facilitation, assessment and portfolio material |
| Educator | 199 | 299 | Family material plus presentation decks, presenter notes and a single-classroom licence |

The inclusions column comes from a prior draft and must be matched to the actual product manifest. The accepted price pairs are supported by the July screenshot and recovered acceptance. Do not use the same name Educator to imply marketplace approval or verification.

# **9 Subscriptions tokens expiry and reactivation**

The development history contains different token scales and payment proposals. Keep package quantity, token spending price, currency price and seller settlement value as separate fields. Token quantity alone is not a cash liability calculation.

## **Price and policy history**

| Date or source | Model recorded | Interpretation |
| :---- | :---- | :---- |
| September 2025 draft | Small token costs such as one per group class and fractions for resources | Early scale; do not merge with later package pricing |
| October 2025 draft | Family Flex 120 monthly tokens, 12-month rollover; premium enrolments separate | Historical family model |
| November 2025 request and draft | Starter 160, Growth 320, Pro 450; 1–3 month expiry; proposed Pro premium access and 70/30 split | Premium inclusion conflicts with later separated model |
| December 2025 draft | Approximately USD5 per token | Conflicts with other implied values; not a current conversion rate |
| March 2026 preference | Premium families access marketplace without a second plan | Benefit quantities were not decided |
| June 26 2026 correspondence | Expired tokens unusable; purchase within 12 months reactivates them | Preserve the reactivation requirement; boundary rules remain open |
| Public pricing reviewed October 5 | Family Flex and time-limited top-up packs coexist | Reconcile the two expiry policies with checkout and June instruction |

References: H01, H05, H08, H09, H11, H12 and W01.

Current public pricing displays Family Flex at USD30/month with 120 family-shared tokens and up to 12-month rollover. It also displays Starter 160 tokens/USD75/one month, Growth 320/USD140/two months and Pro 450/USD190/three months. The page's wording and top-up validity need a single approved implementation policy. \[W01\]

The developer explicitly described on 26 June: after expiry tokens cannot be used, but buying more within 12 months makes the expired tokens usable again. This is direct dated correspondence, correcting the earlier recovered June 30 attribution. \[N01\] Do not delete expired balances immediately if they are eligible for reactivation. \[H12\]

## **Proposed wallet design**

Maintain token lots with origin, owner, quantity, available remainder, issue time, expiry time, package/grant reference and status. Maintain immutable ledger entries for grant, purchase credit, debit, refund, expiry, reactivation and authorised adjustment. Use compensating entries for corrections rather than editing history.

Family sharing should mean an adult-controlled wallet can fund eligible purchases for connected learners. It must not mean students can transfer tokens, change subscriptions or obtain guardian billing access.

Spending should allocate tokens according to the approved priority rule. Earliest expiry first is a proposed sensible default, not a recovered requirement. The system must explain available balance separately from expired balance and show why a purchase is blocked.

## **Reactivation decisions to record**

| Decision | Why it matters |
| :---- | :---- |
| Does the 12-month window start at issue or expiry | Determines which lots can return |
| Do subscription renewals count as buying more | Affects Family Flex behaviour |
| Which new purchases qualify | Avoids free grants unexpectedly reactivating paid balances |
| What expiry applies after reactivation | Determines the next spending window |
| Do all eligible lots reactivate or a capped quantity | Affects financial exposure and balance presentation |
| What happens beyond the window | Determines whether balance is retired or retained as history |
| How do refunds affect reactivated tokens | Prevents a refunded top-up becoming a free renewal mechanism |
| What happens on subscription cancellation | Separates future grants from existing purchased rights |

## **Settlement value is a separate decision**

The historical drafts refer to 70 percent teacher and 30 percent platform revenue share. That is insufficient to calculate a payout from a token debit. A Family Flex subscription and a top-up pack can have different cash-per-token economics. Promotional tokens may generate no direct cash payment.

Decision needed: whether settlement uses actual collected revenue per token lot, a fixed approved token redemption value or another funded model. Also decide treatment of tax, processor fees, discounts, refunds and platform-funded grants. Do not use either the old USD0.45 or USD5 draft value as an implicit current payout rate. \[H04, H08, H09\]

# **10 Payments enrolments and educator payouts**

Historical designs considered AU and US Stripe routing, with regional organisation and family transactions. Stripe is also used in existing enrolment operations. The deployed account configuration, webhook design and merchant responsibility have not been inspected. \[H01, H18\]

Proposed engineering design: a purchase records product/offer version, licence, currency, gross amount, discount, tax, gateway identifiers, token allocation and access recipients. Payment success and access activation should be connected through a durable backend process. Do not activate access solely because the browser returned to a success page.

The design must distinguish premium placement applications, confirmed enrolments, marketplace checkout, organisation licensing and token-package purchases. A form can capture intent before an educator placement or quote is confirmed.

## **Two educator earning models**

| Engagement | Evidence for earnings | Calculation basis |
| :---- | :---- | :---- |
| Marketplace sale or class | Approved offer, eligible purchase and fulfilment rule | Agreed seller revenue share and token settlement policy |
| Contracted program delivery | Assigned engagement, session record and contract | Agreed per-session or hourly fees |

The directly reviewed Australian educator contract gives standard rates of AUD50 for a 60-minute session or group of 1–4 students, AUD62.50 for 5–9 students and AUD75 for 10 or more. Personalised iProject sessions are AUD50/hour unless otherwise agreed. It describes fortnightly invoicing through Teachworks and equal AUD rates for international educators, with possible transfer/conversion fees. These belong to the named contract's engagements, not every seller on KTA+. \[D02\]

The same contract requires a session summary within 24 hours. For a missed one-to-one session, the educator waits 15 minutes, attempts contact, records the absence and receives an AUD15 cancellation fee under that contract. Do not automatically apply this no-show rule to marketplace classes, other agreements or student refund policy. \[D02\]

## **Proposed payout lifecycle**

An earning progresses from calculated to pending, eligible, included in a payout and paid. Refunds, disputes and corrections need explicit reversal/hold entries. Actual states should match the provider and existing code. The educator view should show gross earnings, deductions, pending amounts, paid amounts and transaction references.

Settlement must never occur twice when a webhook is retried. A refund must update both access and the financial records according to approved rules. If a program educator is paid by session, reversing a student's marketplace resource purchase should not alter the program educator's session fee.

Decision needed: earning trigger for self-paced sales, live attendance, cancellation and no-show; payout timing and minimum; merchant/entity for each stream; split calculation basis; provider verification; dispute handling; and whether KTA+ replaces or reconciles with Teachworks invoicing at launch.

# **11 Teacher Module and Compliance Hub**

The Teacher Module is the recorded next development priority. September correspondence includes contractual status, messaging and content uploads. The wider historical dashboard includes authoring, teaching, cohorts, resources, earnings and compliance. \[H04, H17\]

A teacher dashboard being present does not prove the Teacher Module is complete. The team should demonstrate applying, being approved, signing/accepting the relevant agreement, obtaining the right authoring permissions, publishing through review, being assigned learners, teaching and receiving the appropriate earnings.

## **Educator approval, type and certification — separate systems**

Account approval states include Pending, Approved, Rejected and Suspended. Educator type is Marketplace Educator by default or Premium Educator assigned/removed manually by admin. Marketplace educators can create/sell courses, offer tutoring/workshops and appear in marketplace surfaces subject to permissions and review. Premium educators represent official programs/cohorts; Premium cannot be purchased or automatically unlocked. \[N02\]

KTA+ Certified is a separate certification status earned through requirements and approved/revoked by admin. It provides a verified badge and intended marketplace trust/visibility benefit; exact ranking effects remain unspecified. It does not indicate employment by KTA+. Marketplace and Premium educators may each be certified or uncertified. Do not require an automatic Marketplace → Certified → Premium progression.

Display applicable badges together beside educator names on profiles, marketplace listings, course pages, tutoring pages and workshops. Public badges must not expose private compliance evidence. Admin needs independent controls for account approval, Premium appointment and certification.

For contracted-teacher demo subject, open-ended text is the current requirement. On 15 June Kale accepted immediate text entry and explicitly deferred the dropdown/text admin toggle until the relevant backend/API is available. Do not treat that future toggle as a launch blocker. \[N01, N02\]

## **Proposed educator onboarding flow**

Application captures identity, professional background, country, proposed subjects/services and applicable supporting evidence. Reviewers examine the configured requirements, request changes where necessary and record an approval decision. Approval enables the permitted educator role; it does not automatically approve every course or confer Premium status.

The historical handbook draft included identity evidence, AU WWCC/Blue Card or US background-check uploads, references, training, content review and agreements. These indicate intended application categories, not a universal legal checklist. Country-specific requirements must be supplied by the approved policy owner. \[H02, H03\]

Proposed evidence records should include requirement type, issuing body, country/jurisdiction, file reference, issue/expiry dates, reviewer, outcome and renewal status. Access to uploaded identity/check documents should be narrower than access to public educator profiles.

## **Compliance states and activity controls**

Proposed states are draft, submitted, needs information, approved, rejected, expired and suspended. A requirement expiring may trigger a warning, block new assignments or suspend particular activity according to approved policy. Do not silently delete existing teaching records or make a student cohort disappear.

Keep four decisions distinct: educator approval, content/listing approval, current safeguarding eligibility and credential/Institute status. A certified educator can still have expired compliance evidence; an approved marketplace educator may not yet be Institute verified.

## **Teacher communication and weekly contribution**

The Australian program contract requires approved-channel communication, attendance, summaries, communication logs and learning plans. Its weekly guide includes a welcome/focus/resource contribution, modelling/scaffolding, engagement/discussion and feedback/recap. \[D02\]

Proposed design: a teaching assignment can generate educator tasks and reminders for expected summaries and resources. A missing summary should be visible to the educator and appropriate administrator. Do not invent automatic fines or payout withholding unless the relevant contract/policy explicitly establishes them.

Student communication must follow guardian controls and safeguarding settings. Organisation leadership does not authorise unmoderated private messages to minors. Retain an audit record for relevant communications and permission changes. \[H03\]

# **12 Co-op workflows and group licences**

Recorded scope: co-ops serve Australia and the US; micro-schools are US-only. The frontend pricing instruction in June 2026 points to the KTA+ pricing page for organisation plans. \[H03, H11\]

Recorded requirement from December 15: Co-op Starter and Plus use the same dashboard and architecture, with plan flags controlling capacity, reporting, assessments and content. Custom module creation is excluded from co-op v1. This supersedes the September design that allowed co-ops to add their own modules. \[H07, H09\]

The public page displays Co-op Starter at USD59/month, up to 20 students/two co-leaders, and Plus at USD109/month, up to 60/six. Marketplace courses remain separate purchases. Starter has capped program selections; Plus expands platform-owned program access. \[W01\]

## **Confirmed organisation onboarding**

The 10 June exchange explicitly approved: Start → Country (AU/US) → Plan Preview and intended plan selection → Basic Details → Visibility → Age Range → Agreements → Review/Submit → Admin Approval → Payment for selected plan → Dashboard access. Country and intended plan are saved with the application and shown to the reviewer; country is not changed in later onboarding steps. No payment occurs at plan-intent selection. Required statuses are Submitted, Under Review, Approved–Awaiting Payment, Active and Rejected. \[N01\]

The 14 June developer update reported country selection, regional plans, review, approval and post-approval payment prompt developed. Verify backend payment activation; page development is not proof of subscription fulfilment.

## **Co-op visibility — final behaviour**

| Type | Discovery and profile | Joining |
| ----- | :---- | :---- |
| Public | Public directory and nearby search; logged-out users and parents see limited profile | Request to Join; coordinator approves/declines |
| Unlisted | No directory/search; direct URL shows same limited profile | Request via link; same coordinator approval |
| Invite-Only | No public directory, search or public profile | Coordinator invite → Accept Invite → short onboarding → Pending → coordinator approval |

Limited public profile contains name, approximate location, description, ages and faith tags. It never reveals exact address, child data, families or internal programs. Public and Unlisted do not allow direct membership; child addition and consent follow approval.

Coordinators may change visibility at any time in settings, immediately and without platform approval. Switching to Public requires confirmation: This will make your Co-op discoverable to nearby families. Visibility changes only discoverability and joining; existing permissions and guardian consent remain intact. Proposed backend checks must deny private data even when a profile URL is known. \[N02\]

## **Coordinator delivery workflow**

1\. An approved coordinator establishes the organisation and its plan.

2\. The coordinator invites parents, rather than replacing parent accounts.

3\. Parents accept membership, add or connect their children and provide required consent.

4\. The coordinator selects included program content or purchases eligible group licences.

5\. Learners are assigned within seat and licence limits.

6\. Calendar, attendance, group communication and enabled reporting support local delivery.

7\. Purchased programs remain distinguishable from included plan content.

The December drafts describe a main coordinator, permission-limited assistants, pending/active children, group purchases and platform-direct payments. They also exclude cost splitting in v1. Check these against acknowledged specifications before assigning them contractual status. \[H09\]

Starter draft selection rules described 3–4 age-eligible KTA programs and three interest-based iProject selections. Decision needed: the precise allowed count, selection lock duration, swaps and what happens on plan change. A vague 3–4 rule cannot be implemented consistently without an approved selection policy.

An upgrade grants the new plan's platform-owned content benefits; it does not grant every independent teacher's course. A downgrade needs a defined treatment of seat excess, previously selected programs, completed records and independently purchased licences.

# **13 Micro-school workflows — authoritative v1**

Micro-schools are US-only. A US-based parent, teacher, pastor or founder may initiate one, becoming its dedicated owner/admin. The micro-school is a distinct platform entity with name, location, description, owner, subscription, roster, programs and settings. The dashboard is an operational control layer; KTA+ supplies infrastructure while the school retains its operational authority. It is not a full LMS or SIS. \[N02\]

Public pricing displays Essentials at USD199/month for up to 120 students and Pro at USD399/month with unlimited students. The pricing page is designated as the source for frontend plan information. The public Pro language about advanced roles/approvals must not override the authoritative fixed v1 roles without a recorded scope decision. \[W01, N02\]

## **Creation and approval**

1\. Eligible user selects Start a Micro-school and an Essentials or Pro plan.

2\. Guided onboarding captures school details, policies and agreements.

3\. School is created Pending; platform admin reviews and approves it.

4\. Approval activates the subscription and grants owner access to the Micro-school Admin Dashboard under the supplied flow.

The exact payment collection/charging point and rejected-application treatment are not defined here. The co-op flow explicitly collects payment after approval; do not automatically copy that state machine into micro-schools without confirming the commercial flow.

## **Fixed roles and family admissions**

Only the Micro-school Admin enters its Admin Dashboard. Fixed v1 roles are Admin, Teacher and Parent; the separate Student Dashboard serves enrolled learners. Teachers and parents use their own dashboards, scoped to permitted school records. No teacher can self-assign to the school or a class.

Each school has a branded, platform-hosted application page, for example /microschools/{school-name}/apply. Schools share it via their own marketing or direct invitations; it is not surfaced through a global parent marketplace in v1. A parent application creates or links a platform parent account. Required information/agreements and school approval produce school membership. The external tuition/access checkpoint requires clarification as described in Revision 2\.

After family approval, the parent submits child profiles. Each child requires separate school-admin approval before being active and available for class assignment. Family approval, child approval and enrolment in a particular class are three distinct events. Guardian consent is never replaced by school approval. \[N02\]

## **Global approved library and curriculum ownership**

Only two v1 sources exist: KTA+-owned Premium Programs (KTA and iProject explicitly named), and approved courses/resources made by independent educators already on the platform. No external organisations submit programs. Marketplace courses share the instructional structure with premium programs; ownership and pricing differ. Resources remain assignable materials rather than being forced into a full scheduled-course shape.

All available premium programs are included for every micro-school, without an extra program purchase. Marketplace items are not included: the school admin purchases each separately. Purchase unlocks entitlement; enablement makes the entitled item usable locally. Neither action itself creates a class or enrols a learner. Global catalogue visibility alone grants no access.

KTA+ maintains premium curriculum and pushes central updates. Independent educators maintain their own marketplace content, with KTA+ approval/compliance oversight. School staff cannot create, upload, edit or restructure curriculum in v1. Structure can be Program → Units/Weeks/Modules → Lessons/Activities → Content Blocks, with labels varying by program. It is visible and read-only locally. Proposed versioning should preserve teaching/submission history while approved updates are rolled out; update migration behaviour needs an agreed rule.

## **Class instances and connected dashboards**

The admin enables an entitled program, creates a class instance with program, assigned eligible teacher and schedule (time, recurrence, location/format), then enrols approved students. Teachers facilitate online or in person, adjust pacing/discussion, manage sessions and record attendance. Admins can override attendance with an audit record. Facilitation flexibility does not confer curriculum editing rights.

The Teacher Dashboard shows assigned classes and enrolled learners. The Parent Dashboard shows school membership, own children, assigned programs, schedules, updates and feedback. The Student Dashboard shows assigned activities, session joining, participation and attendance; this does not promise a full LMS. Admin oversight includes families, students, teachers, classes, attendance, incidents and pending approvals. Backend scope checks must enforce these relationships.

## **Billing and staffing separation**

The owner pays the KTA+ B2B platform subscription. Parents pay tuition externally to the micro-school; the school pays its teachers outside KTA+. KTA+ does not collect, split or escrow tuition in v1. Do not create school-tuition gateway events or local teacher earnings in the platform marketplace payout ledger.

Optional live/hybrid KTA+ Premium Educator support is program-level support contracted through KTA+/TTN LLC, separate from the school's staffing. It is not automatically included live staffing simply because premium curriculum is included. Enquiries go to admin@thetransformationnetwork.us. Scope, pricing and any staffing arrangement need confirmation before implementation.

## **Teacher eligibility and safety gates**

Platform accounts and vetting establish eligibility; the school chooses and links its teachers. The recommended model funnels invitations and optional teacher applications into pending onboarding/review. It captures account basics, agreements and a declaration of direct child interaction. Interaction includes live sessions, 1:1, feedback and messaging. Required clearance cannot be overridden by school admins.

The recommended guardrails block interactive assignment, student messaging, 1:1 and student-profile access when required approval/clearance is missing or expired. Implement only against approved policy/evidence rules and resolve the assistant-role ambiguity. A proposed checklist shows account, agreements, delivery declaration, applicable clearance, role and first class assignment. Recommended extra roles and teacher application discovery remain scope decisions, not confirmed additions to the fixed v1 role model. \[N02\]

# **14 KTA Plus Institute and educator recognition**

The directly reviewed Institute questionnaire is an unanswered design brief. It references a July 27 wireframe and proposes Foundations, Practice Labs, Mentored Application, Certification Sprint and Verified Educator. It asks for confirmation of stage names, actions, time commitment, benefits, application fields, mentors and review mechanics. Those questions are not answers. \[D01\]

The proposed journey involves reflection, practice evidence, recorded teaching, rubric review, possible resubmission, portfolio and a profile badge. The new correspondence explicitly establishes educator type and certification as independent systems. Premium is manually appointed, and certification is separately approved; no strict credential progression is required. This supersedes earlier drafts implying certification automatically precedes Premium status. Institute curriculum, fees and renewal remain separate decisions. \[N02, H20\]

Institute-related prices of approximately USD497 for verification and USD89/year for active status were proposals. Do not implement them as final prices or display guaranteed benefits, ranking changes or recognition claims without approval. \[H20\]

Recorded launch context: Institute is presented as coming in 2027; the current landing page gathers interest. The August scheduling request to Gabriel deferred later work and spread costs. Confirm whether that schedule concerns the Institute/GG Studio engagement rather than Robin's main platform contract. \[H21, D05\]

Proposed design: keep educator operational approval, compliance status, certification award, active verification subscription and Premium appointment as distinct records. This allows a historical certification to remain recorded even if an annual membership lapses, while public active-status badges follow approved rules.

Decision needed: final terminology, prerequisites, curriculum, rubric, reviewers, fees, renewal rules, badge visibility and whether credentials affect marketplace discovery. Recorded teaching submissions involving children require their own approved consent and privacy handling.

# **15 Scheduling session records and notifications**

On 8 May Kale corrected the meeting recap: Zoom integration is a primary/core platform goal, with manual session links retained as an option. The developer acknowledged this. The initial suggestion to add Zoom only at the end is superseded; sequencing may be staged but Zoom is not an optional future add-on. The exact integration scope and current implementation require demonstration. \[N01\]

The May recap includes teacher-created dates/times, in-platform student joining, email notifications for session notes, teacher invoices based on class dates, manual admin paid status and invoice/payment-confirmation emails. Preferred parent times for 1:1 and direct creation of Stripe products from admin were explicitly future ideas. Kale clarified that class-size-dependent premium pricing in that discussion meant teacher wage calculation, not family course price. \[N01\]

Worldwide teacher timezones were requested 31 July, reported added 1 August and explicitly accepted by Kale. AU/US course access rules must not limit the timezone selector to US zones. \[N01\]

Families and educators are distributed across Australia, New Zealand and the US. The October operational correspondence identifies discrepancies across email/calendar and Mighty displays around Australian daylight-saving changes. The current operational instruction is to follow email/calendar notifications first. The new platform needs one consistent scheduling representation. \[H18\]

Proposed engineering design: store the session's actual instant and original IANA timezone. For recurring teaching, preserve the intended local schedule and recurrence timezone. Expand each occurrence with daylight-saving rules; do not assume a fixed UTC offset for an entire term.

A reschedule needs to update the session record, joining information, calendar event and parent/educator notification. Display both local time and an explicit timezone when ambiguity matters. Cancellation, attendance and summary status belong to the occurrence, not only the parent series.

The class roster and joining link should be available only to authorised participants. Recording access needs an explicit entitlement/consent rule. Do not expose classroom links or recordings through public listing previews.

Proposed notifications include placement confirmation, purchase/access confirmation, session reminder/change, missing-summary reminder, new feedback, expiring compliance evidence and token expiry/reactivation. Capture delivery outcome and retry failures; duplicate webhook events should not send duplicate purchase confirmations.

# **16 Existing tools integrations and migration**

Existing operations use Teachworks for enrolment/session administration, Mighty learning spaces, Zoom, Google learning materials and a Framer public site. Typebot and Hostinger Reach support public enquiries. Historical CRM architectures proposed HubSpot and later Zoho; neither should be assumed to be the deployed canonical CRM. \[H01, H14, H18, D06\]

## **Transactional email versus marketing campaigns**

The 8 May exchange separates automated session notes, reminders, invoices and activity notifications from the global marketing mailing list. The developer said transactional email could run without Reach. Kale clarified the separate requirement for newsletters, course/shop launches, podcasts, promotions and announcements, with organised campaigns. The developer would consult the team; no completed global marketing integration was demonstrated in that exchange. September Typebot/Reach work is enquiry capture, not proof that all platform registrations are synced. \[N01, D06\]

## **Enquiry capture**

September 21 records document Typebot enquiry fields being mapped into Hostinger Reach and tags being added. The reviewed screenshots show use of the profile-scoped contacts route and an older route marked deprecated. This is historical integration evidence, not current API documentation. Verify current provider documentation before changing the integration. \[D06\]

Kale requested immediate notification whenever someone completes Typebot and consistent tagging across flows. Adding someone to an email list does not itself establish an internal instant notification. Demonstrate each completion branch, field mapping, tag assignment and the separate notification. Do not include API tokens or contact identifiers in this handover.

## **Migration responsibilities**

Proposed migration inventory should record the current owner of family identity, learner roster, sessions, invoices, content, consent, summaries and subscriptions. Decide for each whether KTA+ imports it, synchronises it or leaves it in the existing operational system for launch.

Avoid sending student work and sensitive learner data into a marketing CRM. Earlier CRM drafts kept parent/guardian contact data in CRM and child learning data in-platform. Treat this as a historical design intention to reconcile with the approved data policy. \[H01\]

A migration rehearsal should test duplicate families, siblings, educator-parent dual roles, organisation memberships, existing purchases and historic attendance. Legacy records need their original identifiers or another reliable mapping so repeat imports do not create duplicates.

# **17 Proposed domain model and lifecycle contracts**

This section is proposed engineering design. It names the relationships the team should verify, not actual table names or endpoints from Robin's repository.

| Domain record | Key relationships |
| ----- | :---- |
| User | Roles, account status and identity |
| Family and guardianship | Adults, children and guardian permissions |
| Learner | Profile, enrolments, consent and learning evidence |
| Organisation and membership | Plan, coordinator/staff/parent roles and scoped learners |
| Educator profile | Approvals, compliance, credentials and payment identity |
| Course version | Modules, lessons, blocks, tasks and resources |
| Offer and licence | Seller, price, audience, delivery mode and use rights |
| Cohort or class instance | Course version, educator, learners and organisation |
| Session occurrence | Actual time, recurrence origin, roster and attendance |
| Order and payment | Offer snapshot, payer, merchant, gateway and fulfilment |
| Enrolment or entitlement | Learner/group, access origin, scope and dates |
| Wallet lot and ledger | Owner, origin, expiry, spending and reactivation |
| Earning and payout | Engagement/order, calculation snapshot and settlement |
| Submission and feedback | Task, learner, version, review and revision |
| Summary and portfolio | Session/project, learning evidence and parent visibility |
| Compliance requirement | Evidence, reviewer, expiry and allowed activities |
| Audit event | Actor, action, affected record, previous/new state and time |

## **Important proposed lifecycles**

Course publication: draft, submitted, changes requested, approved, published, archived. A meaningful edit to published content should either create a new version or pass the relevant review rule.

Premium enrolment: enquiry/application, placement review, payment/confirmation, active, paused/withdrawn, completed. The exact placement/payment order is a product decision, especially where a quote is customised.

Marketplace order: created, payment pending, paid, fulfilment pending, fulfilled, cancelled/refunded/disputed. Retrying payment confirmation or fulfilment should converge on one purchase and one entitlement.

Assignment: assigned, in progress, submitted, reviewed, revision requested, resubmitted, complete. Record completion criteria; merely opening a lesson need not demonstrate mastery.

Wallet lot: active, expired, eligible for reactivation, reactivated, exhausted or retired. Reactivation is an event, and the ledger preserves the prior expiry.

These lifecycles should be adopted only after comparison with existing migrations and business logic. Preserve working behaviour where it matches recorded requirements rather than renaming every entity to fit this document.

# **18 Implementation invariants and failure handling**

The following are proposed engineering acceptance requirements. They protect the relationships already described and should be checked at backend level.

1\. Every learner-access request must have a valid relationship and entitlement. A hidden button is not an access control.

2\. A family's spendable wallet cannot become negative because two purchases execute concurrently.

3\. One gateway transaction or subscription renewal cannot create multiple token credits, access grants or payouts.

4\. An included resource cannot debit tokens for the same included access.

5\. A group licence cannot be fulfilled as unrestricted global access.

6\. Removing an organisation membership cannot erase the child's independent purchases or family identity.

7\. A plan upgrade cannot include third-party content without its agreed licence or commercial basis.

8\. Publishing content cannot implicitly approve the educator's compliance, certification or Premium status.

9\. A refund must be traceable through payment, token ledger, entitlement and earnings adjustments.

10\. A revised student submission must not overwrite the evidence of the earlier version and its feedback.

11\. Staff or contracting entity changes cannot rewrite historical financial records.

12\. Critical configuration changes must record who changed them and when they become effective.

Where payment succeeds but access creation fails, record a recoverable fulfilment problem and retry safely. Where a notification fails, keep the purchase and access valid and retry the message. Where compliance expires, apply the approved activity restriction and alert the owner rather than deleting records.

# **19 Dated development progress and verification needs**

The ledger below uses direct developer correspondence \[N01\]. Reported API completion, reported frontend pages, design changes, user approval of a requirement and product acceptance are different evidence levels. The videos are referenced demonstrations, not independently reviewed acceptance results. Earlier recovered September module-status summaries remain supplementary \[H17\]. Do not turn either source into a verified completion percentage.

| Date | Reported work or agreed change | Evidence level and next verification |
| ----- | :---- | :---- |
| 8 May | Zoom made core; teacher wages vary by class size; marketing separated from transactional email | Explicit user corrections acknowledged; verify integrations and wage rules |
| 12–15 May | app.ktaplus.io confirmed; full server setup, frontend/backend sites and child-onboarding APIs reported; admin.ktaplus.io supplied | Deployment report; inspect environments, access and actual stack |
| 18–21 May | Parent onboarding choices, avatar, child addition, email verification and submission reported | Email not yet set up; OTP displayed in success message then. Confirm resolved; online US consent and completion/redirect were requested |
| 20–21 May | Course-specific premium details and subscription pages approved | Approved UX direction; test course-specific subscription attachment |
| 26 May | Robin baseline timeline now recovered in N07; extension discussed | Four items reported complete; June–July dates are targets. See Section 28 for reconciliation |
| 4–5 June | KTA course/week/step/block management APIs reported; all authoring redirected to Teacher/AdminTeacher workflow | Earlier backend-admin authoring was corrected; demonstrate current authoring context |
| 7–14 June | Co-op introduction/plans/roster/program pages, then marketplace/messages/announcements/settings and micro-school onboarding pages reported | Frontend/pages reports; co-op AU/US approval-before-payment flow agreed 10 June and reported added 14 June |
| 11 June | Teacher registration, contracted/marketplace onboarding APIs, chunk uploads, verification/admin review and AdminTeacher creation reported | Message wording on frontend integration is ambiguous; verify current API integration instead of assuming completion |
| 15 June | Open demo subject accepted; admin toggle deferred | Confirm text input now; keep toggle in future backlog |
| 18 June | Course creation, overview/module/lesson/block APIs, teacher course lists/banner details and announcement CRUD reported | API report; prove permissions and frontend/backend roundtrip |
| 22 June | Marketplace-teacher onboarding and login reported | Includes identity, safety, training, references, alignment, legal agreements and final review; test approval boundaries |
| 26 June | Marketplace list/filter/detail; token-package CRUD, one-time/subscription packages, payments, wallet/history reported | API/admin report; developer states reactivation within 12 months; test expiry boundaries and settlement |
| 27 June | Teacher group-course builder, curriculum/modules/lessons and Text/Image/Video blocks reported | Only three block types then; do not read as all blocks completed |
| 30 June–1 July | Two self-paced paths designed; rich editor demonstrated and accepted; subject configuration promised | Embedded image/video in Text Box explicitly deferred; standalone media blocks remain |
| 2 July | Micro-school overview, classes, week details, roster, recordings, attendance, library, enablement, families/students/teachers/requests, messages/settings pages reported | Frontend page report; verify real school scope, paid entitlement, admissions and class assignment |
| 5–6 July | Separate marketplace Figma shared; all-pages navigation explained as authenticated dashboards | Recovery/design pointers; verify login routing and demo access |
| 8 July | Contracted-teacher onboarding pages reported | Identity, induction, mock teaching, agreements and review; verify real approval/contracts |
| 12–14 July | Announcements and self-paced builder pages reported; KTA confirmed to support all listed delivery/course types | UI progress plus explicit user answer; demonstrate both self-paced paths |
| 16–21 July | Initial AdminTeacher pages, premium creation/update and group/self-paced creation reported | 16 July explicitly says initial pages; payout/Compliance/settings page presence is not completed business logic |
| 18–26 July | Duration 1–12 weeks, manual token price, guide, Subject-only, country and KTA theme features discussed and several reported delivered | Compare each item with current form and backend; preserve marketplace/KTA geography distinction |
| 23 July | Shared KTA summary initially confirmed | Superseded by later course-specific summary change; no longer the build rule |
| 27–30 July | KTA course fields, profile image and expanded multi-subject tags requested; all block types and editing/deletion/summary features reported | Admin-configurable subjects reported; verify full block set and every summary field |
| 1 August | Worldwide timezones reported and accepted; bold/underline/links re-demonstrated | Accepted direction; still test DST and stored zones |
| 3–4 August | Current order claimed delivered; Kale disputed KTA completeness; developer reported image and summary editing with videos | Disputed/clarified delivery; verify complete workflow, not just an order status |
| 4 August | Weekly icon inclusion/module image editing queried | Developer promised to check; no explicit resolution found in supplied messages |
| 12 August | Course-specific summary; teacher course-resource APIs, learner resources, marketplace resource CRUD/token enrolment APIs reported | API report; obtain parent/student view requested later |
| 12–13 August | Next backend phase offer accepted | Prose \$1500/20 days; order shows 60 days, total \$1582.50 with fees. Reconcile actual contract milestone and remaining scope |
| 17–20 August | Marketplace self-paced summary exclusion and token Resources explicitly sent; summary moved to course; summary before modules requested | Direct requirements/acknowledgements now established; verify final ordering |
| 21 August | Source delivery/commit history/GitHub ownership and documentation promised | Reported existing attachment and future promise; obtain actual source and verify owner-controlled repo |
| 24–27 August | iProject mentor/request/child-specific creation APIs reported and video positively reviewed | Developer explicitly says iProject not complete; verify remaining workflow |
| 1 September | Course resource add/delete implemented in AdminTeacher course details | Reported implementation; parent/student display demo requested 15 September |
| 17–18 September | My Resources CRUD reported; marketplace-resource ESA removal requested | Verify frontend, protected access and tokens; do not infer premium ESA changes |
| 24–26 September | Accident/continuity issue communicated; full-team review and questions promised; meeting held | 26 September written follow-up defines review areas and roadmap need; no full inventory/roadmap appears in pasted record |
| 1–4 October | Questions promised; later deferred to meeting; server review and weekly demos discussed | Requests/commitments, not completed deliverables |
| 5 October | 42-minute call recorded | Call contents absent; obtain recap and decisions before treating new verbal rules as approved |

## **Current module assessment for the team**

| Area | Evidence-supported position | Demonstration required |
| ----- | :---- | :---- |
| Parent onboarding | UI/features reported May; US consent and completion defects identified | Online consent, real verification email, completion and dashboard redirect |
| Marketplace/course builder | Extensive APIs/pages reported June–July | Both self-paced paths, all block types, review, publication, purchase and learner access |
| Premium/AdminTeacher | Course-specific summary and resource editing reported through September | AdminTeacher account creation, full KTA course editing, geography, enrolment and learner view |
| Wallet/tokens | Package/payment/wallet APIs reported June | Credits/debits, subscription renewals, expiry/reactivation, refunds and funding reconciliation |
| iProject | Parent request and child-specific course APIs reported August; explicitly incomplete then | Matching, permissions, mentored delivery, payment and completion |
| Co-op | Frontend and agreed country/plan/approval/payment flow reported June | Subscription activation, visibility, family/child approval and purchased group access |
| Micro-school | Broad page set reported July | Authoritative v1 admissions, read-only library, purchase versus enablement, scoped classes and external tuition boundary |
| Teacher Module | Onboarding APIs and frontend reported June/July; remaining work in handover | Independent status dimensions, contracts, approvals, messaging, uploads and assignment |
| Payouts/Compliance/settings | Initial AdminTeacher pages reported July; remaining logic in later handover | Earning models, manual paid status, compliance gates and actual configuration persistence |
| AI summary tool | Mentioned as expected improvement in 26 May concern; delivery not established | Confirm exact inputs, output, review workflow and implemented status |
| Zoom/email/marketing | Requirements and early transactional approach established; no complete integration evidence | Core Zoom workflow with manual link option; transactional events; separate marketing sync |
| Infrastructure/source | Server deployment and source/GitHub handover reported/promised | Actual stack, owner access, full history, deployment instructions and backup restore |

## **Recovery links from the correspondence**

These identify records to retrieve and correlate with deployed commits. Linked content has not been established by the pasted correspondence itself. Credential-document URLs and Zoom meeting passcodes are deliberately excluded; obtain credentials through the team's secure access process.

| Record | Pointer | Recovery purpose |
| ----- | :---- | :---- |
| Main platform | https\://app.ktaplus.io/ | Current frontend deployment reported by team |
| Platform administration | https\://admin.ktaplus.io/ | Backend administration reported by team |
| Page index | https\://app.ktaplus.io/all-pages | Dashboard/page navigation; authenticated routes |
| 26 May feature-priority plan | [KTA+ timeline](https://docs.google.com/document/d/1DQeDlawZdNbKAU4Ztlmx24_YH6lN2tSyLgIief7Iv98/edit) | Partial planning source; retrieve full text |
| Ongoing modifications document | [Latest Modifications 10th June](https://docs.google.com/document/d/1DOwIit2xHok4TSl4K1hgrs7ULyRvIpBlnjw2wW57kyg/edit) | Versioned changes including self-paced workflow |
| Main Figma design | https\://www\.figma.com/design/6wqOhx90lftaCzH1Lx274i/ | Source design referenced in 30 June update |
| Independent Marketplace design | https\://www\.figma.com/design/UEmTx0jOE2xGp1dr7fu9Ov/ | Separate design shared 5 July |
| Self-paced builder, 14 July | https\://www\.loom.com/share/4a04233ee7124c5d80638714437347ef | Both creation paths and curriculum setup |
| Premium editing, 4 August | https\://www\.loom.com/share/3ffa4638a76845a0acb7e198c67d2eb4 | Course creation workflow reported |
| Premium summary, 4 August | https\://www\.loom.com/share/5406a8146e6b48688412cf0769cad301 | Editable fields reported |
| Course summary, 20 August | https\://app.usebubbles.com/afaNXRn3kfeXKNSL3AXUzW/recording-aug-20-2026 | Course-level summary/overview |
| iProject, 24 August | https\://app.usebubbles.com/iSNcThu9ExCAg3eMEsmuVA/kalekneale-iproject-request-and-create-course | Parent request to child-specific course |
| Resources, 17 September | https\://app.usebubbles.com/eX8QgzfEpCiQq6SSA6CPwD/recording-sep-17-2026 | Teacher resource CRUD |
| 5 October meeting | Fiverr conversation: 5 October, 42-minute call | Retrieve recording/transcript and written outcome; availability not verified |

The 12 August offer describes PHP/Laravel, HTML/CSS and React. Confirm actual technology and dependencies from code. The developer's remaining 50% phrase is a commercial phase description, not a reliable estimate of technical completion. Its 20-day prose and 60-day order field conflict; record the actual agreed deadline and acceptance scope rather than choosing one silently.

## **Scope that must remain explicitly deferred or unresolved**

Future features explicitly mentioned in the May recap include parent preferred-time suggestions for 1:1 and Stripe product creation from the admin dashboard. The 15 June demo-subject dropdown/text toggle is deferred. Embedded media in Text Box was proposed for later work. Institute delivery remains a coming-2027 scope. Zoom differs: Kale explicitly corrected its classification to a core goal, so it cannot be removed as a future idea. AI-generated summaries, weekly module images and the complete supported block inventory need specific implementation evidence rather than inference from generic page completion. \[N01\]

# **20 Change history the team must preserve**

| Date | Change or decision | Affected feature |
| ----- | :---- | :---- |
| September 2025 | Shared course architecture, dashboards and organisation scope drafted | Platform structure |
| September 24 2025 | Parent-created student accounts and consent boundaries required | Identity and organisation onboarding |
| September 30 2025 | Desktop-only content authoring accepted | Mobile scope |
| October 28 2025 | Premium enrolment separated from marketplace tokens in discussion | Billing and access |
| November 9 2025 | Proposed token tiers and premium access introduced | Historical conflict to resolve |
| December 15 2025 | Shared Co-op Starter/Plus dashboard; no custom modules in co-op v1 | Organisation plan permissions |
| December 19 2025 | Parent/group/both licence selection required | Marketplace publishing |
| December 21 2025 | TTN Charity excluded from global KTA+ operating authority | Roles and merchant configuration |
| March 19 2026 | Premium families need marketplace access without a second plan | Membership benefits |
| June 14 2026 | Pricing page designated for organisation frontend prices | Regional plan catalogue |
| June 26–July 1 2026 | Token reactivation stated; rich editor accepted with embedded media deferred | Wallet and authoring |
| July 22 2026 | Digital editions accepted at 59/119/199 USD and 89/179/299 AUD | Resource catalogue |
| July 27–30 2026 | Course-specific fields requested; subjects/multi-select acknowledged and reported built | Premium builder and metadata |
| August 1 2026 | Landing page first and later-phase schedule requested from Gabriel | Confirm separate engagement scope |
| August 12–20 2026 | Summary moved to course; sent marketplace self-paced/resource clarification; summary before modules requested | Course rules and authoring |
| August 24 2026 | Child-specific iProject request/course APIs reported; module explicitly incomplete | iProject |
| September 18 2026 | ESA removed from marketplace resources; token model reiterated | Resources |
| September 21 2026 | Typebot to Reach setup and instant notification request | Public enquiries |
| September 24 to 26 2026 | Robin handover concern; new team review and priority sequence | Delivery ownership |
| October 4 2026 | Comprehensive status/logic review and weekly video expectations reiterated | Team reporting |
| October 5 2026 | Premium/token separation confirmed; full SaaS scope and January explanation recovered; 42-minute call recap absent | Billing, scope and handover |

A newer date alone does not make an assistant proposal an approved decision. For each conflicting rule, compare explicit user instructions, sent correspondence, acknowledged tickets, meeting records and tested behaviour. Record the final answer and retire the superseded configuration.

# **21 Decisions required before production acceptance**

| ID | Decision | Owner to confirm | Affected modules |
| :---: | :---- | :---- | :---- |
| DEC01 | Final family/token catalogue by currency and region | Kale | Pricing, checkout, wallet |
| DEC02 | Subscription versus top-up expiry and reactivation boundaries | Kale with team implementation review | Wallet, refunds, notifications |
| DEC03 | Premium family marketplace benefit and promotional grants | Kale | Membership, wallet, access |
| DEC04 | CLOSED: premium enrolment separate; parents may additionally subscribe to tokens | Technical lead to verify | Billing, programme access |
| DEC05 | Marketplace token model established; confirm product exceptions and group-licence pricing only | Kale | Marketplace, resources, licences |
| DEC06 | Seller split and token redemption funding/value | Kale and finance owner | Earnings, payouts, reporting |
| DEC07 | Merchant and contracting entity per transaction stream | Kale and authorised advisers | Gateway, invoices, approval roles |
| DEC08 | Sent August clarification established; confirm summary behaviour for premium self-paced courses | Kale and technical lead | Premium and self-paced builder |
| DEC09 | Full iProject approval, matching and placement lifecycle | Kale | iProject, enrolment, educator assignment |
| DEC10 | Co-op selections, locks, downgrade and seat-excess rules | Kale | Organisation plan flags |
| DEC11 | CLOSED product rule: micro-school curriculum read-only; verify enforcement and retire local upload roles | Technical lead | Builder permissions and licences |
| DEC12 | Marketplace cancellation/refund/no-show rules | Kale | Orders, sessions, settlement |
| DEC13 | Contract-specific program fees and invoicing transition | Kale | Teaching records, Teachworks, earnings |
| DEC14 | Approved clearance policies, assistant interaction rules and expiry restrictions | Policy owner nominated by Kale | Teacher Module and Compliance Hub |
| DEC15 | Institute names, fees, badge renewal and launch scope | Kale | Institute and educator profiles |
| DEC16 | Canonical CRM and migration/synchronisation boundaries | Kale and technical lead | Enquiries, notifications, data migration |
| DEC17 | Actual deployed stack, infrastructure and launch date | Technical lead with Kale | Operations and delivery roadmap |
| DEC18 | Current ownership/licensing for legacy and new IP | Kale and authorised advisers | Contracts, content ownership, repository control |
| DEC19 | Micro-school family activation: approval alone or admin-recorded external tuition confirmation | Kale | Admissions and membership |
| DEC20 | Micro-school subscription charge/activation timing and rejected application handling | Kale | School onboarding and B2B billing |
| DEC21 | Fixed v1 school roles versus public Pro advanced-role claims; teacher-application path | Kale | School staffing and plan permissions |
| DEC22 | All available premium school access versus KTA regional course eligibility | Kale | Library, access and geography |
| DEC23 | Central curriculum updates applied to active/archived classes | Kale and technical lead | Versions, delivery and evidence |
| DEC24 | Optional Premium Educator support scope, fees and contracting route | Kale | Program staffing and service enrolment |
| DEC25 | 12 August offer: 20-day prose versus 60-day order delivery and actual remaining scope | Kale and project lead | Contract milestones and roadmap |
| DEC26 | January 16 premium and nine marketplace block types versus reported three-block implementation | Technical lead with Kale | Builder, submissions and feedback |
| DEC27 | Baseline SaaS features and future enhancements mapped to signed delivery phases | Kale and project lead | Scope, UAT and release plan |
| DEC28 | Conflicting storage region language and configured tenant boundaries | Technical lead and policy owner | Hosting, access and exports |
| DEC29 | Hive consent scopes, parent-visible messaging and safe handling of queued posts after revocation | Kale and policy owner | Community, messages and moderation |
| DEC30 | Meaning and data source for premium listing Live indicator | Kale with technical lead | Discovery, scheduling and badges |

Use a decision record with question, alternatives, evidence, chosen rule, approver, date, effective version and implementation/test links. Do not close a decision merely because a developer has made a local assumption.

# **22 Repository infrastructure and knowledge recovery**

The earlier stack draft listed Flutter, Laravel/PHP, PostgreSQL, Firebase/Auth0 and AWS/Azure options. The newly supplied 12 August offer describes PHP/Laravel, HTML/CSS and React, and the developer reported server/frontend/backend deployment in May. These are correspondence claims, not inspection of dependency manifests or actual deployed infrastructure. \[N01\] Establish the actual stack from repositories, manifests, database migrations and hosting configuration. \[H01\]

On 20 August Kale explicitly requested frontend/backend repositories in a GitHub account/organisation he controls, with continuing team access and setup/deployment documentation. On 21 August the developer said current backend source was attached to the last delivery and promised complete source, commit history and proper documentation in Kale's GitHub at completion, with ownership belonging to Kale and no code reuse. The promise is now documented; actual transfer and completeness remain to be verified. \[N01\] An unrelated Lovable/Netlify student-project retrieval must not be mistaken for KTA+ architecture. \[H22\]

The new team should deliver the following repository-specific records:

* Repository URLs, organisation/owner, branches, release tags and protected-branch rules.  
* The commit currently deployed to each environment and the last known working commit.  
* Local setup instructions, dependency versions, database setup, migrations and seed/demo data.  
* Architecture showing actual services, database, storage, queues, scheduled jobs and external integrations.  
* Environment-variable names and secure ownership/access arrangements, without publishing secret values.  
* Deploy/release instructions, rollback steps, domain/DNS responsibility and TLS setup.  
* Jobs for renewals, expiry, reactivation, reminders and payout reconciliation, with failure handling.  
* Backup schedule, retention and an observed restore rehearsal.  
* Logs, monitoring, error alerts, access audit records and the operational contact owner.  
* Test evidence for critical journeys and known defects, with their severity and affected release.

Recover Robin's knowledge through existing code, comments, tickets, design files, messages and recordings. If Robin cannot participate, continuity must not depend on his recovery. The team should document each inferred rule and show the evidence supporting it.

The scope also includes frontend/backend source, schemas, APIs, UI/UX assets and build/deployment information in the earlier IP drafts. Confirm those assets are under the appropriate owner-controlled accounts. Do not treat a compiled app or a server login as a complete source-code handover. \[H19\]

# **23 Acceptance scenarios and demonstration order**

These are proposed acceptance checks for the replacement team. They are practical demonstrations and meaningful regression cases; they are not claims that tests have been run on the platform.

| ID | Scenario | Expected evidence |
| :---: | :---- | :---- |
| ACC01 | Parent with two children joins one program each | Correct child access, separate progress and guardian view |
| ACC02 | Learner requests another family's resource/submission | Backend denies access and records relevant failure |
| ACC03 | Family buys tokens; payment event repeats | One credit/receipt; no premium enrolment granted |
| ACC04 | Two simultaneous purchases exceed combined balance | No negative balance or duplicate fulfilment |
| ACC05 | Token lot expires and qualifying purchase reactivates it | Correct unavailable/reactivated balance and ledger history |
| ACC06 | Top-up refunded after reactivation | Approved reactivation/refund policy consistently applied |
| ACC07 | Premium parent adds, then cancels a token subscription | Independent bills and entitlements; premium enrolment and included materials remain active |
| ACC08 | Family purchases self-paced course | Syllabus/content/task flow without forced premium summary |
| ACC09 | Educator formats text and adds separate media blocks | Formatting/links and image/video blocks preserved; embedded Text Box media remains deferred |
| ACC10 | Teacher submits a parent-only listing | Co-op cannot obtain group rights from that offer |
| ACC11 | Co-op buys group licence and upgrades plan | Licensed seats work; unrelated seller courses stay separately paid |
| ACC12 | Co-op leader attempts custom authoring in v1 | Disabled in interface and denied by backend |
| ACC13 | Organisation invite awaits parental consent | Child remains appropriately restricted until approval |
| ACC14 | Micro-school teacher logs in | Assigned classes only; no school billing/admissions access |
| ACC15 | Custom iProject has draft and revised evidence | Original work, feedback, revision and outcomes remain connected |
| ACC16 | Group Pathways learners submit individual work | Private learner records with permitted shared collaboration |
| ACC17 | Educator is also a parent | Parent and educator scopes operate independently |
| ACC18 | Marketplace earning and contract session earning coexist | Correct separate bases and payout reconciliation |
| ACC19 | Missed program 1:1 under the Australian contract | Attendance/contact record and applicable AUD15 fee |
| ACC20 | Session crosses Australian daylight-saving change | Correct original/local times across family and teacher views |
| ACC21 | Compliance evidence expires | Approved warning/restriction without loss of student records |
| ACC22 | Typebot completes each enquiry branch | Correct mapped contact/tag and separate immediate notification |
| ACC23 | Payment succeeds while access fulfilment fails | Safe retry produces one entitlement |
| ACC24 | Team restores backup and deploys from documented source | Observed reproducible recovery |
| ACC25 | Creator starts self-paced course with no prior live cohort | Blank-course authoring and approved marketplace publication work |
| ACC26 | Creator converts completed live course to self-paced | Source retained; reused content and protected recordings obey approved access rules |
| ACC27 | School admin enables included premium and attempts unpurchased marketplace item | Premium needs no extra purchase; marketplace enablement denied until purchase |
| ACC28 | School buys marketplace course, enables it and creates class | One entitlement; distinct enablement, teacher assignment and student enrolment |
| ACC29 | School teacher attempts to upload or edit curriculum | Read-only interface and backend denial; platform authoring remains separately authorised |
| ACC30 | School owner pays subscription while parent pays tuition externally | B2B subscription only; no tuition split or local teacher payroll created |
| ACC31 | Family approved but child approval/class assignment pending | No automatic child approval or class access |
| ACC32 | Certified marketplace educator gains/loses Premium appointment | Independent states and multiple badges update without changing unrelated approvals |
| ACC33 | Public co-op switches Unlisted and Invite-Only | Discovery/profile/join flow changes immediately; private member data stays protected |
| ACC34 | Co-op selects plan and submits before approval | Country/plan saved; no premature charge; approval prompts payment and activation follows success |
| ACC35 | Teacher with missing/expired required clearance is assigned interactive duty | Guardrail rejects assignment and messaging; school cannot override |
| ACC36 | AdminTeacher edits summary for one KTA course | Other courses unchanged; summary precedes modules; marketplace self-paced has ordinary syllabus |
| ACC37 | AU/US parent browses marketplace and regional KTA courses | Marketplace cross-region access; direct KTA respects USA/AU/Global |

Demonstration order should follow the dependency chain: identities and permissions; educator approval/Teacher Module; content creation/review; enrolment and entitlement; teaching/submissions/summaries; wallet/payment; earnings/payout; organisation licences; scheduling/notifications; deployment/recovery.

# **24 Team working agreement and near term roadmap**

The September communications promised a full-team review, questions before discussion, a roadmap, server discussion and continuing weekly updates. Kale's October request reiterates inventory, completed/partial/remaining status, module logic, priorities, timeline and weekly video walkthroughs. \[H17\]

Proposed recovery phase: establish access, deployed version, actual data model and missing decisions. Produce the feature inventory and decision log before promising a new completion date.

Proposed implementation phase: complete Teacher Module, then payouts, Compliance Hub and settings in the recorded sequence, while resolving blocking payment/access/compliance decisions. Verify reported-complete modules alongside this work so defects are included in the real roadmap.

Proposed acceptance phase: run the critical scenarios, rehearse migration and deployment, demonstrate unresolved defects and obtain product acceptance against the agreed release scope. Native mobile and Institute expansion remain separately scoped work unless a current contract says otherwise.

Each roadmap item should contain feature, current status, owner, evidence, dependencies, unresolved decision, next deliverable and estimated date. Use complete, partial, not started, blocked or awaiting acceptance; avoid a single optimistic percentage.

The weekly video should show the actual build and commit/environment, demonstrate a finished workflow, identify remaining defects and decisions, and explain the next week's intended work. Pair it with a short written change log and updated feature status. A meeting longer than one hour may be needed to examine the connected commercial and teaching workflows; use the agenda rather than revisiting every historical document verbally.

# **25 Source register and review coverage**

The references below identify directly reviewed files, retrieved dated conversation records and public copy. Historical conversation recovery provides summaries of earlier messages; it is not the original full document or a complete meeting transcript. The replacement team should attach original specifications, acknowledged tickets and recordings to the corresponding decision records when available.

## **Directly reviewed sources**

| Reference | Source | Review result and use |
| ----- | :---- | :---- |
| D01 | KTA+ Pasted markdown.md, 9 August 2026 | Complete 465-line Institute questionnaire; proposed stages and unanswered design questions |
| D02 | TTN Educator Services Agreement 2026, 17 pages | Reviewed extracted text across all pages; contracting context, fees, summaries, attendance and weekly contributions |
| D03 | iProject International Pasted text(2).txt, master program prompt v2 | Complete 1343-line prompt read; personalisation, modes, inquiry, revision and portfolio logic |
| D04 | Screenshot Jul 23, 2026 at 7.00.58 am | Pixels reviewed; USD59/119/199 and AUD89/179/299 pairs visible |
| D05 | Contract-page photo 4EE0396A, 2 August 2026 | Extracted contract page; Framer/Figma/development phases and USD16900 agreement; full scope/signatures not established |
| D06 | KTA+ screenshots Sep 21, 2026 | Reviewed extracted integration/setup evidence; Typebot, Reach, contacts, tags and API setup; credentials omitted |
| D07 | KTA+ screenshots 10 and 20 July 2026 | Pixels reviewed; curriculum catalogue and workbook marketing imagery, supporting content context |
| D08 | Kingdom Thinkers Academy Pasted text (2).txt | Complete 3237-line curriculum prompt read; inquiry, evidence, critique, disciplinary integration and portfolio context |
| D09 | TTN Educator Onboarding Guide, 13 pages | Extracted text exposed only booking links; substantive guide contents not established |
| N01 | Pasted text.txt, supplied Oct 5, 2026 | Entire 4484-line developer correspondence reviewed; dated May–October decisions, acknowledgements, reports, demonstration links and source-handover promise |
| N04 | Pasted text(1).txt Full Developer Scope AU and US, supplied Oct 5, 2026 | Entire 5253-line SaaS scope reviewed; baseline features, schema/API examples, conflicts and future enhancements reconciled in Section 26; original creation date not stated |
| N07 | Robin's May 26 timeline supplied by Kale on Oct 5, 2026 | Four reported-complete items and 11 planned dates reviewed; crosswalk in Section 28; schedule is not proof of delivery |
| N06 | Initial Project Overview supplied by Kale on Oct 5, 2026; original date unspecified | Journey overview reviewed in full; mostly corroborates scope, adds explicit live indicator and program-teacher collaboration, and contains superseded payment/role wording |
| N05 | January 7 developer curriculum explanation supplied by Kale | Premium week structure and 16 block types; independent course/tutoring reuse and nine block types; design and mobile claims are historical reports; year not explicit |
| N03 | Oct 5, 2026 direct product confirmation | Premium enrolment separate from tokens; optional additional parent token subscription |
| N02 | Additional v1 correspondence supplied by Kale with this update | Providers/library, self-paced paths, educator status, co-op visibility and authoritative micro-school workflows; original dates mostly unspecified |
| W01 | https\://www\.ktaplus.io/pricing | Public text reviewed Oct 5, 2026; USD family/top-up/organisation snapshot; currency controls and checkout not verified |

D05 describes a separate design/landing-page engagement context. Do not import its amounts or milestones into the main platform development contract without the full agreement. D09 must be reviewed from the original rendered pages before its onboarding wording is treated as approved.

## **Dated historical development references**

| Reference | Date and topic | Evidence classification |
| ----- | :---- | :---- |
| H01 | 4 and 23 September 2025 developer brief/course/marketplace architecture | Historical assistant specifications following user requests |
| H02 | 16 and 23 September 2025 parent dashboard, consent and educator application | Historical specification; policy implementation unverified |
| H03 | 23 and 24 September 2025 organisation roles, country scope and parent consent | Explicit user requirements plus historical drafts |
| H04 | Sep 23, 2025 unified Program/Marketplace/Hybrid teacher dashboard | Historical design; 70/30 marketplace split proposal |
| H05 | Oct 28, 2025 Family Flex and premium payment separation | Explicit separation request and pricing draft |
| H06 | 30 November and 2 December 2025 self-paced/live/1:1 learning | Historical workflow drafts |
| H07 | 29 and 30 September 2025 local authoring and desktop-only authoring | Recorded requirements; co-op authoring later narrowed |
| H08 | Nov 9, 2025 Starter/Growth/Pro and premium-token model | User exploration plus assistant blueprint; conflicting history |
| H09 | 15, 19, 22 and 28–31 December 2025 organisation plans/licensing/read-only curriculum | Explicit co-op v1/licence requirements plus historical designs |
| H10 | Dec 21, 2025 entity separation and global approval authority | Explicit user operating constraint |
| H11 | 19 March and 14 June 2026 marketplace benefits and organisation pricing | Recorded preference and explicit pricing-page instruction |
| H12 | June 2026 developer progress, reactivation and Text Box | Earlier recovery; N01 dates token report to 26 June and supplies editor follow-up |
| H13 | 13 and 27 July 2026 premium builder and structured Program Summary | Earlier recovered drafts; N01 now provides sent requests, acknowledgements and subsequent progress |
| H14 | Aug 30, 2026 ecosystem explanation | Draft distinguishes tokens and paid premium programs |
| H15 | Aug 17, 2026 developer clarification and iProject progress | Earlier recovery; N01 confirms the answer was sent and received, with later iProject progress |
| H16 | 10, 20 and 22 July 2026 digital edition prices/inclusions | Recorded user acceptance for prices; inclusion drafts |
| H17 | 24–26 September and 4 October 2026 handover communications | Recorded team/status/priority and reporting requirements |
| H18 | September–October 2026 visible operational program correspondence | Package/timetable/enrolment/summary context; not full platform spec |
| H19 | August–December 2025 platform IP assignment drafts | Ownership intent and asset scope; execution not established |
| H20 | 28 May and 9 August 2026 Institute/verification/Premium discussion | Proposed prices, journey and status structure |
| H21 | 1 August and September 2026 Gabriel schedule/Institute interest page | User scheduling request and coming-2027 context |
| H22 | Aug 19, 2026 GitHub and backend handover enquiry | Visible request; repository status unverified |

## **Inventory coverage**

The KTA+ folder inventory contained 71 items: 68 image files, one video, one workbook/model and one Markdown questionnaire. Images were screened through available extracted text; the five July images lacking readable text were materialised and visually inspected. The Institute questionnaire was read in full. The investor-model workbook and marketing video were classified as supporting materials rather than technical implementation specifications. No software acceptance claim in this handover relies on them.

A wider non-image inventory returned 56 files and 11 folder entries. Targeted development/title/content searches did not identify a complete original technical specification or a full developer meeting transcript. Related curriculum and contract sources were read where they clarified learning and educator workflows. Source identities are retained in the working review record.

The newly supplied N01 correspondence adds primary development evidence beyond the original inventory. N02 locks several previously unresolved v1 decisions. Linked Google documents, Figma files and demonstrations are recovery pointers; their contents and current availability are not established by the pasted messages alone.

The following appendix records every item in the KTA+ folder and its review disposition. It helps the new team distinguish development evidence from adjacent investor, marketing and integration material.

# **26 Full SaaS scope reconciliation**

The original scope defines a much broader platform than the recent micro-school clarifications alone. It covers family and learner identity, three premium programs, independent courses/resources, organisations, community, regional admin operations, payments, safety, integrations and technical operations. These remain the baseline inventory for review. A later decision changes the specific conflicting rule; it does not silently delete every other requirement in that module. The attachment contains examples, placeholders, recommended features and explicitly future enhancements as well as requirements. Contractual inclusion and implemented status must be recorded separately. \[N04\]

## **Which source governs each rule**

Use Kale's current explicit confirmations and final v1 instructions for their stated scope. Preserve the later May–September decisions where they amend January or the original scope. Retain compatible January structure and block requirements unless an approved later scope change removes them. A developer saying no separate design is needed means reuse was planned, not that the underlying functionality was delivered. A later report of only three blocks is evidence of a narrower implementation, not approval to remove the other required blocks.

The January 7 message's year was not explicitly supplied. Treat it as the January baseline preceding the later updates in this project, without inventing an exact year in its source record. The full SaaS attachment's creation date is also not established. Neither document provides a verified inventory of today's deployed application.

## **Curriculum architecture and the January block inventory**

KTA and iProject share the week-based content builder, with program-specific content and permissions. This reuse is compatible with the later requirement for course-specific summaries, KTA themes and an iProject parent request/mentor assignment workflow. It does not make KTA and iProject identical products. Thinkers Academy and independent tutoring can share scheduling, classroom material and feedback components while retaining different enrolment, branding, educator engagement and payment rules. \[N05, N01\]

| Learning path | January structure | Current implementation interpretation |
| ----- | :---- | :---- |
| KTA | Course → Weeks → Lessons → Blocks | Shared premium builder; course-specific summary and themes; authorised AdminTeacher edits |
| iProject | Course → Weeks → Lessons → Blocks | Same builder; personalised request, mentor matching, learner plan and project evidence remain distinct |
| Independent Group Live | Course → Modules → Lessons → Blocks | Independent seller authoring; scheduled cohort and enrolment separate from curriculum |
| Independent Self-Paced | Recorded content and task submissions, with teacher feedback | Both blank creation and live-course conversion required by later decision; no mandatory live session |
| Thinkers Academy | Tutoring workflow designed in Figma, according to January report | Verify booking, placement, classroom material and parent summary; premium payment remains separate from tokens |
| Independent 1:1 tutoring | Reuse Thinkers Academy structure | Reuse UX/components without inheriting premium billing or contracted educator fees |

January specifies the following block menus. The teacher references describe authorised platform creators. They do not grant micro-school teachers curriculum-editing rights. Marketplace approval and premium authoring authority remain separate. \[N05, N02\]

| Premium KTA and iProject block | Corresponding independent Group Live option |
| ----- | :---- |
| Text Note | Text Note |
| Image | Image |
| Video | Video |
| Audio | Audio |
| Research Resources Link | External Link |
| File / PDF | Downloadable Resource |
| Reflection Response | Not separately named in the nine-block menu |
| Open-Ended Question | Not separately named; do not assume Quiz implements it |
| Checklist | Not separately named |
| Self-Assessment | Not separately named |
| Project Milestones | Not separately named |
| Vocabulary Word | Not separately named |
| Bible Connection | Not separately named |
| Family Discussion | Not separately named |
| Quiz | Quiz |
| Uploads Task | Uploads Task |
| No exact premium counterpart named | Discussion Prompt |

The right column maps comparable intent, not a verified shared database type. The independent menu contains nine distinct options. The later 27 June update reports Text, Image and Video only. June rich-text delivery does not prove Audio, Quiz, Uploads Task, Discussion Prompt, Downloadable Resource or External Link blocks work. Nor does it prove premium reflection, self-assessment, milestones, vocabulary, Bible/family discussion blocks exist. Record each block as implemented, partial, missing or explicitly deferred only after a demonstration. \[N01\]

For an interactive block, demonstrate more than creation: persistence, student rendering, response/submission, feedback, parent visibility, permissions and any completion rule. Confirm which of the nine marketplace options apply to self-paced authoring; the later self-paced instruction explicitly requires videos, downloads, quizzes, assignments and resources. No independent premium-only block rights should be inferred from a reused component.

## **Rules that the original scope must not reintroduce**

| Earlier scope or January assumption | Rule to preserve now | Source |
| :---- | :---- | :---- |
| iProject and Thinkers sessions may use tokens or Stripe; premium examples include token prices | Premium enrolment and its included benefits are paid separately from tokens. Parents may additionally subscribe to tokens; no premium access from a token plan | N03 |
| Marketplace courses/resources offer cash, tokens and ESA | Current marketplace model is token-based; remove marketplace ESA features as directed. Premium payment and applicable premium ESA arrangements are separate | N01 |
| Example prices such as one token per group session, USD49 direct course purchase or USD99 tutoring hour | Historical examples, not approved checkout values. Use confirmed pricing and current public catalogue; token redemption economics remain open | N04, W01 |
| Co-op coordinators and school admins create private courses/modules | No school-local curriculum creation, upload or restructuring in v1; co-op custom authoring is also excluded by later v1 decisions. Platform creator rights remain separate | N02, H09 |
| Micro-schools purchase premium bundles, teacher contracts and semester invoices | School owner pays Essentials/Pro platform subscription; available premium curriculum included; marketplace purchases separate; tuition and local teacher pay external | N02 |
| Broad third-party program language | Only KTA+ Premium and approved independent educators already on-platform; no external organisation provider submission route | N02 |
| Self-paced courses derived from recorded live delivery | Support both conversion and blank creation; no prior live cohort required | N02, N01 |
| One shared premium summary reused across KTA courses | Each premium course has its own summary; marketplace self-paced courses do not use premium Program Summary | N01 |
| Generic Category/Subject fields and fixed subjects | Separate Category removed; configurable subjects and multi-select reported delivered; contracted demo subject open text, admin mode toggle planned | N01, N02 |
| CONTRACTED/PROGRAM/MARKETPLACE represented by one teacher type | Keep approval, Marketplace/Premium educator type and certification independent. Preserve contracts/program assignments as additional engagement records | N02 |
| Teacher dashboard upload permissions apply to any school-linked teacher | School delivery teacher has read-only curriculum; authorised premium/marketplace authoring requires separate platform permission | N02 |
| Co-op creation/invite immediately yields active members | Plan/onboarding saved, platform review/payment activation as agreed; all family joining approval-based, child consent still required | N01, N02 |
| Public/Unlisted/Private-to-Group visibility applied interchangeably | Co-op organisation visibility is Public/Unlisted/Invite-Only. Listing/resource visibility is a different setting; no public profile for Invite-Only | N02 |
| January says no separate iProject design needed | Shared builder may be reused, but iProject request, placement, mentor and personalised learner flows still need implementation and review | N01, N05 |
| January says all mobile features designed | Design report only. Verify current mobile deliverables and release phase; responsive web does not establish a delivered native app | N05 |
| Automatic attendance from video logs or 90 percent viewed proves learning | Teachers record attendance, admins can override. Automation and self-paced completion criteria require validation; attendance, progress and achievement are different records | N02, N04 |

## **Full platform coverage for the replacement team**

Use this inventory alongside the dated development ledger. Retained baseline means the feature remains in the original scope inventory; it does not mean it is proven complete or contractually due in the next release. The project lead should map each row to the signed milestone, current owner, deployed evidence and remaining work. \[N04\]

| Scope area | Baseline responsibility to preserve or reconcile | Current review position |
| ----- | :---- | :---- |
| Regional SaaS and identity | AU/US operating contexts, family identity, guardian-linked learners, educator and organisation roles | Retain scoped access. Student self-registration in one free-signup paragraph contradicts the explicit parent-created sub-account rule; parent creation governs |
| Free entry and onboarding | Free profile/preview/sample resources, verification, parent/child data and consents | Retain inventory; sample entitlements and exact verification methods need current configuration. Later US online consent flow replaces print/upload UX |
| Premium programs | KTA themes/cohorts, iProject personalised mentoring and group paths, Thinkers tutoring and parent reports | Retain all three. Separate premium payments; shared content builder does not remove program-specific operations |
| Marketplace discovery | Cards/detail pages, age/subject/mode/schedule filters, seller profile, reviews, wishlist and listing policies | Retain inventory; remove superseded ESA/cash controls and Category field. Reviews/wishlists are not proven by filter delivery |
| Creator and publishing | Draft/review/publish, content ownership, course metadata, blocks, versioning and approval | Retain. Blank self-paced route required; compare 16/9 block baseline with actual three-block report |
| Resources and downloads | Packs/tasks, attachments, limited previews, owned/included states, protected download/viewer, history, watermarking | CRUD reported. Demonstrate full entitled learner journey; no token debit for included premium material; marketplace Resources token-only |
| Family wallet and tokens | Monthly allocation, top-ups, history, expiry, rollover, refunds and reactivation | Retain current prices/rules rather than example scales. Original monthly schema cannot alone model lot-specific expiry/reactivation or all top-ups |
| Premium billing and enrolment | Program offer/SKU, placement, direct payment, confirmed enrolment, materials and sessions | Retain; independent from tokens. Marketplace placement of a premium listing is discovery, not permission to token-pay |
| Regional finance and payouts | Merchant routing, receipts, disputes/refunds, marketplace share and program educator fees | Retain distinct earning models. Connect/dual Stripe accounts are design requirements, not verified configuration; local school payroll excluded |
| ESA premium operations | Verification, rule/SKU mapping, eligible checkout, receipts, attendance evidence and admin tools | Retain historical premium inventory pending phase/policy confirmation; remove marketplace ESA. Do not turn school tuition into a platform ESA checkout |
| Parent dashboard | Child oversight, schedules, programs, purchases, wallet, consent, communications, reports and safety | Retain; premium and token plan may coexist. Show school context and included access separately from family purchases |
| Student dashboard | Assigned content/sessions, tasks, submissions, feedback, resources and participation | Retain content access. School operational dashboard remains distinct from learner experience; achievement badges/certificates need verification |
| Educator onboarding and status | Marketplace vetting, contracted onboarding/demo/training/agreements, clearances and admin review | Retain approved routes. Independent statuses and manual Premium appointment replace single progression/type assumptions |
| Teacher delivery and growth | Assigned rosters, sessions, attendance, reporting, resources, messages, finance, compliance and Teacher Hub | Retain inventory. Restricted school delivery rights; creator permissions separately authorised. Teacher Hub detail/delivery remains unverified |
| Co-ops | AU/US onboarding, coordinators, roster, approvals, group licences, announcements, attendance and subscription | Retain. Current visibility logic and approval/payment flow govern; shared token pools and seatless licences are not automatically approved |
| Micro-schools | US entity/owner, admissions, separate child approval, teachers, enabled library, classes, safety and B2B subscription | Later authoritative flow governs; school autonomy and external tuition/payroll remain explicit |
| Global Hive | Platform-wide feed, curated channels, parent consent, safe display names, moderation, reports and portfolios | Retain baseline community inventory. Cohort discussions stay outside Global Hive; duplicated Space fields in attachment need cleanup, not new public school exposure |
| Local parent matching | Opt-in city-level discovery, parent connection request, accepted parent-only conversation, hide/block/report | Retain baseline inventory; feature flag initially off in scope. No child matching/DMs or exact address disclosure |
| Notifications and calendar | Session reminders/summaries, approvals, low balance, expiries, digests, timezone schedule | Retain core inventory; worldwide timezone change reported. Marketing campaigns and transactional email are separate requirements |
| AU/US platform admin | Programs, publishing review, educator/school approvals, finance, consents, incidents, moderation, configuration and support | Regional tools remain inventory; TTN Charity platform authority is superseded by H10. Confirm entity roles; authorised frontend AdminTeacher edits curriculum |
| AU donors | Donor consent/privacy, acknowledgements, donations and exports | Historical charity scope; platform inclusion/merchant need confirmation under H10. Non-DGR statement is historical, not current tax-status verification |
| CRM and integrations | HubSpot parent-only segmentation/sync in baseline, Stripe/Postgres linkage; later Reach/Typebot and Teachworks transition | Canonical CRM still open. Do not assume HubSpot dropped or Reach fully substituted; keep learner evidence out of marketing sync |
| Safety privacy and legal records | Consent versions, acceptance evidence, moderation, reporting, clearance renewal, audit exports and data access | Retain requirements inventory; verify actual policies and retention schedule. Several supposedly verbatim agreements are placeholders, not complete legal text |
| Technical operations and UAT | Backend/API/queue, storage/auth, encryption, tenant isolation, deployments, logs, exports and scenario checks | Reconcile with actual repository. Sample SQL, endpoints, JSON and stack options are illustrative; no assumption they exist in deployed code |
| Cross-dashboard and advanced features | Search, copilot, calendar/inbox, accessibility, trust tools, signals, interoperability, badges, offline support, flags | Preserve inventory and distinguish baseline proposals from explicitly future items; signed release allocation and completion unknown |

## **Community and safety details newly recovered**

The Hive is a global social learning area; class/cohort discussion belongs in separate class spaces. Minors' posting, commenting and reacting require the appropriate parent-granted scope. The attachment distinguishes View only, React and Post, with default/read-only and revoked states. Parent oversight and mentor moderation remain required. A revoked child must not be able to post through an old browser session, mobile session or queued action. Resolve what happens to previously queued posts before publishing them after consent withdrawal. \[N04\]

The document contains repeated composer fields, including a default this Space visibility that conflicts with its explicit global-only Hive definition. Preserve the global feed/channels model; do not infer that the Hive can expose school-class records. Family Threads are a separate private parent/family/mentor concept. Their release phase and exact access need confirmation.

No private student messaging is a retained baseline product guardrail. Later school guidance permits approved, cleared teachers to message students; interpret this as parent-visible, scoped communication unless Kale explicitly changes the safety model. Parental toggles cannot override platform restrictions, and clearance alone does not grant unrestricted private messaging. Local parent matching enables adult connections only after opt-in and accepted requests; it is separate from co-op discovery.

## **Explicitly future features and unresolved phase allocation**

The attachment labels role-specific enhancements as future: student focus planner, public-safe portfolio and wellbeing pulse; family auto-top-up/budget controls and smart oversight; teacher attendance assist, rubric helper and cohort composer; co-op seat orchestration, shared token pool and impact reports; micro-school clearance radar, standards map and request centre; AU donor insight/export/policy diff; and US ESA simulator/evidence autocomplete/benchmarks. Record these separately from launch defects. \[N04\]

The universal section also proposes semantic command search, role-aware AI copilot, two-way calendar integration, unified inbox, accessibility/translation tools, trust/export controls, safety intelligence, engagement risk signals, LTI/SCORM/OneRoster interoperability, open badges, offline submission/PWA support and experiments. It is not uniformly labelled future. Do not silently remove it, or promise it is in v1: map each capability to the agreed milestone and evidence. The micro-school dashboard's operational remit does not itself prohibit a separately scoped integration, but it does not require a full LMS/SIS implementation either.

## **Technical and policy contradictions to resolve before acceptance**

The original scope assigns TTN Charity AU platform administration and Stripe routing. The later December instruction excludes that charity from KTA+ operations, approvals, payments and moderation, and identifies TTN LLC as global network authority. Preserve that separation; the AU services contract does not reinstate charity platform control. Current merchants and IP ownership still need confirmation. \[H10, D02\]

The scope consistently requires tenant/role isolation but allows cross-region marketplace discovery in later decisions. Public catalogue visibility and data-access boundaries are different concerns. Private family, class, financial and compliance records still need scoped backend access. Confirm who can buy/teach across regions, which merchant applies and where sensitive records are stored; do not implement a blanket catalogue region block that conflicts with July access rules.

Storage language differs: several sections require AU-in-AU and US-in-US, while the technical summary says AU data on AU or US servers. Record an approved residency decision and inspect hosting configuration. The US/AU legal references and universal seven-year retention statements are historical scope claims. They do not establish current legal applicability or a legally sufficient retention policy; use approved policies and qualified review when resolving them.

The token SQL links each ledger to a subscription and each transaction to a child. Current top-ups, organisation licences, refunds, promotional credits and expiry/reactivation require additional relationships or a compatible implementation. Do not copy the example schema into production without reconciliation. Similarly, a resource's includedWithPrograms program flag is insufficient if only particular courses/packages include that file: check the actual enrolled offer and entitlement scope to prevent overgranting.

Automatic certificates, 90 percent video completion, provider attendance capture, parent approval of every feedback item and consent expiry notifications are baseline behaviours requiring confirmation. They must not be inferred from course CRUD. A missing consent may block new learner access, but the system should retain accurate historical attendance and safety evidence rather than prevent necessary record correction.

## **Additional demonstrations from the recovered scope**

| ID | Scenario | Expected evidence |
| :---: | :---- | :---- |
| ACC38 | Creator opens premium and independent block menus | Correct 16/9 baseline inventory or documented approved deferrals; unauthorised school staff cannot author |
| ACC39 | Learner submits interactive block and teacher reviews | Saved response/file, feedback, parent visibility and progress work together; no cross-learner leakage |
| ACC40 | KTA and iProject use same builder | Shared week structure; distinct course summary, content and iProject request/mentor lifecycle |
| ACC41 | Parent revokes Hive posting while old session has a queued action | Backend denies new participation; queued-publication policy enforced and audit retained |
| ACC42 | Parent opts out of local matching or blocks another parent | Discovery/contact requests cease as specified; no minors/exact addresses in adult matching |
| ACC43 | Included premium resource is also listed for token sale | Eligible learner downloads without debit; unrelated family must obtain its own licence |
| ACC44 | AU/US admin opens restricted records and regional finance | Correct scoped access/merchant; no leakage despite cross-region marketplace browsing |
| ACC45 | Admin reviews original-scope and future-feature inventory | Every item linked to milestone, owner, status and evidence; no design report treated as deployed acceptance |

# **27 Initial project overview review**

The initial journey overview reinforces the family-led model, marketplace discovery, separate premium/independent learning offers and scoped teacher dashboards. Its original date is unspecified; it is historical product context, not a replacement for the later v1 decisions. Most of its content is already covered in this handover. Two explicit details merit additional tracking: a Live indicator on premium listings, and collaboration between assigned program teachers. Neither statement supplies evidence of current implementation. \[N06\]

## **Useful additions and reinforced workflows**

| Detail in the overview | Contribution to the current handover | Developer action |
| :---- | :---- | :---- |
| Premium listings show Live when classes are active | Explicit listing-state requirement; not previously specified in this handover | Confirm whether it means a running cohort or a session happening now; derive from the approved schedule/status rule |
| Contract teachers collaborate under program admin guidance | Explicit staff collaboration expectation | Recover design/ticket and demonstrate permitted collaboration within assigned program scope; do not expose every teacher's roster or learner records |
| Parent messages a course teacher before enrolling | Reinforces Contact Teacher in the original SaaS listing scope | Adult enquiry should not require paid enrolment; apply approved teacher availability, reporting and rate limits without exposing child data |
| Parent assigns a child after purchasing | Reinforces separation of payment entitlement from learner enrolment | Support eligible child selection under the purchased licence; do not grant all siblings access from a single-child purchase |
| Premium and independent offers have distinct labels | Reinforces a shared discovery hub with different product types | Distinguish a Premium Program product label from the seller's Premium Educator badge and certification |
| Teachers view students, resources, tasks and feedback | Reinforces delivery workflow beyond course creation | Verify scoped enrolment, submissions, review and parent reports; do not infer all capabilities work because dashboard pages exist |

The Live indicator needs a precise rule. Live delivery mode, enrolment availability, an active cohort and a session in progress are different states. Use distinct wording where needed and avoid making the initial overview's phrase currently active imply a real-time broadcast. This is DEC30, rather than an invented implementation decision.

## **Older wording that must remain superseded**

Purchases using tokens or dollars is a broad historical description, not a choice of payment method for every product. Premium enrolment is separately paid, marketplace uses its current token model, and a premium parent may optionally add a token subscription. A premium listing inside Marketplace does not change those rules. \[N03, N01\]

Admin-managed premium programs describes platform ownership and oversight. It does not restore backend-admin curriculum editing: authorised frontend AdminTeacher creators manage premium course content under the later authoring decision. Approval of an independent educator does not itself publish every listing; content review, safety requirements and licence conditions still apply. Full control over pricing and content means control of owned offers within those platform rules. \[N01, N02\]

The two teacher types describe commercial engagement contexts. They do not collapse account approval, Marketplace/Premium status, certification, contracts or assignments into one exclusive role. Upload/share resources and create assignments applies only where separately authorised; school-linked delivery teachers still cannot author or alter curriculum. Student communication remains parent-visible and appropriately scoped. \[N02\]

Learning Leader is historical micro-school wording; the current v1 operational role is Micro-school Admin. Parents are one eligible founder group, not the only one: the later flow also allows US-based teachers, pastors and founders. Platform approval, external tuition, child approval and class assignment remain separate. The overview cannot bypass these gates or introduce platform tuition processing. \[N02\]

Standalone modules are mentioned again but were already in the original scope. Confirm how such offers are packaged, licensed and enrolled before exposing a new product type. Student access to a self-paced class means opening its content and tasks; it does not require a live Join Session action.

## **Additional demonstration**

| ID | Scenario | Expected evidence |
| :---: | :---- | :---- |
| ACC46 | Parent views premium listing before, during and after its approved active period | Live label follows the recorded definition and source data; delivery mode and available enrolment are not confused with session-in-progress status |

# **28 Robin May 26 delivery baseline**

Robin's May 26 timeline provides a concrete historical delivery sequence that was absent from the earlier pasted correspondence. It reports four items complete and schedules eleven further items between 6 June and 10 July. Preserve it as the original baseline, not today's roadmap. Later changes, reports and acceptance evidence determine current scope and status. No item becomes completed merely because its target date passed. \[N07\]

## **Items reported complete on May 26**

| Feature | Robin's reported status | Verification still required |
| ----- | :---- | :---- |
| Admin Dashboard layout | Completed | Layout only; demonstrate approval, permissions, configuration and finance workflows separately |
| Parent onboarding | Completed | Later record identifies email verification, US consent and redirect concerns; verify resolution and complete onboarding |
| Add children | Completed | Parent-owned child creation, sibling handling, consent and correct learner access; school child approval remains a separate gate |
| Database design and project structure | Complete | Obtain actual schema, migrations, repository structure and deployment documentation; reported design completion is not a source-code handover |

The completed parent/child claims are consistent with May UI/API progress reports, but they do not resolve the defects raised in the surrounding correspondence or establish current production acceptance. School-specific admissions and child approval must not be collapsed into platform child creation. \[N01, N02\]

## **Planned dates compared with later evidence**

| Milestone | May 26 target | Later record and current verification |
| :---- | :---- | :---- |
| Kingdom Thinkers Academy and its courses | 6 June | KTA APIs reported 4 June, authoring corrected 4–5 June; editing/summary still discussed July–August and completeness disputed 3–4 August. Verify full course lifecycle |
| Thinkers Academy and its courses | 10 June | January says Figma design complete; July asks how tutoring differs from KTA/iProject. No definitive end-to-end delivery acceptance identified |
| Teachers onboarding | 13 June | APIs reported 11 June; marketplace onboarding/login 22 June; contracted pages 8 July. Verify both routes, agreements, review, clearance and independent statuses |
| Assign teacher to premium program courses | 16 June | AdminTeacher account/assignment direction discussed 5 June; later premium pages and authoring reported. Demonstrate delivery assignment, scoped roster and reassignment separately from creator permissions |
| Independent teacher course creation | 20 June | Shared builder APIs 18 June; group builder/three blocks 27 June; later self-paced and metadata changes. Verify complete block inventory, both self-paced paths, review and publication |
| Purchase token | 23 June | Token/payment/wallet report dated 26 June. That report date does not establish the actual finish date; demonstrate successful and failed purchase, credits, history and expiry/reactivation |
| Purchase subscription | 25 June | One-time/subscription package APIs and payments reported 26 June. Verify renewal, cancellation and fulfilment; premium enrolment and optional token subscription remain independent |
| Full learner workflow | 30 June | Self-paced pages still updated July; learner resource APIs August, parent/student demo requested September; iProject explicitly incomplete 24 August. Demonstrate each learner route end-to-end |
| Media hub | 5 July | Baseline names a separate deliverable. No specific completion/acceptance evidence identified; recover intended podcast/blog/video/parent-resource scope and demonstrate it |
| Learner or children login access | 7 July | Authenticated dashboard routing explained 6 July, which is not proof of child login. Demonstrate child-specific credentials, guardian link, allowed records and unauthorised-access rejection |
| Profile settings | 10 July | Settings pages reported in role dashboards; initial AdminTeacher settings page mentioned 16 July. Demonstrate actual save/update and appropriate role scope, not page presence alone |

The table identifies dated evidence, not measured schedule variance. A report issued after a target could describe earlier work; a page or API delivered before a target could still leave integration unfinished. Record actual completion and acceptance dates only when supported by commits, deployments and demonstrations. No new completion percentage can be derived from this timeline.

## **What the timeline changes for the replacement team**

The baseline makes full learner workflow, child login, media hub and functional profile settings explicit delivery items. Keep them visible in the recovery inventory rather than inferring them from the presence of a course builder or dashboard. Thinkers Academy also needs its own verified tutoring journey, even if it reuses independent tutoring components.

The eleven dates describe sequence, not dependencies sufficient for release. Teacher approval and assignment, approved content, paid entitlement, guardian consent and child login must connect before a learner flow is accepted. Token/subscription success must produce the correct access while leaving premium enrolment independently billed. A later resource upload must appear in the correct authorised parent/student view.

The timeline does not list iProject, co-ops, micro-schools, payouts, Compliance Hub, global community or the entire SaaS integration inventory separately. Their absence is not evidence that they were excluded, cancelled or completed; use the full scope, later correspondence and signed milestones to determine commitments. The September recovery sequence remains Teacher Module, payouts, Compliance Hub and settings until replaced by an agreed current roadmap. \[N04, N01\]

Ask the team to report original target, current status, evidence link, remaining work, owner and revised forecast for every baseline item. Keep revised forecasts separate from original dates so the handover preserves the history. Do not silently reuse these past dates as a new promise.

# **Appendix KTA Plus file inventory**

| Item | Filename | Review disposition |
| :---: | :---- | :---- |
| 01 | Screenshot 2026-09-28 at 11.01.04 am.png | Text screened; investor application or financial support |
| 02 | Screenshot 2026-09-28 at 10.59.18 am.png | Text screened; investor application or financial support |
| 03 | Screenshot 2026-09-28 at 10.57.35 am.png | Text screened; investor application or financial support |
| 04 | Screenshot 2026-09-28 at 10.56.02 am.png | Text screened; investor application or financial support |
| 05 | Screenshot 2026-09-28 at 10.53.30 am.png | Text screened; investor application or financial support |
| 06 | Screenshot 2026-09-28 at 10.50.35 am.png | Text screened; investor application or financial support |
| 07 | Screenshot 2026-09-28 at 10.47.30 am.png | Text screened; investor application or financial support |
| 08 | Screenshot 2026-09-28 at 10.46.33 am(1).png | Text screened; investor application or financial support |
| 09 | Screenshot 2026-09-28 at 10.46.33 am.png | Text screened; investor application or financial support |
| 10 | KTA\_Plus\_Stage\_2\_Investor\_Financial\_Model.xlsx | Supporting investor model; not a technical specification |
| 11 | Screenshot 2026-09-28 at 10.38.45 am.png | Text screened; investor application or financial support |
| 12 | Screenshot 2026-09-28 at 10.36.41 am.png | Text screened; investor application or financial support |
| 13 | Screenshot 2026-09-28 at 10.36.14 am.png | Text screened; investor application or financial support |
| 14 | Screenshot 2026-09-28 at 10.31.50 am.png | Text screened; investor application or financial support |
| 15 | Screenshot 2026-09-28 at 10.19.05 am.png | Text screened; investor application or financial support |
| 16 | Screenshot 2026-09-28 at 9.13.28 am.png | Text screened; investor application or financial support |
| 17 | Screenshot 2026-09-28 at 9.12.30 am.png | Text screened; investor application or financial support |
| 18 | Screenshot 2026-09-28 at 9.11.02 am.png | Text screened; investor application or financial support |
| 19 | Screenshot 2026-09-28 at 9.09.24 am.png | Text screened; investor application or financial support |
| 20 | Screenshot 2026-09-28 at 9.06.55 am.png | Text screened; investor application or financial support |
| 21 | Screenshot 2026-09-28 at 9.05.10 am.png | Text screened; investor application or financial support |
| 22 | Screenshot 2026-09-28 at 9.03.23 am.png | Text screened; investor application or financial support |
| 23 | Screenshot 2026-09-28 at 9.01.42 am.png | Text screened; investor application or financial support |
| 24 | Screenshot 2026-09-28 at 8.43.47 am(1).png | Text screened; investor application or financial support |
| 25 | Screenshot 2026-09-28 at 8.58.36 am.png | Text screened; investor application or financial support |
| 26 | Screenshot 2026-09-28 at 8.53.07 am.png | Text screened; investor application or financial support |
| 27 | Screenshot 2026-09-28 at 8.49.35 am.png | Text screened; investor application or financial support |
| 28 | Screenshot 2026-09-28 at 8.46.52 am.png | Text screened; investor application or financial support |
| 29 | Screenshot 2026-09-28 at 8.43.47 am.png | Text screened; investor application or financial support |
| 30 | IMG\_6504.png | Text screened; investor application or financial support |
| 31 | IMG\_6502.png | Text screened; investor application or financial support |
| 32 | IMG\_6501.png | Text screened; investor application or financial support |
| 33 | Screenshot 2026-09-21 at 10.47.36 am.png | Text reviewed; enquiry and Reach integration D06 |
| 34 | Screenshot 2026-09-21 at 10.42.24 am.png | Text reviewed; enquiry and Reach integration D06 |
| 35 | Screenshot 2026-09-21 at 10.39.01 am.png | Text reviewed; enquiry and Reach integration D06 |
| 36 | Screenshot 2026-09-21 at 10.37.14 am.png | Text reviewed; enquiry and Reach integration D06 |
| 37 | Screenshot 2026-09-21 at 10.35.49 am.png | Text reviewed; enquiry and Reach integration D06 |
| 38 | Screenshot 2026-09-21 at 10.34.15 am.png | Text reviewed; enquiry and Reach integration D06 |
| 39 | Screenshot 2026-09-21 at 10.33.06 am.png | Text reviewed; enquiry and Reach integration D06 |
| 40 | Screenshot 2026-09-21 at 10.30.48 am.png | Text reviewed; enquiry and Reach integration D06 |
| 41 | Screenshot 2026-09-21 at 10.30.18 am.png | Text reviewed; enquiry and Reach integration D06 |
| 42 | Screenshot 2026-09-21 at 10.28.04 am.png | Text reviewed; enquiry and Reach integration D06 |
| 43 | Screenshot 2026-09-21 at 10.27.43 am.png | Text reviewed; enquiry and Reach integration D06 |
| 44 | Screenshot 2026-09-21 at 10.27.11 am.png | Text reviewed; enquiry and Reach integration D06 |
| 45 | Screenshot 2026-09-21 at 10.24.57 am.png | Text reviewed; enquiry and Reach integration D06 |
| 46 | Screenshot 2026-09-21 at 10.23.45 am.png | Text reviewed; enquiry and Reach integration D06 |
| 47 | Screenshot 2026-09-21 at 10.22.45 am.png | Text reviewed; enquiry and Reach integration D06 |
| 48 | Screenshot 2026-09-21 at 10.19.49 am.png | Text reviewed; enquiry and Reach integration D06 |
| 49 | Screenshot 2026-09-21 at 10.19.12 am.png | Text reviewed; enquiry and Reach integration D06 |
| 50 | Screenshot 2026-09-21 at 10.13.48 am.png | Text reviewed; enquiry and Reach integration D06 |
| 51 | Screenshot 2026-09-21 at 10.12.50 am.png | Text reviewed; enquiry and Reach integration D06 |
| 52 | Screenshot 2026-09-21 at 10.12.17 am.png | Text reviewed; enquiry and Reach integration D06 |
| 53 | Screenshot 2026-09-21 at 10.11.32 am.png | Text reviewed; enquiry and Reach integration D06 |
| 54 | Screenshot 2026-09-21 at 10.10.33 am.png | Text reviewed; enquiry and Reach integration D06 |
| 55 | Screenshot 2026-09-21 at 10.10.12 am.png | Text reviewed; enquiry and Reach integration D06 |
| 56 | Screenshot 2026-09-21 at 10.09.35 am.png | Text reviewed; enquiry and Reach integration D06 |
| 57 | Screenshot 2026-09-21 at 10.08.45 am.png | Text reviewed; enquiry and Reach integration D06 |
| 58 | Screenshot 2026-09-21 at 10.07.48 am.png | Text reviewed; enquiry and Reach integration D06 |
| 59 | Screenshot 2026-09-21 at 10.06.41 am.png | Text reviewed; enquiry and Reach integration D06 |
| 60 | Screenshot 2026-09-21 at 10.05.49 am.png | Text reviewed; enquiry and Reach integration D06 |
| 61 | Screenshot 2026-09-21 at 10.05.22 am.png | Text reviewed; enquiry and Reach integration D06 |
| 62 | IMG\_6299.jpeg | Text screened; marketing or supporting imagery |
| 63 | chart-1.png | Text screened; marketing or supporting imagery |
| 64 | KTA Final Cut v3 (1).mp4 | Marketing video; no technical acceptance relied on |
| 65 | Pasted markdown.md | Read in full; Institute questionnaire D01 |
| 66 | 4EE0396A-15CC-489E-9C59-20A303624753.png | Contract page extraction reviewed D05 |
| 67 | Screenshot 2026-07-23 at 7.00.58 am.png | Pixels reviewed; pricing or content context D04 D07 |
| 68 | Screenshot 2026-07-20 at 5.24.51 pm.png | Pixels reviewed; pricing or content context D04 D07 |
| 69 | Screenshot 2026-07-20 at 5.11.47 pm.png | Pixels reviewed; pricing or content context D04 D07 |
| 70 | Screenshot 2026-07-20 at 5.10.58 pm.png | Pixels reviewed; pricing or content context D04 D07 |
| 71 | Screenshot 2026-07-10 at 1.43.27 pm.png | Pixels reviewed; pricing or content context D04 D07 |

# **Appendix Original records needed for final reconciliation**

The full developer SaaS scope is now recorded as N04. Obtain its original version/date and the signed main-platform contract to establish delivery commitments; all versioned technical specifications; Robin's last substantive Zoom recording/transcript and follow-up decisions; the 5 October 42-minute meeting recording/recap and any replacement-team notes; linked planning/modifications documents and delivery source-code attachments; final pricing/expiry/payout approval; current Figma designs; GitHub repositories and issue history; architecture/schema/API documentation; deployed environment details; current compliance policies; and the complete onboarding guide.

Until these are reconciled, use this overview to preserve recovered logic and drive demonstrations. Keep every unresolved commercial or permission rule in the decision register so the replacement team does not silently make a new product decision while rebuilding missing context.