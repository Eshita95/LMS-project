<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Curriculam;
use Livewire\Component;

class CourseShow extends Component
{
    public $course_id;
    public function render()
    {
        $course = Course::where('id', $this->course_id)->first();
        $curriculams = Curriculam::where('course_id', $this->course_id)->get();

        return view('livewire.course-show', [
            'course' => $course,
            'curriculams' => $curriculams,
        ]);
    }

    public function curriculamDelete($id)
    {
        $curriculum = Curriculam::findOrFail($id);

        $curriculum->delete();

        flash()->addSuccess('Curriculum deleted successfully');
    }

}
