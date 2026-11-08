   

---

# **📚 KTA+ – Full Developer Scope (AU & US)**

---

## **![][image1]**

![][image2]

## 

## **1\) Introduction (verbatim)**

[https\://www\.canva.com/design/DAGx\_5iKRu0/a3Ta5v6Dy999-oA\_mTF7ng/edit?utm\_content=DAGx\_5iKRu0\&utm\_campaign=designshare\&utm\_medium=link2\&utm\_source=sharebutton](https://www.canva.com/design/DAGx_5iKRu0/a3Ta5v6Dy999-oA_mTF7ng/edit?utm_content=DAGx_5iKRu0&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton)

Logos for AU Charity and Programs (AU & US): [https\://www\.canva.com/design/DAG0BvM2zcg/o5uIaAT\_Nwb-EkW3kvzCLg/edit?utm\_content=DAG0BvM2zcg\&utm\_campaign=designshare\&utm\_medium=link2\&utm\_source=sharebutton](https://www.canva.com/design/DAG0BvM2zcg/o5uIaAT_Nwb-EkW3kvzCLg/edit?utm_content=DAG0BvM2zcg&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton)

**KTA+** is a **multi-tenant SaaS platform**, operated by:

* **The Transformation Network Ltd (Australia)** → registered charity (ABN 34 685 689 721), governed by the **ACNC**, subject to the **Privacy Act 1988 (Cth)** and the **Online Safety Act 2021**.

* **The Transformation Network LLC (United States)** → Delaware-registered LLC (EIN 33-4152618), subject to **COPPA**, **FERPA**, **CCPA/CPRA**, and **state child protection laws**.

**Goal:** Deliver **faith-centered education** with compliance, flexible monetisation, and safe community tools.

---

## **2\) Vision (verbatim)**

* **Faith \+ Family First:** integrate discipleship into education.

* **Safety \+ Compliance:**

  * AU → ACNC / eSafety.

  * US → FTC / FERPA / State laws.

* **Flexibility:** Free sign-up, token system, structured program enrolments.

* **Scalability:** Families, teachers, co-ops, micro-schools.

* **Marketplace:** Educators sell resources, courses, and programs.

* **Premium Access:** Structured programs (KTA, iProject, Thinkers) also available via the **Marketplace** for eligible families, co-ops, and micro-schools.

---

## **3\) Stakeholders (verbatim)**

* **Parents** → Primary account holders.

* **Students** → Sub-accounts, never self-register.

* **Teachers** → Independent contractors.

**Role Naming Summary (KTA+ Platform)**

**Kingdom Thinkers Academy – Teacher:** Familiar, trusted, and relational term that resonates with parents and reflects holistic, faith-based learning.

**iProject International – Mentor:** Personal and growth-focused role that aligns with project-based, student-led learning and discipleship.

**Thinkers Academy – Tutor:** Academic support role providing targeted assistance for mainstream students needing homework or exam help.

**Independent Teacher Marketplace – Instructor:** Clear, skills-based title suited for marketplace courses and global audiences.

**Platform-wide System Role – Educator:** Neutral umbrella label used across backend systems to cover all teaching roles.

* **Co-op Coordinators** → Billing/admin role for small groups.

* **Micro-School Admins (US only)** → Org-level managers.

* **Admins** → AU (charity staff) & US (LLC staff).

* **Donors** → AU only.

---

## **4\) Core Features (verbatim)**

* **Programs:** Kingdom Thinkers Academy (KTA), iProject International, Thinkers Academy.

* **Marketplace:** Upload courses/resources, teacher vetting required.

* **Dashboards:** Role-specific dashboards (Parents, Students, Teachers, Co-ops, Micro-schools, Admins).

* **Premium Access:**

  * Families → enrol directly.

  * Co-ops \+ Micro-schools → access bundled enrolments.

  * **Programs also accessible through the Marketplace** for flexible purchase.

* **CRM:** HubSpot integrated with Stripe \+ Postgres.

# **💳 KTA+ Payments & Pricing – Developer Scope**

---

## **1\) Payment Levels Overview**

KTA+ operates with **three main entry levels** across both AU (charity) and US (LLC):

### **1\. Free Sign-Up (Onboarding Funnel)**

* **Who:** Any parent/guardian, student, or teacher.

* **Access:**

  * Create a profile.

  * Explore dashboards (preview mode).

  * Access sample resources (e.g., one free lesson or PDF pack).

* **Purpose:** Build trust, capture leads, and allow families to explore before paying.

* **Backend Flags:** `account_tier = FREE_TRIAL`

---

### **2\. Family Subscription \+ Tokens**

* **Who:** Families who want flexible access without locking into a program.

* **Model:** Monthly subscription → monthly token allocation.

* **Example Pricing:**

  * **US:** \$25–35 USD / family / month.

  * **AU:** \$40–60 AUD / family / month.

* **Token Usage:**

  * Group classes → 1 token per class.

  * Resources/downloads → 0.25–0.5 token.

  * 1:1 tuition → 3–5 tokens per session.

* **Features:**

  * Tokens roll over month to month.

  * Parents manage tokens in dashboard.

  * Prevents wasted fees (families only pay for what they use).

* **Backend Implementation:**

  * Subscription creates **monthly token credit allocation** in `tokens_ledger`.

  * Token balance reduces as items booked/downloaded.

  * Unused tokens roll over with `balance_forward`.

  * Token expiry policy (e.g., 12-month expiry) configurable.

---

### **3\. Program Enrolments (Premium Paths)**

Logos for programs  
[https\://www\.canva.com/design/DAG0BvM2zcg/o5uIaAT\_Nwb-EkW3kvzCLg/edit?utm\_content=DAG0BvM2zcg\&utm\_campaign=designshare\&utm\_medium=link2\&utm\_source=sharebutton](https://www.canva.com/design/DAG0BvM2zcg/o5uIaAT_Nwb-EkW3kvzCLg/edit?utm_content=DAG0BvM2zcg&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton)

Structured program enrolments for families who want a full commitment.

* **Kingdom Thinkers Academy (Homeschool Focus): ages 5-18**

  * Enrolment fee per term/semester.

  * Includes group classes \+ optional 1:1 add-ons.

📚 Kingdom Thinkers Academy – Developer Notes

1\. Framework: Five-Theme Model

A unifying lens for faith, wisdom, and learning across ages 5–18.

Themes (10-week cycles):

Made In His Image → Identity, dignity, vocation, Christ-like character.

Creation → Wonder, science, and stewardship; studying God’s world with care.

In His Hands → Providence, trust, resilience; seeing God’s care and responding with wisdom.

Alpha & Omega → God’s big story across time; history’s patterns and hope.

In The World, Not Of It → Discernment & wise engagement with culture and civic life.

How the framework works:

Themes generally run on 10-week cycles; Made In His Image may span the full year as a throughline.

Each group has a Big Picture statement that frames the inquiry (truth/proposition guiding questions \+ assessment).

Themes act as lenses that shape projects/units; Scripture anchors every inquiry.

Learners document evidence, reflections, and outcomes.

Assessment emphasizes growth of character, understanding, and skill alongside product quality.

Parents and teachers coach the process.

2\. Interactive Classes & 1:1 Pathways

Designed for ages 5–18 with guided projects, inquiry, and mentoring.

Australian Curriculum (AU families)

Aligned with the Australian Curriculum v9 for homeschool registration and reporting.

Flexible enough for Australian expat families abroad.

US Curriculum Standards (US families)

Alignment will vary by state.

Core structure (themes \+ inquiry cycles) remains consistent, but mapping to state standards will be localized depending on where the family resides.

ESA-funded families may require evidence of alignment to state-approved benchmarks → dev note: store and generate curriculum mapping documents per state.

Inquiry & Projects

Transdisciplinary, project-based learning cycles.

Builds wisdom, skill, and practical application.

Ages 5–18 Pathways

Cohorts that nurture growth at each stage (primary → middle → secondary).

Each linked to the Five-Theme Framework.

Christian Educators

Qualified teachers with a biblical worldview.

Act as guides, mentors, and facilitators (not just content deliverers).

3\. Parent Interaction

Enrol children by term (AU) or semester (US).

Select theme/program cycle at sign-up.

View progress reports, attendance, and project submissions in dashboard.

Manage payments via Stripe (AU Charity / US LLC) or ESA (US).

Consent management embedded for all enrolments.

In US: Parent dashboard will also display state-aligned reporting tools if ESA/state rules require it.

4\. Teacher Interaction

Teachers are vetted and contracted by the charity (AU) or LLC (US).

Use their dashboard to:

Schedule live classes.

Upload self-paced lessons/resources.

Track attendance \+ ESA compliance logs.

Record student progress (projects, assessments, reflections).

Teachers may also tag lessons with state-alignment metadata (for US).

Collaboration with parents encouraged — parents can view and comment on reflections.

5\. Student Experience

Log in with personal dashboard (child sub-account).

View classes, projects, and resources aligned to their theme cycle.

Submit assignments/projects.

Access downloadable 10-week resource packs \+ tasks.

Join live classes or view recordings.

US students: may see additional “State Standards” tags linked to their lessons if required for compliance.

* **iProject International (Homeschool Project-Based Learning): ages 5-18**

  * Program fee for mentorship \+ projects.  
  * Specialised Group Classes

  * Includes community and showcase events.

🌱 iProject International – Developer Notes

1\. Program Overview & Ethos

Positioning:

iProject International is a project-based, inquiry-driven, faith-centered program where students design, build, and present real-world projects with Christian mentors.

Core Attributes:

200+ hours of one-on-one mentoring already delivered.

15+ years of educator experience backing the model.

50+ completed projects demonstrating proven outcomes.

Emphasis on innovation — projects can range from digital city design to entrepreneurial ventures with real-world impact.

Flexible pathways: families can choose the scope and mode of delivery that fits their needs.

Curriculum customization: families can align projects with national/state curriculum or pursue fully inquiry-based learning.

Community hub: includes “The Hive” for peer connection, reflection, and showcases.

Group classes: added alongside 1:1 mentoring for collaborative experiences.

2\. Structure, Delivery & Features

Delivery Modes

One-to-One Mentorship: personalized sessions tailored to the student’s interests.

Group Classes: collaborative classes in selected topics (entrepreneurship, innovation, etc.).

Blended/Self-Paced Tasks: downloadable or online project tasks that support live mentoring.

Project & Inquiry Cycles

Students advance through projects anchored in inquiry questions.

Each student follows a personalized learning plan, co-designed with mentors and parents.

Projects culminate in deliverables or presentations that are often shared publicly.

Community & Collaboration

The Hive: a student hub for peer-to-peer reflections, project updates, and showcases.

Mini-Collaborations: opportunities for students to collaborate with peers on smaller projects.

Encourages peer feedback and Christian community interaction.

Curriculum & Alignment

Australia: families can align projects with the Australian Curriculum to meet state requirements.

United States: alignment depends on the family’s state; projects can be mapped to state benchmarks as required (especially for ESA-funded families).

Flexibility: families may choose more formal alignment or a fully inquiry-led approach.

Assessment & Feedback

Focus is on growth and iteration rather than high-stakes testing.

Teachers/mentors provide rubric-based feedback, comments, and progress reflections.

Formal assessments (tests, quizzes) are available as optional add-ons for families who want them.

Enrollment Dynamics

Students can join at any point in the year (not locked to traditional term dates).

Works well for families with multiple children — each child can have a custom plan.

3\. Parent / Teacher / Student Experience

Parents

Collaborate with mentors to design their child’s personalized learning plan.

Access progress dashboards showing project milestones, reflections, and attendance.

Approve enrolments and curriculum alignment choices.

Manage billing or token usage for sessions.

Teachers / Mentors

Mentor dashboard to manage assigned students’ projects and progress.

Schedule 1:1 or group sessions.

Provide rubric-based feedback, reflections, and ongoing coaching.

Moderate peer interactions in “The Hive.”

Students

Student dashboard displays projects, tasks, mentor feedback, and peer contributions.

Submit deliverables, reflections, and revisions.

Join live sessions or access recordings.

Engage in collaborative experiences through mini-collabs and showcases.

* **Thinkers Academy (Mainstream School Support): ages 5-18**

  * Families purchase 1:1 tuition sessions separately.

  * Per-session or bundle pricing (e.g., 5-pack, 10-pack).

🧠 Thinkers Academy – Developer Notes & Spec

1\. Program Overview & Ethos

Positioning:

Thinkers Academy provides 1:1 online tuition tailored to students in primary/elementary and secondary/senior school (2–12), helping them build knowledge, confidence, and character through personalized instruction.

Key Attributes:

One-on-one tutoring delivered by qualified Christian educators.

Covers all academic subjects (math, literacy, science, etc.).

Uses a digital classroom hub where assignments can be uploaded and shared with the tutor.

After each session, parents receive a summary / feedback report.

Flexible payment models: pay-as-you-go or term-based.

Emphasis on diagnosis, growth, and relationship-based learning.

2\. Structure, Delivery & Features

Delivery Modes

1:1 Tutoring Sessions: Students book private one-to-one lessons.

Digital Classroom Hub: A shared online workspace where students and tutors can upload assignments, collaborate, and review materials.

Session Feedback & Reporting: After each session, a summary is sent to parents, including progress and next steps.

Session Flow

Engaging Start: Begin by discussing focus areas and goals for the session.

Learning Goal: Establish what the student aims to achieve.

Concept Exploration: Tutor leads demonstration, guided practice, and application.

Progress Reflection: Student and tutor review what was learned and areas to work on.

Personalized Feedback: Tutor sends detailed feedback to parent within \~24 hours.

3\. Parent / Teacher / Student Experience

Parents

Book sessions through their dashboard (per session or term packs).

Get emailed summaries after each tutoring session.

See upcoming sessions, past sessions, and performance feedback.

Manage payment (tokens or Stripe) and monitor usage.

Teachers / Tutors

Manage their students’ schedules and session bookings.

Access the digital classroom hub to review assignments, upload materials, and interact with students.

Provide session summaries and qualitative feedback.

Use diagnostic assessments to tailor future lessons.

Students

Login to access scheduled tutoring sessions.

Use digital classroom to upload homework or view resources.

Participate live (via Zoom / integrated video) or revisit recorded sessions.

Reflect on their progress via self-check prompts.

4\. Curriculum, Alignment & Flexibility

Thinkers Academy supports alignment with state/national curricula as needed — especially to help students with school requirements.

While the core is tutoring rather than full curriculum delivery, tutors can tailor lessons to school topics or the family’s goals.

For US families, alignment to state standards would depend on the student’s location; tutors can tag lessons with the relevant standards when needed.

Flexibility in pacing: sessions can adapt based on student progress and need.

5\. Pricing Models & Payments

Pay-As-You-Go: per-hour rate (e.g. \$99/hr).

Term Pricing: a package for a set number of sessions per term (e.g. 10-week bundle at discounted rate).

No long-term lock-in contracts — families can cancel as needed.

Payments processed via Stripe (or integrated into token system in KTA+).

6\. Integration with KTA+ Platform

Thinkers Academy will fit into the same enrolment, billing, dashboard, token, and compliance systems as KTA and iProject.

Tutors also appear in the teacher marketplace if they choose to sell custom courses or resources.

Session scheduling, class materials, and feedback all use shared platform components (calendar, file upload, messaging, reports).

Analytics: session counts, tutor utilization, parent feedback, session summaries.

* **Premium Access via Marketplace:**

  * All structured programs (KTA, iProject, Thinkers) also listed in the **Marketplace**, so families, co-ops, and micro-schools can buy directly.

  * Co-ops and Micro-schools may bulk-enrol with premium program bundles.

**Backend Implementation:**

* SKUs: `KTA_TERM_STD`, `IPROJECT_10W`, `THINKERS_1ON1_5PK`, etc.

* Stripe Checkout sessions created with SKU → map to program enrolment table.

* Attendance automatically tied to program enrolment ID.

* ESA eligibility checked via **esa\_program\_rule\_skus** (see ESA section).

---

## **2\) Payment Flows**

### **A. Stripe (Family Subscription \+ Program Enrolments)**

* **AU Charity:** Stripe account `AU_CHARITY` (The Transformation Network Ltd).

* **US LLC:** Stripe account `US_LLC` (The Transformation Network LLC).

* **Connect accounts:** Used for teacher payouts (70/30 split).

* **Currencies:** Multi-currency (AUD for AU, USD for US).

### **B. ESA (US Only)**

* Parents select **ESA** at billing step.

* Must complete **ESA Verification Form \+ Agreement**.

* Once approved, eligible SKUs may be purchased via ESA.

* Mixed cart flow: ESA-eligible → ESA checkout, non-eligible → Stripe personal card.

* ESA receipts \+ attendance logs generated automatically (7-year retention).

---

## **3\) Subscription & Token Ledger (DB)**

**Table: tokens\_ledger**

`CREATE TABLE tokens_ledger (`

  `id UUID PRIMARY KEY DEFAULT gen_random_uuid(),`

  `parent_id UUID NOT NULL REFERENCES parents(id),`

  `subscription_id UUID NOT NULL,`

  `month_start DATE NOT NULL,`

  `tokens_allocated NUMERIC(6,2) NOT NULL,`

  `tokens_used NUMERIC(6,2) DEFAULT 0,`

  `tokens_rolled_over NUMERIC(6,2) DEFAULT 0,`

  `balance NUMERIC(6,2) GENERATED ALWAYS AS (tokens_allocated + tokens_rolled_over - tokens_used) STORED,`

  `expiry_date DATE,`

  `created_at TIMESTAMPTZ DEFAULT NOW(),`

  `updated_at TIMESTAMPTZ DEFAULT NOW()`

`);`

**Table: token\_transactions**

`CREATE TABLE token_transactions (`

  `id UUID PRIMARY KEY DEFAULT gen_random_uuid(),`

  `ledger_id UUID NOT NULL REFERENCES tokens_ledger(id),`

  `child_id UUID NOT NULL REFERENCES children(id),`

  `sku_code TEXT NOT NULL,`

  `tokens_spent NUMERIC(6,2) NOT NULL,`

  `description TEXT,`

  `created_at TIMESTAMPTZ DEFAULT NOW()`

`);`

---

## **4\) User Journey Flow (with Payments)**

1. **Free Sign-Up** → parent creates account, explores dashboards, sees free resources.

2. **Upgrade to Subscription** → family chooses monthly plan, receives tokens.

3. **Use Tokens** → book group classes, download resources, book 1:1 sessions.

4. **Program Enrolments** → commit to structured program (KTA/iProject/Thinkers).

5. **ESA (US families only)** → verify ESA, then use funds for eligible programs/resources.

6. **Co-ops / Micro-schools** → coordinators/admins buy premium bundles; parents can still use ESA individually for their child.

---

## **5\) Developer Requirements for Payments**

✅ **Stripe Integration**

* Dual accounts: AU (charity) \+ US (LLC).

* Token subs billed monthly; enrolments billed per SKU.

* Receipts auto-generated for Stripe \+ ESA.

✅ **ESA Integration**

* Must respect state rules (`esa_program_rules`).

* Generate ESA Receipts \+ Attendance Logs automatically.

* Parents see **Receipts & Attendance** tab in Dashboard.

✅ **Token System**

* Monthly allocation based on subscription tier.

* Transactions logged in `token_transactions`.

* Rollovers supported; expiry configurable.

✅ **Program Enrolments**

* Map each enrolment to SKU; mark as premium program in DB.

* Attendance logs link to enrolment.

* Bulk enrolments possible for Co-ops/Micro-schools.

✅ **Audit & Compliance**

* 7-year storage for ESA \+ COPPA/FERPA consents.

* Stripe receipts \+ ESA receipts stored immutable.

* All actions logged (timestamp, IP, user\_id).

---

## **6\) Example Pricing (placeholders for dev & ops)**

| Product | US Pricing | AU Pricing |
| ----- | ----- | ----- |
| Family Subscription (tokens) | \$25–35 USD / month | \$40–60 AUD / month |
| Group Class | 1 token | 1 token |
| Resource Download | 0.25–0.5 token | 0.25–0.5 token |
| 1:1 Tuition | 3–5 tokens | 3–5 tokens |
| KTA Program (per term) | \$XXX USD | \$XXX AUD |
| iProject Program (10 weeks) | \$XXX USD | \$XXX AUD |
| Thinkers 1:1 Bundle (10 pack) | \$XXX USD | \$XXX AUD |

*(XXX placeholders → to be set by ops team)*

# ***📚 KTA+ Developer Scope – Course Modules***

---

## ***1\) Purpose***

*The **Course Module Builder** is the central tool for learning content in KTA+.*  
 *It must support:*

* ***Teachers in Marketplace** (selling standalone modules/courses).*

* ***Premium Programs** (KTA, iProject, Thinkers).*

* ***Co-ops** (custom group modules).*

* ***Micro-schools** (org-level courses for their students).*

*Inspired by **Mighty Networks’ course creation**, but adapted to:*

* *Handle compliance (child safety, consent).*

* *Fit the **token system** (for flexible purchase).*

* *Work with **ESA receipts** (attendance logs for US families).*

---

## ***2\) Module Hierarchy***

*`Course → Modules → Lessons → Blocks`*

* ***Course** \= top-level product (e.g., “Survival Skills Term 1”)*

* ***Module** \= a themed grouping (e.g., “Shelter Building”)*

* ***Lesson** \= a single learning event (live or self-paced)*

* ***Block** \= smallest unit of content (text, video, quiz, resource, task)*

---

## ***3\) Course Metadata (teacher-facing form fields)***

*When creating a new **Course** (Marketplace or Premium):*

* ***Title** (short text) – required*

* ***Subtitle/Tagline** (short text) – optional*

* ***Description** (rich text) – required*

* ***Category/Subject** (dropdown, multi-select; e.g., Faith, STEM, Arts, Literacy, History)*

* ***Programs Flag** (checkbox): KTA / iProject / Thinkers / Marketplace / Co-op / Micro-school*

* ***Target Age/Year Level** (dropdown; multiple allowed)*

* ***Estimated Duration** (e.g., “6 weeks”, “12 hours total”)*

* ***Difficulty Level** (Beginner / Intermediate / Advanced)*

* ***Tags/Keywords** (chips for search)*

* ***Cover Image** (file upload, min 1200x675px)*

* ***Promo Video** (optional embed or upload, MP4 \< 200MB)*

* ***Pricing/Access**:*

  * *Token cost (if Marketplace)*

  * *Included in Program (if Premium)*

  * *Bundle eligible (Y/N)*

* ***Consent Flags:***

  * *AU → require parent consent check before enrollment*

  * *US → ESA eligibility (pull from `esa_program_rule_skus`)*

---

## ***4\) Module Metadata***

*Each **Course** has one or more **Modules**.*

* ***Module Title** (short text)*

* ***Module Overview** (rich text; 200–500 words)*

* ***Module Duration** (weeks or hours)*

* ***Order/Sequence** (drag-and-drop ordering)*

* ***Optional Cover Image** (banner for module card)*

---

## ***5\) Lesson Metadata***

*Each **Module** has multiple **Lessons**.*

* ***Lesson Title** (short text)*

* ***Lesson Type** (radio):*

  * ***Live Class** (Zoom/WebRTC integration)*

  * ***Self-Paced** (on-demand content)*

  * ***Project Task** (upload/deliverable required)*

* ***Lesson Overview** (rich text; 100–300 words)*

* ***Lesson Objectives** (checklist of 2–5 outcomes)*

* ***Resources** (multiple uploads: PDF, PPT, DOCX, MP4, links)*

* ***Estimated Time to Complete** (minutes/hours)*

* ***Attendance Requirement (Y/N)** – required for ESA compliance.*

---

## ***6\) Lesson Blocks***

*Teachers build **content blocks** inside each lesson.*

***Supported Block Types (similar to Mighty Networks):***

1. ***Text Block***

   * *Rich text (headings, lists, formatting, scripture quotes).*

2. ***Video Block***

   * *Upload (MP4, \<500MB) or embed (YouTube/Vimeo).*

   * *Captions file upload (VTT/SRT).*

3. ***Audio Block***

   * *Upload MP3 or embed podcast-style content.*

4. ***Image Block***

   * *Upload PNG/JPG (with alt text for accessibility).*

5. ***Quiz Block***

   * *Question types: Multiple choice, True/False, Short answer.*

   * *Option: “Auto-grade” vs “Manual review”.*

6. ***Assignment/Task Block***

   * *Instructions (rich text).*

   * *File upload (PDF, DOCX, image, video).*

   * *Deadline (date/time).*

7. ***Discussion Prompt Block***

   * *Title \+ description.*

   * *Link to moderated forum thread.*

   * *Parent oversight via dashboard.*

8. ***Downloadable Resource Block***

   * *Upload (PDF, DOCX, ZIP).*

   * *Token cost (0.25–0.5 tokens, if Marketplace).*

9. ***External Link Block***

   * *Title \+ URL (open in new tab).*

   * *Safety disclaimer.*

---

## ***7\) Teacher / Admin Permissions***

* ***Teachers (Marketplace):***

  * *Can create/edit their own Courses → Modules → Lessons.*

  * *Cannot publish until vetting \+ approval.*

* ***Program Admins (Premium Programs):***

  * *Can create/edit on behalf of KTA/iProject/Thinkers.*

* ***Co-op Coordinators / Micro-school Admins:***

  * *Can create **private courses/modules** visible only to their group.*

* ***Global Admins (AU/US):***

  * *Full override \+ moderation rights.*

---

## ***8\) Publishing Workflow***

1. *Draft → Teacher builds course (unpublished).*

2. *Submit for Review → Admin reviews for alignment with policies.*

3. *Publish → Course live in Marketplace or attached to Program.*

4. *Updates → New version saved; old version archived (audit).*

---

## ***9\) Compliance & Safety***

* ***AU:** Must comply with Privacy Act 1988 (Cth), Online Safety Act 2021, Child Safe Standards.*

* ***US:** Must comply with COPPA, FERPA, CCPA/CPRA.*

* ***Moderation hooks:***

  * *Auto-flag text for banned words.*

  * *Auto-scan uploaded files with virus scanner.*

  * *Teachers must tag lessons “ESA Attendance Required” where applicable.*

---

## ***10\) Attendance Tracking***

* ***Live classes:** Attendance auto-marked from Zoom/WebRTC logs.*

* ***Self-paced lessons:** Completion \= “viewed 90% of content” or quiz submitted.*

* ***Projects:** Completion \= submission uploaded.*

* ***ESA:** Only states marked `attendance_required = TRUE` must generate logs.*

---

## ***11\) Receipts & Certificates***

* ***Marketplace:** Auto-generate Stripe receipt \+ optional “Certificate of Completion”.*

* ***Premium Programs:** Certificate auto-issued at module completion.*

* ***ESA:** Generate ESA receipt \+ attendance log (per course).*

---

## ***12\) Database Schema (simplified)***

*`courses (id, title, subtitle, description, category, target_age, duration, difficulty, cover_image, promo_video, program_flags, pricing, created_by, status)`*

*`modules (id, course_id, title, overview, duration, order)`*

*`lessons (id, module_id, title, type, overview, objectives, resources, estimated_time, attendance_required)`*

*`lesson_blocks (id, lesson_id, block_type, content_json, order)`*

*`enrollments (id, course_id, parent_id, child_id, payment_method, token_cost, esa_status, created_at)`*

*`attendance_logs (id, enrollment_id, lesson_id, status, duration, timestamp)`*

---

## ***13\) Example Flow***

***Teacher Marketplace Course – “Intro to Robotics”***

* *Course → 3 Modules → each with 4–5 Lessons → each Lesson has mix of text, video, quiz, assignment.*

* *Priced at 10 tokens or \$49 direct purchase.*

* *ESA flagged **eligible** (attendance logs required).*

* *Parent buys → child enrolled → parent sees consent record in Dashboard → receipts \+ attendance auto-generated.*

**🛒 Marketplace Course Listing – Product & UI Spec**

## **1\) Listing Card (Catalog/Grid view)**

**Purpose:** fast scan, high CTR, consistent with Outschool-style listings.

**Required fields on card:**

* Cover image (16:9, min 1200×675)

* Course Title

* Short tagline (max 90 chars)

* Age range / Year level (e.g., “Ages 8–11”)

* Meeting pattern (e.g., “Weekly • 8 weeks • Live” or “Self-paced • 6 lessons”)

* Price / Token cost (e.g., “\$49 or 10 tokens”)

* Badges: **Premium Program** (KTA / iProject / Thinkers), **ESA Eligible**, **New**, **Bestseller**, **Top Rated**

* Rating (⭐ 4.8) \+ review count (127)

* Availability preview (next start date in viewer’s timezone)

**Card hover/secondary info:**

* Teacher avatar \+ name

* Class size cap (e.g., “Max 10 learners”)

* “Add to Wishlist” / “Share” quick actions

---

## **2\) Listing Detail Page (Course PDP)**

### **A. Hero Section**

* **Title**

* **Tagline**

* Teacher avatar \+ name, verified badge (vetted/cleared)

* Rating \+ reviews count, link to reviews section

* **Badges:** Premium Program, ESA Eligible, Moderated Community, Faith & Family Friendly

* **Price & Tokens:** `$49 USD or 10 tokens` (auto-convert for AU if AU tenant)

* **CTA buttons:**

  * \[See Class Times\] (scroll to Schedule)

  * \[Enroll / Add to Cart\] (handles tokens/Stripe/ESA)

  * \[Contact Teacher\] (in-platform messages)

* **Hero media:** cover image and optional promo video

### **B. “What you’ll learn” (Learning Goals)**

* 3–6 bullet outcomes (short, assessable)

* Optional standards mapping (e.g., “Aligned with ACARA / NGSS”—toggle per region)

### **C. Class Experience**

* Delivery mode: **Live** / **Self-paced** / **Hybrid**

* Interaction: small group, discussion prompts, projects, breakout rooms

* Technology used: Zoom/WebRTC, Google Docs, Scratch, etc.

* Parent involvement expectations (e.g., “Optional supervision for Ages 7–8”)

### **D. Syllabus / Curriculum**

* Module & lesson list with brief summaries

* For live classes: meeting cadence & duration per lesson

* For self-paced: estimated hours per lesson, assessments, due dates (if any)

### **E. Schedule & Availability**

* Localized to viewer’s timezone

* **Schedule table** (for live cohorts): start date, days, time, duration, seats left

* Self-paced: “Start anytime”

* **Class size:** min/max, waitlist toggle

* **Rescheduling policy** link

### **F. Requirements**

* Prerequisites (skill level, prior modules)

* Materials (supplies list), software/hardware, accounts needed

### **G. Parental Guidance (Safety)**

* Age-appropriateness notes

* Sensitive content disclosures if any

* Moderation rules & platform safety

* **AU:** Child Safe Principles note

* **US:** COPPA/FERPA note (if school groups)

### **H. Teacher Bio**

* Photo, verified ID/clearances badges

* Qualifications, teaching style, faith/family statement (if provided)

* Links to other listings & overall rating

### **I. Reviews**

* Star average, histogram

* Students/parents verified badges

* Sort by Recent/Helpful

* Report review option (moderation queue)

### **J. Pricing & Purchase Options**

* **Price & Tokens:** `$XX or Y tokens`

* **ESA Eligible** badge if SKU flagged \+ state rule OK

* **Group discounts** (Co-ops/Micro-schools) if enabled

* **Refund policy** (depends on tenant/jurisdiction and product type)

* **Bundle offers / upsells** (e.g., add 1:1 Thinkers sessions at token discount)

### **K. FAQ**

* 5–10 common questions (teacher can propose; admin can pin/curate)

### **L. Policies (auto-inserted)**

* Platform ToS, Privacy, Parent Consent

* Class cancel/reschedule rules

* Marketplace content policy

---

## **3\) Search & Filter Facets**

**Searchable fields:**

* Title, tagline, description, teacher name, tags, subject

**Filters:**

* Age/Year band

* Subject/Category (Faith, STEM, Arts, Literacy, etc.)

* Delivery Mode (Live / Self-paced / Hybrid)

* Duration (Single session / 4–6 weeks / 8–12 weeks / Ongoing)

* Price band / Token band

* Start date (for live cohorts)

* Premium Program (KTA / iProject / Thinkers)

* ESA Eligible (US only)

* Rating (4.5+, 4.0+)

* Class size (≤ 6, ≤ 10, ≤ 15\)

* Language, Accessibility captions

---

## **4\) Compliance & Moderation Hooks**

* **Auto-scan uploads** (virus scan, mime)

* **Prohibited content filter** on description/blocks (keyword lists \+ ML)

* **Age-appropriateness warning** if content keywords mismatch target age

* **Disclosure check**: if external platforms are required, must list accounts needed

* **AU:** Show Child Safe statement

* **US:** If under-13 learners, enforce in-platform messaging only; log moderation

* **Review moderation** queue

---

## **5\) Pricing/Tokens/ESA Logic (Marketplace PDP)**

* Always show **both** cost modes when available: `$USD/AUD` **and** `tokens`

* Show **ESA Eligible** only if:

  1. Family has approved `esa_status=APPROVED`, **and**

  2. Course SKU is eligible per `esa_program_rule_skus`, **and**

  3. Active state rule permits Marketplace for that SKU (see `marketplace_allowed`)

* Mixed cart split if parent adds multiple items with different payment methods

---

## **6\) JSON Schema (Course Listing)**

`{`

  `"id": "COURSE_123",`

  `"slug": "intro-to-robotics-for-ages-8-11",`

  `"title": "Intro to Robotics: Build, Code, Create!",`

  `"tagline": "Hands-on robotics for curious minds (Ages 8–11)",`

  `"coverImageUrl": "https://cdn.kta/robots-cover.jpg",`

  `"promoVideoUrl": "https://cdn.kta/robots-promo.mp4",`

  `"ageRange": { "min": 8, "max": 11 },`

  `"subjects": ["STEM", "Engineering"],`

  `"deliveryMode": "LIVE",           // LIVE | SELF_PACED | HYBRID`

  `"duration": { "format": "WEEKS", "value": 6 },`

  `"cohortPattern": "Weekly • 60 min",`

  `"classSize": { "min": 4, "max": 10 },`

  `"price": { "currency": "USD", "amount": 49.0, "tokenCost": 10.0 },`

  `"badges": { "premiumProgram": "KTA", "esaEligible": true, "topRated": true, "new": false },`

  `"rating": { "avg": 4.8, "count": 127 },`

  `"teacher": {`

    `"id": "TEACHER_45",`

    `"name": "Jordan Ellis",`

    `"avatarUrl": "https://cdn.kta/jordan.png",`

    `"verified": true,`

    `"bioShort": "Maker educator & mentor"`

  `},`

  `"learningGoals": [`

    `"Assemble and program a simple robot",`

    `"Understand sensors and movement",`

    `"Collaborate and present weekly builds"`

  `],`

  `"experience": {`

    `"interaction": "Small-group live instruction with projects",`

    `"technology": ["Zoom", "Scratch", "Micro:bit"],`

    `"parentInvolvement": "Optional supervision for tool use"`

  `},`

  `"syllabus": [`

    `{ "week": 1, "title": "Robotics Basics", "summary": "Motors, sensors, safety" },`

    `{ "week": 2, "title": "Movement", "summary": "Drive & turn" }`

  `],`

  `"schedule": [`

    `{ "startAtIso": "2025-10-05T21:00:00Z", "durationMin": 60, "days": ["Sun"], "seatsLeft": 3 },`

    `{ "startAtIso": "2025-11-09T21:00:00Z", "durationMin": 60, "days": ["Sun"], "seatsLeft": 8 }`

  `],`

  `"requirements": {`

    `"prereqs": ["Basic typing"],`

    `"materials": ["Micro:bit kit", "Laptop"],`

    `"software": ["Scratch account"]`

  `},`

  `"parentalGuidance": "Hand tools supervised by adults; no violent content.",`

  `"policies": {`

    `"refundPolicyKey": "STANDARD_7_DAY",`

    `"reschedulePolicyKey": "FLEX_COHORT"`

  `},`

  `"faq": [`

    `{ "q": "Do I need a Micro:bit?", "a": "Yes, any Micro:bit V2 is fine." }`

  `],`

  `"seo": {`

    `"metaTitle": "Intro to Robotics (Ages 8–11) | KTA+",`

    `"metaDescription": "Build and code robots in a live 6-week course for ages 8–11.",`

    `"canonicalUrl": "https://kta.education/marketplace/intro-to-robotics-for-ages-8-11"`

  `},`

  `"schemaOrg": {`

    `"@type": "Course",`

    `"name": "Intro to Robotics: Build, Code, Create!",`

    `"provider": { "@type": "Organization", "name": "KTA+" }`

  `},`

  `"flags": {`

    `"coopsAllowed": true,`

    `"microschoolsAllowed": true,`

    `"programAccess": ["KTA", "Marketplace"]`

  `},`

  `"sku": "KTA_ROB_6W_LIVE",`

  `"esa": {`

    `"eligible": true,`

    `"eligibleStates": ["AZ", "WV"],            // computed by rules`

    `"requiresAttendance": true                 // from esa_program_rules`

  `},`

  `"i18n": { "locale": "en-US" }`

`}`

---

## **7\) PDP Layout Components (Frontend)**

* `<CourseHero />` – title, badges, price/tokens, CTAs, teacher chip

* `<LearningGoals />` – bullet list \+ standards tags

* `<ClassExperience />` – mode, interaction, tech, parent note

* `<Syllabus />` – expandable weeks/lessons

* `<Schedule />` – timezone-aware cohort selector; “Start Anytime” for self-paced

* `<Requirements />`

* `<ParentalGuidance />` – jurisdiction-sensitive notes (AU/US)

* `<TeacherBio />` – full bio, other courses grid

* `<Reviews />` – list \+ histogram, verified badges

* `<PricingPanel />` – tokens/\$, ESA badge, refund/reschedule

* `<FAQ />`

**Sticky sidebar (desktop):** price/tokens, ESA eligible badge, Enroll button, next start date.

---

## **8\) Teacher Listing Form (Marketplace Creator)**

**Fields to collect from teacher:**

* Title, Tagline, Cover image, Promo video

* Subject(s), Age range, Delivery mode

* Duration, Cohort pattern, Class size min/max

* Learning goals (3–6)

* Class experience (free text \+ tech list)

* Syllabus builder (weeks/lessons summaries)

* Requirements (prereqs, materials, software/accounts)

* Parental guidance (plain, child-safety compliant)

* Pricing: cash price (USD/AUD), token price

* Availability: cohort sessions (UTC ISO start \+ duration \+ days)

* ESA toggle request (org will map SKU eligibility)

* Premium Program flag (if part of KTA/iProject/Thinkers)

* FAQ (up to 10 Q/A)

* Save Draft / Submit for Review

**Moderation checklist (auto \+ human):**

* Prohibited words scan

* Missing parental guidance

* Age vs content mismatch

* External links present → ensure listed under “Requirements”

* Sensitive topics require disclosure (teacher prompted)

---

## **9\) Co-ops & Micro-schools Add-Ons**

* **Visibility scope**: Public / Unlisted / Private-to-Group

* **Group pricing**: coordinator/admin rates & seats

* **Roster sync**: enrollment via group rosters, still respecting parental consent

* **ESA**: Each family’s ESA verified individually; show ESA badge only to parents with `esa_status=APPROVED`

---

## **10\) SEO & Sharing**

* Generate OpenGraph & Twitter card (cover image, title, price snippet, rating)

* JSON-LD Schema.org `Course` \+ `Offer` (local currency)

* Canonical URL per locale/tenant

* Clean slugs; 301 redirect on title update

---

## **11\) Accessibility**

* All images require **alt text**

* Promo videos: captions (VTT/SRT)

* Keyboard reachable CTAs; ARIA labels on tabs/accordions

* High-contrast badge colors; text size minimums

---

## **12\) Purchase/Enroll Logic**

* If **tokens available** ≥ token price → enable “Pay with Tokens”

* Else → “Buy tokens” upsell modal

* If **ESA eligible & approved** → show “Use ESA” option; otherwise gray badge \+ tooltip “Requires ESA verification”

* Mixed cart: split checkout flows automatically

* Premium Programs: if purchased, mark included courses as “Included” and disable price

---

# **🔧 Developer Notes**

* **Indexing:** store denormalized search fields (title, tagline, teacher, tags, age bands, subjects) in search index (e.g., Meilisearch/Elastic)

* **Timezone:** all schedule datetimes stored as UTC; convert for display

* **Caching:** PDP cached by `course_id` with short TTL; schedule hydrated client-side for timezone accuracy

* **AB Testing:** hero CTA order, price vs token prominence

* **Analytics:** CTR, add-to-cart, conversion, cohort fill rates, refund rate, attendance completion

---

# **🧪 Sample JSON Listing (Filled)**

`{`

  `"id": "COURSE_981",`

  `"slug": "world-builders-bible-ages-10-13",`

  `"title": "World Builders & the Bible: Create a Faith-Inspired Fantasy Realm",`

  `"tagline": "Storycraft + worldbuilding with positive values",`

  `"coverImageUrl": "https://cdn.kta/worldbuilders-cover.jpg",`

  `"promoVideoUrl": null,`

  `"ageRange": { "min": 10, "max": 13 },`

  `"subjects": ["Literacy", "Creative Writing", "Faith"],`

  `"deliveryMode": "HYBRID",`

  `"duration": { "format": "WEEKS", "value": 8 },`

  `"cohortPattern": "Weekly • 75 min • plus self-paced prompts",`

  `"classSize": { "min": 4, "max": 8 },`

  `"price": { "currency": "USD", "amount": 79.0, "tokenCost": 16.0 },`

  `"badges": { "premiumProgram": "KTA", "esaEligible": true, "topRated": false, "new": true },`

  `"rating": { "avg": 0, "count": 0 },`

  `"teacher": {`

    `"id": "TEACHER_202",`

    `"name": "A. Rivers",`

    `"avatarUrl": "https://cdn.kta/rivers.png",`

    `"verified": true,`

    `"bioShort": "Author & homeschool mentor"`

  `},`

  `"learningGoals": [`

    `"Design a coherent fantasy world map and cultures",`

    `"Draft a short story rooted in Biblical themes of hope and courage",`

    `"Give and receive constructive feedback"`

  `],`

  `"experience": {`

    `"interaction": "Small group workshops + shared docs",`

    `"technology": ["Zoom", "Google Docs"],`

    `"parentInvolvement": "Suggested for feedback at home"`

  `},`

  `"syllabus": [`

    `{ "week": 1, "title": "Big Picture", "summary": "Theme, tone, values" },`

    `{ "week": 2, "title": "Maps & Places", "summary": "Regions and lore" },`

    `{ "week": 3, "title": "People & Creatures", "summary": "Design cultures ethically" }`

  `],`

  `"schedule": [`

    `{ "startAtIso": "2025-10-03T00:30:00Z", "durationMin": 75, "days": ["Thu"], "seatsLeft": 5 }`

  `],`

  `"requirements": {`

    `"prereqs": ["Comfort writing a paragraph"],`

    `"materials": ["Notebook", "Colored pencils"],`

    `"software": ["Google account (parent-assisted)"]`

  `},`

  `"parentalGuidance": "Faith-centered discussion; fantasy themes handled age-appropriately. No graphic content.",`

  `"policies": {`

    `"refundPolicyKey": "STANDARD_7_DAY",`

    `"reschedulePolicyKey": "FLEX_COHORT"`

  `},`

  `"faq": [`

    `{ "q": "Is prior creative writing needed?", "a": "No—just enthusiasm!" }`

  `],`

  `"seo": {`

    `"metaTitle": "World Builders & the Bible (Ages 10–13) | KTA+",`

    `"metaDescription": "An 8-week hybrid course blending worldbuilding and faith-centered storytelling.",`

    `"canonicalUrl": "https://kta.education/marketplace/world-builders-bible-ages-10-13"`

  `},`

  `"schemaOrg": {`

    `"@type": "Course",`

    `"name": "World Builders & the Bible: Create a Faith-Inspired Fantasy Realm",`

    `"provider": { "@type": "Organization", "name": "KTA+" }`

  `},`

  `"flags": {`

    `"coopsAllowed": true,`

    `"microschoolsAllowed": true,`

    `"programAccess": ["KTA", "Marketplace"]`

  `},`

  `"sku": "KTA_WBIBLE_8W_HYB",`

  `"esa": {`

    `"eligible": true,`

    `"eligibleStates": ["AZ", "WV"],`

    `"requiresAttendance": true`

  `},`

  `"i18n": { "locale": "en-US" }`

`}`

# **📦 Downloadable Resources UI – Spec**

> Resource types

> * **Program Pack (10-Week)**: multi-file bundle (teacher guide, lesson plans, worksheets, answer keys).

> * **Short Task**: single file or tiny bundle (e.g., 1–2 lesson worksheets, project brief, quiz).

Supported containers: **PDF** (preferred), **ZIP** (if multi-file), **ePub** (optional), **MP4** (if the pack includes video).

---

## **1\) Placement in the Product**

* **Marketplace PDP**: “Resources” tab on course page (or dedicated Resource PDP if listed standalone).

* **Premium Programs (KTA/iProject/Thinkers)**: “Resources” tab on the program dashboard and inside each module/lesson.

* **Co-ops / Micro-schools**: “Group Resources” library visible only to the group; optional private listings.

* **Parent Dashboard**: “Downloads” page for all purchased/unlocked resources per child/family.

---

## **2\) Catalog/Grid UI (Resources Library)**

**Card fields (compact, grid 3–4 across):**

* Thumbnail (auto from first PDF page / provided cover)

* Title

* Tagline (max 90 chars)

* Labels: **10-Week Pack**, **Short Task**

* Price/Token: “\$9 or 2 tokens” / “Included” (if premium)

* Badges: **Premium Program**, **ESA Eligible** *(if allowed for downloads in that state)*, **New**, **Top Rated**

* Quick actions: \[Preview\] \[Add to Cart\] \[Wish-list\]

**Hover/secondary info:**

* Age band / Year level

* File count & total size (e.g., “6 files • 42MB”)

* Format icons (PDF/ZIP)

---

## **3\) Resource Detail Page (Resource PDP)**

### **Hero**

* Title, tagline

* Badges: Program/ESA/Moderation/Faith & Family Friendly

* Price/token info & “Included with Program” chip (if applicable)

* CTA area:

  * **If not owned:** \[Add to Cart\], \[Buy with Tokens\], \[Use ESA\] (if eligible), \[Preview\]

  * **If owned:** \[Download\], \[Open in Viewer\] (PDF web viewer), \[Re-download\]

### **Overview**

* Description (rich text)

* What’s inside (bulleted list; for packs list each item)

* Learning goals/outcomes

* Age / Level

* Estimated time (e.g., “\~10 weeks” or “\~45 min”)

### **What’s included (Expandable list)**

* File table: filename, type, size, last updated

* Optional per-file preview (first page image thumbnails)

### **Usage & Permissions**

* License summary (non-transferable family/school use)

* “Safe use reminder” (technology supervision, child safety)

* If ESA: note about receipts & compliance

### **Ratings/Reviews**

* Stars \+ list (moderated)

### **Teacher/Publisher**

* Avatar, name, verified badge

* Link to other resources

---

## **4\) Purchase / Access Logic (Top CTA)**

* **Token purchase** enabled when `token_cost` set and family has balance.

* **Stripe purchase** enabled when `cash_price` set.

* **ESA option** only when:

  1. Parent ESA **APPROVED**,

  2. SKU eligible in `esa_program_rule_skus`,

  3. State rule allows **marketplace downloads** (some ESA programs **do not**; honor `marketplace_allowed`).

* **Included**: If resource is part of an active **Program enrollment**; show “Included” and enable download.

**Mixed Cart rule:** Resource items can co-exist with class enrollments; during checkout, split by method (ESA vs Stripe vs tokens).

---

## **5\) Download UX (Owned State)**

* Primary buttons:

  * **\[Download Now\]** (downloads bundle or single file)

  * **\[Open PDF Viewer\]** (in-app, watermarked)

* Show **watermark note**: “This file is personalized for \[Parent Name / Child Initials\].”

* Show **download history** (timestamp, IP, device) in a collapsible panel for the parent.

**Partial content:** If bundle, allow per-file download with a dropdown kebab menu:

* Download file

* View in browser (PDF only)

* Report an issue

---

## **6\) Preview UX**

* **Page-limited PDF preview** (first 3–5 pages) with blur overlay.

* Overlay footer: “Unlock full pack – \$9 or 2 tokens” (CTA bar).

* For Short Tasks, preview first page only.

* Disable copy/capture UI elements (best effort; cannot prevent screenshots).

---

## **7\) Resource Builder (Teacher/Admin UI)**

**Create Resource (standalone or attach to Course/Module/Lesson):**

* Title (required)

* Tagline (optional)

* Description (rich text)

* Type: **10-Week Pack** / **Short Task**

* Age/Year level

* Subject tags

* Formats: Upload files (PDF/ZIP/MP4). Drag to order.

* Cover image (optional, otherwise auto)

* Pricing: `cash_price`, `token_cost`

* Program association (KTA/iProject/Thinkers)

* ESA eligibility request (toggle; final mapping done by compliance)

* Visibility: Public / Unlisted / Group-Only (Co-op/Micro-school)

* Compliance checklist (checkboxes):

  * No prohibited content

  * Child-appropriate language & imagery

  * External links audited

* Save Draft / Submit for Review

**Moderation Dashboard:**

* Virus scan status

* OCR compliance (for accessibility; optional)

* Keyword flags

* Approve / Request changes

---

## **8\) JSON Schemas**

### **A) Resource (PDP)**

`{`

  `"id": "RES_1001",`

  `"slug": "kta-10-week-faith-stem-pack",`

  `"title": "KTA 10-Week Faith & STEM Pack",`

  `"tagline": "Hands-on projects blending science and discipleship",`

  `"type": "PROGRAM_PACK",             // PROGRAM_PACK | SHORT_TASK`

  `"ageRange": { "min": 9, "max": 12 },`

  `"subjects": ["STEM", "Faith"],`

  `"descriptionHtml": "<p>10 weeks of structured lessons...</p>",`

  `"includes": [`

    `{ "filename": "Week1-Lesson.pdf", "type": "PDF", "sizeBytes": 5242880, "previewPages": 3 },`

    `{ "filename": "Student-Worksheets.zip", "type": "ZIP", "sizeBytes": 12582912 }`

  `],`

  `"media": {`

    `"coverImageUrl": "https://cdn.kta/pack-cover.jpg",`

    `"promoVideoUrl": null`

  `},`

  `"pricing": {`

    `"currency": "USD",`

    `"cashPrice": 9.0,`

    `"tokenCost": 2.0,`

    `"includedWithPrograms": ["KTA"]`

  `},`

  `"badges": { "premiumProgram": "KTA", "esaEligible": false, "new": true },`

  `"ownership": {`

    `"owned": false,`

    `"included": false`

  `},`

  `"esa": {`

    `"eligible": false,`

    `"eligibleStates": [],`

    `"requiresAttendance": false`

  `},`

  `"publisher": {`

    `"id": "TEACHER_77",`

    `"name": "M. Harper",`

    `"avatarUrl": "https://cdn.kta/harper.png",`

    `"verified": true`

  `},`

  `"files": [`

    `{`

      `"id": "FILE_1",`

      `"filename": "Week1-Lesson.pdf",`

      `"mime": "application/pdf",`

      `"sizeBytes": 5242880,`

      `"downloadUrl": null,`

      `"previewImageUrls": [`

        `"https://cdn.kta/previews/w1p1.jpg",`

        `"https://cdn.kta/previews/w1p2.jpg"`

      `]`

    `}`

  `],`

  `"policies": {`

    `"license": "Family/Group non-transferable use",`

    `"refundPolicyKey": "DIGITAL_NO_REFUND"`

  `},`

  `"rating": { "avg": 4.9, "count": 82 },`

  `"i18n": { "locale": "en-US" }`

`}`

### **B) Download entitlement (after purchase)**

`{`

  `"resourceId": "RES_1001",`

  `"parentId": "PAR_22",`

  `"childId": "CH_88",`

  `"entitled": true,`

  `"method": "TOKENS",                 // TOKENS | STRIPE | ESA | INCLUDED`

  `"orderId": "ORD_5555",`

  `"downloadUrls": [`

    `{ "fileId": "FILE_1", "signedUrl": "https://..." }`

  `],`

  `"watermark": {`

    `"name": "Harper Family",`

    `"childInitials": "A.H.",`

    `"timestamp": "2025-09-23T10:45:00Z"`

  `}`

`}`

---

## **9\) Components (Frontend)**

> Use your stack (Flutter for app / React for web). Example component responsibilities below.

* `<ResourceCard />` – grid card with badges, price/tokens, quick actions.

* `<ResourceHero />` – title, badges, CTA state machine (buy/download/preview).

* `<ResourceIncludes />` – file list with per-file actions.

* `<ResourcePreview />` – limited page PDF previewer with CTA overlay.

* `<ResourceCTA />` – switches between Buy with Tokens / Stripe / ESA / Included.

* `<DownloadHistory />` – table (timestamp, IP, device); parent-only.

* `<GroupVisibilityBadge />` – “Co-op Only” / “Micro-school Only”.

**State machine for CTA**

`LOCKED (show purchase options)`

  `├── Buy with Tokens → grant entitlement → DOWNLOADED state`

  `├── Buy with Stripe → grant entitlement → DOWNLOADED state`

  `└── Use ESA (if allowed) → grant entitlement → DOWNLOADED state`

`INCLUDED (program) → show Download`

`ENTITLED (owned) → show Download + Viewer + History`

---

## **10\) Token/Stripe/ESA Handling (Frontend)**

* If `tokenCost` present and `tokenBalance >= tokenCost` → enable “Buy with Tokens”.

* If `cashPrice` present → show Stripe purchase.

* If `esa.eligible === true` AND family `esa_status=APPROVED` AND state rule `marketplace_allowed=true` → show “Use ESA”.

* If `includedWithPrograms` contains any **active** enrollment for this child → auto mark as **Included**.

**Post-purchase**: Call entitlement API → return signed URLs \+ watermark meta.

---

## **11\) Watermarking & Anti-sharing**

* **Personalized watermark** stamped on each PDF page: “KTA+ • \[Parent Name\] • \[Child Initials\] • \[Order/UUID\]”.

* Watermark toggles: diagonal light gray text; unobtrusive but visible.

* ZIP bundles: include a small `_license.txt` with buyer info \+ timestamp.

* Rate-limit downloads (e.g., 10 per day per file).

* Track download telemetry (IP, device UA).

* Show **“Do not share”** reminder in the download modal.

---

## **12\) Accessibility**

* Alt text required for covers/thumbnails.

* PDF text should be OCR’d/searchable where feasible.

* Keyboard navigable previewer; zoom & page jump; ARIA roles on controls.

* High contrast focus states.

---

## **13\) Co-ops & Micro-schools**

* **Group-only visibility**: resources marked `visibility=GROUP_ONLY` appear only to members.

* **Seatless license**: download access scoped to parent accounts in group roster.

* **Admin re-share disabled**: admins cannot extract nor bulk share signed URLs; each parent downloads via their account.

* **Billing**: group purchase enables “Included” for rostered learners.

---

## **14\) Error/Edge Cases**

* **ESA not allowed for downloads**: hide ESA button; show tooltip “Your state ESA does not cover downloadable resources.”

* **Token shortfall**: show “Buy Tokens” modal.

* **Network fail on signed URL**: retry, then show “Request a fresh link” (regenerates signed URL).

* **File too large for preview**: skip preview; show thumbnails only.

* **Expired entitlement** (if policy changes): show contact support CTA.

---

## **15\) API Endpoints (example)**

* `GET /api/resources/:slug` → Resource PDP JSON

* `POST /api/resources/:id/purchase` → { method: "TOKENS" \| "STRIPE" \| "ESA" }

* `GET /api/resources/:id/entitlement?childId=` → signed URLs \+ watermark meta

* `GET /api/resources/:id/downloads/history` → recent download events (parent only)

* `POST /api/resources/:id/report` → content issue flag

---

## **16\) Sample UI Copy**

* **Preview overlay:** “You’re viewing a preview (3 pages). Unlock the full pack for **2 tokens** or **\$9**.”

* **Watermark note:** “Personalized copy. Please don’t share outside your family/group.”

* **Included chip:** “Included with your KTA enrollment.”

* **ESA tooltip (disabled):** “ESA rules in **\[STATE\]** do not cover downloads.”

---

## **17\) QA Checklist**

* Preview respects page caps for both pack and short task.

* Purchase paths: tokens/Stripe/ESA work and grant entitlement.

* Included state correctly unlocks download without payment.

* Signed URLs expire and are regenerated cleanly.

* PDF watermark renders on all pages (test dark/light).

* Accessibility: keyboard, alt text, captions/pass

* Co-op/Micro-school visibility & entitlement restricted to group members.

* ESA rules honored via `esa_program_rules` (if Marketplace downloads disabled, ESA button hidden).

---

## **5\) Parent / Guardian Onboarding**

### **5.1 Flow (US & AU)**

1. Welcome → logo, tagline “Faith, Family & Future Learning”, \[Get Started\].

2. **Create Parent Account** → fields below; MFA (email \+ SMS).

3. **Add Child Profile(s)** → fields below; program selection.

4. **Verification**

   * **AU**: Email \+ phone required; optional gov ID.

   * **US**: If any child **DOB \< 13**, COPPA verification: micro-charge, gov ID, or signed consent upload. Store method, timestamp, IP (retain **7 years**).

5. **Digital Consent** (verbatim forms below).

6. **Child Safety Notice** (verbatim, AU vs US).

7. **Confirmation** → success \+ consent status badge.

8. **Parent Dashboard** → consent management, oversight, communications controls, billing/tokens, safety reports.

### **5.2 Parent Account Form (explicit)**

* Full Name (text)

* Email Address (email)

* Phone Number (text, \+country code)

* Password (password; 12+ chars, 1 upper, 1 lower, 1 digit, 1 special)

* Verify Email Code (6 digits)

* Verify SMS Code (6 digits)

### **5.3 Child Profile Form (explicit)**

* Child Full Name (text)

* Date of Birth (date picker)

* Program(s) (checkbox): Kingdom Thinkers Academy / iProject International / Thinkers Academy / Other

* \[Add Another Child\] button

### **5.4 📄 Parent/Guardian Digital Consent – AU (verbatim)**

Welcome to KTA+ – Faith, Family & Future Learning.  
As part of our commitment to child safety and compliance with Australian law, children under 18 must have parent or guardian consent before accessing the platform.

Child’s Details (auto-collected at sign-up)  
Child’s Full Name: \[entered by parent/guardian\]  
Date of Birth: \[entered by parent/guardian\]  
Program(s) Enrolled: \[checkbox: Kingdom Thinkers Academy / iProject International / Thinkers Academy / Other\]

Parent/Guardian Details (auto-collected at sign-up)  
Full Name: \[entered by parent/guardian\]  
Relationship to Child: \[entered by parent/guardian\]  
Phone Number: \[entered by parent/guardian\]  
Email Address: \[entered by parent/guardian\]

Terms of Consent  
☐ Parental Responsibility – I confirm that I am the parent/legal guardian of the child named above, and I will maintain oversight of my child’s account, enrolments, and activity.  
☐ Online Child Safety – I consent to my child participating in moderated online classes, communities, and project activities within KTA+. I understand mandatory reporting obligations may apply if safety concerns are raised.  
☐ Privacy & Data Collection – I consent to The Transformation Network collecting and using my child’s personal information in accordance with the Privacy Act 1988 (Cth) and the organisation’s Privacy Policy.  
☐ Educational Content – I consent to my child accessing curriculum, lessons, and resources hosted on KTA+.  
☐ Technology Use – I accept responsibility for providing safe home technology and internet access for my child’s participation.  
☐ Withdrawal of Consent – I understand I can withdraw consent at any time by written notice to The Transformation Network.

Acknowledgement  
By ticking the boxes above and clicking “I Consent”, I acknowledge that I have read, understood, and agreed to the terms, and I consent for my child to access and participate in the KTA+ platform.

Digital Signature / Confirmation  
Parent/Guardian Full Name: \[auto-fill from above\]  
Date: \[auto-stamped\]  
IP address & timestamp recorded automatically for audit purposes.

\[ ✅ I Consent \]

**Backend/Audit:** Link record to child\_id; store checkbox states, timestamp, IP; exportable PDF.

### **5.5 📄 Parent/Guardian Digital Consent – US (verbatim)**

Welcome to KTA+ – Faith, Family & Future Learning.  
As required by US law (COPPA, FERPA, CCPA/CPRA), parental consent is required before children can access the platform.

Child’s Details  
Child’s Full Name: \[entered by parent/guardian\]  
Date of Birth: \[entered by parent/guardian\]  
Program(s) Enrolled: \[checkbox: Kingdom Thinkers Academy / iProject International / Thinkers Academy / Other\]

Parent/Guardian Details  
Full Name: \[entered by parent/guardian\]  
Relationship to Child: \[entered by parent/guardian\]  
Phone Number: \[entered by parent/guardian\]  
Email Address: \[entered by parent/guardian\]

Terms of Consent  
☐ Parental Responsibility – I confirm I am the parent/legal guardian of the child named above.  
☐ Online Child Safety – I consent to my child participating in moderated classes, communities, and activities.  
☐ Privacy & Data Collection – I consent under COPPA (under 13), FERPA (if applicable), and CCPA/CPRA (if California resident).  
☐ Withdrawal of Consent – I understand I may revoke consent at any time.  
☐ Mandatory Reporting – I acknowledge that concerns of child harm may be reported to CPS or law enforcement.

Acknowledgement  
By checking these boxes, I confirm that I have read, understood, and agreed to these terms.

Digital Signature / Confirmation  
Parent/Guardian Full Name: \[auto-fill\]  
Date: \[auto-stamped\]  
IP address & timestamp logged.

**Retention:** keep for **7 years** (COPPA).

### **5.6 Child Safety Notices (verbatim)**

* **AU:** “KTA+ is committed to the National Principles for Child Safe Organisations. All online spaces are moderated, and parents have dashboard oversight.” \[Continue\]

* **US:** “By law, concerns may be reported to law enforcement or CPS if child safety issues arise.” \[Continue\]

---

## **6\) Teacher Onboarding**

### **6.1 📲 Digital Teacher Approval Form (verbatim)**

**Section A – Teacher Details**

* Full Name, Date of Birth, Address, Phone, Email, Country (AU/US)

**Section B – Identity Verification**

* Government ID Upload, ID Number, Expiry Date, Staff Verifier (dropdown), Verification Date (auto)

**Section C – Child Safety Clearance**

* **AU:** Upload WWCC, Number, Expiry, “Added to re-verification calendar”

* **US:** Upload Background/FBI Check, Number, Expiry, “Added to re-verification calendar”

**Section D – Training & Policy**

* Checkbox: “Child Safety Induction completed”

* Upload signed acknowledgement of KTA+ Child Safety Policy

* Completion Date

**Section E – References**

* Reference 1 (Name, Contact, Relationship)

* Reference 2 (Name, Contact, Relationship)

* Notes (long text)

**Section F – Content Alignment**

* Upload sample course material

* Checkbox: “Reviewed and approved”

* Reviewer Notes

**Section G – Legal Agreements**

* Upload signed Teacher Marketplace Agreement (AU or US)

* Checkbox: “Teacher accepts 70/30 revenue split”

* Checkbox: “Independent contractor status acknowledged”

* Agreement Date

**Section H – Final Approval**

* Status (Approved/Declined)

* Reason if Declined

* Approved by (dropdown)

* Approval Date (auto)

* Digital signature (checkbox \+ Admin login validation)

### **6.2 Teacher Marketplace Agreements (verbatim)**

* **AU Agreement** – (full legal text provided earlier; include word-for-word).

* **US Agreement** – (full legal text provided earlier; include word-for-word).

**Backend:** store immutable PDFs; Stripe Connect for payouts.

# **👩‍🏫 Contracted Teacher Onboarding Flow (AU Charity & US LLC)**

### **Key Difference vs Marketplace Teachers**

* **Marketplace teachers** → independent sellers, vetted and approved for listing courses in the Marketplace.

* **Contracted teachers** → formally engaged by the AU Charity or US LLC to deliver structured programs (KTA, iProject, Thinkers). They act under closer oversight, with structured contracts and integration into program delivery.

---

## **1\. Invitation & Application**

* **Entry Point**: Candidate is recruited by KTA, iProject, or Thinkers leadership.

* **Invite Email**: “You have been selected to join as a Contracted Educator with \[Charity/LLC\]. Click below to begin your onboarding.”

* **Application Portal Fields**:

  * Full Name, Date of Birth, Contact Info.

  * Resume/CV upload.

  * Specialisation (Faith, STEM, Literacy, Project-based, etc.).

  * Preferred program assignment (KTA / iProject / Thinkers).

* **Backend**: `teacher_type = CONTRACTED`; status \= `PENDING_APPLICATION`.

---

## **2\. Identity & Background Verification**

* **Identity**: Government-issued ID upload (AU: Passport/Driver Licence; US: State ID/Passport).

* **Child Safety Clearance**:

  * AU: Working With Children Check (WWCC).

  * US: FBI/State Background Check.

* **System Actions**:

  * Verify authenticity (OCR/DB check).

  * Store in compliance DB with re-verification dates.

  * Add to **re-verification calendar** (notifications sent 30 days before expiry).

---

## **3\. Program-Specific Training & Induction**

* **Induction Modules** (separate from Marketplace training):

  * **Child Safety & Reporting** (mandatory).

  * **Faith-Centered Pedagogy** (discipleship integration).

  * **Program Curriculum Induction**:

    * KTA: Kingdom Inquiry Cycle.

    * iProject: Project-based mentorship.

    * Thinkers: Tutoring and support structure.

* **Digital Acknowledgements**:

  * Checkbox: “I have completed all induction training.”

  * Upload signed **Acknowledgement of KTA+ Contracted Teacher Policy**.

---

## **4\. Sample Teaching Session**

* Teacher delivers **mock lesson** (live Zoom/WebRTC) observed by Program Admin.

* Admin evaluates:

  * Alignment with program philosophy.

  * Classroom management & engagement.

  * Faith/family integration.

* Reviewer logs approval/rejection in compliance DB.

---

## **5\. Legal Contract Execution**

* **Contract Type**: “Educator Contractor Agreement” (different from Marketplace Agreement).

* **Jurisdiction**:

  * AU Charity → Queensland law.

  * US LLC → Delaware law.

* **Content Includes**:

  * Independent contractor terms.

  * Program assignment scope (KTA / iProject / Thinkers).

  * Child safety obligations.

  * Reporting and assessment duties.

  * IP ownership & non-disclosure.

  * Payment structure (per session, per term, or stipend).

* **Digital Signature**: Immutable PDF stored in compliance DB.

---

## **6\. Payment Setup**

* **Stripe Connect** (Contractor Payout):

  * AU Teachers → Paid via AU Charity account (AUD).

  * US Teachers → Paid via US LLC account (USD).

* **Backend**: Link `stripe_account_id` to contracted teacher profile.

* **Contracted Payment Model** (different from token split):

  * KTA Teachers → per-term teaching fee \+ optional tutoring add-ons.

  * iProject Mentors → per-project fee \+ optional tutoring add-ons

  * Thinkers Tutors → per-session or bundle pricing.

---

## **7\. Final Approval & Program Assignment**

* Admin reviews all onboarding steps:

  * Identity ✅

  * Safety Clearance ✅

  * Induction ✅

  * Mock Lesson ✅

  * Legal Contract ✅

  * Stripe ✅

* Status \= `APPROVED_CONTRACTED`.

* Teacher is assigned to **Program Roster** (e.g., KTA Term 4 → Literacy Stream).

* Welcome Email: “You are now an official Contracted Educator with \[Charity/LLC\]. Please log in to access your Program Dashboard.”

---

## **8\. Dashboard Access (Contracted Teacher View)**

* **Restricted Scope** (different from Marketplace):

  * View assigned classes/programs only.

  * Upload lessons/resources only for assigned cohorts.

  * Access program curriculum packs (pre-approved).

  * Attendance \+ reporting tools (linked to ESA receipts where relevant).

  * Direct communication with Program Admin (not full Marketplace forums).

  * Finance tab → contracted payment breakdowns.

    [🔔 Program Staff Communication (US & AU Premium)](https://docs.google.com/document/d/1n4OSU1pyL_aQ_qs1gR_Zwvf8QnhV1elap1R_Ayg4Lf0/edit?tab=t.0)

---

## **9\. Ongoing Compliance & Renewal**

* **Re-verification reminders**: WWCC/FBI renewals.

* **Contract renewals**: New Agreement signed per year or per program cycle.

* **Performance reviews**: Quarterly check-ins with Program Admins.

* **Spot audits**: Admin reviews of live sessions and submitted resources.

---

## **🔑 Key System Distinctions**

* `teacher_type = CONTRACTED` (vs `MARKETPLACE`).

* Contracted teachers tied to **program\_rosters**; Marketplace tied to **marketplace\_courses**.

* Payment \= stipend/fee model (not token split).

* Access \= restricted to assigned cohorts/program dashboards.

---

## **7\) Co-ops**

### **7.1 Co-op Coordinator Agreements (verbatim)**

* **AU Co-op Coordinator Agreement** – (full text; WWCC, Child Safe Standards, ACNC, billing facilitator).

* **US Co-op Coordinator Agreement** – (full text; background check, COPPA/FERPA/CCPA, billing facilitator).

**Flow:** Coordinator applies → clearance → signs agreement → creates group → invites families → **families control consent** → coordinator manages billing/tokens.  
 **Premium Access:** Co-ops can buy KTA, iProject, Thinkers bundles and (state-permitting) Marketplace.

---

## **8\) Micro-Schools (US only)**

### **8.1 Micro-School Admin Agreement (verbatim)**

* (Full text: EIN/charter docs, teacher vetting required, COPPA/FERPA/CCPA, premium access, Delaware law).

**Flow:** Admin applies → school verification → staff vetting → parents still sign consent → bulk enrol → admin attendance oversight (no private messages) → premium program access.  
 **ESA:** parents manage ESA individually; admin can request parent ESA authorization per enrollment.

---

## **9\) Donors (AU charity)**

### **9.1 AU Donor Agreement (verbatim; non-DGR)**

* Includes explicit clause: **“The Transformation Network Ltd is not endorsed as a DGR. Donations are not tax-deductible.”**

### **9.2 AU Donor Privacy Notice (verbatim; non-DGR note included)** 

### **9.3 AU Donor Flow Checkboxes (mandatory)**

\[ \] I have read and agree to the Donor Agreement.  
\[ \] I have read and agree to the Donor Privacy Notice.  
\[ \] I understand The Transformation Network Ltd is not a DGR and my donation is not tax-deductible.

---

## **10\) ESA (US) – Policy, Agreement, Forms, Templates (verbatim)**

### **10.1 ESA Policy – United States (verbatim)**

* Purpose, Eligibility, Payment Flow, Parental & Org responsibilities, Refunds, Data Protection, Governing Law (Delaware \+ state rules).

### **10.2 ESA Agreement – United States (verbatim)**

* Parent responsibilities, Org responsibilities, Eligible programs (KTA, iProject, Thinkers, Marketplace if allowed), Receipts & reporting, Refunds, Data protection, Governing law, Acknowledgement, Digital signature.

### **10.3 ESA Verification Form – United States (verbatim)**

* Parent/Child auto-filled, ESA Program (AZ/FL/WV/Other), ESA Account ID, Award Letter upload, 3 compliance checkboxes, digital signature, validation rules.

### **10.4 ESA Receipt Template – United States (verbatim)**

* Parent, Child, Program, ESA Program, ESA ID, itemised charges, total, Stripe reference, timestamp, UUID.

### **10.5 ESA Attendance Log Template – United States (verbatim)**

* Sessions table (date, class, teacher, duration, status), totals, timestamp, UUID.

### **10.6 Integration into Onboarding (US) – Payment Step**

* Payment method radio: **Family Subscription \+ Tokens (Stripe)** / **Program Enrolment (Stripe)** / **ESA** (shows ESA Verification Form inline).

* States: `esa_status = NONE | PENDING_VERIFICATION | APPROVED | REJECTED | EXPIRED`.

* Admin queue for review; email templates for Submitted/Approved/Rejected; 7-year retention.

---

## **11\) ESA State Rules Matrix – Developer Scaffold**

### **11.1 Database (Postgres)**

* `esa_program_rules`, `esa_program_rule_skus`, `esa_receipt_requirements` (DDL provided earlier).

* Active rules view by effective dates.

### **11.2 Admin UI**

* `/admin/esa/rules` (list, edit, duplicate, archive).

* Sections: General, Eligibility flags, SKUs mapping, Receipt fields, Notes.

* Roles: `ROLE_ADMIN_US`, `ROLE_COMPLIANCE_US`.

### **11.3 Enforcement Hooks**

* **Checkout guard:** split eligible vs non-eligible; block if no active rule; respect `marketplace_allowed`.

* **Attendance:** enable per `attendance_required`.

* **Refunds:** honor `refund_rule`.

* **Receipts:** fields required per rule; include rule metadata in footer.

### **11.4 Feature Flags Object (frontend/backend)**

marketplaceAllowed, asyncAllowed, attendanceRequired, receiptsRequired, refundRule, minHoursPerTerm, notes

### **11.5 Starter Seed (placeholders)**

* YAML examples for **AZ**, **FL**, **WV** with SKU mappings and conditions (placeholders to be confirmed by ops/legal).

---

## **12\) Privacy Policies (verbatim)**

### **12.1 AU Privacy Policy (verbatim)**

* APP compliance, ACNC governance, APP 8 cross-border disclosure, OAIC rights, AU hosting, retention.

### **12.2 US Privacy Policy (verbatim)**

* COPPA parental rights, FERPA for schools, CCPA/CPRA, FTC/state audits, US hosting, retention.

---

## **13\) Terms of Service (verbatim)**

* Acceptance, Eligibility, Accounts & Roles, Content rules, Child Safety & Mandatory Reporting, Payments, Tokens, Program Enrolments, Termination, IP, Disclaimers, Jurisdiction (AU: QLD; US: DE), Amendments, Contact.

---

## **14\) CRM Implementation (HubSpot) – Expanded**

* **Phase 1:** single instance; tags: AU\_Family, AU\_Donor, US\_Family, US\_Coop, US\_MicroSchool; pipelines (Donations vs Subscriptions/Enrolments).

* **Phase 2:** Stripe (dual accounts) sync; Postgres → HubSpot (parents only; **no child progress**); landing pages & automations.

* **Phase 3:** AU donor/family separation; ACNC exports; US CAN-SPAM \+ CCPA notices; privacy policy updates naming HubSpot as processor.

* **Phase 4:** nurture flows (families → co-ops → micro-schools); donor retention; dashboards (subs growth, token usage, ESA revenue, pipeline health).

---

## **15\) Parental Dashboard – Feature Outline (verbatim & integrated)**

**Purpose:** Oversight & compliance (Privacy Act 1988 (Cth), Online Safety Act 2021, Child Safe Standards).  
 **Features:**  
 A) Consent Management (view/revoke/update; log every action)  
 B) Account Oversight (programs, classes, badges, progress, reports)  
 C) Communication Controls (forums, P2P messaging toggles, teacher feedback visibility, notifications)  
 D) Payment & Subscriptions (family subscriptions, tokens, bundles; Stripe payer of record; invoices)  
 E) Safety & Reporting (Report a Concern; safety log of incidents/moderation)

**User Flow:** Sign-up → Verification → Consent → Ongoing access → Revocation locks child.  
 **Backend:** Consent records in Postgres (timestamp, IP, digital signature); role-based permissions (Parent admin over linked children).

# **🎓 Student Dashboard – Recommended Features**

**Student dashboard**[https\://www\.canva.com/design/DAG2lNkxp2M/4c-5PXJ0RUycO-vwQrFF8Q/edit](https://www.canva.com/design/DAG2lNkxp2M/4c-5PXJ0RUycO-vwQrFF8Q/edit)  
Program dashboard[https\://www\.canva.com/design/DAG2p7tjc0w/Zd004cPA2tdq87B4Ud2Z9g/edit?utm\_content=DAG2p7tjc0w\&utm\_campaign=designshare\&utm\_medium=link2\&utm\_source=sharebutton](https://www.canva.com/design/DAG2p7tjc0w/Zd004cPA2tdq87B4Ud2Z9g/edit?utm_content=DAG2p7tjc0w&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton)

## **1\. Welcome & Personalisation**

* Student’s name \+ profile avatar (fun, age-appropriate).

* Today’s greeting (e.g., *“Good morning, Evan\!”*).

* **Progress bar**: “You’ve completed 3 of 5 lessons this week.”

* Motivational verse/quote of the day (faith-centered).

---

## **2\. Classes & Programs**

* **Current Enrolments** section:

  * List of active programs (KTA / iProject / Thinkers).

  * Each card shows: Title, Teacher avatar, Next session time, Progress badge.

* **Quick actions**: \[Join Class\], \[View Lessons\], \[Submit Work\].

* Calendar sync: Cohort schedule auto-populated (ESA compliance requires this).

---

## **3\. Assignments & Tasks**

* To-Do List:

  * Independent Learning, projects, and showcases due soon.

  * Task cards with due dates, priority colours.

* Submission status:

  * \[Not Started\] → \[In Progress\] → \[Submitted\] → \[Reviewed\].

* Upload button: drag/drop files or attach Google Docs.

---

## **4\. Resources Library**

* “My Resources” tab → shows lesson packs, worksheets, videos assigned by teacher.

* Files are read-only with watermarking (safe sharing).

* ESA flag: if required, student sees “Attendance Required” note.

---

## **5\. Attendance & Certificates**

* Visual record: ✅ Completed lessons / 🔲 Upcoming lessons.

* Streaks or badges: “Perfect attendance 2 weeks in a row\!”

* Certificates unlocked after module completion (shareable in Parent Dashboard).

---

## **6\. Safe Community Features**

* **Discussion Threads**:

  * Only for lessons where teacher enables them.

  * Moderated \+ parent-visible.

  * “Post a thought / ask a question” box.  
  * Access to The Hive (based on parent consent)

* **No private messaging** (COPPA, eSafety).

* Emoji/sticker reactions instead of free chat (child-safe).

---

## **7\. Progress & Feedback**

* Simple tracker: “Maths – 70% completed, Science Project – 2 milestones left.”

* Teacher feedback bubble (comments shown after parent approval).

* Gamified badges: “Creative Thinker”, “Faith Builder”, “Team Player.”

---

## **8\. Safety & Support**

* **Report Concern** button (student-friendly wording: “I feel unsafe” → sends to Parent \+ Safety Team).

* “Help” → guides, how-to videos, and faith encouragement.

---

## **9\. Mobile-Friendly UX**

* Designed for tablets/Chromebooks (common in homeschooling).

* Clear big buttons, minimal clutter.

---

# **🔑 Compliance Guardrails**

* **Parent Oversight**: Every student dashboard is linked to the Parent Dashboard; parents can see *exactly* what the child sees.

* **Audit Logging**: All actions (submissions, attendance, discussions) timestamped \+ stored 7 years (ESA/FERPA/COPPA).

* **Customisable Visibility**: Admins can toggle which features appear per age band (e.g., no forums for under-10).

---

✨ The **feel** should be:

* **Fun & motivating for kids** (progress bars, badges, friendly UI).

* **Transparent for parents** (everything mirrored in their dashboard).

* **Safe & compliant** (no private chat, everything logged).

  # **The Hive — UI/Dev Spec for KTA+**

  ## **1\) Vision & Guardrails**

**The Hive** is a single, universal, platform‑wide social learning space for **families across the world**. Cohort/class discussion remains in class Spaces elsewhere in KTA+. The Hive is the *global commons* for sharing learning highlights, testimonies, builds, and encouragement across ages and regions.

**Core Safety Defaults**

* Family transparency: parents can view their own child’s posts, comments, reactions (and optionally co‑post in Family threads).  
* **Parent Consent Gate:** minors cannot post/comment/react in The Hive until a parent enables access. Consent is revocable at any time and instantly enforced platform‑wide.  
* Global visibility with sensible rails: posts publish to the **Global Hive** or to **curated Channels** (e.g., Maker, Scripture & Reflection, Nature, Service Projects). No cohort/class spaces inside The Hive.  
* AI \+ human moderation: text/image scanning pre- and post-publish; multilingual support.  
* Identity: child‑safe display names and avatars; no surnames by default; strict PII/geo‑data controls.  
  ---

  ## **2\) Top-Level IA (Information Architecture)**

* **Global Hive (Home)** → unified feed across the whole network with filters.  
* **Channels** → topic-based subfeeds (e.g., Maker, Faith in Action, Nature Lab, Coding, Arts, Testimony, Wins & Gratitude). Channels are curated and age-aware.  
* **Discover** → rotating prompts, highlights, and challenges across time zones.  
* **Create Post** (composer) → choose Channel (default: Global), attach projects.  
* **Parent View** → child activity dashboard; parents may post in Family threads and react/encourage on public posts (no DMs).  
* **Moderation Console** → global queue with regional reviewers; translation inline.  
* **Profile (Student/Family)** → learning artifacts, badges; share‑to‑portfolio.  
  ---

  ## **3\) Primary Screens & Wireframe Notes**

  ### **3.1 Feed ("Buzz Feed")**

**Layout**

* Left: Filters (All, My Channel, My Posts, Media, Badges) \+ Channel list  
* Center: Composer → Post cards (infinite scroll, global)  
* Right: "Hive Highlights" (mentor-curated global), Guidelines card, Global prompts

**Filters**

* Channel, Age band (Y1–2, Y3–4, Y5–6, Y7–8, Y9–10, 16+), Media type, Language

**Post Card Anatomy**

* Header: Avatar, DisplayName · Age band · Time · Channel badge · Locale flag  
* Body: Rich text (≤ 1,000 chars), media carousel, attached iProject link chip  
* Reactions: Celebrate, Encourage, Prayed, Inspired  
* Actions: Comment, Share-to-Portfolio, Report  
* Safety chips: Pending Review, Mentor Approved, Flagged

**Empty States**

* New user → "Welcome to the Hive\! Share a win or join a prompt."

  ### **3.2 Composer (Create Post)**

* Fields: Textarea, media upload, Project attach, **Channel selector** (default: Global), Age band auto-tag, Language auto-detect \+ manual override, Consent checkbox (parent-set default)  
* Submit logic: student → moderation queue by age band; older students may be auto-approved per policy; parents may co‑post in Family threads.  
* PII/Profanity check on draft and submit; inline guidance; translation at moderation.  
* Fields: Textarea (with Scripture-friendly formatter), media upload (image/video/pdf), Project attach, Visibility (default: this Space), Mentions (mentor only), Consent checkbox for media (parent-set default)  
* Submit logic: If student role → goes to moderation queue (configurable auto-approve for older grades)  
* PII/Profanity check runs on draft and on submit; inline warnings

  ### **3.3 Post Detail**

* Full content \+ threaded comments (2 levels), time-stamps  
* Mentor tools: Approve/Unapprove, Pin to Highlights, Convert to Artifact (Portfolio)  
* Parent chip: "Visible to Parent(s)" with hover tip  
* Audit trail drawer: creation, edits, approvals

  ### **3.4 Parent View (Dashboard)**

* Child selector (if multiple)  
* Tabs: Activity \| Mentions by Mentor \| Family Threads \| **Hive Access** \| Settings  
* **Hive Access (per child):**  
  * Toggle: **Allow Hive Access** (Off → child is read‑only; cannot post/comment/react)  
  * Scope options (radio or checkboxes): **View only**, **View \+ React**, **View \+ React \+ Post**  
  * Timestamp \+ actor: "Enabled by \[Parent Name\] on \[Date/Time\]"  
  * Quick revoke button with confirm modal; retains audit trail  
  * Digest \+ notifications sub‑toggles (only available if access is enabled)  
* Activity stream: global posts/comments/reactions by child, approval status, links to originals  
* Parents can: start a **Family Thread** (private to family \+ mentors) and re‑share child’s global posts to it; react/encourage on global posts  
* Weekly Digest toggle; Safe Words notifications; per‑Channel subscription

  ### **3.5 Moderation Console**

* Queues: **Pending (Global)**, **Flagged**, **Auto-held (PII/Profanity/Geo)**, **Appeals**  
* Region/timezone routing; built‑in translate/retranslate preview  
* Batch: Approve, Return with Note, Hide, Archive; pin to Highlights  
* Item view: content, policy hits, student history, **consent status** badge, family contact quick‑link  
* SLA indicators: items pending \>48h highlighted; surge mode for campaigns  
* Queues: **Pending (Global)**, **Flagged**, **Auto-held (PII/Profanity/Geo)**, **Appeals**  
* Region/timezone routing; built‑in translate/retranslate preview  
* Batch: Approve, Return with Note, Hide, Archive; pin to Highlights  
* Item view: content, policy hits, student history, family contact quick‑link  
* SLA indicators: items pending \>48h highlighted; surge mode for campaigns  
* Queues: **Pending**, **Flagged**, **Auto-held (PII/Profanity)**, **Appeals**  
* Batch actions: Approve, Return with Note, Hide, Archive  
* Item view: Original content, highlights of policy hits (keywords), student history, parent contact quick-link  
* SLA indicators: items pending \>48h highlighted  
  ---

  ## **4\) Roles & Permissions**

* **Student**: create posts/comments in Global or Channels; no DMs; can report.  
* **Parent**: view child activity; **post in Family Threads**; react/encourage on Global/Channel posts; cannot DM students.  
* **Mentor**: approve/return posts, curate Highlights, moderate comments, convert to portfolio artifacts.  
* **Admin/Ops**: global console; manage Channels, policies, word lists, age‑based auto‑approve.  
  ---

  ## **5\) Safety Systems**

**Consent Enforcement**

* Composer, comment box, and reaction controls are **gated** by consent status.  
* If **View only**: feed visible; action controls disabled with tooltip: "A parent needs to enable access to participate."  
* If **Revoked**: hide composer and comments; retain access to Parent Family Threads.

**Automated Filters**

* Profanity/bullying lists; PII patterns (email, phone, address), geo/precise location, time/place meeting invites; image nudity/violence detection  
* Actions: block submit with guidance or auto‑hold; auto‑redact PII snippets (masked for mentors)

**Global Reporting**

* Report reasons: unkind, unsafe, off-topic, privacy, spam  
* Optional auto‑hide from peer view until review (mentor/admin visible)

**Age & Locale**

* Age band drives moderation strictness and feature flags  
* Locale-aware policies (e.g., privacy norms); date/number localisation; multilingual moderation

**Audit & Rate Limits**

* Immutable logs; post cadences; media caps; challenge campaign throttles

  ## **9\) UX Copy (starter)**

* **Composer placeholder:** "Share a win with the whole Hive…"  
* **Safety prompt:** "Don’t share last names, addresses, or meeting plans."  
* **Pending badge:** "Awaiting mentor review"  
* **Report modal:** "Tell us what feels off so we can make it right."  
* **Guidelines card:** "Be kind. Be truthful. Be a builder."  
* **Channel tip:** "Choose a Channel so the right families find your post."  
* **Consent callout (child):** "A parent needs to enable your Hive access before you can post."  
* **Consent toggle (parent):** "Allow my child to participate in the Hive" with sub-options: View only / View \+ React / View \+ React \+ Post  
  ---

  ## **10\) Accessibility & i18n**

* Text alternatives for media; captions for video  
* Dyslexia-friendly font support toggle  
* Keyboard-only composer and moderation workflows  
* Date/number localisation; right-to-left support ready  
  ---

  ## **11\) Notifications**

* Student: Approved, Returned-with-note, Mentioned by mentor  
* Parent: Weekly digest, Safe-words alert, Milestone badge  
* Mentor: New pending items, Flags, Appeals  
  ---

  ## **12\) Analytics**

* `hive_feed_view(space_id)`  
* `post_created(space_id)` / `post_approved`  
* `reaction_added(type)`  
* `report_submitted(reason)`  
* `parent_digest_enabled`  
* Funnels from composer → approval → highlight pin  
  ---

  ## **13\) Rollout Plan**

1. Launch **Global Hive** with Channels disabled (single global feed) for 2–4 weeks to learn norms  
2. Enable curated Channels and multilingual moderation  
3. Add Parent **Family Threads** and weekly digests  
4. Introduce Highlights, badges, and portfolio export  
   ---

**Implementation Note:** The Hive is platform‑wide; do not mirror class/cohort Spaces here. Keep class talk in class Spaces. The Hive showcases the *best of KTA+* globally, with robust moderation and family transparency.

## **14\) Parent Consent (Global Hive Access)**

**Goal:** Give parents clear, revocable control over their child’s participation in the global Hive.

**States**

* **Pending**: default for new minors (read‑only)  
* **Granted – View only**: can browse; no reactions/comments/posts  
* **Granted – React**: can add Celebrate/Encourage/Prayed/Inspired; no comments/posts  
* **Granted – Post**: full participation (subject to moderation)  
* **Revoked**: read‑only; composer/comments disabled

**Flows**

1. **First‑run gate**: if child tries to post/react without consent → ConsentGate UI explains and links parent.  
2. **Parent toggle**: from Parent Dashboard → updates Consent; audit log recorded.  
3. **Revocation**: immediate enforcement; queued posts remain pending until mentor/admin decision.

**Compliance**

* Store consent version and actor; surface in audit trails; include in data export.  
* Regional policy variants (e.g., COPPA/GDPR‑K) via `version` string.

**Telemetry**

* `consent_view_opened`, `consent_granted(scope)`, `consent_revoked`, `blocked_action_due_to_consent`.  
  ![][image3]

# **👩‍👧 Parent Dashboard – Recommended Features**

## **1\. Welcome & Overview**

* Parent’s name \+ family profile.

* Quick summary cards:

  * **Children enrolled** (avatars with progress rings).

  * **Active subscriptions** (e.g., “Family Subscription – 12 tokens available”).

  * **Upcoming classes** this week.

  * **Consent status** (green ✅ or red ⚠️ if action needed).

---

## **2\. Consent Management**

* **Consent Records** tab:

  * Digital consents (AU/US versions) with signed date, IP, and PDF download.

  * Buttons: \[Revoke Consent\], \[Update Consent\].

  * **History log** (timestamped actions for audit).

* Alerts: “Your child’s consent for Community Forums will expire in 30 days.”

---

## **3\. Child Oversight**

* **Linked Child Accounts**:

  * Each child card shows: current programs, progress %, attendance streaks, badges earned, session notes

  * Click → opens a mirror of the Student Dashboard (read-only).

* **Activity Feed**:

  * “Evan submitted Robotics Project Task 2.”

  * “Maya attended ‘Survival Skills’ live session.”

  * “Phoenix received teacher feedback in Literacy.”

---

## **4\. Payment & Subscriptions**

* **Family Subscription Panel**:

  * Current plan (e.g., \$25 USD/month).

  * Token balance with rollover tracker.

  * \[Buy More Tokens\] button.

* **Invoices & Receipts**:

  * Downloadable PDF receipts (Stripe \+ ESA).

  * Filters: Date range, child, program.

* **ESA Tab (US only)**:

  * ESA Verification Status (Pending / Approved / Rejected).

  * ESA Receipt & Attendance Log downloads.

---

## **5\. Program & Class Management**

* **Programs Enrolled** (KTA, iProject, Thinkers):

  * Each program card shows: Term dates, assigned teacher, class times and access to course modules.

  * \[View Resources\], \[Attendance Logs\], \[Message Teacher\].

* **Marketplace Purchases**:

  * Purchased courses/resources with expiry or ongoing status.

---

## **6\. Communication Controls**

* **Messaging Center**:

  * Inbox for teacher communications.

  * Parent has option: toggle child messaging ON/OFF.

* **Community Settings**:

  * Per child: Allow/disallow access to forums.

  * Moderation visibility: Parent sees flagged posts.

---

## **7\. Safety & Reporting**

* **Safety Log**:

  * Shows all incidents reported (by child, teacher, moderator).

  * Status (open, under review, resolved).

* **Report Concern** button:

  * “Report an unsafe interaction” → logs to safety team \+ admin.

* **Child Safety Notices** (AU vs US):

  * AU → Child Safe Standards statement.

  * US → COPPA/FERPA rights summary.

---

## **8\. Resources & Downloads**

* **My Library**:

  * All purchased/unlocked packs (10-week, short tasks).

  * Download history with watermark notice.

  * “View in Browser” PDF option.  
  * 

**Podcast and Media Hub Access**

The Make School Great Again Podcast

Blog

Videos

Parent Resources

* **Included Program Resources** auto-appear when child is enrolled in a Premium Program.

  # **1\) Parent Community Matching (Opt-in, City-level)**

  ## **Goal**

Help parents **discover and connect** with nearby families while preserving privacy (no exact addresses, city-level only).

## **UX (Parent)**

* **Onboarding card (dismissible):**  
   “Find families near you?”

  * City (required, free text with autocomplete)

  * Country (auto-derived)

  * Radius selector (10 / 25 / 50 km)

  * Opt-ins (checkboxes):

    * “Show my profile in local results”

    * “Allow messages from matched parents”

  * \[Save & Preview Matches\]

* **Matches view:** list of parent cards showing: first name \+ last initial, number of children, interests/tags (e.g., STEM, Faith studies), *approximate* distance (“\~12 km away”), and \[Request Connect\].

* **Privacy banner:** “We never show your street address. You can hide your profile at any time.”

  ## **UX (Messaging)**

* **First contact \= request:** “Sarah wants to connect” → Parent can **Accept / Decline**.

* If accepted, open a **parent-to-parent thread** (in-platform, no email disclosure).

* **No direct contact with children**. All messages logged & moderated.

  ## **Data Model (DB)**

* `-- City-level, no precise coordinates stored`  
* `CREATE TABLE parent_locations (`  
*   `parent_id UUID PRIMARY KEY REFERENCES parents(id),`  
*   `city TEXT NOT NULL,`  
*   `region TEXT,            -- state/province`  
*   `country_code CHAR(2) NOT NULL,`  
*   `lat NUMERIC(9,6) NULL,  -- optional city centroid only`  
*   `lng NUMERIC(9,6) NULL,`  
*   `radius_km INT DEFAULT 25,`  
*   `show_in_search BOOLEAN DEFAULT FALSE,`  
*   `accept_inbound BOOLEAN DEFAULT TRUE,`  
*   `interests TEXT[] DEFAULT '{}',`  
*   `updated_at TIMESTAMPTZ DEFAULT NOW()`  
* `);`  
*   
* `CREATE TABLE parent_connections (`  
*   `id UUID PRIMARY KEY DEFAULT gen_random_uuid(),`  
*   `requester_parent_id UUID NOT NULL REFERENCES parents(id),`  
*   `target_parent_id UUID NOT NULL REFERENCES parents(id),`  
*   `status TEXT NOT NULL CHECK (status IN ('PENDING','ACCEPTED','DECLINED','BLOCKED')),`  
*   `created_at TIMESTAMPTZ DEFAULT NOW(),`  
*   `updated_at TIMESTAMPTZ DEFAULT NOW()`  
* `);`


  ## **API (Server)**

* `POST /api/community/location`  
   Body: `{ city, region, countryCode, radiusKm, showInSearch, acceptInbound, interests[] }`

* `GET /api/community/matches?radiusKm=&interests=`  
   Returns paginated list of **parent summaries** (no exact addresses).

* `POST /api/community/connect`  
   Body: `{ targetParentId }` → creates PENDING request.

* `POST /api/community/connect/:id/respond`  
   Body: `{ action: 'ACCEPT'|'DECLINE'|'BLOCK' }`

* `GET /api/community/conversations` / `POST /api/community/messages`

  ## **Matching Logic (Service)**

* Filter: same `country_code`, within `radius_km` of **city centroid**.

* Rank by: shared interests overlap → recency of activity → distance.

* Hard rules: exclude blocked users; exclude if either `show_in_search=false`.

  ## **Safety & Compliance**

* **AU (eSafety/Privacy Act):** city-only granularity, no minors in DMs, all messages moderated/logged.

* **US (COPPA/FERPA/CCPA):** parent-only messaging; opt-in consent stored with timestamp/IP.

* **Moderation hooks:** keyword filters, report button on messages, rate-limits (e.g., 10 new requests/day).

* **Controls:** parent can hide profile, revoke consent, block users, delete conversation.

  ## **Copy (UI)**

* Toggle label: “Show me to nearby parents”

* Tooltip: “We’ll only show your **city**—never your exact address.”

* Empty state: “No matches nearby yet. Widen your radius or add interests.”

  ## **Analytics**

* Events: `community_opt_in`, `match_viewed`, `connect_requested`, `connect_accepted`, `message_sent`.

* KPIs: opt-in rate, request → accept rate, reports per 1k messages.

  ---

  # **2\) Parent Dashboard CTA: “Start a Co-op”**

  ## **Goal**

Convert motivated parents into **Co-op Coordinators** with a guided setup—while preserving parental consent control.

## **UX (Parent Dashboard Widget)**

**Card (always visible, dismissible once created):**

* Title: **Want to start a Co-op?**

* Body: “Bring families together for shared classes and resources.”

* Buttons: \[Start a Co-op\] (primary), \[Learn More\] (secondary)

  ### **Flow: Start a Co-op (Stepper)**

1. **Basics**: Co-op name, city/region, short description, logo (optional)

2. **Visibility**: Public / Unlisted / Invite-only

3. **Interests**: Subjects, ages, meeting cadence (weekly, fortnightly)

4. **Policies**: Accept Co-op Coordinator Agreement (AU or US variant auto-selected by tenant), confirm child-safety overview

5. **Create** → lands on **Co-op Dashboard** with Invite link generator

**Post-create nudges**

* “Invite the first 5 families”

* “Pick your first program bundle”

* “Set your communication rules”

  ## **Data Model (DB)**

* `CREATE TABLE coops (`  
*   `id UUID PRIMARY KEY DEFAULT gen_random_uuid(),`  
*   `owner_parent_id UUID NOT NULL REFERENCES parents(id),`  
*   `name TEXT NOT NULL,`  
*   `city TEXT, region TEXT, country_code CHAR(2),`  
*   `visibility TEXT NOT NULL CHECK (visibility IN ('PUBLIC','UNLISTED','INVITE_ONLY')),`  
*   `description TEXT,`  
*   `interests TEXT[] DEFAULT '{}',`  
*   `created_at TIMESTAMPTZ DEFAULT NOW()`  
* `);`  
*   
* `CREATE TABLE coop_memberships (`  
*   `coop_id UUID REFERENCES coops(id),`  
*   `parent_id UUID REFERENCES parents(id),`  
*   `role TEXT NOT NULL CHECK (role IN ('COORDINATOR','ASSISTANT','MEMBER')),`  
*   `status TEXT NOT NULL CHECK (status IN ('INVITED','ACTIVE','REMOVED')),`  
*   `PRIMARY KEY (coop_id, parent_id),`  
*   `created_at TIMESTAMPTZ DEFAULT NOW()`  
* `);`


  ## **API (Server)**

* `POST /api/coops` → create (validates Agreement acceptance)

* `GET /api/coops/:id` → details \+ invite link

* `POST /api/coops/:id/invite` Body: `{ emails[] }`

* `POST /api/coops/:id/visibility`

* `GET /api/coops/:id/members` / `POST /api/coops/:id/members` (role updates)

  ## **Compliance & Safety**

* **Consent primacy:** children join classes only after **each parent** consents.

* Coordinators cannot message children directly; only parents & teachers.

* All invites are parent-to-parent; audit logged with IP/timestamps.

* AU/US Coordinator Agreements presented at creation; stored immutable PDF.

  ## **Copy (UI)**

* Card subtitle: “Create a private group for classes, resources, and schedules.”

* Helper text (policies step): “Parents retain full consent over their children’s participation.”

  ## **Analytics**

* Events: `coop_card_view`, `coop_create_start`, `coop_created`, `coop_invites_sent`, `coop_first_purchase`.

* KPI: completion rate of stepper, first-5 invites time, group activation (first program purchased).

  ---

  # **3\) Integration Between Features**

* On the **Community Matches** page, show a small prompt:  
   “Found like-minded families? **Start a Co-op** together.” → deep-link to stepper with **city prefilled**.

* On a **Co-op page**, suggest inviting nearby parents:  
   “Invite parents near **{city}**” → opens invite modal with **search filter** set to city.

  ---

  # **4\) Feature Flags & Rollout**

* `feature.community_matching` (default: OFF → A/B in AU first)

* `feature.coop_starter_card` (default: ON for Parent role)

* Gradual % rollout; monitor reports & acceptance metrics; enable rate-limits server-side.

  ---

  # **5\) Minimal UI Components (reusable)**

* `<LocationOptInCard />` – city input (autocomplete), radius, toggles

* `<ParentMatchList />` – compact profile cards \+ Request Connect

* `<SafeMessageThread />` – parent↔parent only, report button

* `<CoopStarterCard />` – dashboard CTA

* `<CoopStepper />` – multi-step creator with Agreement modal

* `<AgreementModal docKey=… />` – renders verbatim legal, logs acceptance

  ---

  # **6\) Copy Snippets (drop-in)**

**Location opt-in:**  
 “Choose your **city** to find families nearby. We’ll only display your **city**, never your street address.”

**Connect request:**  
 “Send a hello? They’ll be able to accept or decline your request.”

**Co-op CTA:**  
 “Want to start a Co-op? Bring families together for shared learning—on your terms.”

---

# **7\) Guardrails Checklist**

* ⬜ City-only location; no precise addresses stored or shown

* ⬜ Opt-in required; easy opt-out toggle on Parent profile

* ⬜ Parent-only messaging; no student accounts in threads

* ⬜ Reporting & blocking available on every conversation

* ⬜ Moderator escalation path \+ rate-limits on requests

* ⬜ AU/US legal agreements stored with version \+ PDF hash

* ⬜ All actions audit-logged (actor, IP, timestamp)

---

## **9\. Notifications & Reminders**

* Expiring clearances (teacher updates).

* Token low balance alerts.

* ESA renewal reminders.  
* Session summaries from teachers/mentors

* Consent expiration notices.

* Weekly digest email option: “This week your family completed 6 lessons.”

---

## **10\. Compliance & Audit**

* Backend stores:

  * Every consent action (with IP \+ timestamp).

  * Every download (with parent name watermark).

  * All payment receipts (7-year retention).

* Dashboard provides **export option**: Generate “Audit Bundle” PDF for legal/ESA purposes.

---

# **🔑 Parent Dashboard Philosophy**

* **Control**: Parents can enable/disable key features for each child.

* **Clarity**: Progress, attendance, payments visible at a glance.

* **Compliance**: Receipts, consents, logs all one click away.

* **Care**: Safety and faith-first design → reassuring, not overwhelming.

---

✨ Visual feel: professional, **“banking app” clean** (for trust), but softened with family-friendly language and program branding.

# **👥 Co-op Dashboard – Recommended Features**

## **1\. Welcome & Group Overview**

* Group name (e.g., *“Faith Learners Co-op”*).

* Coordinator name \+ contact details.

* Quick stats:

  * Families enrolled.

  * Children active.

  * Programs purchased (KTA, iProject, Thinkers bundles).

  * Token pool (if shared).

---

## **2\. Family & Child Management**

* **Roster Table**:

  * Parent name, Child(ren) names, Consent status.

  * Enrollment status: Active / Pending / Expired.

* **Consent Mirror**:

  * Coordinator can *view* consent records but **cannot override** parent authority.

  * Consent icons: ✅ Complete, ⚠️ Action Needed.

* **Invite Families**:

  * Send secure invite link for parents to onboard children into the Co-op.

  * Parents must approve before child appears in roster.

---

## **3\. Program & Bundle Management**

* **Premium Bundles**:

  * Buy KTA, iProject, Thinkers packages for group.

  * Display terms (per term/10 weeks).

  * Bulk enrol option: select children → assign to bundle.

* **Marketplace Access**:

  * Group pricing (discount rates).

  * Private listings for Co-op only.

---

## **4\. Billing & Payments**

* **Coordinator Billing Account**:

  * One Stripe account → pays for bundles/resources.

  * Monthly invoices viewable/downloadable.

* **Family Add-ons**:

  * Parents can still individually purchase Marketplace or ESA-eligible items for their own child.

  * Dashboard displays which purchases are group-funded vs parent-funded.

* **ESA (US only)**:

  * Co-op coordinator cannot spend ESA directly.

  * Families still pay with their own ESA approval.

  * Coordinator dashboard shows which SKUs are flagged ESA-eligible, but badges are only visible at parent level.

---

## **5\. Attendance & Reporting**

* **Group Attendance Log**:

  * Rollup of all sessions attended by Co-op children.

  * Coordinator can filter by program, teacher, or date range.

* **Export Logs**:

  * CSV/PDF of attendance for internal reporting.

  * For ESA: only parents can download official ESA logs, but coordinator sees aggregate stats.

---

## **6\. Communication Hub**

* **Announcements**:

  * Coordinator → send updates to all families.

* **Forum Access**:

  * Optional Co-op-only discussion board (moderated, parent-visible).

* **Teacher Messages**:

  * Coordinator can view general updates but cannot bypass parent-child oversight.

---

## **7\. Resource Library**

* **Group Resources Tab**:

  * Bundled packs purchased at group level.

  * Shared access: each family downloads individually (watermarked with their parent name).

* **Visibility Badges**: “Co-op Only Resource.”

---

## **8\. Safety & Compliance**

* **Safety Alerts**:

  * Coordinator notified if incident raised within group.

  * Cannot resolve — flagged to Admin \+ Parent.

* **Child Safe Standards (AU)** \+ **COPPA/FERPA (US)** banners shown.

* **Audit Trail**:

  * Every coordinator action logged (timestamp, IP, action).

---

## **9\. Coordinator Tools**

* **Group Settings**:

  * Edit group name, description, logo.

  * Manage coordinator team (assign assistants with limited rights).

* **Enrollment Reports**:

  * Active vs inactive families.

  * Token usage summary (if shared subscription chosen).

* **Reminders**:

  * Consent expiring.

  * Bundle renewal due.

---

## **10\. Dashboard Philosophy**

* **Parents retain control**: Co-op dashboard never overrides parent consent or child safety.

* **Coordinator \= facilitator**: They manage group-level purchasing, scheduling, and communication.

* **Transparency**: Everything parents see, coordinator sees in aggregate (but not private).

---

✨ Visual feel: **“mini admin panel”** but simplified. Tabs across top: *Overview \| Families \| Programs \| Attendance \| Billing \| Resources \| Safety*.

# **🏫 Micro-school Admin Dashboard – Recommended Features**

## **1\. Welcome & Overview**

* **Micro-school name** (verified during onboarding).

* Admin name \+ contact details.

* Quick stats summary cards:

  * Total families.

  * Total students.

  * Active programs (KTA, iProject, Thinkers).

  * ESA approvals (aggregate view).

  * Upcoming classes this week.

---

## **2\. Staff & Teacher Management**

* **Roster of Teachers** linked to the micro-school.

  * Name, role, clearance status, contract expiry.

  * Background check expiry reminders.

* **Assign Teachers** → link approved teachers to programs/courses.

* **Verification Logs**: all vetting stored for audit.

---

## **3\. Family & Student Roster**

* **Family Roster Table**:

  * Parent names, contact info, consent status.

  * Children with age, program enrolments, attendance % to date.

* **Consent Oversight**:

  * Admin sees “Consent Complete / Missing” but **cannot override parents**.

  * Parents still own consent rights; Admin only monitors compliance.

* **Bulk Enrollment Tool**:

  * Select multiple children → assign to a program bundle.

  * Useful for term starts (e.g., enrolling all Year 5 students into KTA Term 2).

---

## **4\. Program & Curriculum Access**

* **Programs Tab**:

  * Overview of all structured programs delivered at micro-school.

  * Cards show: Program name, enrolled students, assigned teacher, next class.

* **Curriculum Packs**:

  * Download/view teacher packs (e.g., lesson plans, resources).

  * Available only to teachers and admins, not students directly.

---

## **5\. Attendance & Compliance**

* **Attendance Dashboard**:

  * Daily/weekly attendance logs for all classes.

  * Filters by program, teacher, student.

* **ESA Integration**:

  * Admin can view which sessions are ESA-eligible.

  * Can **export bulk attendance logs** for school reporting.

  * Parents still download individual ESA logs for their own child.

* **Audit Trail**: all attendance records stored with timestamp, IP, duration.

---

## **6\. Billing & Finance**

* **Micro-school Billing Account** (US LLC Stripe):

  * View invoices for program bundles and teacher contracts.

  * Track payment history (per semester/term).

* **Family Payments**:

  * Parents still pay for extras (Marketplace, tutoring, ESA-funded items).

  * Dashboard displays what’s funded by school vs parents.

* **Reporting**:

  * Download CSV/PDF summaries of costs per program, per child, or per funding source.

---

## **7\. Communication & Community**

* **Announcements**:

  * Admin can send school-wide updates to all families.

* **Teacher Messaging**:

  * Internal comms tool with audit logging (for FERPA/COPPA).

  * No private teacher-student chat (all comms mirrored to parents).

* **School Forum** (optional):

  * Moderated community for enrolled families.

  * Parent-visible, teacher-moderated.

---

## **8\. Safety & Reporting**

* **Incident Log**:

  * Shows all safety incidents flagged by teachers, parents, or students.

  * Status updates: Under Review, Resolved, Escalated.

* **Mandatory Reporting Tools**:

  * US compliance: generate report template for CPS/law enforcement if required.

  * Pre-filled with timestamps, child details, teacher notes.

* **Audit Access**:

  * Immutable logs available for 7 years.

---

## **9\. Resource Library**

* **School Resources Tab**:

  * Group-level packs purchased (curriculum, 10-week programs).

  * Private visibility: only available to enrolled families \+ teachers.

* **Usage Controls**:

  * Parents download resources watermarked individually.

  * Admin cannot mass-export — prevents uncontrolled distribution.

---

## **10\. Notifications & Reminders**

* Teacher clearance expiry alerts.

* ESA approvals expiring soon.

* Term bundle renewal reminders.

* Parent consents lapsing.

* Program start/end cycle reminders.

---

## **11\. Compliance Guardrails**

* **COPPA/FERPA Compliance**:

  * No private chat features.

  * Parent consent must be valid before a child is active.

  * All student data stored with audit logging.

* **Audit Export**:

  * Generate “Compliance Bundle” (PDF with consents, attendance, receipts).

* **Data Retention**:

  * Minimum 7 years for ESA/COPPA records.

---

# **🔑 Micro-school Dashboard Philosophy**

* **Admin \= oversight & facilitation**, not replacing parental rights.

* **School-level control**: Enrolments, teachers, finances, compliance.

* **Parent \+ Teacher transparency**: Every action logged and mirrored.

---

✨ Visual design: More **“institutional”** than Co-op dashboard. Tabs across top:  
 *Overview \| Staff \| Families \| Programs \| Attendance \| Billing \| Resources \| Safety \| Reports*.

---

# **🎓 Program Teacher Dashboard (Contracted – KTA / iProject / Thinkers)**

## **Purpose**

Operational control for contracted educators delivering structured programs. Focus: **cohort delivery, attendance, reporting, and compliance** (ESA/FERPA/COPPA/eSafety). No pricing or marketplace publishing.

## **Home**

* **Status chips:** ✅ Approved · Clearance OK/Expiring · Contract active/ending

* **Today:** Upcoming classes (Join/Start Live), attendance due, submissions to review

* **Alerts:** ESA attendance missing; clearance expiring; incident assigned

## **Core Navigation**

1. **Cohorts**

   * Cards: Program, term, teacher, schedule, seats, ESA badge

   * Actions: Join Live, Open Lesson, Roster, Attendance, Message Cohort

   * **Roster:** learner list (first name/initial), consent status icon, parent contact (masked)

2. **Curriculum**

   * Read/clone **program-owned** course packs

   * Build lessons within assigned scope (Course → Modules → Lessons → Blocks)

   * Versioning with admin review (no marketplace publish)

3. **Attendance & Assessment**

   * Live: auto-capture with manual override \+ reason

   * Self-paced: 90% viewed or quiz submitted

   * Projects: rubric grading, feedback, resubmission

   * **Exports:** cohort CSV/PDF; ESA-ready logs (if required)

4. **Messages & Announcements**

   * Post to cohort (parent-mirrored)

   * Lesson discussion threads (moderated, no private DMs)

5. **Resources**

   * Upload lesson files (PDF/ZIP/MP4); mark “included”

   * Watermark preview (parent/child personalized)

6. **Payouts (Program)**

   * Stipend/term schedule, sessions delivered, statements (CSV/PDF)

7. **Compliance Hub**

   * WWCC/FBI status & reminders

   * Agreements (versioned PDFs)

   * Incident log (file/view status)

   * ESA checklist per cohort/course

8\. **Teacher Hub for Professional Growth**

## **UI Components**

`<CohortCard/> <RosterTable/> <AttendancePanel/> <LessonViewer/> <BlocksEditor (restricted)/> <Announcements/> <SafetyQueue/> <ESAComplianceBar/> <PayoutsStipendPanel/>`

## **Permissions (Program)**

* Create/edit lessons **within assigned program** only 

* No pricing, no marketplace publish

* Access only to assigned cohorts/rosters

* View ESA flags; generate ESA attendance where required

## **Data Model (Program)**

* `teachers.type = "PROGRAM"`

* `program_assignments(teacher_id, program_id, term_id, cohort_id)`

* `attendance_logs(enrollment_id, lesson_id, status, duration, timestamp, source)`

* `payout_statements(type="PROGRAM_STIPEND")`

## **API (Program)**

* `GET /api/program/teacher/dashboard`

* `GET /api/program/cohorts?status=active`

* `POST /api/program/attendance` ({cohortId, sessionId, marks\[\]})

* `POST /api/program/announcements`

* `GET /api/program/esa/logs?cohortId=...`

* `GET /api/teacher/payouts?type=PROGRAM_STIPEND`

## **Guardrails**

* No student-private messaging; all mirrored to parents

* Region data residency (US↔US, AU↔AU)

* All actions timestamp/IP logged; virus-scan uploads; keyword filter

* Consent must be valid before attendance can be recorded

## **Notifications**

* 24h/10m pre-class; missing attendance; clearance 30/7/1 days; incident updates; stipend posted

---

# **🛒 Marketplace Teacher Dashboard (Independent Sellers)**

## **Purpose**

Creation and sale of courses/resources in Marketplace. Focus: **authoring, pricing/tokens, review workflow, students who purchased, ESA eligibility per SKU**. No program stipend, no program rosters.

## **Home**

* **Status chips:** ✅ Approved to list · Stripe Connect Connected/Action Needed

* **Today:** Live classes to host, submissions to review

* **Business snapshot:** Views → Wishlists → Enrolments · Revenue MTD

## **Core Navigation**

1. **My Courses**

   * Table/cards: title, status (Draft/In Review/Published), rating, enrollments

   * Actions: Edit, Submit for Review, Publish (post-approval), Schedule

2. **Course/Module Builder**

   * Full editor (Course → Modules → Lessons → Blocks)

   * **Pricing:** cash (USD/AUD), tokens; bundles

   * **ESA eligibility request** flag (org maprules)  
     s to   
3. **Scheduling**

   * Cohorts (live) with timezone-aware sessions; class size caps; reschedule/make-up flows

4. **Students & Rosters**

   * Enrolled learners for **your course only**

   * Attendance tools (live/self-paced) → feeds receipts if ESA-required

5. **Messages & Discussions**

   * Announcements to enrolled families

   * Lesson threads (moderated, parent-visible)

6. **Resources (for sale)**

   * Upload packs; set **cash/token** price

   * Previews (limited pages), watermark handling, entitlement checks

7. **Payouts (Marketplace)**

   * Revenue share (e.g., 70/30), statements, refunds, tax info

8. **Compliance Hub**

   * Agreements, clearances, content moderation status

   * ESA state-eligibility viewer for course SKUs

## **UI Components**

`<CourseTable/> <PublishBar status/> <PricingPanel cash/tokens/> <ScheduleManager/> <EnrollmentRoster/> <ESAComplianceBar/> <ResourceBuilder/> <PayoutsRevenuePanel/> <ReviewsAndRatings/>`

## **Permissions (Marketplace)**

* Full authoring of owned courses/resources

* Must pass **Submit → Review → Publish**

* Set pricing/tokens; toggle ESA eligibility request (final mapping by compliance)

* Access only to rosters of purchased learners

## **Data Model (Marketplace)**

* `teachers.type = "MARKETPLACE"`

* `courses(owner_teacher_id, status, price_cash, price_tokens, sku, esa_flags)`

* `enrollments(course_id, parent_id, child_id, method: STRIPE|TOKENS|ESA)`

* `payout_statements(type="MARKETPLACE_SHARE")`

## **API (Marketplace)**

* `GET /api/marketplace/teacher/dashboard`

* `POST /api/courses/:id/submitForReview`

* `POST /api/courses/:id/publish` (after approval)

* `POST /api/courses/:id/schedule`

* `GET /api/courses/:id/enrollments`

* `POST /api/courses/:id/announcements`

* `GET /api/teacher/payouts?type=MARKETPLACE_SHARE`

## **Guardrails**

* Review workflow blocks publish until approved

* ESA: show badge only if **family ESA approved** and **SKU eligible** and **state allows**

* No student-private messaging; all mirrored to parents

* Virus-scan \+ prohibited-keyword filters on all uploads

## **Notifications**

* Course approved/rejected with notes

* New enrollments/refunds; upcoming sessions; ESA fields incomplete; Stripe Connect issues

---

# **🧭 Where They Differ (Quick Matrix)**

| Area | Program Teacher | Marketplace Teacher |
| ----- | ----- | ----- |
| Primary Goal | Deliver assigned **program** cohorts | Create and sell **courses/resources** |
| Content Rights | Program-owned packs; limited authoring | Full authoring; owns listings |
| Publish Flow | Direct to cohort (admin oversight) | Submit → Review → Publish |
| Pricing | None (program set) | Set price/tokens; bundles |
| Rosters | Program cohorts only | Purchasers of your listings |
| Payouts | Stipend/term | Revenue share (70/30) |
| ESA | Attendance logs per program/course if required | ESA badge/receipts if SKU eligible and state allows |
| Messaging | Cohort announcements; parent-mirrored | Course announcements; parent-mirrored |
| Compliance | Contracted vetting \+ program policy | Marketplace vetting \+ content moderation |

---

# **🔒 Common Safety & Compliance (Both)**

* No teacher↔student private DMs; parent-visible threads only

* Consent validation gate before learner can access live classes

* Region data residency; full audit logging (7 years for COPPA/ESA)

* Auto virus-scan; keyword moderation; report/escalation workflow

* Watermarked resources; download telemetry and rate-limits

# **🇦🇺 AU Charity Admin Dashboard**

**Entity:** The Transformation Network Ltd (Australia) – ACNC governed, Privacy Act 1988 (Cth), Online Safety Act 2021  
 **Primary Goal:** Faith-centered education with **charity governance**, **donor management**, and **child safety** at the core. **No ESA.**

## **1\) Personas / Roles**

* **ROLE\_ADMIN\_AU** (Charity Admin – full tenant control)

* **ROLE\_COMPLIANCE\_AU** (Privacy/eSafety/Child Safe Standards)

* **ROLE\_FINANCE\_AU** (Stripe AU \+ donor finance)

* **ROLE\_MODERATION\_AU** (content safety)

* **ROLE\_SUPPORT\_AU** (tier-2 support)

## **2\) Navigation**

1. Overview (Charity KPIs & alerts)

2. Programs (KTA, iProject, Thinkers)

3. Marketplace (reviews, listings, resources)

4. Compliance & Safety (consents, incidents, moderation, legal)

5. Payments & Donors (Stripe AU \+ donor flows)

6. Attendance & Reports

7. CRM & Communications

8. Logs & Audit

9. Feature Flags & Config

10. Support Tools

## **3\) Overview**

* **KPI Cards:** Active families/students/teachers, program enrolments, marketplace sales (AUD), donor volume, attendance completion %, open safety incidents.

* **Alerts:** Teacher WWCC expiring; privacy policy version bump coverage; moderation spikes; Stripe payout issues (AU).

## **4\) Programs**

* **Terms & Cohorts:** create terms, assign teachers, caps, schedules.

* **Curriculum Packs:** upload/approve; archive versions.

* **Attendance Settings:** per-course rules (no ESA requirements).

## **5\) Marketplace**

* **Review Queue:** auto-scans (virus/keywords/parental guidance) \+ human check.

* Approve/Reject/Unpublish with reasons; AU visibility toggles.

* **Pricing Audit:** AUD pricing \+ token sanity.

## **6\) Compliance & Safety (AU)**

* **Consents:** AU parental consent viewer (PDF with IP/timestamp/version).

* **Child Safety Incidents:** pipeline (New → Review → Reported if required → Resolved); ACNC & eSafety guidance links.

* **Moderation:** flagged posts/files; remove/warn/suspend; audit trail.

* **Legal Versioning:** AU Privacy Policy, ToS, Consent (verbatim) with version bump \+ acceptance tracking.

## **7\) Payments & Donors (AU)**

* **Stripe AU (Charity):** payouts status, disputes, refunds, receipts storage.

* **Donor Management (non-DGR):**

  * Donor Agreement \+ Donor Privacy (verbatim) acknowledgment tracking.

  * Donation exports; “not tax-deductible” compliance banners.

* **Teacher Payouts (Program/Marketplace):** Connect status, statements in AUD.

## **8\) Attendance & Reporting**

* Cohort attendance monitor; completion analytics; exports (CSV/PDF).

* **Audit bundles** (attendance, consents, receipts) for ACNC/eSafety reviews.

## **9\) CRM & Communications**

* HubSpot sync monitor (AU segmentation).

* Broadcasts to AU families/teachers; legal update banners.

## **10\) Logs & Audit**

* Immutable logs; consent and moderation exports; retention clocks per AU policy.

## **11\) Feature Flags & Config**

* AU-specific flags (e.g., under-13 messaging restrictions, marketplace visibility).

* Maintenance mode \+ tenant branding.

## **12\) Guardrails (AU)**

* Data residency: AU data on AU (or approved) servers.

* Parent consent must be valid before child access.

* No private teacher–student DMs; all parent-mirrored.

* Two-person review for destructive actions (e.g., mass unpublish).

## **13\) Success Metrics (AU)**

* Teacher approval SLA, safety incident time-to-close, consent coverage %, refund rate, donor conversion/retention, attendance completeness.

## **14\) Data / API (AU Highlights)**

* **Data:** `donor_agreement_au`, `donor_privacy_au`, `privacy_policy_au`, `acceptances`, `payout_statements(tenant='AU')`

* **APIs:**

  * `GET /api/au/admin/overview`

  * `POST /api/au/admin/listings/:id/approve|reject`

  * `GET /api/au/admin/consents?childId=...` (PDF bundle)

  * `GET /api/au/admin/finance/stripe` / payouts / refunds

  * `GET /api/au/admin/audit?...`

---

# **🇺🇸 US LLC Admin Dashboard**

**Entity:** The Transformation Network LLC (United States) – COPPA/FERPA, CCPA/CPRA, state child protection laws  
 **Primary Goal:** Program & marketplace operations with **ESA** enablement, **state-by-state compliance**, and school-like oversight (micro-schools).

## **1\) Personas / Roles**

* **ROLE\_ADMIN\_US** (LLC Admin – full tenant control)

* **ROLE\_COMPLIANCE\_US** (COPPA/FERPA/CCPA \+ ESA)

* **ROLE\_FINANCE\_US** (Stripe US, ESA finance)

* **ROLE\_MODERATION\_US** (content safety)

* **ROLE\_SUPPORT\_US** (tier-2 support)

* **ROLE\_MICROSCHOOL** (org admin; scoped access)

## **2\) Navigation**

1. Overview (LLC KPIs & alerts)

2. Programs (KTA, iProject, Thinkers) & Micro-schools

3. Marketplace (reviews, listings, ESA eligibility)

4. Compliance & Safety (US consents, incidents, moderation, legal)

5. Payments & ESA (Stripe US, ESA rules, verification, evidence)

6. Attendance & ESA Reporting

7. CRM & Communications

8. Logs & Audit

9. Feature Flags & Config

10. Support Tools

## **3\) Overview**

* **KPI Cards:** Active families/students/teachers, enrolments, marketplace sales (USD), **ESA transactions \+ states**, attendance (ESA-required vs general), open incidents.

* **Alerts:** COPPA/FERPA policy version bump acceptance, ESA rules expiring, teacher background checks expiring, Stripe payout issues (US).

## **4\) Programs & Micro-schools**

* Terms/cohorts manager; assign teachers; caps/schedules.

* **Micro-school Admins:** manage staff, bulk enrolments (parent consent gate), org-level reports.

* Curriculum packs; versioning; attendance requirements per course/cohort.

## **5\) Marketplace**

* **Review Queue:** safety/content alignment \+ ESA eligibility checks.

* Approve/Reject/Unpublish; US visibility flags.

* **ESA surface:** show which SKUs requested eligibility; map to state rules.

## **6\) Compliance & Safety (US)**

* **US Consents:** COPPA (under-13), FERPA (if school-based), CCPA/CPRA—viewer \+ export.

* **Incidents:** pipeline with CPS/law enforcement reporting templates; immutable evidence hashes.

* **Moderation:** flagged content queue; parent-visible outcomes.

* **Legal Versioning:** US Privacy Policy & ToS (verbatim) with acceptance tracking.

## **7\) Payments & ESA (US)**

* **Stripe US (LLC):** payouts, disputes, refunds; receipts immutable.

* **ESA Suite:**

  * **Rules Matrix Editor:** `esa_program_rules`, `esa_program_rule_skus`, `esa_receipt_requirements`.

  * **Verification Queue:** statuses (PENDING → APPROVED/REJECTED/EXPIRED); award letter storage.

  * **Checkout Enforcement:** split cart, marketplace\_allowed, attendanceRequired.

  * **Evidence Bundles:** receipt \+ attendance logs; **7-year retention**.

  * **State Snapshots:** active states, last-updated, exceptions.

## **8\) Attendance & ESA Reporting**

* Attendance monitor; **ESA-required** sessions highlighted.

* Generate ESA-compliant reports (per state, per SKU, per child).

* Anomaly detector (missing logs for ESA classes; short durations).

## **9\) CRM & Communications**

* HubSpot sync monitor (US segmentation).

* Broadcasts; legal/ESA update banners requiring acknowledgment.

## **10\) Logs & Audit**

* Immutable logs; consent/ESA/attendance exports; **7-year** retention timers.

## **11\) Feature Flags & Config**

* US-specific flags (ESA flows, micro-school features, messaging restrictions).

* Tenant branding; maintenance mode; targeted rollouts.

## **12\) Guardrails (US)**

* Data residency: US data on US servers.

* Parent consent pre-access (COPPA, FERPA contexts).

* No private teacher–student DMs; parent mirrored.

* ESA: strict rule enforcement before purchase/access.

* Two-person review for destructive operations.

## **13\) Success Metrics (US)**

* ESA approval rate & processing time; evidence bundle completeness; consent coverage; attendance completeness for ESA; payout latency; dispute/refund rates.

## **14\) Data / API (US Highlights)**

* **Data:** `esa_program_rules`, `esa_program_rule_skus`, `esa_receipt_requirements`, `acceptances(US)`, `payout_statements(tenant='US')`

* **APIs:**

  * `GET /api/us/admin/overview`

  * `GET/POST /api/us/admin/esa/rules`

  * `GET /api/us/admin/esa/verifications` • `POST /api/us/admin/esa/verifications/:id/approve`

  * `GET /api/us/admin/attendance?esaRequired=true` • exporters

  * `POST /api/us/admin/listings/:id/approve|reject`

  * `GET /api/us/admin/consents?childId=...` (bundle)

  * `GET /api/us/admin/finance/stripe` / refunds

  * `GET /api/us/admin/audit?...`

---

## **🔎 AU Charity vs US LLC – What’s Different?**

| Area | AU Charity Admin | US LLC Admin |
| ----- | ----- | ----- |
| Primary Compliance | ACNC, Privacy Act 1988 (Cth), Online Safety Act 2021 | COPPA, FERPA, CCPA/CPRA \+ state laws |
| Payments | Stripe AU, AUD | Stripe US, USD |
| Donors | **Yes** (non-DGR; not tax-deductible) | **No** (not a charity) |
| ESA | **No** | **Yes** (rules matrix, verification, evidence, 7-year retention) |
| Micro-schools | Not applicable | **Yes** (org-level admin & reports) |
| Legal Docs | AU Privacy Policy, AU Consent | US Privacy Policy, COPPA/FERPA consent |
| Attendance | Standard program/marketplace | Standard \+ **ESA-required sessions** tracking & evidence |
| Data Residency | AU servers (or approved) | US servers |
| Moderation | AU safety framing & escalation | US safety framing & CPS/law enforcement templates |

---

## **Implementation Notes (Both Tenants)**

* **RBAC isolation:** never leak cross-tenant data; each dashboard runs scoped to its tenant.

* **Verbatim legal text:** stored by `doc_key + version_id`; acceptance logged with IP/signature/PDF hash.

* **Audit everywhere:** timestamp \+ IP \+ actor \+ diff; exportable bundles.

* **Parent primacy:** parents control consent; admins can view/export but not override.

* **No student-private messaging:** all communications mirrored to parents; moderated.

# **🔮 Universal, Cross-Dashboard Features**

## **1\) Global Command Palette & Search**

* One shortcut (`⌘/Ctrl + K`) to search **people, classes, resources, receipts, consents, incidents**, and jump to actions (“mark attendance”, “download ESA bundle”).

* Semantic search across lessons/resources; respects RBAC/tenant.

* **Build notes:** Index denormalized fields \+ embeddings; per-tenant sharding; results filtered by role.

## **2\) Copilot (Guardrailed AI)**

* Role-aware assistant that can: summarize policies, draft parent emails, propose lesson outlines, explain attendance issues, generate checklists.

* Strict **safety rails**: no private DMs, no unsanctioned data movement, citations to source records, opt-in by tenant.

* **Build notes:** Server-side prompts with PII redaction; per-tenant policy packs (AU vs US); audit every suggestion.

## **3\) Smart Calendar & Timezone Brain**

* Unified calendar view (classes, deadlines, reviews, payouts).

* Auto time-zone conversion; **conflict detection** (teacher double-book, student overlap).

* One-click **reschedule with notifications** (parents mirrored).

* **Build notes:** iCal feeds, Google/Microsoft 2-way optional, cohort-aware collisions.

## **4\) Universal Inbox & Notification Center**

* Single feed for messages, approvals, safety alerts, expiring consents/clearances, ESA actions, payouts, refunds.

* **Digest mode** (daily/weekly) and **Do-Not-Disturb** windows.

* **Build notes:** Notification types table \+ per-role priorities; email \+ in-app \+ push.

## **5\) Accessibility & Inclusion Suite**

* Dyslexia-friendly toggle, adjustable line spacing, focus mode.

* Auto-captions for videos; transcript download; keyboard-first navigation.

* Live translation (UI \+ teacher announcements) with parent preview.

* **Build notes:** WCAG 2.2 baseline; caption pipeline; locale packs (en-AU, en-US first).

## **6\) Privacy & Data Controls (Trust Center)**

* “Why you’re seeing this” explainer panels on sensitive cards (attendance, recommendations).

* One-click **data export bundles** (consents, receipts, attendance) for any child/family.

* **Region locks** surfaced in UI (AU data in AU, US in US).

* **Build notes:** Prebuilt PDF/ZIP exporters; immutable hashes; retention timers visible.

## **7\) Safety Intelligence (Real-time)**

* Soft-signal detector for risky content (toxicity, grooming cues) across forums/attachments → **triage queue**; parents mirrored.

* Age-band policies (under-13 stricter defaults; US COPPA gates).

* **Build notes:** On-upload scanning \+ text heuristics \+ ML; false-positive review flows.

## **8\) Learning & Engagement Signals**

* Early-warning **risk scores** (low attendance, missed tasks) surfaced to all relevant roles with “next best action”.

* Cohort health heatmaps (attendance %, completion, message sentiment).

* **Build notes:** Lightweight feature store; explainable scoring; no black-box gating.

## **9\) Interop & Portability**

* **LTI 1.3** provider (embed KTA+ in school LMS) and SCORM viewer (read-only).

* SIS/roster import (CSV \+ OneRoster ready).

* Webhooks for **attendance, purchases, incidents** to district/coop systems.

* **Build notes:** Scoped API keys per tenant; replay protection; event schemas.

## **10\) Gamified Recognition (Privacy-safe)**

* **Open Badges** for milestones (attendance streaks, project mastery).

* Parent-approved sharing (toggle per child).

* **Build notes:** Badge issuer service; obfuscated public URLs; revocation list.

## **11\) Offline-friendly & Low-Bandwidth Mode**

* PWA install; lesson caching; queued submissions/attendance when offline.

* Degraded video (auto bitrate) \+ download-later tasks.

* **Build notes:** Background sync \+ service workers; per-file size caps.

## **12\) Feature Flags & Experiments Everywhere**

* Tenant/role targeting for new flows (ESA v2, schedule UI v2).

* Built-in A/B metrics: CTR → completion → refund/incident impact.

* **Build notes:** Central flag service \+ guardrails; auto rollback on error budgets.

---

# **🧑‍🎓 Student — Future Enhancements**

* **Focus Planner**: weekly goals with parent-approved rewards; AI suggests time blocks.

* **Project Portfolio**: safe, shareable showcase; teacher-curated with parent toggle.

* **Wellbeing pulse** (opt-in): simple emoji check-ins → alert parent/teacher if concerning.

# **👩‍👧 Parent — Future Enhancements**

* **Family Wallet**: auto top-up tokens, budget alerts, purchase approvals.

* **Smart Oversight**: “Show me today’s highlights” (submissions, feedback, risks).

* **Consent Lifecycle**: renewals calendar; pre-filled re-sign; cross-child actions.

# **👩‍🏫 Teacher (Program & Marketplace) — Future Enhancements**

* **Auto-attendance assist** (live → reconcile with roster; suggests fixes).

* **Rubric helper**: draft feedback from rubric \+ work artifacts (teacher approves).

* **Cohort Composer**: recommends session cadences from outcomes \+ timezone mix.

# **👥 Co-op — Future Enhancements**

* **Seat Orchestrator**: auto-balance seats across cohorts; waitlist rules.

* **Shared Token Pool (optional)**: coordinator sets allocation rules; parent transparency.

* **Impact Reports**: engagement & completion summaries for grant reporting.

# **🏫 Micro-school (US) — Future Enhancements**

* **Staff Clearance Radar**: forecast expiries \+ bulk re-verification workflows.

* **Org-wide Curriculum Map**: coverage vs standards; gaps and recommendations.

* **FERPA Request Center**: structured intake \+ fulfillment SLA tracking.

# **🌐 AU Charity Admin — Future Enhancements**

* **Donor Insights** (non-DGR context): campaign attribution, program impact snapshots.

* **ACNC Export Pack**: preformatted bundles for audits.

* **Policy Diff Viewer**: compare legal versions; re-acceptance heatmap.

# **🇺🇸 US LLC Admin — Future Enhancements**

* **ESA Rule Simulator**: test a cart against state rules before publishing SKUs.

* **Evidence Autocomplete**: prefill ESA receipts/attendance from logs with state-specific footers.

* **Micro-school Benchmarks**: anonymized cohort stats across orgs (privacy-preserving).

---

## **⚙️ Quick Effort Guide**

* **Low**: Global command palette, digest emails, consent lifecycle UI, PWA shell.

* **Medium**: Universal inbox, rubric helper (draft-only), badge issuer, SIS CSV import.

* **High**: Safety intelligence, ESA simulator, offline sync with conflict resolution, LTI 1.3.

---

## **🔐 Non-negotiables (for all new features)**

* RBAC everywhere (tenant \+ role).

* Data residency honored (AU↔AU, US↔US).

* Full audit logs (actor, IP, timestamp, diff).

* Parent primacy: no private student chats; all child comms parent-visible.

* Clear **opt-in** for AI-assisted features; show sources; easy disable.

---

## **16\) Technical Architecture & Security**

* **Frontend:** Flutter (mobile/web), modern component library; responsive.

* **Backend:** PHP Laravel; REST/GraphQL; job queue for attendance, receipts, email.

* **DB:** PostgreSQL; schemas for agreements, consents, ESA, audit.

* **Auth:** Auth0 or Firebase Auth; roles (Parent, Student, Teacher, Coordinator, Micro-school Admin, Org Admin, Donor).

* **Payments:** Stripe (AU Charity, US LLC; Connect for teachers).

* **Storage:** AU data on AU or US servers; US data on US servers; encrypted at rest.

* **Logs & Audit:** Every acceptance/consent/action with **timestamp, IP, user\_id, version\_id**.

* **Exports:** PDF generation for agreements, receipts, attendance, audit bundles.

* **Moderation:** Flag/report pipeline; escalation to safety team; immutable incident logs.

* **Compliance Retention:** AU (as needed for ACNC/eSafety); US **7 years** for COPPA/ESA; donor/finance per tax law.

---

## **17\) QA / UAT Checklists (high-level)**

* **Onboarding (Parent/Teacher/Co-op/Micro-school/Donor)**: forms, validation, agreements stored, audit logs present.

* **ESA**: form validation, admin review, status transitions, checkout enforcement, receipt & attendance PDFs, role permission checks.

* **Marketplace**: vetting gate for teachers; listing → purchase → access; program SKUs appear in marketplace as premium where allowed.

* **Privacy/ToS**: display full text; acceptance stored with versioning.

* **Billing/Tokens**: rollover tokens; split carts (ESA vs personal); refunds follow rules.

* **CRM**: HubSpot sync (parents only), segmentation, email automations.

---

## **18\) Versioning & Document Control**

Store a **version\_id** for every legal doc:

* parent\_consent\_au v1.0

* parent\_consent\_us v1.0

* teacher\_agreement\_au v1.0

* teacher\_agreement\_us v1.0

* coop\_agreement\_au v1.0

* coop\_agreement\_us v1.0

* microschool\_admin\_agreement\_us v1.0

* donor\_agreement\_au v1.1 (non-DGR)

* donor\_privacy\_au v1.0

* privacy\_policy\_au v1.0

* privacy\_policy\_us v1.0

* tos\_global v1.0

* esa\_policy\_us v1.0

* esa\_agreement\_us v1.0

**Acceptance table fields:** user\_id, doc\_key, version\_id, accepted\_at, ip\_address, signature\_name (if applicable), hash\_of\_rendered\_pdf.

---

### **Final Notes**

* All “(verbatim)” sections above must be inserted **word-for-word** (as already provided in this scope).

* Where you send updated agreements later, replace the verbatim blocks and **bump version\_id**.

* Keep **AU vs US** experiences split server-side by **tenant \+ user locale**; display the right legal text and storage region automatically.

---

[image1]: <data:image/png;base64,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>

[image2]: <data:image/png;base64,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>

[image3]: <data:image/png;base64,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>