- when answer me, give me a little bit of context, talk in ASD-STE100 Simplified Technical English, and use the ubiquitous language from docs/CONTEXT.md
- don't run browser tests if anything need to be checked visually asked me to check and confirm manually
- don't run npm run build , it's local development and composer dev is already active with vite running
- I'm using bun in this project not npm
- when using mass assign don't pass things like $request->all() or $data array except when
  the $data array is coming from validation but in all other time build an array like $user = User::
  Create(['name'=> 'admin'])
- don't use default in migration
- when using Livewire component or page you should use single or multi file component but never a class component
- when you need to use an icon first check if it available in the heroicon blade components if not then use an svg

## Seeders and factories

A ticket that adds a model isn't finished until that model has its factory and its seeder.

- **Every model has a factory and is seeded.** Use one seeder per group of models that are created together: a child that can't exist without its parent is seeded with the parent. Every model with data is in exactly one seeder. Technical tables (tokens, OTPs, cache, jobs, permissions) get no seeder.
- **Two entry seeders:**
    - `ProductionSeeder`: real data only, e.g. roles and Staff accounts, governorates, settings, content, the review account. It can run on the production server, and again on every deploy, without duplicating rows (`updateOrCreate`/`firstOrCreate`).
    - `DemoSeeder`: calls `ProductionSeeder`, then every demo seeder in dependency order, so every model has test data. It refuses to run when `APP_ENV=production`.
    - `DatabaseSeeder` calls `DemoSeeder` when the app is local, else `ProductionSeeder`. Locally, `php artisan migrate:fresh --seed` gives the full test data.
- **Demo data goes through the app's actions**, not raw inserts, so it is data the real app could make.
- **Images:**
    - An image that exists in the repo is used from there. Production seeders use only these.
    - Otherwise, demo seeders use a real Unsplash photo from a fixed list of photo IDs per kind of image, kept in the code: `https://images.unsplash.com/photo-<id>?w=1200&q=80`. No API key, no random images.
    - One class, `Database\Seeders\Images\UnsplashImages`, returns the photo's local file. The first run downloads it into `storage/app/private/seed-images/<id>.jpg`. Every later run, including every `migrate:fresh --seed`, uses that file and makes no download. The cache is not in git, so each machine downloads once.
    - Seeders copy the file to the model's storage and keep the cache file (media library: `preservingOriginal()`). If the media library is used, `DemoSeeder` runs `media-library:clean` first, so `migrate:fresh` leaves no orphan files.
- **Tests never download.** The base `TestCase` calls `Http::preventStrayRequests()`; tests fake Unsplash with `Http::fake()`.
