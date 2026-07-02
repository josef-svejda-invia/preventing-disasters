# 2. The Therac-25

A computer-controlled radiation therapy machine (mid-1980s). Between 1985 and
1987 it delivered massive radiation overdoses to at least six patients, several
fatal.

## What went wrong (high level)

- Safety interlocks moved **from hardware into software**. Earlier models had
  independent **hardware** interlocks that made the unsafe state *physically
  impossible*; the 25 removed them and trusted software alone.
- A **race condition** could leave the machine in an unsafe state if an operator
  edited treatment settings quickly.
- Cryptic error codes were routinely overridden by operators.
- Reused code from earlier models hid latent bugs.
- No independent review; the failure mode was assumed "impossible".

## Why it's a great teaching case

- Each individual flaw looks survivable on its own.
- Combined, they were lethal.
- Every flaw has a direct modern-software analogue.

_A genuinely fascinating disaster — worth an evening of reading. The canonical
account is Leveson & Turner (1993); good summary on
[Wikipedia](https://en.wikipedia.org/wiki/Therac-25). But we're engineers — so
let's do the more useful thing and break it ourselves._

---

[◀ Intro](01-intro.md) · [Index](README.md) · [Next: The code ▶](03-the-code-walkthrough.md)
