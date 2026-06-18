# Projects

Projects, users, tasks, and time entries.

## List projects

```php
$projects = $xero->projects()
    ->contact('contact-id')
    ->states('INPROGRESS')
    ->page(1)
    ->get();
```

## Create a project

```php
$project = $xero->projects()
    ->create()
    ->title('Website rebuild')
    ->contact('contact-id')
    ->estimateAmount(1200)
    ->save();

$projectId = $project->getProjectId();
$projectName = $project->getName();
```

## Update a project

```php
$updated = $xero->projects()
    ->update('project-id')
    ->title('Website rebuild v2')
    ->save();
```

## Close or reopen a project

```php
$closed = $xero->projects()
    ->patch('project-id')
    ->close()
    ->save();
```

```php
$reopened = $project?->close()->reopen();
```

## Project users

```php
$users = $xero->projects()
    ->users()
    ->page(1)
    ->perPage(100)
    ->get();

$email = $users->first()?->getEmail();
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

$taskId = $task->getTaskId();
```

## Time entries

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

## Scopes

- `projects.read` — read projects, tasks, users, and time entries
- `projects` — write projects, tasks, and time entries; patch project state
