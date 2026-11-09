# Workflows, Environments & Git Guidelines

This document outlines deployment pipelines, Git workflows, local synchronization setup, code review checklists, and execution protocols.

## 1. CI/CD (GitHub Deploy)
- **Deploy Trigger**: CI/CD runs and deploys only when pushing to the `main` branch. The `dev` branch does not deploy.
- **Build Step**:
  - Run `npm ci && npm run build` for `[project-slug]-theme` and `[project-slug]-account` before deployment.
- **Exclusion Rules**:
  - Automatically exclude `.git*`, `node_modules/`, `src/`, `package.json`, `package-lock.json`, and `AGENTS.md` files from deployment.
- **Secrets Configured**:
  - `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`, `FTP_THEME_DIR`, `FTP_PLUGIN_DIR`.

## 2. Git Workflow
- **Commit Messages**: Always follow Conventional Commits format (`feat:`, `fix:`, `style:`, `docs:`, `refactor:`, `chore:`).
- **Target Branching Workflow**: To prevent accidental deployment to production servers, never push to `main` directly during active tasks.
  - Local tasks and features must be merged and pushed to `dev` for testing.
  - Merge features into `main` only when deploying production-ready assets.
  - Recommended Branch commands:
    ```sh
    # For active development tasks:
    git checkout dev
    git add .
    git commit -m "feat: description"
    git push origin dev

    # For production releases (deploy via main):
    git checkout main
    git pull origin main
    git merge dev
    git push origin main
    ```

## 3. WordPress & Node.js Development Environment (Auto-Sync Setup)
When initiating a new WordPress theme or plugin workspace that integrates Node.js assets, implement a robust local development workflow utilizing hot reloading/browser synchronization. This ensures PHP template modifications and Node.js compiled assets are synchronized in real-time without manual page refreshes.

### 3.1 Package Configuration & Dependencies
To orchestrate watch compilation tasks and live-reloading in parallel, ensure the following developer tools are installed in your `package.json`:
- `browser-sync` (Live reload engine proxying the local WordPress instance)
- `npm-run-all` (Orchestrates parallel and sequential scripts execution)
- Compilers/watchers as appropriate (e.g., `esbuild` for scripts bundling, `@tailwindcss/cli` for styling)

```json
"devDependencies": {
  "browser-sync": "^3.0.4",
  "npm-run-all": "^4.1.5",
  "@tailwindcss/cli": "^4.1.18",
  "esbuild": "^0.27.3"
}
```

### 3.2 Script Definition Schema
Configure scripts in your `package.json` to monitor project assets (`.php`, `.css`, `.js`), ignore dependency paths (`node_modules`, `vendor`), and run compiling watchers in parallel:

```json
"scripts": {
  "start": "npm run dev",
  "dev": "npm-run-all --parallel watch:tailwind watch:js serve",
  "serve": "browser-sync start --proxy \"http://yourproject.local\" --port 3000 --ui-port 3001 --files \"./**/*.php,./dist/**/*.css,./dist/**/*.js\" --ignore \"node_modules/**/*,vendor/**/*,.git/**/*\"",
  "watch:tailwind": "tailwindcss -i ./src/input.css -o ./dist/tailwind.css --watch",
  "watch:js": "esbuild src/js/app.js --bundle --outfile=dist/app.js --watch",
  "build": "npm-run-all build:js build:tailwind",
  "build:tailwind": "tailwindcss -i ./src/input.css -o ./dist/tailwind.css --minify",
  "build:js": "esbuild src/js/app.js --bundle --minify --outfile=dist/app.js"
}
```

### 3.3 Local Execution Workflow
1. Ensure your local WordPress environment is active and accessible via a local domain (e.g., `http://yourproject.local`).
2. Run `npm install` to load all packages.
3. Start the hot-reload server by executing:
   ```bash
   npm run dev
   ```
4. Access the development environment through the BrowserSync proxy endpoint: `http://localhost:3000`. Any code change will inject updated CSS or trigger page refreshes dynamically.

## 4. Build Script Completion
When defining `npm run build`, all referenced scripts must exist.
Ensure scripts are structured such that running `npm run build` runs all required sub-compilation watchers/builders cleanly.

## 5. Senior Execution Protocol
Before making any code change, the agent must:
1. Read the required project rule files based on priority.
2. Inspect existing related files before creating new files.
3. Reuse existing helpers, widgets, option keys, meta keys, REST routes, and CSS patterns when available.
4. Avoid duplicate systems or overlapping widgets.
5. Keep changes minimal and targeted.
6. Preserve backward compatibility for Elementor control IDs, option keys, meta keys, CSS classes, and REST response structures.
7. Apply WordPress security standards: nonce, capability, sanitization, escaping, REST permission callbacks, and `$wpdb->prepare()` for SQL.
8. Verify both frontend and Elementor editor rendering when modifying widgets.
9. Run or document required build steps when touching `src/`, `dist/`, Tailwind, or JS bundles.
10. Summarize changed files, risk areas, and verification steps after completion.

## 6. Backward Compatibility Rules
Do not rename existing:
- Elementor control IDs
- CSS/BEM class names
- WordPress option keys
- post meta keys
- user meta keys
- REST route names
- REST response keys
- AJAX action names
- shortcode names
Unless a migration path or compatibility fallback is implemented.

## 7. Code Review & Bug Prevention Guidelines
When reviewing code changes or performing verification, ensure the following checklist is followed:
- **Logic & Edge Cases**: Verify all logical flows and ensure edge cases (e.g., empty arrays, null/undefined inputs) are handled properly.
- **Security Check**: Scan for common vulnerabilities, including lack of data sanitization/escaping, missing nonces, and improper capability validation.
- **Resource & Caching**: Check for memory leaks, resource exhaustion, and incorrect caching behaviors.
- **Conventions & Patterns**: Ensure code adheres strictly to established workspace patterns, WordPress Coding Standards, and global rules.
- **Bug Reporting**: Proactively identify and report pre-existing bugs in code touched during implementation to maintain codebase quality.
- **Confidence & Accuracy**: Rely on a thorough understanding of the codebase; do not flag speculative or low-confidence issues. Check if specific git commits are checked out or if local states differ.
- **Review Checklists by Component**:
  - **PHP / WordPress Specific**: Verify ABSPATH exists, verify nonces/capabilities, verify context escaping, verify all SQL custom statements utilize `$wpdb->prepare()`.
  - **JavaScript Specific**: Check for DOM presence guards, verify external dependency loads, avoid global namespace pollution, ensure zero inline scripting is introduced.
  - **Elementor Specific**: Validate parity between `render()` and `content_template()`, verify 3-file widget structure with inline card markup (zero `card.php`, `get_template_part()`, or `set_query_var()` usage), check backward compatibility of control IDs, and verify styling rules apply in both frontend and editor.
  - **Deployment Specific**: Verify build compiles cleanly, ensure compiled assets are output to `dist/`, check that configuration files exclude node dependencies from build targets.

## 8. Bug Correction Steps (`fix-bug.md` Action)
1. **Read Rules**: Review priority rules files.
2. **Identify Root Cause**: Locate the bug by tracking execution logs or database dumps.
3. **Targeted Edit**: Implement a targeted patch. Avoid general refactoring of surrounding code.
4. **Backward Compatibility**: Ensure your fix does not alter key layouts or database hooks.
5. **Log Summary**: Summarize the files changed and methods used to correct the bug.
