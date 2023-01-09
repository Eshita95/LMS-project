<?php

namespace App\Http\Livewire;

use App\Models\Lead;
use Flasher\Prime\FlasherInterface;
use Livewire\Component;

class LeadIndex extends Component
{
    public function render()
    {
        $leads= Lead::paginate(10);
        return view('livewire.lead-index',[
            'leads' => $leads
        ]);
    }

    public function leadDelete($id){
        // permission_check('lead-management');
        $lead = Lead::findOrFail($id);
        $lead->delete();

        flash()->addSuccess('Lead deleted successfully');

    }
}
