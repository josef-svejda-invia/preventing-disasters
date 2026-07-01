# 4. Would you ship this?

The gauntlet. A handful of functions, one at a time. For each:

1. **The clean version, on screen.** _Hands up — would you approve this PR?_
2. **Ten seconds.** _Where's the bug? Shout it._
3. **The reveal** — the one line, circled, and what it does to a patient.
4. **A true story** — the real bug this one is modelled on.
5. **The lesson**, in one line.

Most of these got approved in real code reviews by real teams. Including mine.
That's the point: they don't _look_ dangerous. That's what makes them dangerous.

## The climax — "safe every single time"

Then the gut-punch. Take the code you just approved, with its **100% green,
100%-covered** test suite, and run it — not once, but on thousands of realistic
patients:

- 1 patient → fine. 10 → fine. 100 → fine.
- **10,000 → the bodies start piling up.**

The bug only fires on a rare ordering (a fast edit; every Nth setup pass). Your
tests happened to pick a safe path. But **you don't run code once — you run it
ten thousand times a day.** At scale, one-in-a-million is Tuesday.

> Rare is not "won't happen." A machine that's 99.99% safe is a body count.
> It has to be safe **every single time.**

> _Speaker note:_ presentation-led — I drive, no workshop. Hooks are hands-up
> only (predict + spot-the-bug); no Slido, no pairing. If the room goes quiet,
> count down and reveal — no dead air. War stories → notes/war-stories.md. The
> bug list, the 10k set piece, and timings live in notes/talk-script.md (Acts 2–3).

---

[◀ The code](03-the-code-walkthrough.md) · [Index](README.md) · [Next: Prevention ▶](05-prevention-strategies.md)
