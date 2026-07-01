# 5. Prevention

You can't stop yourself making mistakes. So you build code that survives them —
**in more than one place, and loudly.**

## Make the mistake impossible

- **Make illegal states unrepresentable** — enums, value objects, not bare
  strings/ints/floats. If it can't be constructed, it can't be shipped.
- **Fail closed by default.** Unknown state → refuse, don't proceed. `isSafe()`
  should return `false` unless something is _proven_ safe, never the reverse.
- **Validate the impossible.** The input that "can't" arrive is the one that
  kills you. Guard it at the boundary. _("The client will never send this." —
  give me five minutes.)_
  - Rule of thumb: assertions (`Webmozart\Assert`) for programmer-error
    invariants ("this can't happen"); plain `if` + exception for expected-but-bad
    runtime input. Don't swallow either.

## Make the mistake LOUD

- **Silent errors are the worst thing in code.** No empty `catch`, no swallowed
  exception, no error nobody reads.
- Errors must be **impossible to ignore and impossible to misread** — the
  opposite of "MALFUNCTION 54, see manual."
- If you can't prevent it, at least make it scream.

## One source of truth — and when you can't

- One rule, one place. Duplicated rules **drift**, and then nobody can tell a
  deliberate difference from a bug. ("Interal SvEo" — ask me.)
- Only merge things that are the _same logic_ — look-alike checks that answer
  different questions must stay separate.
- **When you genuinely can't unify:** link the copies with a `@see` annotation,
  both ways, so the next person who edits one _discovers_ the other. Drift
  happens because the copies are invisible to each other — make the relationship
  loud.

## Catch it in more than one place

- **Defense in depth.** Independent checks; don't trust a single source of truth.
  The safeguard someone deletes "to simplify" was often the only one left.
- Audit logs and monitoring — you can't debug, or prove, what you didn't record.

## Test the danger, not the lines

- **100% coverage proved nothing.** Test the _safety property_ — that an unsafe
  state is _refused_ — not that the happy path returns non-null.

> _Speaker note:_ map each bullet back to the exact bug from section 4 (and the
> commit that fixes it). This is the "here's what I actually do" section — keep
> it concrete, not a principles lecture.

---

[◀ Would you ship this?](04-finding-the-risks.md) · [Index](README.md) · [Next: Other failures ▶](06-other-disasters.md)
