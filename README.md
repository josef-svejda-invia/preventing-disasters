# Preventing Disasters with PHP

Materials for the **Tech Growth Day** session _"Preventing Disasters with PHP"_.

We look at real engineering disasters — primarily the **Therac-25** radiation
overdoses — and ask the practical question: *what could have prevented them?*
A small, deliberately flawed PHP project inspired by the Therac-25 gives us
something concrete to break, critique, and fix together.

> ⚠️ **The code in `src/` is intentionally unsafe.** It exists to demonstrate
> failure modes. Do not copy it into anything real.

## What's in here

| Path             | What it is                                                        |
| ---------------- | ----------------------------------------------------------------- |
| `presentation/`  | The talk, as plain Markdown — start at [`presentation/README.md`](presentation/README.md). |
| `src/`           | The Therac-25-inspired simulation (intentionally flawed).         |
| `tests/`         | PHPUnit tests.                                                    |
| `bin/console.php`| Runnable demo entrypoint.                                         |
| `notes/`         | Private working notes — **git-ignored**, not published.           |

## Running the project

Runs on **PHP 8.5 in Docker**; the code stays within readable **8.2+** syntax.

```bash
make build      # build the image
make install    # composer install
make test       # run PHPUnit
make run        # run the demo entrypoint
```

No Docker? With a local PHP 8.2+ and Composer:

```bash
composer install
composer test
php bin/console.php
```

## Presenting

The slides live in `presentation/` as Markdown and are designed to read well
directly in the GitHub/GitLab repo browser. Start at
[`presentation/README.md`](presentation/README.md).
