# 3. The code — hidden in plain sight

A small, modern, clean PHP project that simulates a Therac-25 treatment console.
It looks like code you'd approve. It is **intentionally lethal**.

The rule for this section: **every dangerous function fits on one screen.** No
digging through the repo — if the bug isn't visible on the slide, it's not fair.
The catch is that "visible" and "noticed" are different things.

## How to read along

- I drive. You watch, and you call it.
- Each bug gets the same treatment: _here's the code — would you ship it?_
- The repo is yours to explore **after** — it's the take-home, not the live medium.

## The code map (what's on each slide)

| # | Bug | Where | The tell |
| - | --- | ----- | -------- |
| 1 | Swallowed error | `src/Console.php` → `fire()` | `catch (UnsafeStateException) {}` — the interlock throws, nobody listens |
| 2 | Cryptic error | `src/MalfunctionEnum.php`, `src/UnsafeStateException.php` | the operator sees only `MALFUNCTION 54` |
| 3/4 | Proxy safety check | `src/SafetyCheck.php` → `needsTarget()` | checks the intended **mode**, ignores the real `$highPower` it was handed |
| 5 | Stale-state race | `src/Console.php` → `editMode()` | a late edit never clears `dataEntryComplete`, so the beam power stays stale |
| 6 | Counter overflow | `src/SetupTest.php` → `targetConfirmed()` | `class3 % 256` — every 256th call skips the check |
| — | (honest physics, not a bug) | `src/Beam.php` → `fire()` | high power + no target = 100× dose |

## Run it yourself

- `php bin/console.php` — the cold open: one ordinary treatment, patient dies.
- `php bin/simulate.php` — scale: `1 → 0, 10 → 0, 100 → 0, 1 000 → 4, 10 000 → 47`.
- `composer test` — the green suite (looks thorough, all pass).
  `composer test:flaws` — the safety properties, which **fail on `main`**.
- `git checkout fixed` — the *same* code, made safe: flaws suite goes green,
  simulator → `0`.

---

[◀ Therac-25](02-therac25.md) · [Index](README.md) · [Next: Would you ship this? ▶](04-finding-the-risks.md)
