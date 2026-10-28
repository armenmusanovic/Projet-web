# AGENTS.md

## Project
Klesarstvo Musanović: web application for a stone-crafting workshop. Customers browse types of stone and finished works and send requests for custom work (stairs, monuments, fireplaces, etc.). Admins manage the content and requests.
Single-page application with a PHP FlightPHP REST backend and MySQL database.
Entities: users, stone_types, works, requests, reviews.
Roles: admin, user.

## Stack
Frontend: HTML, CSS, JavaScript, Bootstrap, AJAX.
Backend: PHP, FlightPHP, PDO, MySQL. Auth: JWT. API docs: OpenAPI/Swagger.

## Folder structure
frontend/ -> css/, js/, views/, assets/, index.html
backend/ -> routes/, services/, dao/, middleware/, config/, logs/
docs/ -> AI_LOG.md

## Architecture rules
- Routes call services, services call DAOs, only DAOs access the database.
- Routes never contain SQL or business logic.
- No mixing frontend and backend code; frontend talks to backend only via AJAX/REST.
- Use PDO prepared statements only.
- Secrets (DB credentials, JWT secret, API keys) stay in backend/config/config.php, which is not committed. Commit config.example.php instead.

## Naming conventions
- PHP classes: PascalCase (UserDao, UserService); file name matches class name.
- Database tables: lowercase plural; columns: snake_case.
- JS files and functions: camelCase. CSS classes: kebab-case.
- API routes: lowercase plural nouns (/users, /works).

## Rules for AI
- Do not generate code I cannot explain; keep it simple and readable.
- Do not add libraries without asking.
- Never hard-code secrets.
- Follow the folder structure and layering above.
