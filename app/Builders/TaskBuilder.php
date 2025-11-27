<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class TaskBuilder extends Builder
{
    public function paginateData($limit)
    {
        $this->latest();

        if ($limit == 'all') {
            return $this->get();
        }

        return $this->paginate($limit);
    }

    public function wherePriority($priority)
    {
        return $this->where('priority', $priority);
    }

    public function whereStatus($status)
    {
        return $this->where('status', $status);
    }

    public function whereSearch($search)
    {
        $this->where('title', 'LIKE', '%' . $search . '%');
    }

    public function sortByColumn($column, $direction)
    {
        if (in_array($column, ['due_date', 'created_at'])) {
            return $this->orderBy($column, $direction);
        }

        return $this;
    }

    public function applyFilters(array $filters)
    {
        $filters = collect($filters);

        if ($filters->get('status')) {
            $this->whereStatus($filters->get('status'));
        }

        if ($filters->get('priority')) {
            $this->wherePriority($filters->get('priority'));
        }

        if ($filters->get('search')) {
            $this->whereSearch($filters->get('search'));
        }

        if ($filters->get('sort_by')) {
            $this->sortByColumn(
                $filters->get('sort_by'),
                $filters->get('sort_dir', 'asc')
            );
        }

        return $this;
    }
}