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

## Database and DAO layer (Milestone 2)
- Database: MySQL, name `klesarstvo`. Schema and sample data are in `backend/database.sql`.
- Tables: users, stone_types, works, requests, request_items, reviews (all with primary keys, foreign keys where needed).
- `backend/dao/Database.php` opens one PDO connection (singleton) and reads credentials from `backend/config/config.php`.
- `backend/config/config.php` is NOT committed (listed in `.gitignore`). `backend/config/config.example.php` is committed as a template.
- All DAO classes extend `BaseDao` and get getAll, getById, create, update and delete from it.
- Each DAO only sets its table name in the constructor and adds its own queries (for example getByEmail, getByUser).
- Only PDO prepared statements are allowed. Never put user values directly into SQL strings.
- Only DAO classes talk to the database. Routes and services must never write SQL.




## Services, routes and API docs (Milestone 3)
- Backend framework: FlightPHP (installed with Composer in `backend/`). `vendor/` is not committed, run `composer install` in `backend/`.
- Entry point is `backend/index.php`, `.htaccess` sends all requests to it.
- There is one service per entity in `backend/services/` (all extend `BaseService`). Services are the only layer that calls DAOs.
- Services validate data and allow only fields listed in `$fields`. Invalid data throws `ValidationException` (400), a missing record throws `NotFoundException` (404).
- Routes are in `backend/routes/`, one file per entity. Routes never contain SQL or business logic, they only call a service.
- `routes/helpers.php` has `respond()` (turns exceptions into JSON with a status code) and `body()` (reads the JSON request body).
- API responses are JSON with correct status codes: 200, 201, 400, 404, 500 (401 and 403 come with JWT in Milestone 4).
- OpenAPI docs are written as PHP attributes in `backend/openapi/` (one file per entity). Swagger UI is at `/docs`, the generated JSON at `/openapi.json`. Every new endpoint must be documented there.
- External API: OpenWeatherMap, called only from `WeatherService` (cURL with a 5 second timeout). Endpoint `GET /weather`. Failures are written to the error log and return 503, the rest of the application keeps working.
- The API key is in `backend/config/config.php` (not committed). `config.example.php` has an empty key.
- Passwords are stored only as hashes (`password_hash`) and the hash is never returned by the API.