<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SweetAlert extends Component
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $data;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $listeners = ['alert'];

    /**
     * Entity Title
     *
     * @var string
     */
    public $entityTitle;

    /**
     * The attributes that are mass assignable.
     *
     * @param string $component
     * @return void
     */
    public function mount($component = "table")
    {
        $this->data['component'] = $component;
    }

    /**
     *
     * @param int $id
     * @param string $action
     * @param array $deleteMessage
     * @return void
     */
    public function alert($id = 0, $action = 'delete', $deleteMessage = [
        'confirm' => 'messages.confirm_delete',
        'success' => 'messages.delete',
    ])
    {
        $this->data['id'] = $id;
        $this->data['action'] = $action;

        $this->data['title'] = __('messages.confirm');
        $this->data['description'] = __($deleteMessage['confirm'], ['title' => $this->entityTitle]);
        $this->data['success_msg'] = __($deleteMessage['success'], ['title' => $this->entityTitle]);

        $this->emit('openAlert', $this->data);
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.sweet-alert');
    }
}
