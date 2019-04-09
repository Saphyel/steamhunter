workflow "Pipeline" {
  resolves = ["Check code style"]
  on = "push"
}

action "Check code style" {
  uses = "./.github/action-codestyle"
}
