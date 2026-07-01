# 2. The Therac-25

A computer-controlled radiation therapy machine (mid-1980s). Between 1985 and
1987 it delivered massive radiation overdoses to at least six patients, several
fatal.

## What went wrong (high level)

- Safety interlocks moved **from hardware into software**.
- A **race condition** could leave the machine in an unsafe state if an operator
  edited treatment settings quickly.
- Cryptic error codes were routinely overridden by operators.
- Reused code from earlier models hid latent bugs.
- No independent review; the failure mode was assumed "impossible".

## Why it's a great teaching case

- Each individual flaw looks survivable on its own.
- Combined, they were lethal.
- Every flaw has a direct modern-software analogue.

> _Speaker note:_ keep this factual and brief — the code walkthrough is where it
> gets concrete. Add a diagram in `assets/` if useful.

---

[◀ Intro](01-intro.md) · [Index](README.md) · [Next: The code ▶](03-the-code-walkthrough.md)
