<?php

namespace App\Http\Livewire;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Course;
use Livewire\Component;
use App\Models\Curriculam;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseCreate extends Component
{
    public $name;
    public $course_image;
    public $description;
    public $price;
    public $selectedDays = [];
    public $selectedTeachers = [];
    public $time;
    public $end_date;

    public $days = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];

    protected $rules = [
        'name' => 'required|unique:courses,name',
        'course_image' => 'required',
        'description' => 'required',
        'price' => 'required',
        'selectedDays' => 'required',
        'time' => 'required'
    ];

    public function render()
    {
        $teachers = User::Role('Teacher')->get();
        return view('livewire.course-create',
        ['teachers' => $teachers]);
    }

    public function formSubmit()
    {
        $this->validate();
        $course = new Course();
        $course->name = $this->name;
        $course->slug = str_replace(' ', '-', $this->name);
        $course->description = $this->description;
        $course->image = $this->course_image;
        $course->price = $this->price;
        $course->user_id = Auth::user()->id;
        $course->save();


        $i = 1;
        $start_date = new DateTime(Carbon::now());
        $endDate =   new DateTime($this->end_date);
        $interval =  new DateInterval('P1D');
        $date_range = new DatePeriod($start_date, $interval, $endDate);
        foreach ($date_range as $date) {
            foreach ($this->selectedDays as $day) {
                if ($date->format("l") === $day) {
                    Curriculam::create([
                        'name' => $this->name . ' #' . $i++,
                        'week_day' => $day,
                        'class_time' => $this->time,
                        'end_date' => $this->end_date,
                        'course_id' => $course->id,
                    ]);
                }
            }
        }
        $i++;

        flash()->addSuccess('Course created successfully');

        return redirect()->route('course.index');
    }

}
