# Repository Guidelines

## Project Structure & Module Organization

Vietnamese web-development coursework using PHP 8.2+, MySQL/MariaDB, PDO, and Vue 3.

- `TH1/`, `TH2/`: standalone PHP exercises covering arrays, functions, and OOP.
- `TH3/`: SQL exercises for `shopping_cart`.
- `TH4/app/`: product CRUD and authentication. Keep connections/access checks in `common/`, product queries in `model/`, and shared HTML in `view/`. `TH4/shopping_cart.sql` provides schema and sample data.
- `TH6/`: Vue exercises (`bai1.html`–`bai3.html`) and `index.html`; vendored Vue, avatar, and license in `assets/`.
- `exam/`: PHP exam solutions.

Week 5 continues inside `TH4`; do not recreate `TH5` or restore discarded TH4 code. Verify files before following historical notes in ignored `GEMINI.md`.

## Build, Test, and Development Commands

Run from the repository root:

```powershell
php TH1/bai1.php                    # Run a standalone exercise
php -l TH4/app/product_add.php      # Check PHP syntax
php -S localhost:8000 -t TH4/app    # Serve product management
php -S localhost:8000 -t TH6        # Serve Vue exercises instead
git diff --check                   # Check whitespace errors
```

TH4 requires MySQL; import `TH4/shopping_cart.sql` through phpMyAdmin. XAMPP is at `D:\xampp`. TH6 opens directly in a browser and works offline. No build or npm installation is required.

## Coding Style & Naming Conventions

Use four-space indentation, UTF-8, Vietnamese interfaces, and simple layouts. Use `snake_case` for PHP feature filenames, `camelCase` for functions, and `baiN` exercise names. Follow neighboring brace styles. Preserve Vue Options API and required directives. No formatter configuration is checked in; check PHP syntax with `php -l`.

## Testing Guidelines

No test framework, test directory, or coverage threshold is checked in. Lint changed PHP files and verify every affected assignment requirement. Check CRUD/authentication, invalid IDs, integer boundaries, and empty input. Use transactions with rollback for database write tests.

For TH6, check grade boundaries, whitespace-only names, integer ticket quantities 1–10, and task filtering/counts. Two VIP tickets plus combo must total 245,000 VND. Check browser errors, offline assets, and mobile layout. Record scenarios and results in the PR.

## Commit & Pull Request Guidelines

History uses `feat:`, `docs:`, and `refactor:` prefixes with short English or Vietnamese summaries. Keep commits scoped to the exercise. PRs should describe changed behavior, affected files, requirement coverage, and verification; include screenshots for UI changes and link issues when applicable. Commit or push when requested.

## Security & Configuration

Use PDO prepared statements, server-side validation, and escaped HTML output. Preserve password hashing, session checks, and confirmed POST deletion with tokens. Keep existing database records intact and exclude real credentials from commits.
