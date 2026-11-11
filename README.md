# Naram's Laravel starter kit

A fork of [laravel/blank-livewire-starter-kit](https://github.com/laravel/blank-livewire-starter-kit) with my packages, tooling and conventions on top. There is no `composer.lock` or `bun.lock`, so every new project installs the newest package versions the constraints allow.

## Before a new project: pull Laravel's latest files

```powershell
cd C:\Users\Naram\Projects\StarterKit
git pull upstream main
git push
```

Git merges Laravel's changes under my edits. Fix any conflict and commit before the push.

## A new client project

Run these in PowerShell. Replace `client` with the project's name.

1. Create the project. Answer the installer's questions: Pest, Boost (choose the agents) and the database.

    ```powershell
    laravel new client --using=https://github.com/Naram-Alkoht/starter-kit --bun
    cd client
    ```

    The installer creates `.env`, sets the app key, runs its Pest and Boost setup, and adds `boost:update` to Composer's `post-update-cmd`.

2. Edit `.env`: `APP_NAME`, `DB_CONNECTION=mysql` and the `DB_*` values. Create the database, then run `php artisan migrate`.
3. Edit `phpunit.xml`: change `starter_kit_test` to `client_test`. The tests use MySQL with the credentials from `.env`.
4. Serve it: `herd link client --secure`.
5. Read `.ai/guidelines/custom.md` and change what differs for this client. Run `php artisan boost:update` after an edit.
6. Create the admin user: `php artisan make:filament-user`. The panel is at `/admin`.
7. Check everything: `composer test`.
8. `git init`, then the first commit.

If the app goes into a monorepo subfolder, add a `paths:` filter to `.github/workflows/tests.yml`.

## Changing the kit

Edit the files here, commit and push. Bump a major version (for example Filament) in `composer.json` by hand.
