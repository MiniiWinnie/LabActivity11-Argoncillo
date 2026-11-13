# Barangay Bulletin - Purok Argoncillo

Lab Activity 11 for Full-Stack Web Development at Ateneo de Davao University.
This Laravel application demonstrates Eloquent relationships, eager loading, pivot
tables, Form Requests, manual authentication, and Blade validation UX.

## Seeded accounts

All seeded passwords are `bulletin2026`.

| Resident | Email |
| --- | --- |
| Lola Argoncillo | `lola.argoncillo@bulletin.test` |
| Kagawad Argoncillo | `kagawad.argoncillo@bulletin.test` |

The database also includes eight factory-generated resident accounts.

## Tags

The five seeded tags are:

- Purok Argoncillo
- Urgent
- Libre
- Schedule
- Health

Each post receives one to three tags through the `post_tag` pivot using
`sync()`. The posts index supports filtering with `?tag={tag-id}`.

## Relationship map

- `Author hasMany Post`: an author can publish multiple bulletin posts.
- `Post belongsTo Author`: each post displays its author.
- `Post hasMany Comment`: comments belong to a bulletin post.
- `Comment belongsTo Post` and `Comment belongsTo User`: each comment records its
  post and logged-in resident.
- `User hasMany Comment`: a resident can write multiple comments.
- `Post belongsToMany Tag` and `Tag belongsToMany Post`: tags are reusable across
  posts and are attached with `sync()`.
- `User hasOne Author`: only users linked to an author profile can publish posts.
- `Author hasManyThrough Comment via Post`: an author page reports comments
  received across that author's posts.

The posts index eager loads `author` and `tags` and uses `withCount('comments')`.
The post detail page uses nested `load('comments.user')`, and lazy loading is
disabled in the application provider to expose accidental N+1 queries.

## Run the project

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run dev
php artisan serve
```

Open `http://127.0.0.1:8000/posts`.
