# Configuration for probot-stale - https://github.com/probot/stale

# Number of days of inactivity before an Issue or Pull Request becomes stale
daysUntilStale: 60

# Number of days of inactivity before a stale Issue or Pull Request is closed.
# Set to false to disable. If disabled, issues still need to be closed manually, but will remain marked as stale.
daysUntilClose: 7

# Issues or Pull Requests with these labels will never be considered stale. Set to `[]` to disable
exemptLabels:
  - breaking-change
  - enhancement
  - discussion
  - cleanup
  - refactoring

# Set to true to ignore issues in a project (defaults to false)
exemptProjects: false

# Set to true to ignore issues in a milestone (defaults to false)
exemptMilestones: false

# Label to use when marking as stale
staleLabel: stale

# Comment to post when marking as stale. Set to `false` to disable
markComment: >
  This issue has been automatically marked as stale because it has not had activity within the last 60 days. It will be closed after 7 days if no further activity occurs. Thank you for your contributions.

# Comment to post when removing the stale label.
# unmarkComment: >
#   Your comment here.

# Comment to post when closing a stale Issue or Pull Request.
closeComment: >
  This issue has been automatically closed because it has not had activity since it was marked as stale. Thank you for your contributions.

# Limit the number of actions per hour, from 1-30. Default is 30
limitPerRun: 30

# Limit to only `issues` or `pulls`
only: issues

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                