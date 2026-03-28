# Projects

Projects should feel like part of the same SDK, not a side module with different rules.

Current coverage:

- projects
- project users
- tasks
- time entries
- project lifecycle patch helpers

## Projects

```php
$projects = $xero->projects()
    ->contact('contact-id')
    ->states('INPROGRESS')
    ->page(1)
    ->get();
```

```php
$project = $xero->projects()
    ->create()
    ->title('Website rebuild')
    ->contact('contact-id')
    ->estimateMinutes(600)
    ->save();

$projectId = $project->getProjectID();
$projectTitle = $project->getTitle();
```

```php
$updated = $xero->projects()
    ->update('project-id')
    ->title('Website rebuild v2')
    ->save();
```

```php
$closed = $xero->projects()
    ->patch('project-id')
    ->close()
    ->save();
```

Loaded projects keep the same fluent style:

```php
$reopened = $project?->close()->reopen();
```

## Project Users

```php
$users = $xero->projects()
    ->users()
    ->page(1)
    ->perPage(100)
    ->get();

$email = $users->first()?->getEmailAddress();
```

## Tasks

```php
$tasks = $xero->projects()
    ->tasks('project-id')
    ->chargeType('TIME')
    ->get();
```

```php
$task = $xero->projects()
    ->tasks('project-id')
    ->create()
    ->name('Discovery')
    ->chargeType('TIME')
    ->rate(150)
    ->save();

$taskId = $task->getTaskID();
```

## Time Entries

```php
$entries = $xero->projects()
    ->timeEntries('project-id')
    ->user('user-id')
    ->task('task-id')
    ->states('INPROGRESS')
    ->get();
```

```php
$entry = $xero->projects()
    ->timeEntries('project-id')
    ->create()
    ->task('task-id')
    ->user('user-id')
    ->date('2026-03-26T00:00:00Z')
    ->durationMinutes(120)
    ->save();

$minutes = $entry->getDuration();
```

## Scope Notes

Projects uses:

- broad `projects`
- granular `projects.read`, `projects`

Use `projects.read` for project, task, user, and time-entry reads.

Use `projects` for project writes, project lifecycle patch calls, task writes, and time-entry writes.
