# 4. Would you ship this?

A handful of small functions, one at a time. Each looks clean — the kind of code
that sails through review. For each: spot what's wrong, see what it does to a
patient, then the one-line fix.

Most of them were approved in real code reviews by real teams. Including mine.
They don't _look_ dangerous — and that's exactly what makes them dangerous.

## The climax — "safe every single time"

Then the gut-punch. Take the code you just approved, with its **100% green,
100%-covered** test suite, and run it — not once, but on thousands of realistic
patients — and watch the body count climb.

The bug only fires on a rare ordering (a fast edit). Your tests happened to pick
a safe path. But **you don't run code once — you run it ten thousand times a
day.** At scale, one-in-a-million is Tuesday.

_Then_ `git checkout fixed` and run the exact same 10,000 patients: **0 dead.**
Nothing changed but the code that looked fine either way.

> Rare is not "won't happen." A machine that's 99.99% safe is a body count.
> It has to be safe **every single time.**

---

[◀ The code](03-the-code-walkthrough.md) · [Index](README.md) · [Next: Prevention ▶](05-prevention-strategies.md)
