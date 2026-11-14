# Contributing

Thank you for helping. This is a small plugin and small pull requests are welcome.

- **Before a large change,** open an issue so the approach can be agreed first.
- **Keep it one job.** The plugin sets meta and social tags. Features outside that
  belong elsewhere.
- **Follow the WordPress coding standards.** Escape everything that is printed,
  clean everything that is saved, and check a nonce and a capability before any change.
- **Test in a real WordPress.** Mount the folder as
  `wp-content/plugins/maxsys-simple-meta-tags`, activate it, and check the page head of
  the home page, a page with its own values, and a page without.
- **Update `readme.txt`** when behaviour changes: the changelog, and the version in
  both `readme.txt` and the plugin header.

## Sign off every commit

This project uses the Developer Certificate of Origin, not a contributor licence
agreement. By signing off you certify that you wrote the change or have the right to
submit it under the project's licence (<https://developercertificate.org/>):

```bash
git commit -s -m "fix: describe the change"
```

A check on every pull request enforces it.

## Security

Do not open a public issue for a vulnerability. See [SECURITY.md](SECURITY.md).

## Conduct

Be kind. The MaxsysLab projects follow the Contributor Covenant; the full text is in
the [Herald repository](https://github.com/MaxsysLab/herald/blob/main/CODE_OF_CONDUCT.md).
