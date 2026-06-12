# WordPress & Elementor Development Rules (คู่มือและกฎการพัฒนา)

ไฟล์กฎการพัฒนาหลักจาก `GEMINI.md` ถูกแบ่งออกเป็นไฟล์ Markdown ย่อยๆ เพื่อให้ง่ายต่อการอ่าน นำไปใช้ และการอ้างอิงสำหรับนักพัฒนาและ AI Agent

---

## ภาษาไทย (Thai)

### โครงสร้างไฟล์กฎการพัฒนา
กฎการพัฒนาถูกแบ่งออกเป็น 5 หมวดหมู่หลักดังนี้:

1. **[1-CORE.md](1-CORE.md) - มาตรฐานและระบบความปลอดภัยหลัก**
   * ลำดับความสำคัญในการอ่านกฎ (Mandatory Pre-Execution Rule)
   * กฎความปลอดภัย (Security) เช่น การตรวจสอบ `ABSPATH`, การตรวจสอบ Nonce และสิทธิ์การเข้าใช้งาน (Cap Checks), การเตรียม SQL Query (`$wpdb->prepare()`), และการทำความสะอาด/กรองข้อมูล (Sanitization/Escaping)
   * มาตรฐานการเขียน HTML (โดยเฉพาะโครงสร้าง `id` มาก่อน `class`), CSS/Tailwind, JS Stack (Alpine.js, Swiper)
   * กฎการทำ SEO/Schema, Accessibility, และ Performance Optimization

2. **[2-ELEMENTOR.md](2-ELEMENTOR.md) - กฎสำหรับ Elementor Widgets**
   * โครงสร้างไฟล์ที่จำเป็นสำหรับ Elementor Widget (4 ไฟล์หลักในแต่ละ Widget)
   * กฎการซิงค์ค่าระหว่าง PHP `render()` และ JS `content_template()` เพื่อให้การแสดงผลในหน้าบ้าน (Frontend) และหน้าแก้ไข (Elementor Editor Preview) ตรงกัน
   * รายการ Widget ที่มีอยู่และวัตถุประสงค์ เพื่อป้องกันการพัฒนา Widget ที่ซ้ำซ้อนกัน

3. **[3-THEME.md](3-THEME.md) - กฎสำหรับ Theme Customization**
   * โครงสร้างโฟลเดอร์ของ WordPress Theme
   * กฎการแยก Business Logic ออกจากไฟล์นำเสนอในส่วน Footer (`template-parts/footer-*`)
   * โครงสร้างและข้อมูลของ Mobile Branches Sheet

4. **[4-PLUGINS.md](4-PLUGINS.md) - กฎสำหรับ Custom Plugins & Tools**
   * กฎของแต่ละ Plugin เช่น ระบบสมาชิก (`[project-slug]-account`), Core functional (`[project-slug]-core`), และการนำเข้าข้อมูล (`[project-slug]-json-import`)
   * การใช้งานและข้อบังคับของ ACF (Advanced Custom Fields) และการลงทะเบียน CPT (Custom Post Types)
   * มาตรฐานความปลอดภัยสำหรับการอัปโหลดไฟล์ และระบบ WooCommerce

5. **[5-WORKFLOWS.md](5-WORKFLOWS.md) - ขั้นตอนการทำงาน, สภาพแวดล้อม และ Git**
   * การจัดทำระบบ CI/CD (GitHub Deploy) และกฎการ Merging/Pushing บน Git
   * วิธีการเซ็ตอัป Local Development Auto-Sync (BrowserSync + Hot Reload)
   * Code Review Checklist และขั้นตอนการแก้ไขบั๊กอย่างเป็นระบบ (Senior Protocol / Bug Correction)

---

## English Version

### Rule Files Structure
The development rules are split into 5 main modules:

1. **[1-CORE.md](1-CORE.md) - Core Standards & Security Guidelines**
   * Priority order for inspecting rules (Mandatory Pre-Execution Rule).
   * Core security conventions: `ABSPATH` check, nonce & capability checks, prepared SQL queries (`$wpdb->prepare()`), and context-specific data sanitization/escaping.
   * HTML conventions (specifically `id` MUST come before `class`), CSS/Tailwind, and JS stacks (Alpine.js, Swiper).
   * Accessibility, SEO & Schema, and Performance optimization rules.

2. **[2-ELEMENTOR.md](2-ELEMENTOR.md) - Elementor Widgets Guidelines**
   * Mandatory 4-file structure for Elementor widgets.
   * Dual-rendering synchronization rule: parity between PHP `render()` and JS `content_template()` to avoid editor preview discrepancies.
   * Catalog of existing widgets to prevent duplicates and code overlaps.

3. **[3-THEME.md](3-THEME.md) - Theme Specific Guidelines**
   * Standard theme folder structure guidelines.
   * Presentation-only templates rules, specifically for footers.
   * Schema definition for mobile branches sheets.

4. **[4-PLUGINS.md](4-PLUGINS.md) - Plugin-Specific Guidelines**
   * Development requirements for Member SPA (`[project-slug]-account`), Core plugin (`[project-slug]-core`), and Importer tool (`[project-slug]-json-import`).
   * Advanced Custom Fields (ACF) local JSON synchronization, Custom Post Types (CPT) registration, and custom REST API routes security.
   * Forms sanitization, server-side validations, AJAX handlers, and WooCommerce-specific integration guidelines.

5. **[5-WORKFLOWS.md](5-WORKFLOWS.md) - Workflows, Environments & Git Guidelines**
   * CI/CD deployment rules (Git branches target, FTP exclusion patterns).
   * Git workflow best practices (Conventional Commits, merge strategy).
   * Local development environment setup (BrowserSync + live reloading proxy configuration).
   * Code review checklist, senior execution protocols, and bug correction guidelines.
