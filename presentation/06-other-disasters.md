# 6. The same mistakes, everywhere

~1 minute each. The Therac-25 wasn't special — these patterns are everywhere.

## Jurassic Park _(fiction, but the cleanest illustration)_

- The system counted the dinosaurs **up to the expected number and stopped** — it
  never looked for _more_. They bred (assumed impossible), so the extras were
  invisible.
- Lesson: **add more checks than you think you need.** Validate the assumption
  you're certain can't be violated — that's the one that eats you (sometimes
  literally).

## Chernobyl

- Operators faced **thousands of signals** and a wall of alarms with no priority.
  When everything is an alert, nothing is.
- Lesson: alert on a **few meaningful signals**, not on everything. Alert fatigue
  is how the real warning gets ignored. (Directly: how we set up monitoring.)

## Boeing 737 MAX (MCAS)

- Software that fought the pilots, driven by a **single** angle-of-attack sensor,
  with the behavior undocumented.
- Lesson: **single point of failure** + hidden behavior. One sensor, no
  redundancy, no way for the human to know what the software was doing.

---

[◀ Prevention](05-prevention-strategies.md) · [Index](README.md) · [Next: Takeaways ▶](07-takeaways.md)
