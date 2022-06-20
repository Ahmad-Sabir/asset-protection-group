<?php

namespace App\Services\Admin\WorkOrder;

use App\Models\Admin\WorkOrder\AdditionalTask;
use App\Http\Requests\Admin\WorkOrder\AdditionalTaskRequest;

class AdditionalTaskService
{
    protected const TASK_STATUS = 'apg.task_status';
    public function __construct(
        protected AdditionalTask $additionalTask,
    ) {
    }

    /**
     * store task.
     *
     * @param AdditionalTaskRequest $request
     * @return mixed
     */
    public function store(AdditionalTaskRequest $request)
    {
        $data = $request->validated();
        $data['due_date'] = $request->due_date;
        return $this->additionalTask->create($data);
    }

    /**
     * store WorkOrder.
     *
     * @param int $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->additionalTask->find($id);
    }

    /**
     * prepare data
     *
     * @param AdditionalTaskRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(AdditionalTaskRequest $request, $id)
    {
        /** @var \App\Models\Admin\WorkOrder\AdditionalTask $updateTask */
        $updateTask = $this->additionalTask->find($id);
        $data = $request->validated();
        $data['due_date'] = $request->due_date;
        $data['status'] = config('apg.task_status.pending');
        if ($request->has('status')) {
            $data['status'] = config('apg.task_status.completed');
        }
        $updateTask->update($data);
        return $this->additionalTask->find($id);
    }

    /**
     * delete task
     *
     * @param int $id
     * @return mixed
     */

    public function delete($id)
    {
        return AdditionalTask::where('id', $id)->delete();
    }

    /**
     * delete task
     *
     * @param int $id
     * @param string $type
     * @return mixed
     */

    public function deleteComment($id, $type)
    {
        /** @var \App\Models\Admin\WorkOrder\AdditionalTask $updateTask */
        $updateTask = $this->additionalTask->find($id);
        if ($type == config('apg.task_type.comment')) {
            $data['comment'] = null;
        } else {
            $data['media_id'] = null;
        }
        return $updateTask->update($data);
    }
}
