# AGENTS.md

## Project
Web application (SPA) with PHP FlightPHP REST backend and MySQL database.

## Stack
Frontend: HTML, CSS, JavaScript, Bootstrap. Backend: PHP, FlightPHP, PDO, MySQL. Auth: JWT.

## Architecture
frontend/ (css, js, views, assets) and backend/ (routes, services, dao, middleware, config, logs). Routes call services, services call DAOs, only DAOs access the database.

## Rules
No mixing frontend and backend code. Use PDO prepared statements. Secrets stay in config.php (not committed).
