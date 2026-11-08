// =============================================================================
// KTA+ (Kingdom Thinkers Academy Plus) — Frontend-Aligned Database Design
// =============================================================================
// Format : DBML (dbdiagram.io) — Table { ... } format.
//          Relationships are INLINE on the FK column:
//            company_id bigint [not null, ref: > companies.id]
//          Paste into dbdiagram.io to view the ERD. Executable MySQL twin:
//          database-executable.sql (98 tables, 166 FKs, verified on MySQL 8.4).
// Source : ONLY frontend + client requirement docs — Figma Master UI
//          (node-id 804-24216; figma.md node-id 9694-1363), Micro-School /
//          Co-op Dashboard Figma (node-id 36516-43293), live app
//          https://app.ktaplus.io (bundle index-C6-MRnI4.js, API base
//          https://admin.ktaplus.io/api), landing https://www.ktaplus.io,
//          input/client-docs (Handover Rev 3.2 + Full SaaS Scope).
// Tables : 98 tables, 168 inline relationships
// Naming : plural snake_case tables, singular snake_case columns,
//          <singular_table>_id FKs, money = *_cents + currency (never float),
//          student IS a row in children (child_id everywhere).
// =============================================================================

Table users {
  id bigint [pk, increment, not null]
  first_name varchar(100) [not null]
  last_name varchar(100) [not null]
  name varchar(255) [not null, note: 'Display name (first + last); kept in sync by app']
  email varchar(255) [not null, note: 'Login email. Unique case-insensitively via collation.']
  phone varchar(30) [null, note: 'E.164 international format']
  password varchar(255) [not null, note: 'Laravel bcrypt/argon hash. Never plaintext.']
  role enum('parent', 'student', 'teacher', 'contracted_teacher', 'coop', 'micro_school', 'admin', 'super_admin') [not null, default: 'parent', note: 'PRIMARY portal role (8 personas, summary section 4). Extra access comes from educator_profiles / org membershi']
  avatar_url varchar(255) [null]
  country enum('AU','US','GLOBAL') [not null, default: 'GLOBAL']
  timezone varchar(64) [not null, default: 'UTC', note: 'IANA zone, e.g. Australia/Sydney']
  status enum('pending_approval','active','suspended','inactive') [not null, default: 'active']
  is_onboarding_completed boolean [not null, default: false]
  email_verified_at timestamp [null]
  remember_token varchar(100) [null]
  deleted_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (email) [name: 'uq_users_email' , unique]
    (role, status) [name: 'idx_users_role_status']
    (country, status) [name: 'idx_users_country_status']
    (deleted_at) [name: 'idx_users_deleted_at']
  }
}

Table password_reset_tokens {
  email varchar(255) [not null]
  token varchar(255) [not null]
  created_at timestamp [null]
}

Table sessions {
  id varchar(255) [pk, not null]
  user_id bigint [null]
  active_child_id bigint [null, note: 'X-Active-Child-Id header: child the parent session is currently acting for (non-teacher/CT only)']
  ip_address varchar(45) [null]
  user_agent text [null]
  payload text [null]
  last_activity int [not null]

  indexes {
    (user_id) [name: 'idx_sessions_user']
    (active_child_id) [name: 'idx_sessions_active_child']
    (last_activity) [name: 'idx_sessions_last_activity']
  }
}

Table otps {
  id bigint [pk, increment, not null]
  user_id bigint [null, ref: > users.id, note: 'NULL for pre-registration OTP by email']
  child_id bigint [null, ref: > children.id, note: 'Set when purpose=child_login_setup (POST /parent/children/{id}/login-setup/send-otp). FK added after children ']
  email varchar(255) [not null, note: 'Destination email: parent email (registration) or child login email (child_login_setup)']
  code_hash varchar(255) [not null, note: 'Hash of the 6-digit code. NEVER store the raw code.']
  purpose enum('registration','login','password_reset','email_verification','child_login_setup') [not null, default: 'registration']
  attempts int [not null, default: 0, note: 'Lock after 5 failed attempts']
  expires_at timestamp [not null, note: 'Typically created_at + 10-15 min']
  used_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (email, purpose, used_at, expires_at) [name: 'idx_otps_email_purpose']
    (child_id, purpose, expires_at) [name: 'idx_otps_child']
    (user_id) [name: 'idx_otps_user']
  }
}

Table app_settings {
  id bigint [pk, increment, not null]
  setting_key varchar(100) [not null, note: 'e.g. token_value_usd_cents, platform_commission_pct']
  setting_value text [null]
  value_type boolean [not null, default: 'string']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (setting_key) [name: 'uq_app_settings_key' , unique]
  }
}

Table children {
  id bigint [pk, increment, not null]
  parent_id bigint [not null, ref: > users.id, note: 'Owning guardian (users.id, role=parent). COPPA: parent is the account holder.']
  login_user_id bigint [null, ref: > users.id, note: 'Optional student login (users.id role=student) created BY the parent via POST /parent/children/{id}/login-setu']
  login_email varchar(255) [null, note: 'Child login email verified by OTP (POST .../login-setup/send-otp + verify-otp)']
  login_setup_completed_at timestamp [null, note: 'Set when the 3-step login-setup flow finishes']
  student_code varchar(32) [null, note: 'Human-friendly unique code shown in UI, e.g. KTA-8F3KQ2']
  name varchar(255) [not null]
  date_of_birth date [null]
  grade_level varchar(50) [null, note: 'Grade K .. Grade 12 (free text in frontend; do not enum — grades change)']
  avatar_id bigint [null, ref: > avatars.id]
  future_aspirations text [null]
  onboarding_draft_id bigint [null, note: 'Draft this child was created from, if any']
  is_active boolean [not null, default: true]
  deleted_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (student_code) [name: 'uq_children_student_code' , unique]
    (login_user_id) [name: 'uq_children_login_user' , unique]
    (parent_id, is_active, created_at) [name: 'idx_children_parent']
    (parent_id, deleted_at) [name: 'idx_children_parent_deleted']
  }
}

Table parent_details {
  id bigint [pk, increment, not null]
  user_id bigint [not null, ref: > users.id, note: 'Guardian account (users.id)']
  country enum('AU','US','GLOBAL') [not null, default: 'GLOBAL']
  state varchar(100) [null]
  city varchar(100) [null]
  address_line text [null]
  postal_code varchar(20) [null]
  emergency_contact_name varchar(255) [null]
  emergency_contact_phone varchar(30) [null]
  photo_id_url varchar(255) [null, note: 'Government photo ID upload (onboarding step 2)']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (user_id) [name: 'uq_parent_details_user' , unique]
  }
}

Table parent_onboarding_drafts {
  id bigint [pk, increment, not null]
  user_id bigint [null, ref: > users.id, note: 'NULL until the account is created mid-wizard']
  current_step int [not null, default: 1, note: 'AU 5-step / US 6-step wizard position']
  country enum('AU','US','GLOBAL') [null]
  payload text [null, note: 'Unsaved wizard answers; promoted to real tables on submit']
  is_completed boolean [not null, default: false]
  completed_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (user_id, is_completed) [name: 'idx_onboarding_drafts_user']
  }
}

Table consents {
  id bigint [pk, increment, not null]
  user_id bigint [not null, ref: > users.id, note: 'Signing guardian']
  child_id bigint [null, ref: > children.id, note: 'Child this consent covers (NULL = account-level consent)']
  consent_type enum('coppa','privacy_policy','safeguarding_policy','terms_of_service','photo_release') [not null]
  policy_version varchar(32) [not null, note: 'Version signed, e.g. 2026-01']
  signature_name varchar(255) [not null, note: 'Typed/signed legal name']
  signature_data text [null, note: 'Signature image data / canvas reference']
  ip_address varchar(45) [null]
  signed_at timestamp [not null]
  created_at timestamp [not null]

  indexes {
    (user_id, consent_type, signed_at) [name: 'idx_consents_user']
    (child_id, consent_type) [name: 'idx_consents_child']
  }
}

Table avatars {
  id bigint [pk, increment, not null]
  name varchar(100) [not null]
  image_url varchar(255) [not null]
  sort_order int [not null, default: 0]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (is_active, sort_order) [name: 'idx_avatars_active_sort']
  }
}

Table subjects {
  id bigint [pk, increment, not null]
  name varchar(100) [not null]
  slug varchar(100) [not null]
  sort_order int [not null, default: 0]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_subjects_slug' , unique]
    (is_active, sort_order) [name: 'idx_subjects_active_sort']
  }
}

Table learning_styles {
  id bigint [pk, increment, not null]
  name varchar(100) [not null, note: 'Visual / Auditory / Kinesthetic / Reading-Writing']
  slug varchar(100) [not null]
  sort_order int [not null, default: 0]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_learning_styles_slug' , unique]
  }
}

Table faith_formation_goals {
  id bigint [pk, increment, not null]
  name varchar(150) [not null]
  slug varchar(100) [not null]
  sort_order int [not null, default: 0]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_faith_goals_slug' , unique]
  }
}

Table interests {
  id bigint [pk, increment, not null]
  name varchar(150) [not null]
  slug varchar(100) [not null]
  interest_type enum('general','project') [not null, default: 'general', note: 'Replaces old interests + project_interests tables']
  sort_order int [not null, default: 0]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug, interest_type) [name: 'uq_interests_slug_type' , unique]
    (interest_type, is_active, sort_order) [name: 'idx_interests_type_active']
  }
}

Table pace_preferences {
  id bigint [pk, increment, not null]
  name varchar(100) [not null, note: 'Self-Paced / Fast / Supported']
  slug varchar(100) [not null]
  sort_order int [not null, default: 0]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_pace_preferences_slug' , unique]
  }
}

Table child_learning_styles {
  id bigint [pk, increment, not null]
  child_id bigint [not null, ref: > children.id]
  learning_style_id bigint [not null, ref: > learning_styles.id]
  created_at timestamp [not null]

  indexes {
    (child_id, learning_style_id) [name: 'uq_child_learning_style' , unique]
  }
}

Table child_faith_formation_goals {
  id bigint [pk, increment, not null]
  child_id bigint [not null, ref: > children.id]
  faith_formation_goal_id bigint [not null, ref: > faith_formation_goals.id]
  created_at timestamp [not null]

  indexes {
    (child_id, faith_formation_goal_id) [name: 'uq_child_faith_goal' , unique]
  }
}

Table child_interests {
  id bigint [pk, increment, not null]
  child_id bigint [not null, ref: > children.id]
  interest_id bigint [not null, ref: > interests.id]
  created_at timestamp [not null]

  indexes {
    (child_id, interest_id) [name: 'uq_child_interest' , unique]
  }
}

Table child_pace_preferences {
  id bigint [pk, increment, not null]
  child_id bigint [not null, ref: > children.id]
  pace_preference_id bigint [not null, ref: > pace_preferences.id]
  created_at timestamp [not null]

  indexes {
    (child_id, pace_preference_id) [name: 'uq_child_pace_preference' , unique]
  }
}

Table educator_profiles {
  id bigint [pk, increment, not null]
  user_id bigint [not null, ref: > users.id]
  educator_type enum('marketplace_teacher','contracted_teacher','admin_teacher') [not null]
  headline varchar(255) [null]
  bio text [null]
  school_name varchar(255) [null]
  country enum('AU','US','GLOBAL') [not null, default: 'GLOBAL']
  state varchar(100) [null]
  stripe_account_id varchar(64) [null, note: 'Stripe Connect Express account id (acct_...)']
  stripe_onboarded boolean [not null, default: false]
  demo_video_url varchar(255) [null, note: 'Teaching demo (onboarding step)']
  hourly_rate_cents bigint [null, note: 'Contracted-teacher hourly rate snapshot source; currency via rate_currency']
  rate_currency varchar(3) [null, default: 'AUD']
  status enum('pending_review','verified','rejected','suspended') [not null, default: 'pending_review', note: 'Account approval ONLY. Independent from certification and Premium appointment (handover Rev 3.2 section 11).']
  certification_status enum('none','pending','certified','suspended') [not null, default: 'none', note: 'KTA+ Certified: separate from approval. Certified educator can still have expired compliance.']
  certified_at timestamp [null]
  premium_appointed_at timestamp [null, note: 'Premium Educator appointment: manually by admin, never auto-unlocked. NULL = not Premium.']
  reviewed_by bigint [null, ref: > users.id, note: 'Super-admin user id']
  reviewed_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (user_id) [name: 'uq_educator_profiles_user' , unique]
    (educator_type, status) [name: 'idx_educator_profiles_type_status']
    (stripe_account_id) [name: 'idx_educator_profiles_stripe']
  }
}

Table educator_compliances {
  id bigint [pk, increment, not null]
  educator_profile_id bigint [not null, ref: > educator_profiles.id]
  check_type enum('wwcc','background_check','child_safety_training') [not null]
  check_number varchar(100) [null, note: 'WWCC / background-check reference number']
  state varchar(100) [null]
  document_url varchar(255) [null, note: 'Certificate / ID upload']
  status enum('pending','verified','rejected','expired') [not null, default: 'pending']
  expires_at date [null]
  verified_by bigint [null, ref: > users.id]
  verified_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (educator_profile_id, status, check_type) [name: 'idx_compliances_profile_status']
    (status, expires_at) [name: 'idx_compliances_expiry']
  }
}

Table educator_references {
  id bigint [pk, increment, not null]
  educator_profile_id bigint [not null, ref: > educator_profiles.id, note: 'Onboarding requires 2 professional references']
  reference_name varchar(255) [not null]
  reference_email varchar(255) [null]
  reference_phone varchar(30) [null]
  relationship varchar(150) [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (educator_profile_id) [name: 'idx_educator_references_profile']
  }
}

Table premium_programs {
  id bigint [pk, increment, not null]
  name varchar(255) [not null, note: 'e.g. Kingdom Thinkers Academy, iProject, Thinkers Academy']
  slug varchar(150) [not null]
  program_type enum('kta','iproject','thinkers','marketplace') [not null, default: 'kta']
  description text [null]
  hero_image_url varchar(255) [null]
  banner_image_url varchar(255) [null, note: 'Backend column name: banner_image (GET premium program banner)']
  is_active boolean [not null, default: true]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_premium_programs_slug' , unique]
    (program_type, is_active, sort_order) [name: 'idx_premium_programs_type_active']
  }
}

Table premium_program_summary_sections {
  id bigint [pk, increment, not null]
  premium_program_id bigint [not null, ref: > premium_programs.id]
  section_key enum('big_picture_statement','key_concepts','key_questions','key_vocabulary','success_criteria','final_product_options','universal_skills','checkpoints','kingdom_themes','inquiry_stage') [not null]
  inquiry_stage enum('wonder','seek','discover','connect','share','grow') [null, note: 'Only when section_key=inquiry_stage']
  title varchar(255) [not null]
  content text [null]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (premium_program_id, section_key, inquiry_stage) [name: 'uq_program_section' , unique]
    (premium_program_id, sort_order) [name: 'idx_program_sections_program']
  }
}

Table courses {
  id bigint [pk, increment, not null]
  premium_program_id bigint [null, ref: > premium_programs.id, note: 'NULL for independent marketplace courses']
  creator_id bigint [not null, ref: > users.id, note: 'Educator user id (users.id). Admin-teacher for premium courses.']
  title varchar(255) [not null]
  slug varchar(255) [not null]
  description text [null]
  short_description varchar(500) [null]
  delivery_mode enum('group_live','self_paced','one_on_one','coop_bundle','micro_school_unit') [not null, default: 'self_paced']
  program_type enum('kta','iproject','thinkers','marketplace') [not null, default: 'marketplace']
  status enum('draft','pending_review','published','rejected','archived') [not null, default: 'draft', note: 'Publish requires educator compliance=verified (enforced in app transaction)']
  moderation_note text [null]
  reviewed_by bigint [null, ref: > users.id]
  reviewed_at timestamp [null]
  grade_level varchar(50) [null]
  age_group varchar(50) [null]
  student_min_age int [null, note: 'Backend courses.student_min_age (marketplace age filter)']
  student_max_age int [null, note: 'Backend courses.student_max_age']
  start_date date [null, note: 'Backend courses.start_date (cohort start)']
  available_seats int [null, note: 'Backend courses.available_seats; NULL = unlimited']
  esa_eligible boolean [not null, default: false, note: 'Backend courses.esa_eligible (ESA checkout filter)']
  summary_title varchar(255) [null, note: 'Backend courses.summary_title']
  summary_subtitle varchar(500) [null, note: 'Backend courses.summary_subtitle']
  cover_image_url varchar(255) [null, note: 'Backend courses.cover_image']
  banner_image_url varchar(255) [null, note: 'GET /teacher/dashboard/courses/{id}/banner']
  timezone varchar(64) [null, note: 'Backend courses.timezone (live schedule display)']
  duration_weeks int [null, note: '1-12 weeks']
  price_fiat_cents bigint [not null, default: 0, note: 'Direct fiat price; 0 = token-only']
  price_currency varchar(3) [not null, default: 'USD']
  price_tokens int [not null, default: 0, note: 'Token price; 0 = fiat-only. NEVER both required for premium (summary 2.2)']
  token_value_usd_cents bigint [null, note: 'Snapshot of 1 token value at pricing time (1 token ~= $5 USD)']
  hero_image_url varchar(255) [null]
  promo_video_url varchar(255) [null]
  converted_from_course_id bigint [null, ref: > courses.id, note: 'Self-paced cloned from a finished live course (POST .../clone-self-paced)']
  published_at timestamp [null]
  deleted_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_courses_slug' , unique]
    (status, delivery_mode, published_at) [name: 'idx_courses_catalogue']
    (creator_id, status, created_at) [name: 'idx_courses_creator_status']
    (premium_program_id, status) [name: 'idx_courses_program']
    (deleted_at) [name: 'idx_courses_deleted']
    (title, short_description, description) [name: 'ft_courses_search']
  }
}

Table course_subjects {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  subject_id bigint [not null, ref: > subjects.id]
  created_at timestamp [not null]

  indexes {
    (course_id, subject_id) [name: 'uq_course_subject' , unique]
    (subject_id, course_id) [name: 'idx_course_subjects_subject']
  }
}

Table course_themes {
  id bigint [pk, increment, not null]
  name varchar(150) [not null, note: 'Frontend: GET /teacher/courses/themes']
  slug varchar(150) [not null]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_course_themes_slug' , unique]
  }
}

Table course_course_themes {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  theme_id bigint [not null, ref: > course_themes.id]
  created_at timestamp [not null]

  indexes {
    (course_id, theme_id) [name: 'uq_course_theme' , unique]
    (theme_id, course_id) [name: 'idx_course_themes_theme']
  }
}

Table course_overviews {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  title varchar(255) [not null, note: 'Backend: title']
  description text [null, note: 'Backend: description']
  sort_order int [not null, default: 0, note: 'Backend column name: order (reserved word, renamed to sort_order)']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id, sort_order) [name: 'idx_course_overviews_course']
  }
}

Table course_summary_sections {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  title varchar(255) [not null]
  section_type enum('text','tags') [not null, default: 'text', note: 'Backend column name: type (renamed; TYPE is reserved)']
  content text [not null, note: 'Backend: content (longText; may hold JSON-array string for tags)']
  sort_order int [not null, default: 0, note: 'Backend column name: order']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id, sort_order) [name: 'idx_course_summary_sections_course']
  }
}

Table course_live_schedules {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  day_of_week enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') [not null]
  start_time time [not null]
  end_time time [not null]
  timezone varchar(64) [not null, default: 'UTC']
  meeting_platform enum('zoom','google_meet','in_person','other') [not null, default: 'zoom', note: 'Zoom is a core requirement (summary 2.5)']
  meeting_url text [null]
  max_seats int [not null, default: 15]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id, day_of_week) [name: 'idx_live_schedules_course']
  }
}

Table course_modules {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  title varchar(255) [not null, note: 'e.g. Week 1: Foundations of Biblical Inquiry']
  description text [null]
  week_number int [not null, default: 1]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id, sort_order) [name: 'uq_modules_course_sort' , unique]
    (course_id, week_number, sort_order) [name: 'idx_modules_course_week']
  }
}

Table course_lessons {
  id bigint [pk, increment, not null]
  module_id bigint [not null, ref: > course_modules.id]
  title varchar(255) [not null]
  description text [null]
  duration_minutes int [not null, default: 45]
  lesson_type enum('live','recorded','self_paced','mixed') [not null, default: 'self_paced']
  is_free_preview boolean [not null, default: false]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (module_id, sort_order) [name: 'uq_lessons_module_sort' , unique]
  }
}

Table lesson_blocks {
  id bigint [pk, increment, not null]
  lesson_id bigint [not null, ref: > course_lessons.id]
  block_type enum('text','video','audio','pdf','image','web_link','family_discussion','quiz','reflection_submission') [not null, note: 'Exactly the 9 frontend block types (summary 2.3). Old 5-type enum dropped audio/pdf/image/web_link/family_disc']
  title varchar(255) [not null]
  content text [null, note: 'Rich text / instructions / Bible reference for text & family_discussion']
  media_url varchar(255) [null, note: 'Video/audio/image/pdf/web_link target (chunked upload -> file_uploads)']
  sort_order int [not null, default: 0]
  metadata text [null, note: 'Non-queryable extras only (e.g. video duration). Quiz structure lives in quiz_* tables.']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (lesson_id, sort_order) [name: 'uq_blocks_lesson_sort' , unique]
    (lesson_id, sort_order) [name: 'idx_blocks_lesson']
  }
}

Table quiz_questions {
  id bigint [pk, increment, not null]
  lesson_block_id bigint [not null, ref: > lesson_blocks.id, note: 'Block with block_type=quiz']
  question_text text [not null]
  marks decimal [not null, default: 1.00]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (lesson_block_id, sort_order) [name: 'uq_quiz_questions_block_sort' , unique]
  }
}

Table quiz_options {
  id bigint [pk, increment, not null]
  question_id bigint [not null, ref: > quiz_questions.id]
  option_text text [not null]
  is_correct boolean [not null, default: false]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (question_id, sort_order) [name: 'idx_quiz_options_question']
  }
}

Table course_announcements {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  author_id bigint [not null, ref: > users.id]
  title varchar(255) [not null]
  content text [not null]
  published_at timestamp [not null]
  created_at timestamp [not null]

  indexes {
    (course_id, published_at) [name: 'idx_announcements_course_date']
  }
}

Table course_reviews {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  parent_id bigint [not null, ref: > users.id, note: 'Reviewing guardian (users.id)']
  rating int [not null, note: '1-5']
  review_text text [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id, parent_id) [name: 'uq_course_reviews_parent' , unique]
    (course_id, created_at) [name: 'idx_course_reviews_course']
  }
}

Table course_enrollments {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  child_id bigint [not null, ref: > children.id]
  parent_id bigint [not null, ref: > users.id, note: 'Sponsoring guardian (users.id)']
  enrollment_source enum('direct_fiat_purchase','token_wallet_spend','premium_subscription','coop_group_assignment','micro_school_instance','esa_voucher') [not null]
  payment_id bigint [null, note: 'payments.id that funded this enrollment']
  status enum('active','completed','dropped','suspended') [not null, default: 'active']
  enrolled_at timestamp [not null]
  completed_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (child_id, course_id) [name: 'uq_enrollments_child_course' , unique]
    (child_id, status, created_at) [name: 'idx_enrollments_child_status']
    (course_id, status) [name: 'idx_enrollments_course_status']
    (parent_id, status) [name: 'idx_enrollments_parent']
  }
}

Table student_lesson_progress {
  id bigint [pk, increment, not null]
  enrollment_id bigint [not null, ref: > course_enrollments.id]
  child_id bigint [not null, ref: > children.id]
  lesson_id bigint [not null, ref: > course_lessons.id]
  status enum('not_started','in_progress','completed') [not null, default: 'not_started']
  score_pct decimal [null, note: 'Quiz/assessment score for this lesson, NULL until graded']
  completed_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (enrollment_id, lesson_id) [name: 'uq_lesson_progress' , unique]
    (child_id, status) [name: 'idx_lesson_progress_child']
  }
}

Table student_block_responses {
  id bigint [pk, increment, not null]
  enrollment_id bigint [not null, ref: > course_enrollments.id]
  child_id bigint [not null, ref: > children.id]
  lesson_block_id bigint [not null, ref: > lesson_blocks.id]
  response_type enum('text_answer','file_upload','quiz_submission') [not null]
  response_text text [null, note: 'Reflection / written answer']
  attachment_url varchar(255) [null, note: 'Homework file (see file_uploads for chunk metadata)']
  quiz_score_pct decimal [null, note: 'Auto-scored quiz result']
  status enum('submitted','under_review','approved','revision_requested') [not null, default: 'submitted']
  teacher_feedback text [null, note: 'Split-pen grading console feedback']
  graded_by bigint [null, ref: > users.id, note: 'Grading educator (users.id)']
  graded_at timestamp [null]
  submitted_at timestamp [not null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (enrollment_id, lesson_block_id) [name: 'uq_block_responses' , unique]
    (status, submitted_at) [name: 'idx_block_responses_grading_queue']
    (child_id, submitted_at) [name: 'idx_block_responses_child']
  }
}

Table student_session_notes {
  id bigint [pk, increment, not null]
  child_id bigint [not null, ref: > children.id]
  teacher_id bigint [not null, ref: > users.id]
  course_id bigint [null, ref: > courses.id]
  session_date date [not null]
  reflection_notes text [null, note: 'Student journal (/student/notes)']
  teacher_remarks text [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (child_id, session_date) [name: 'idx_session_notes_child_date']
    (teacher_id, session_date) [name: 'idx_session_notes_teacher_date']
  }
}

Table student_todos {
  id bigint [pk, increment, not null]
  child_id bigint [not null, ref: > children.id]
  course_id bigint [null, ref: > courses.id]
  title varchar(255) [not null]
  due_date date [null]
  is_completed boolean [not null, default: false]
  completed_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (child_id, is_completed, due_date) [name: 'idx_student_todos_open']
  }
}

Table class_sessions {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  class_instance_id bigint [null, note: 'micro_school_class_instances.id when run inside a micro-school']
  teacher_id bigint [not null, ref: > users.id]
  title varchar(255) [null]
  starts_at timestamp [not null]
  ends_at timestamp [not null]
  timezone varchar(64) [not null, default: 'UTC']
  meeting_platform enum('zoom','google_meet','in_person','other') [not null, default: 'zoom']
  meeting_url text [null]
  recording_url varchar(255) [null, note: 'Parent Media Hub recording after the session']
  status enum('scheduled','in_session','completed','cancelled') [not null, default: 'scheduled']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id, starts_at) [name: 'idx_class_sessions_course_time']
    (teacher_id, starts_at) [name: 'idx_class_sessions_teacher_time']
    (status, starts_at) [name: 'idx_class_sessions_status_time']
  }
}

Table attendance_records {
  id bigint [pk, increment, not null]
  class_session_id bigint [not null, ref: > class_sessions.id]
  child_id bigint [not null, ref: > children.id]
  status enum('present','absent','excused','late') [not null, default: 'absent']
  marked_by bigint [null, ref: > users.id]
  marked_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (class_session_id, child_id) [name: 'uq_attendance_session_child' , unique]
    (child_id, class_session_id) [name: 'idx_attendance_child']
  }
}

Table badges {
  id bigint [pk, increment, not null]
  name varchar(150) [not null]
  slug varchar(100) [not null]
  image_url varchar(255) [null]
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_badges_slug' , unique]
  }
}

Table child_badges {
  id bigint [pk, increment, not null]
  child_id bigint [not null, ref: > children.id]
  badge_id bigint [not null, ref: > badges.id]
  earned_at timestamp [not null]
  created_at timestamp [not null]

  indexes {
    (child_id, badge_id) [name: 'uq_child_badges' , unique]
    (child_id, earned_at) [name: 'idx_child_badges_child']
  }
}

Table tutoring_availability {
  id bigint [pk, increment, not null]
  teacher_id bigint [not null, ref: > users.id]
  day_of_week enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') [not null]
  start_time time [not null]
  end_time time [not null]
  timezone varchar(64) [not null, default: 'UTC']
  is_active boolean [not null, default: true]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (teacher_id, is_active, day_of_week) [name: 'idx_tutoring_availability_teacher']
  }
}

Table tutoring_bookings {
  id bigint [pk, increment, not null]
  teacher_id bigint [not null, ref: > users.id]
  parent_id bigint [not null, ref: > users.id]
  child_id bigint [not null, ref: > children.id]
  course_id bigint [null, ref: > courses.id, note: 'Marketplace 1-on-1 course, if booked from one']
  session_date date [not null]
  start_time time [not null]
  end_time time [not null]
  timezone varchar(64) [not null, default: 'UTC']
  status enum('scheduled','completed','cancelled','rescheduled','no_show') [not null, default: 'scheduled']
  student_mood enum('overwhelmed','mostly_okay','confident') [null, note: 'Pre-session mood tracker (tutoring hub)']
  meeting_url text [null]
  session_plan_notes text [null, note: 'Connect / identify / solve / next-steps plan']
  lesson_notes text [null, note: 'Post-session summary + homework log']
  no_show_fee_cents bigint [null, note: 'AUD $15 no-show fee (contracted rate card); NULL if not a no-show']
  payment_id bigint [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (teacher_id, session_date, start_time) [name: 'uq_tutoring_bookings_slot' , unique]
    (teacher_id, session_date, status) [name: 'idx_tutoring_bookings_teacher_date']
    (child_id, status, session_date) [name: 'idx_tutoring_bookings_child']
    (parent_id, status) [name: 'idx_tutoring_bookings_parent']
  }
}

Table subscription_plans {
  id bigint [pk, increment, not null]
  premium_program_id bigint [null, ref: > premium_programs.id, note: 'Set for premium plans: frontend POST /teacher/premium-programs/{slug}/plans/store. Backend table: premium_prog']
  plan_type enum('premium','coop','micro_school') [not null, note: 'One plans table for all three B2B/family plans (old DBML had none for co-op/micro)']
  name varchar(150) [not null, note: 'Explorer / Adventure / Journey, Co-op Starter..., Micro Essentials...']
  slug varchar(150) [not null]
  billing_interval enum('weekly','monthly','annual') [not null, default: 'monthly']
  seat_limit int [null, note: 'NULL = unlimited (micro Pro). Co-op: 20/60 per summary 4.1 — see open question in docs/07']
  mentoring_sessions_per_week int [not null, default: 0, note: 'Adventure=1, Journey=2, Explorer=0']
  is_active boolean [not null, default: true]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug, billing_interval) [name: 'uq_subscription_plans_slug_interval' , unique]
    (plan_type, is_active, sort_order) [name: 'idx_subscription_plans_type']
    (premium_program_id, is_active) [name: 'idx_subscription_plans_program']
  }
}

Table subscription_plan_prices {
  id bigint [pk, increment, not null]
  plan_id bigint [not null, ref: > subscription_plans.id]
  currency varchar(3) [not null, note: 'AUD / USD — one row per currency (admin sets both)']
  price_cents bigint [not null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (plan_id, currency) [name: 'uq_plan_prices_plan_currency' , unique]
  }
}

Table parent_subscriptions {
  id bigint [pk, increment, not null]
  parent_id bigint [not null, ref: > users.id]
  child_id bigint [null, ref: > children.id, note: 'NULL = family-level subscription']
  plan_id bigint [not null, ref: > subscription_plans.id]
  stripe_subscription_id varchar(128) [null]
  stripe_customer_id varchar(128) [null]
  status enum('trialing','active','past_due','paused','canceled','incomplete') [not null, default: 'active']
  current_period_start timestamp [null]
  current_period_end timestamp [null]
  cancel_at_period_end boolean [not null, default: false]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (parent_id, status) [name: 'idx_parent_subscriptions_parent']
    (stripe_subscription_id) [name: 'idx_parent_subscriptions_stripe']
    (status, current_period_end) [name: 'idx_parent_subscriptions_period_end']
  }
}

Table organization_subscriptions {
  id bigint [pk, increment, not null]
  plan_id bigint [not null, ref: > subscription_plans.id, note: 'plan_type = coop / micro_school']
  co_op_id bigint [null]
  micro_school_id bigint [null]
  stripe_subscription_id varchar(128) [null]
  stripe_customer_id varchar(128) [null]
  status enum('trialing','active','past_due','canceled','incomplete') [not null, default: 'active']
  current_period_start timestamp [null]
  current_period_end timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (co_op_id, status) [name: 'idx_org_subscriptions_coop']
    (micro_school_id, status) [name: 'idx_org_subscriptions_micro']
    (stripe_subscription_id) [name: 'idx_org_subscriptions_stripe']
  }
}

Table payments {
  id bigint [pk, increment, not null]
  payer_id bigint [not null, ref: > users.id, note: 'users.id who paid (parent / org admin)']
  payment_purpose enum('premium_subscription','token_package','marketplace_course','tutoring_booking','resource_purchase','coop_subscription','micro_school_subscription','esa_invoice') [not null]
  reference_id bigint [null, note: 'Id of the thing bought (course_id, plan_id, booking_id, ...). reference_type says which.']
  reference_type varchar(50) [null]
  amount_cents bigint [not null]
  currency varchar(3) [not null, default: 'USD']
  token_amount int [null, note: 'Tokens credited, when purpose=token_package']
  payment_method enum('card','stripe','esa_voucher','token_wallet') [not null, default: 'card']
  stripe_payment_intent_id varchar(128) [null]
  stripe_charge_id varchar(128) [null]
  idempotency_key varchar(128) [not null, note: 'Client-generated UUID per checkout attempt']
  status enum('requires_action','processing','succeeded','failed','refunded','partially_refunded') [not null, default: 'requires_action']
  paid_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (idempotency_key) [name: 'uq_payments_idempotency' , unique]
    (payer_id, created_at) [name: 'idx_payments_payer']
    (reference_type, reference_id) [name: 'idx_payments_reference']
    (status, created_at) [name: 'idx_payments_status']
    (stripe_payment_intent_id) [name: 'idx_payments_stripe_intent']
  }
}

Table invoices {
  id bigint [pk, increment, not null]
  payment_id bigint [null, ref: > payments.id]
  invoice_number varchar(100) [not null, note: 'Audit-compliant sequential number (ESA + tax statements)']
  buyer_id bigint [not null, ref: > users.id]
  amount_cents bigint [not null]
  currency varchar(3) [not null, default: 'USD']
  invoice_type enum('sale','esa_claim','payout_statement','refund') [not null, default: 'sale']
  pdf_url varchar(255) [null, note: 'Generated PDF (ESA audit invoice / monthly tax statement)']
  issued_at timestamp [not null]
  created_at timestamp [not null]

  indexes {
    (invoice_number) [name: 'uq_invoices_number' , unique]
    (buyer_id, issued_at) [name: 'idx_invoices_buyer']
  }
}

Table wallets {
  id bigint [pk, increment, not null]
  user_id bigint [not null, ref: > users.id, note: 'Guardian owner (users.id)']
  balance_tokens int [not null, default: 0, note: 'Available tokens (cache of ledger)']
  lifetime_purchased_tokens int [not null, default: 0]
  lifetime_spent_tokens int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (user_id) [name: 'uq_wallets_user' , unique]
  }
}

Table token_packages {
  id bigint [pk, increment, not null]
  name varchar(150) [not null, note: 'Starter / Growth / Pro / Family Flex (120 tokens/month)']
  token_amount int [not null, note: 'Base tokens credited per purchase']
  bonus_tokens int [not null, default: 0]
  price_cents bigint [not null]
  currency varchar(3) [not null, default: 'USD']
  is_subscription boolean [not null, default: false, note: 'Family Flex monthly grant vs one-off top-up']
  is_active boolean [not null, default: true]
  sort_order int [not null, default: 0]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (is_active, sort_order) [name: 'idx_token_packages_active']
  }
}

Table token_lots {
  id bigint [pk, increment, not null]
  wallet_id bigint [not null, ref: > wallets.id]
  payment_id bigint [null, ref: > payments.id]
  tokens_total int [not null]
  tokens_remaining int [not null]
  status enum('active','expired','reactivated','exhausted') [not null, default: 'active']
  expires_at timestamp [not null, note: 'Credit time + 12 months']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (wallet_id, status, expires_at) [name: 'idx_token_lots_spend']
    (status, expires_at) [name: 'idx_token_lots_expiry_scan']
  }
}

Table token_transactions {
  id bigint [pk, increment, not null]
  wallet_id bigint [not null, ref: > wallets.id]
  lot_id bigint [null, ref: > token_lots.id, note: 'Lot this entry moves (NULL for wallet-level adjustments)']
  transaction_type enum('purchase','monthly_grant','marketplace_spend','refund','expiry','reactivation') [not null]
  amount_tokens int [not null, note: 'Positive = credit, negative = debit']
  balance_after int [not null, note: 'Wallet balance right after this entry (audit chain)']
  reference_type varchar(50) [null, note: 'course / resource / tutoring_booking / payment']
  reference_id bigint [null]
  idempotency_key varchar(128) [null, note: 'Prevents double-spend on retried checkout']
  description varchar(255) [not null]
  created_at timestamp [not null]

  indexes {
    (idempotency_key) [name: 'uq_token_transactions_idempotency' , unique]
    (wallet_id, created_at) [name: 'idx_token_transactions_wallet']
  }
}

Table educator_payout_ledger {
  id bigint [pk, increment, not null]
  educator_id bigint [not null, ref: > users.id, note: 'users.id of the educator']
  payment_id bigint [null, ref: > payments.id]
  sale_reference_type varchar(50) [not null, note: 'course / resource / tutoring_booking']
  sale_reference_id bigint [not null]
  gross_cents bigint [not null]
  educator_share_cents bigint [not null, note: '70% of net']
  platform_share_cents bigint [not null, note: '30% commission']
  currency varchar(3) [not null, default: 'USD']
  status enum('pending','available','paid','reversed') [not null, default: 'pending', note: 'pending = 7-day hold, then available']
  available_at timestamp [null]
  stripe_transfer_id varchar(128) [null]
  paid_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (educator_id, status, created_at) [name: 'idx_payout_ledger_educator']
    (status, available_at) [name: 'idx_payout_ledger_available']
  }
}

Table contracted_timesheets {
  id bigint [pk, increment, not null]
  teacher_id bigint [not null, ref: > users.id, note: 'Contracted educator (users.id)']
  week_start date [not null, note: 'Monday of the timesheet week']
  session_id bigint [null, ref: > class_sessions.id, note: 'class_sessions.id this line covers (NULL = manual line)']
  minutes_taught int [not null, default: 0]
  rate_cents_per_hour bigint [not null, note: 'Rate snapshot at submission (AUD 50 / 62.50 / 75 by class size)']
  currency varchar(3) [not null, default: 'AUD']
  amount_cents bigint [not null, note: 'Computed: minutes/60 * rate']
  status enum('draft','submitted','approved','rejected','paid') [not null, default: 'draft']
  reviewed_by bigint [null, ref: > users.id]
  reviewed_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (session_id) [name: 'uq_timesheets_session' , unique]
    (teacher_id, week_start, status) [name: 'idx_timesheets_teacher_week']
  }
}

Table resources {
  id bigint [pk, increment, not null]
  uploader_id bigint [not null, ref: > users.id, note: 'Backend column name: teacher_id (renamed to uploader_id for consistency)']
  course_id bigint [null, ref: > courses.id, note: 'Set when created via POST /teacher/courses/{id}/resources/store (course-attached resource). GET /teacher/cours']
  subject_id bigint [null, ref: > subjects.id]
  title varchar(255) [not null]
  subtitle varchar(255) [null, note: 'Backend resources.subtitle']
  description text [null]
  overview text [null, note: 'Backend resources.overview']
  usage_and_permissions text [null, note: 'Backend resources.usage_and_permissions']
  student_min_age int [null, note: 'Backend resources.student_min_age']
  student_max_age int [null, note: 'Backend resources.student_max_age']
  esa_eligible boolean [not null, default: false, note: 'Backend resources.esa_eligible']
  cover_image_url varchar(255) [null, note: 'Backend resources.cover_image']
  sales_count int [not null, default: 0, note: 'Backend resources.sales_count. WARNING: denormalised counter — keep in sync in the purchase transaction or der']
  resource_type enum('worksheet_packet','printable_book','unit_study_guide','audio_lesson','lesson_plan') [not null]
  grade_level varchar(50) [null]
  price_fiat_cents bigint [not null, default: 0]
  price_tokens int [not null, default: 0]
  currency varchar(3) [not null, default: 'USD']
  status enum('draft','pending_review','published','archived') [not null, default: 'draft']
  deleted_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (status, resource_type, created_at) [name: 'idx_resources_catalogue']
    (uploader_id, status) [name: 'idx_resources_uploader']
    (course_id, status) [name: 'idx_resources_course']
    (subject_id, status) [name: 'idx_resources_subject']
    (title, description) [name: 'ft_resources_search']
  }
}

Table resource_editions {
  id bigint [pk, increment, not null]
  resource_id bigint [not null, ref: > resources.id]
  edition enum('student','family','educator') [not null]
  price_fiat_cents bigint [not null]
  currency varchar(3) [not null]
  includes_text text [null, note: 'What this edition includes (workbook, guide, decks, classroom licence...)']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (resource_id, edition, currency) [name: 'uq_resource_edition' , unique]
  }
}

Table course_versions {
  id bigint [pk, increment, not null]
  course_id bigint [not null, ref: > courses.id]
  version_number int [not null]
  status enum('draft','published','archived') [not null, default: 'draft']
  published_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id, version_number) [name: 'uq_course_version' , unique]
  }
}

Table donors {
  id bigint [pk, increment, not null]
  user_id bigint [null, ref: > users.id, note: 'NULL for guest donor']
  full_name varchar(255) [not null]
  email varchar(255) [not null]
  country enum('AU','US','GLOBAL') [not null, default: 'AU']
  consent_given_at timestamp [null, note: 'Donor privacy consent timestamp']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (email) [name: 'idx_donors_email']
  }
}

Table donations {
  id bigint [pk, increment, not null]
  donor_id bigint [not null, ref: > donors.id]
  payment_id bigint [null]
  amount_cents bigint [not null]
  currency varchar(3) [not null, default: 'AUD']
  acknowledgement_sent_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (donor_id, created_at) [name: 'idx_donations_donor']
  }
}

Table resource_files {
  id bigint [pk, increment, not null]
  resource_id bigint [not null, ref: > resources.id]
  file_name varchar(255) [not null]
  file_path varchar(255) [not null, note: 'Object-storage path (never a local disk path in code)']
  file_size_bytes bigint [not null]
  mime_type varchar(100) [not null]
  preview_pages int [null, note: 'Watermarked preview page count (first 1-2 pages)']
  created_at timestamp [not null]

  indexes {
    (resource_id) [name: 'idx_resource_files_resource']
  }
}

Table resource_accesses {
  id bigint [pk, increment, not null]
  resource_id bigint [not null, ref: > resources.id]
  user_id bigint [not null, ref: > users.id, note: 'Purchasing guardian']
  child_id bigint [null, ref: > children.id, note: 'Child the resource was bought for']
  access_source enum('direct_fiat','token_spend','premium_membership','esa_voucher') [not null]
  payment_id bigint [null, ref: > payments.id]
  watermarked_file_path varchar(255) [null, note: 'Per-buyer watermarked PDF path']
  downloaded_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (resource_id, user_id, child_id) [name: 'uq_resource_accesses' , unique]
    (user_id, created_at) [name: 'idx_resource_accesses_user']
  }
}

Table iproject_requests {
  id bigint [pk, increment, not null]
  parent_id bigint [not null, ref: > users.id]
  child_id bigint [not null, ref: > children.id]
  project_title varchar(255) [not null]
  driving_question text [null, note: 'Student-led inquiry driving question']
  interest_area varchar(150) [null]
  target_outcomes text [null]
  delivery_pathway enum('diy_content','group_pathway_cohort','mentored_one_to_one') [not null, default: 'mentored_one_to_one']
  assigned_mentor_id bigint [null, ref: > users.id]
  status enum('draft','submitted','mentor_assigned','in_progress','completed','cancelled') [not null, default: 'submitted']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (child_id, status) [name: 'idx_iproject_child_status']
    (assigned_mentor_id, status) [name: 'idx_iproject_mentor']
  }
}

Table iproject_milestones {
  id bigint [pk, increment, not null]
  iproject_request_id bigint [not null, ref: > iproject_requests.id]
  title varchar(255) [not null]
  description text [null]
  sort_order int [not null, default: 0]
  is_completed boolean [not null, default: false]
  completed_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (iproject_request_id, sort_order) [name: 'uq_iproject_milestones_sort' , unique]
  }
}

Table ai_outcome_generations {
  id bigint [pk, increment, not null]
  user_id bigint [not null, ref: > users.id, note: 'Who generated it (parent or student login)']
  child_id bigint [not null, ref: > children.id]
  subject_area varchar(100) [null]
  grade_level varchar(50) [null]
  child_passion text [null]
  standards_alignment varchar(150) [null]
  generated_outcomes text [not null, note: 'Structured milestones/rubric returned by the AI provider']
  input_payload text [null, note: 'Exact inputs, so history/details pages are reproducible']
  pdf_export_url varchar(255) [null]
  created_at timestamp [not null]

  indexes {
    (child_id, created_at) [name: 'idx_ai_outcomes_child']
    (user_id, created_at) [name: 'idx_ai_outcomes_user']
  }
}

Table esa_program_rule_skus {
  id bigint [pk, increment, not null]
  state_code varchar(10) [not null, note: 'US state code e.g. AZ, FL, UT, IA']
  sku_type enum('course','resource') [not null]
  course_id bigint [null, ref: > courses.id]
  resource_id bigint [null, ref: > resources.id]
  esa_eligible boolean [not null, default: true]
  attendance_required boolean [not null, default: false]
  marketplace_allowed boolean [not null, default: true, note: 'FALSE = ESA does not cover marketplace downloads in this state']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (state_code, sku_type, course_id, resource_id) [name: 'uq_esa_rule_state_sku' , unique]
    (state_code, esa_eligible) [name: 'idx_esa_rule_state']
  }
}

Table esa_enrollments {
  id bigint [pk, increment, not null]
  parent_id bigint [not null, ref: > users.id]
  child_id bigint [not null, ref: > children.id]
  course_id bigint [not null, ref: > courses.id]
  payment_id bigint [null]
  invoice_id bigint [null, ref: > invoices.id, note: 'Generated audit invoice (invoices.id)']
  state_program enum('arizona_esa','florida_step_up','utah_fits_all','iowa_students_first','other_us_esa') [not null]
  student_state_id varchar(100) [not null, note: 'State voucher / scholarship ID. Store encrypted at app layer (sensitive PII).']
  funding_amount_cents bigint [not null]
  currency varchar(3) [not null, default: 'USD']
  proof_document_url varchar(255) [null]
  status enum('pending_approval','approved','reimbursed','rejected') [not null, default: 'pending_approval']
  rejection_reason text [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (parent_id, status) [name: 'idx_esa_parent_status']
    (child_id, status) [name: 'idx_esa_child']
  }
}

Table co_ops {
  id bigint [pk, increment, not null]
  coordinator_id bigint [not null, ref: > users.id, note: 'Lead parent (users.id)']
  name varchar(255) [not null]
  slug varchar(255) [null]
  description text [null]
  meeting_address text [null, note: 'Never expose member children addresses (summary 4.2)']
  city varchar(100) [null]
  state varchar(100) [null]
  postal_code varchar(20) [null]
  country enum('AU','US') [not null]
  visibility enum('public','unlisted','invite_only') [not null, default: 'unlisted']
  invite_token varchar(128) [null, note: 'Secret link token for unlisted co-ops']
  max_students int [null, note: 'From plan seat_limit; NULL = unlimited plan']
  min_age int [null]
  max_age int [null]
  logo_url varchar(255) [null]
  status enum('pending_review','active','suspended') [not null, default: 'pending_review']
  deleted_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (slug) [name: 'uq_co_ops_slug' , unique]
    (country, visibility, status) [name: 'idx_co_ops_directory']
    (coordinator_id) [name: 'idx_co_ops_coordinator']
  }
}

Table co_op_members {
  id bigint [pk, increment, not null]
  co_op_id bigint [not null, ref: > co_ops.id]
  user_id bigint [not null, ref: > users.id, note: 'Parent or facilitator (users.id)']
  member_role enum('main_coordinator','assistant_coordinator','family_parent','facilitator') [not null, default: 'family_parent']
  status enum('pending','approved','declined','removed') [not null, default: 'pending']
  joined_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (co_op_id, user_id) [name: 'uq_co_op_members' , unique]
    (co_op_id, status) [name: 'idx_co_op_members_status']
  }
}

Table co_op_children {
  id bigint [pk, increment, not null]
  co_op_id bigint [not null, ref: > co_ops.id]
  child_id bigint [not null, ref: > children.id]
  parent_id bigint [not null, ref: > users.id, note: 'Consent must come from this guardian (summary 4.3)']
  status enum('pending','approved','removed') [not null, default: 'pending']
  approved_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (co_op_id, child_id) [name: 'uq_co_op_children' , unique]
    (co_op_id, status) [name: 'idx_co_op_children_status']
  }
}

Table co_op_program_bundles {
  id bigint [pk, increment, not null]
  co_op_id bigint [not null, ref: > co_ops.id]
  course_id bigint [not null, ref: > courses.id]
  payment_id bigint [null, ref: > payments.id]
  licensed_seats int [not null]
  expires_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (co_op_id, course_id) [name: 'uq_co_op_bundles' , unique]
  }
}

Table co_op_announcements {
  id bigint [pk, increment, not null]
  co_op_id bigint [not null, ref: > co_ops.id]
  author_id bigint [not null, ref: > users.id]
  title varchar(255) [not null]
  content text [not null]
  published_at timestamp [not null]
  created_at timestamp [not null]

  indexes {
    (co_op_id, published_at) [name: 'idx_co_op_announcements']
  }
}

Table micro_schools {
  id bigint [pk, increment, not null]
  admin_id bigint [not null, ref: > users.id, note: 'School director (users.id)']
  name varchar(255) [not null]
  slug varchar(255) [not null]
  subdomain varchar(100) [not null, note: '[subdomain].ktaplus.io — unique']
  legal_entity_name varchar(255) [not null]
  address text [not null]
  city varchar(100) [not null]
  state varchar(50) [not null, note: 'US state']
  postal_code varchar(20) [not null]
  country varchar(2) [not null, default: 'US', note: 'Micro-schools are US-only by decision (summary 2.3)']
  student_capacity int [null, note: 'From plan seat_limit; NULL = unlimited']
  logo_url varchar(255) [null]
  status enum('pending_approval','active','suspended') [not null, default: 'pending_approval']
  deleted_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (subdomain) [name: 'uq_micro_schools_subdomain' , unique]
    (slug) [name: 'uq_micro_schools_slug' , unique]
    (admin_id) [name: 'idx_micro_schools_admin']
    (state, status) [name: 'idx_micro_schools_state_status']
  }
}

Table micro_school_program_enablements {
  id bigint [pk, increment, not null]
  micro_school_id bigint [not null, ref: > micro_schools.id]
  course_id bigint [not null, ref: > courses.id]
  is_enabled boolean [not null, default: true]
  licensed_seats int [null]
  payment_id bigint [null, ref: > payments.id, note: 'NULL for included premium curriculum']
  enabled_at timestamp [not null]
  created_at timestamp [not null]

  indexes {
    (micro_school_id, course_id) [name: 'uq_micro_enablements' , unique]
    (micro_school_id, is_enabled) [name: 'idx_micro_enablements_enabled']
  }
}

Table micro_school_teachers {
  id bigint [pk, increment, not null]
  micro_school_id bigint [not null, ref: > micro_schools.id]
  teacher_id bigint [not null, ref: > users.id, note: 'Educator (users.id); must be compliance-verified before class assignment']
  status enum('pending','active','inactive') [not null, default: 'pending']
  assigned_at timestamp [null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (micro_school_id, teacher_id) [name: 'uq_micro_teachers' , unique]
    (micro_school_id, status) [name: 'idx_micro_teachers_status']
  }
}

Table micro_school_families {
  id bigint [pk, increment, not null]
  micro_school_id bigint [not null, ref: > micro_schools.id]
  parent_id bigint [not null, ref: > users.id]
  status enum('pending','active','inactive') [not null, default: 'pending']
  joined_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (micro_school_id, parent_id) [name: 'uq_micro_families' , unique]
    (micro_school_id, status) [name: 'idx_micro_families_status']
  }
}

Table micro_school_students {
  id bigint [pk, increment, not null]
  micro_school_id bigint [not null, ref: > micro_schools.id]
  child_id bigint [not null, ref: > children.id]
  parent_id bigint [not null, ref: > users.id]
  status enum('pending','enrolled','graduated','withdrawn') [not null, default: 'pending']
  enrolled_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (micro_school_id, child_id) [name: 'uq_micro_students' , unique]
    (micro_school_id, status) [name: 'idx_micro_students_status']
  }
}

Table micro_school_class_instances {
  id bigint [pk, increment, not null]
  micro_school_id bigint [not null, ref: > micro_schools.id]
  course_id bigint [not null, ref: > courses.id, note: 'READ-ONLY central curriculum reference']
  teacher_id bigint [not null, ref: > users.id]
  instance_name varchar(255) [not null, note: 'e.g. Grade 4 Inquiry Morning Cohort']
  classroom_location varchar(150) [null, note: 'Room or virtual meet link']
  schedule_days varchar(100) [null, note: 'e.g. Mon, Wed, Fri (display); concrete dates in class_sessions']
  start_time time [null]
  end_time time [null]
  timezone varchar(64) [not null, default: 'UTC']
  status enum('upcoming','in_session','completed','cancelled') [not null, default: 'upcoming']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (micro_school_id, status, created_at) [name: 'idx_micro_class_instances']
    (teacher_id, status) [name: 'idx_micro_class_instances_teacher']
  }
}

Table micro_school_class_students {
  id bigint [pk, increment, not null]
  class_instance_id bigint [not null, ref: > micro_school_class_instances.id]
  child_id bigint [not null, ref: > children.id]
  status enum('enrolled','dropped','completed') [not null, default: 'enrolled']
  created_at timestamp [not null]

  indexes {
    (class_instance_id, child_id) [name: 'uq_micro_class_students' , unique]
    (child_id, status) [name: 'idx_micro_class_students_child']
  }
}

Table micro_school_announcements {
  id bigint [pk, increment, not null]
  micro_school_id bigint [not null, ref: > micro_schools.id]
  author_id bigint [not null, ref: > users.id]
  title varchar(255) [not null]
  content text [not null]
  target_audience enum('all','parents_only','teachers_only') [not null, default: 'all']
  published_at timestamp [not null]
  created_at timestamp [not null]

  indexes {
    (micro_school_id, target_audience, published_at) [name: 'idx_micro_announcements']
  }
}

Table conversations {
  id bigint [pk, increment, not null]
  conversation_type enum('direct','course_group','coop_group','micro_school_group','support') [not null]
  course_id bigint [null, ref: > courses.id]
  co_op_id bigint [null, ref: > co_ops.id]
  micro_school_id bigint [null, ref: > micro_schools.id]
  subject varchar(255) [null]
  last_message_at timestamp [null, note: 'Denormalised ONLY for inbox ordering; updated in same tx as each message']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (course_id) [name: 'idx_conversations_course']
    (co_op_id) [name: 'idx_conversations_coop']
    (micro_school_id) [name: 'idx_conversations_micro']
    (last_message_at) [name: 'idx_conversations_last_message']
  }
}

Table conversation_participants {
  id bigint [pk, increment, not null]
  conversation_id bigint [not null, ref: > conversations.id]
  user_id bigint [not null, ref: > users.id, note: 'users.id (parent/teacher/admin). Student chat goes via children? No — student Hive is community_posts, not DMs']
  role enum('owner','member','moderator') [not null, default: 'member']
  last_read_at timestamp [null, note: 'Unread = messages newer than this']
  left_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (conversation_id, user_id) [name: 'uq_conversation_participants' , unique]
    (user_id, left_at, conversation_id) [name: 'idx_conversation_participants_inbox']
  }
}

Table messages {
  id bigint [pk, increment, not null]
  conversation_id bigint [not null, ref: > conversations.id]
  sender_id bigint [not null, ref: > users.id]
  body text [not null]
  attachment_url varchar(255) [null]
  edited_at timestamp [null]
  deleted_at timestamp [null, note: 'Soft delete = sender retracted; row kept for audit']
  created_at timestamp [not null]

  indexes {
    (conversation_id, id) [name: 'idx_messages_feed']
    (sender_id, created_at) [name: 'idx_messages_sender']
  }
}

Table community_posts {
  id bigint [pk, increment, not null]
  author_id bigint [null, ref: > users.id, note: 'Parent author (users.id)']
  child_id bigint [null, ref: > children.id, note: 'Student author (children.id) — Hive']
  scope enum('parent_community','student_hive') [not null]
  category varchar(100) [not null, default: 'General]
  title varchar(255) [null]
  content text [not null]
  attachment_url varchar(255) [null]
  is_pinned boolean [not null, default: false]
  moderation_status enum('pending','approved','rejected') [not null, default: 'pending', note: 'Hive posts must be approved before showing to peers']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (scope, moderation_status, is_pinned, created_at) [name: 'idx_community_posts_feed']
    (scope, category, created_at) [name: 'idx_community_posts_category']
    (author_id, created_at) [name: 'idx_community_posts_author']
    (child_id, created_at) [name: 'idx_community_posts_child']
    (title, content) [name: 'ft_community_posts_search']
  }
}

Table community_comments {
  id bigint [pk, increment, not null]
  post_id bigint [not null, ref: > community_posts.id]
  author_id bigint [null, ref: > users.id]
  child_id bigint [null, ref: > children.id]
  content text [not null]
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (post_id, created_at) [name: 'idx_community_comments_post']
  }
}

Table community_post_likes {
  id bigint [pk, increment, not null]
  post_id bigint [not null, ref: > community_posts.id]
  author_id bigint [null, ref: > users.id]
  child_id bigint [null, ref: > children.id]
  created_at timestamp [not null]

  indexes {
    (post_id, author_id) [name: 'uq_post_likes_user' , unique]
    (post_id, child_id) [name: 'uq_post_likes_child' , unique]
  }
}

Table parent_connections {
  id bigint [pk, increment, not null]
  requester_id bigint [not null, ref: > users.id, note: 'users.id (parent)']
  target_id bigint [not null, ref: > users.id]
  status enum('pending','accepted','declined','blocked') [not null, default: 'pending']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (requester_id, target_id) [name: 'uq_parent_connections' , unique]
    (target_id, status) [name: 'idx_parent_connections_incoming']
    (requester_id, status) [name: 'idx_parent_connections_outgoing']
  }
}

Table student_connections {
  id bigint [pk, increment, not null]
  requester_id bigint [not null, ref: > children.id, note: 'children.id']
  target_id bigint [not null, ref: > children.id]
  status enum('pending','accepted','declined','blocked') [not null, default: 'pending']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (requester_id, target_id) [name: 'uq_student_connections' , unique]
    (target_id, status) [name: 'idx_student_connections_incoming']
    (requester_id, status) [name: 'idx_student_connections_outgoing']
  }
}

Table support_tickets {
  id bigint [pk, increment, not null]
  user_id bigint [not null, ref: > users.id]
  subject varchar(255) [not null]
  category enum('billing','technical','curriculum','safeguarding','general') [not null, default: 'general']
  priority enum('low','medium','high','urgent') [not null, default: 'medium']
  status enum('open','pending_user','resolved','closed') [not null, default: 'open']
  conversation_id bigint [null, ref: > conversations.id, note: 'Linked support conversation (conversations.id)']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (user_id, status, created_at) [name: 'idx_support_tickets_user']
    (status, priority, created_at) [name: 'idx_support_tickets_queue']
  }
}

Table notifications {
  id bigint [pk, increment, not null]
  user_id bigint [not null, ref: > users.id, note: 'Recipient (users.id)']
  type varchar(64) [not null, note: 'e.g. enrollment_confirmed, submission_graded, payout_available']
  title varchar(255) [null]
  body text [null]
  data text [null, note: 'Ids the frontend needs to deep-link (course_id, enrollment_id...)']
  read_at timestamp [null]
  created_at timestamp [not null]

  indexes {
    (user_id, read_at, created_at) [name: 'idx_notifications_inbox']
  }
}

Table file_uploads {
  id bigint [pk, increment, not null]
  uploader_id bigint [not null, ref: > users.id]
  purpose enum('lesson_video','lesson_audio','resource_pdf','homework_file','profile_image','compliance_document','demo_video','other') [not null, default: 'other']
  original_name varchar(255) [not null]
  file_path varchar(255) [null, note: 'Final assembled object-storage path']
  mime_type varchar(100) [null]
  file_size_bytes bigint [null]
  chunk_count int [null]
  chunks_received int [not null, default: 0]
  status enum('uploading','assembling','completed','failed') [not null, default: 'uploading']
  created_at timestamp [not null]
  updated_at timestamp [not null]

  indexes {
    (uploader_id, status, created_at) [name: 'idx_file_uploads_uploader']
  }
}

Table admin_audit_logs {
  id bigint [pk, increment, not null]
  admin_id bigint [not null, ref: > users.id, note: 'Acting super-admin (users.id)']
  action varchar(100) [not null, note: 'e.g. educator.verified, course.rejected, payout.approved']
  entity_type varchar(64) [null, note: 'e.g. educator_profiles, courses']
  entity_id bigint [null]
  old_values text [null]
  new_values text [null]
  ip_address varchar(45) [null]
  created_at timestamp [not null]

  indexes {
    (admin_id, created_at) [name: 'idx_admin_audit_admin']
    (entity_type, entity_id, created_at) [name: 'idx_admin_audit_entity']
  }
}
