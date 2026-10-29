# Klesarstvo Mušanović

Web application for a family stone-crafting workshop. Customers browse stone types and finished works, register, and send requests for a quote (stairs, monuments, fireplaces, etc.). The admin manages the catalog and processes requests.

## Technologies
- Frontend: HTML, CSS, JavaScript, Bootstrap, AJAX (single-page application)
- Backend: PHP, FlightPHP (REST API), PDO
- Database: MySQL
- Authentication: JWT
- API documentation: OpenAPI / Swagger

## Entities
- users: registered users (roles: admin, user)
- stone_types: types of stone (granite, marble, limestone...)
- works: gallery of finished works
- requests: a quote request sent by a customer
- request_items: items inside one request (product, stone, dimensions, engraving text)
- reviews: customer reviews

Relationships:
- one user has many requests and many reviews
- one request has many request_items
- one stone type is used in many request_items and many works

ERD: see `docs/erd.png`

![ERD](docs/erd.png)

## Roles
- admin: full CRUD on all entities, processes requests
- user: sends requests, views own requests, writes reviews, views catalog

Test accounts (will be added in Milestone 4):
- admin: [email] / [password]
- user: [email] / [password]

## External API
Planned: weather forecast (OpenWeatherMap) shown on the request page, because installing outdoor stonework depends on the weather. Details will be added in Milestone 3.

## Running locally
1. Install XAMPP and start Apache and MySQL.
2. Clone the repository into `htdocs`.
3. Open `http://localhost/[your-folder]/Projet-web/frontend/index.html`
4. Backend setup (later milestones): import the `.sql` file and copy `config.example.php` to `config.php`.

## Links
- Swagger documentation: (Milestone 3)
- Deployed application: (Milestone 5)