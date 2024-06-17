<?php

namespace App\Http\Controllers;

use App\Helpers\NepaliDate;
use Illuminate\Http\Request;
use Auth;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Support\Facades\Hash;
use Validator;


use App\Models\User;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Shift;
use App\Models\DefaultClockout;
use App\Models\AcceptedLeave;
use App\Models\CompanySetting;
use App\Models\Report;
use App\Models\Setting;
use App\Models\SalaryPaid;
use Storage;
use Illuminate\Http\Response;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AttendanceController extends Controller
{
    public function todayList()
    {
        if (Auth::User()) {
            return redirect()->route('home');
        } else {
            $users = User::with('clockout', 'default_clockout')
                ->where('is_deleted', 0)
                ->where('department_id', '!=', 1)
                ->get();
            $attendance_user = [];
            $late_clockout = [];

            foreach ($users as $user) {
                $is_leave = AcceptedLeave::whereDate('date', Carbon::today())
                    ->where('user_id', $user->id)
                    ->count();
                if ($is_leave >= 1) {
                    $leave = AcceptedLeave::whereDate('date', Carbon::today())
                        ->where('user_id', $user->id)
                        ->first();
                    $type = '';
                    if ($leave->leave->leave_type_full) {
                        $data = [
                            'leave' => true,
                            'allow_attendance' => false,
                            'leave_type' => 'full',
                            'user' => $user,
                            'type' => 'clockin',
                            'attendance' => null
                        ];
                    } else {
                        $type = 'half';
                        if ($user->clockout || $user->default_clockout) {
                            if ($user->clockout) {
                                $data = [
                                    'leave' => true,
                                    'allow_attendance' => true,
                                    'leave_type' => 'half',
                                    'user' => $user,
                                    'type' => 'clockout',
                                    'attendance' => $user->clockout
                                ];
                            } elseif ($user->default_clockout) {
                                $data = [
                                    'leave' => true,
                                    'allow_attendance' => true,
                                    'leave_type' => 'half',
                                    'user' => $user,
                                    'type' => 'default-clockout',
                                    'attendance' => $user->default_clockout
                                ];
                            }
                        } else {
                            $attendance = Attendance::where('user_id', $user->id)
                                ->whereDate('date', Carbon::today())
                                ->count();
                            if ($attendance == 0) {
                                $data = [
                                    'leave' => true,
                                    'allow_attendance' => true,
                                    'leave_type' => 'half',
                                    'user' => $user,
                                    'type' => 'clockin',
                                ];
                            } else {
                                $data = [
                                    'leave' => true,
                                    'allow_attendance' => false,
                                    'leave_type' => 'half',
                                    'user' => $user,
                                    'type' => 'clockin',
                                ];
                            }
                        }
                    }

                } else {
                    if ($user->clockout || $user->default_clockout) {
                        if ($user->clockout) {
                            $data = [
                                'leave' => false,
                                'allow_attendance' => true,
                                'user' => $user,
                                'type' => 'clockout',
                                'attendance' => $user->clockout
                            ];
                        } elseif ($user->default_clockout) {
                            $data = [
                                'leave' => false,
                                'allow_attendance' => true,
                                'user' => $user,
                                'type' => 'default-clockout',
                                'attendance' => $user->default_clockout
                            ];
                        }
                    } else {
                        $data = [
                            'leave' => false,
                            'allow_attendance' => true,
                            'leave_type' => '',
                            'user' => $user,
                            'type' => 'clockin',
                            'attendance' => null
                        ];
                    }

                }
                $attendance_user[] = $data;
            }
            return view('attendance.todayList', compact('attendance_user'));

        }
    }

    public function getClockinForm(Request $request)
    {
        $res['status'] = false;
        $res['message'] = '';
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['message'] = $errors->first();
        } else {
            $user = User::find($request->user_id);
            $shifts = $user->department->active_shifts;
            $res['status'] = true;
            $res['view'] = view('attendance.component.clockin-form', compact('user', 'shifts'))->render();
        }
        return json_encode($res);
    }

    public function clockin(Request $request)
    {
        $res['status'] = false;
        $res['title'] = '';
        $res['text'] = '';

        $validator = Validator::make($request->all(), [
            'pin' => 'required',
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',

            'time' => 'required',
            'image' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title'] = $errors->first();
        } else {
            $user = User::find($request->user_id);
            if ($user) {
                if (Hash::check($request->pin, $user->pin)) {
                    $date = Carbon::today();
                    $old_default_clockout = Attendance::where('user_id', $user->id)
                        ->where('default_clockout', true)
                        ->first();
                    $already_clocked_in = Attendance::whereDate('date', $date)
                        ->where('user_id', $user->id)
                        ->where('clockout', null)
                        ->first();
                    $clocked_in_today = Attendance::whereDate('date', $date)
                        ->where('user_id', $user->id)
                        ->where('clockout', '!=', null)
                        ->get();
                    $is_already_clocked_in = false;
                    if ($clocked_in_today) {
                        foreach ($clocked_in_today as $clockin) {
                            if (strtotime($request->time) <= strtotime($clockin->clockout)) {
                                $is_already_clocked_in = true;
                            }
                        }
                    }
                    if ($old_default_clockout) {
                        $res['title'] = 'Old Attendance';
                        $res['text'] = 'You are yet to clockout.';
                    } elseif ($already_clocked_in) {
                        $res['title'] = 'Clocked In';
                        $res['text'] = 'You are already clocked in.';
                    } elseif ($is_already_clocked_in) {
                        $res['title'] = 'Clocked In';
                        $res['text'] = 'You were present.';
                    } else {
                        $shift = Shift::find($request->shift_id);
                        $image = str_replace('data:image/png;base64,', '', $request->image);
                        $image = str_replace(' ', '+', $image);
                        $image_name = time() . '-cin.png';
                        Storage::disk('verification')->put($image_name, base64_decode($image));
                        $is_leave = AcceptedLeave::whereDate('date', Carbon::today())
                            ->where('user_id', $user->id)
                            ->count();
                        if ($is_leave >= 1) {
                            $leave = AcceptedLeave::whereDate('date', Carbon::today())
                                ->where('user_id', $user->id)
                                ->first();
                            $data['is_leave'] = true;
                            $data['leave_id'] = $leave->id;
                            $data['leave_type_id'] = $leave->type->id;
                            $data['leave_day'] = $leave->leave->leave_type_full == 1 ? 1 : 0.5;
                        }
                        if ($request->is_changed) {
                            $data['actual_time'] = $request->time;
                            $data['clockin'] = Carbon::now()->format('H:i');
                            $data['status'] = 'unverified';
                        } else {
                            $data['clockin'] = $request->time;
                            $data['status'] = 'verified';
                        }
                        $data['user_id'] = $user->id;
                        $data['date'] = $date;
                        $data['clockin_verification'] = $image_name;
                        $data['shift_id'] = $shift->id;
                        $settings = CompanySetting::where('id', 1)->first();
                        $data['is_late'] = Carbon::parse($request->time)->gt(Carbon::parse($settings->max_allow_time)) ? 1 : 0;
                        $data['remarks'] = $request->remarks;
                        Attendance::create($data);
                        $res['status'] = true;
                    }

                } else {
                    $res['title'] = 'Incorrect pin';
                    $res['text'] = 'Please try again with correct pin.';
                }

            } else {
                $res['title'] = 'No such user found';
                $res['text'] = 'Please try again later';

            }

        }

        return json_encode($res);
    }

    public function getClockoutForm(Request $request)
    {
        $res['status'] = false;
        $res['text'] = '';
        $res['title'] = '';

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['text'] = 'Oops';
            $res['text'] = $errors->first();
        } else {
            $user = User::find($request->user_id);
            $today = Carbon::today();
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->where('clockout', null)
                ->first();
            if ($attendance) {
                $res['status'] = true;
                $res['view'] = view('attendance.component.clockout-form', compact('user', 'attendance'))->render();

            } else {
                $res['text'] = 'Cannot Clockout without clockin';
                $res['title'] = 'Oops';

            }
        }


        return json_encode($res);
    }

    public function clockout(Request $request)
    {
        $res['status'] = false;
        $res['title'] = '';
        $res['text'] = '';

        $validator = Validator::make($request->all(), [
            'pin' => 'required',
            'user_id' => 'required|exists:users,id',
            'attendance_id' => 'required|exists:attendances,id',
            'time' => 'required',
            'image' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title'] = $errors->first();
        } else {
            $user = User::find($request->user_id);
            if ($user) {
                if (Hash::check($request->pin, $user->pin)) {
                    $date = Carbon::today();
                    $attendance = Attendance::where('user_id', $user->id)
                        ->where('id', $request->attendance_id)
                        ->where('clockout', null)
                        ->first();
                    if ($attendance) {

                        $image = str_replace('data:image/png;base64,', '', $request->image);
                        $image = str_replace(' ', '+', $image);
                        $image_name = time() . '-cin.png';
                        Storage::disk('verification')->put($image_name, base64_decode($image));


                        $attendance->clockout = $request->time;
                        $attendance->clockout_verification = $image_name;
                        $attendance->update();

                        $res['status'] = true;
                    } else {
                        $res['title'] = 'Already Clockout';
                        $res['text'] = 'You are already clockedout.';
                    }


                } else {
                    $res['title'] = 'Incoreect pin';
                    $res['text'] = 'Please try again with correct pin.';
                }

            } else {
                $res['title'] = 'No such user found';
                $res['text'] = 'Please try again later';

            }

        }

        return json_encode($res);
    }

    public function markPresent(Request $request)
    {
        $res['status'] = false;
        $res['title'] = '';
        $res['text'] = '';
        $res['redirect'] = true;
        $res['redirect_url'] = route('attendance.monthly');

        $validator = Validator::make($request->all(), [

            'user_id' => 'required|exists:users,id',
            'shift' => 'required|exists:shifts,id',
            'time' => 'required',
            'time.*.clockin' => 'required',
            'time.*.clockout' => 'required',
            'date' => 'required|date',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title'] = $errors->first();
        } else {
            $user = User::find($request->user_id);
            $shift = Shift::find($request->shift);
            $date = Carbon::parse($request->date);

            $old_attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $date)
                ->delete();
            $image_name = time() . 'default-cin.jpg';

            $data['user_id'] = $user->id;
            $data['date'] = $date;
            $data['clockin'] = $request->time[$shift->id]['clockin'];
            $data['clockin_verification'] = $image_name;
            $data['clockout'] = $request->time[$shift->id]['clockout'];
            $data['clockout_verification'] = $image_name;
            $data['shift_id'] = $shift->id;
            $data['remarks'] = "Clockin by " . Auth::user()->name;

            Attendance::create($data);
            $res['status'] = true;

        }
        return json_encode($res);
    }

    public function markAbsent(Request $request)
    {
        $staff = User::where('slug', $request['slug'])->first();
        if ($staff) {
            $attendance = new Attendance();
            $attendance->user_id = $staff->id;
            $attendance->shift_id = $request->shift_id;
            $attendance->date = Carbon::now();
            $attendance->remarks = $request->remarks;
            $attendance->reviewed_by = Auth::user()->id;
            $attendance->is_absent = 1;
            $attendance->save();
            toastr()->success('Marked absent', 'Success !!!');
            return redirect()->route('attendance.today');
        } else {
            toastr()->error('The staff does not exists', 'Error !!!');
            return redirect()->route('attendance.today');
        }
    }

    public function cancelAbsent(Request $request)
    {
        $staff = User::where('slug', $request['slug'])->first();
        $attendance = Attendance::where('user_id', $staff->id)
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->first();

        if ($staff && $attendance) {
            $attendance->delete();
            toastr()->success('Cancelled', 'Success !!!');
            return redirect()->route('attendance.today');
        } else {
            toastr()->error('The staff does not exists', 'Error !!!');
            return redirect()->route('attendance.today');
        }
    }

    public function cancelLeave(Request $request)
    {
        $user = User::where('slug', $request['slug'])->first();
        if ($user) {
            $attendances = $user->today_attendance;
            if ($attendances) {
                foreach ($attendances as $attendance) {
                    $accepted_leave = AcceptedLeave::where('user_id', $user->id)->whereDate('date', now())->first();
                    $accepted_leave->delete();
                    $attendance->delete();
                }
            }
            toastr()->success('Leave Cancelled', 'Success !!!');
            return redirect()->route('attendance.today');
        }
        toastr()->error('The staff does not exists', 'Error !!!');
        return redirect()->route('attendance.today');
    }

    public function getDefaultClockoutForm(Request $request)
    {
        $res['status'] = false;
        $res['text'] = '';
        $res['title'] = '';

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'attendance_id' => 'required|exists:attendances,id'

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['text'] = 'Oops';
            $res['text'] = $errors->first();
        } else {

            $today = Carbon::today();
            $user = User::find($request->user_id);
            $attendance = Attendance::where('id', $request->id)
                ->where('user_id', $user->id)
                ->where('default_clockout', 1)
                ->first();
            if ($attendance) {
                $res['status'] = true;
                $res['view'] = view('attendance.component.default-clockout-form', compact('user', 'attendance'))->render();

            } else {
                $res['text'] = 'Already Clockedout';
                $res['title'] = 'Oops';
            }
        }

        return json_encode($res);
    }

    public function defaultClockout(Request $request)
    {
        $res['status'] = false;
        $res['title'] = '';
        $res['text'] = '';

        $validator = Validator::make($request->all(), [
            'pin' => 'required',
            'user_id' => 'required|exists:users,id',
            'attendance_id' => 'required|exists:attendances,id',
            'time' => 'required',
            'image' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title'] = $errors->first();
        } else {
            $user = User::find($request->user_id);
            if ($user) {
                if (Hash::check($request->pin, $user->pin)) {
                    $date = Carbon::today();
                    $attendance = Attendance::where('user_id', $user->id)
                        ->where('id', $request->attendance_id)
                        ->where('default_clockout', true)
                        ->first();
                    if ($attendance) {

                        $image = str_replace('data:image/png;base64,', '', $request->image);
                        $image = str_replace(' ', '+', $image);
                        $image_name = time() . '-cin.png';
                        Storage::disk('verification')->put($image_name, base64_decode($image));


                        $attendance->clockout = $request->time;
                        $attendance->clockout_verification = $image_name;
                        $attendance->default_clockout = false;
                        $attendance->update();

                        $res['status'] = true;
                    } else {
                        $res['title'] = 'Already Clockout';
                        $res['text'] = 'You are already clockedout.';
                    }


                } else {
                    $res['title'] = 'Incoreect pin';
                    $res['text'] = 'Please try again with correct pin.';
                }

            } else {
                $res['title'] = 'No such user found';
                $res['text'] = 'Please try again later';

            }

        }

        return json_encode($res);
    }

    public function autoDefaultClockout()
    {
        $min_date = config('software.start_date');
        $latest_default_clockout = DefaultClockout::orderBy('id', 'desc')->first();
        if ($latest_default_clockout) {
            $from = Carbon::parse($latest_default_clockout->date);
        } else {
            $from = Carbon::parse($min_date);
        }
        if ($from >= Carbon::yesterday()) {
            dd('yesterday');
        } else {

            $dates = CarbonPeriod::create($from->add(1, 'days'), Carbon::yesterday());

            foreach ($dates as $date) {
                $users = User::where('is_deleted', false)
                    ->where('department_id', '!=', 1)
                    ->get();
                if ($users) {
                    foreach ($users as $user) {
                        //For creating attendance
                        $data['user_id'] = $user->id;
                        $data['date'] = $date;
                        $data['is_absent'] = false;
                        $data['is_holiday'] = false;
                        $data['holiday_id'] = null;
                        $data['holiday_type'] = null;

                        $data['is_leave'] = false;
                        $data['leave_id'] = null;
                        //For creating attendance

                        $is_user_holiday = false;
                        $is_department_holiday = false;
                        $holiday_id = null;

                        if ($user->holidays->count() > 0) {
                            foreach ($user->holidays as $holiday) {
                                if ($holiday->day == $date->format('w')) {
                                    $is_user_holiday = true;
                                    $holiday_id = $holiday->id;

                                }
                            }
                        } else {
                            if ($user->department->holidays->count() > 0) {
                                foreach ($user->department->holidays as $holiday) {
                                    if ($holiday->day == $date->format('w')) {
                                        $is_department_holiday = true;
                                        $holiday_id = $holiday->id;
                                    }
                                }
                            } else {

                            }
                        }
                        $attendances = Attendance::where('user_id', $user->id)->whereDate('date', $date)->get();

                        if ($attendances->count() >= 1) { //If attendance
                            foreach ($attendances as $attendance) {
                                if ($attendance->clockout == null) {//If no clockout
                                    $attendance->clockout = Carbon::now();
                                    $attendance->default_clockout = true;
                                    $attendance->update();
                                }
                            }
                        } else { //If no attendance
                            //Leave Check
                            $leave = AcceptedLeave::where('user_id', $user->id)
                                ->whereDate('date', $date)
                                ->first();

                            //Leave Check
                            if ($is_user_holiday || $is_department_holiday || $leave) { //If holiday

                                if ($leave) {
                                    $data['is_leave'] = true;
                                    $data['leave_id'] = $leave->id;
                                    $data['leave_type_id'] = $leave->type->id;
                                    $data['leave_day'] = 1;

                                } else {
                                    if ($is_user_holiday) {
                                        $data['holiday_id'] = $holiday_id;
                                        $data['holiday_type'] = 01;
                                    } elseif ($is_department_holiday) {
                                        $data['holiday_id'] = $holiday_id;
                                        $data['holiday_type'] = 10;
                                    }
                                    $data['is_holiday'] = true;
                                }
                                Attendance::create($data);
                            } else { //If no Holiday
                                $data['is_absent'] = true;
                                Attendance::create($data);
                            }
                        }

                    }
                }

                $default_clockout_data['date'] = $date;
                DefaultClockout::create($default_clockout_data);
            }

            dd('done');
            die;

        }
    }

    public function monthly()
    {
        if (request()->year && request()->month) {
            $date = Carbon::createFromDate(request()->year, request()->month, date('d'));
            $month = request()->month;
            $year = request()->year;
        } else {
            $date = Carbon::createFromDate(date('Y'), date('m'), date('d'));
            $month = date('m');
            $year = date('Y');
        }

        if ($month > 12 || $month < 1) {
            return redirect()->back();
        }
        // $month=Carbon::now();
        $firstDay = Carbon::createFromDate($year, $month, 1)->firstofMonth();
        $lastDay = Carbon::createFromDate($year, $month, 1)->endofMonth();
        $period = CarbonPeriod::create($firstDay, $lastDay);
        //Header
        $headers = [];
        foreach ($period as $day) {
            $nepali_date = NepaliDate::eng_to_nep($day->format('Y'), $day->format('m'), $day->format('d'));
            $this_day = [
                'w' => $day->format('w'),
                'bs' => $nepali_date['date'],
                'ad' => $day->format('j'),
                'day' => $day->format('D'),
                'is_holiday' => false
            ];
            $headers[] = $this_day;
        }
        //Header
        $users = User::where('is_deleted', false)
            ->where('department_id', '!=', 1)
            ->with('department')
            ->get();
        $attendances = [];
        foreach ($users as $user) {
            $attendance = [];
            $total_working_days = 0;
            $total_holidays = 0;
            $total_present_days = 0;
            $total_absent_days = 0;
            $total_leave_days = 0;

            foreach ($period as $day) {
                $total_working_days += 1;

                $this_attendance = Attendance::where('user_id', $user->id)
                    ->whereDate('date', $day)
                    ->first();

                if ($this_attendance) {
                    if ($this_attendance->is_holiday) {
                        $attendance[] = [
                            'class' => 'holiday',
                            'text' => 'H',
                            'date' => $day,
                        ];
                        $total_holidays += 1;

                    } elseif ($this_attendance->is_absent) {
                        $attendance[] = [
                            'class' => 'absent',
                            'text' => 'A',
                            'date' => $day,
                        ];
                        $total_absent_days += 1;

                    } elseif ($this_attendance->is_leave) {
                        $total_holidays += 1;
                        $total_leave_days += 1;
                        if ($this_attendance->clockin) {
                            if ($this_attendance->leave->is_paid) {
                                $attendance[] = [
                                    'multiple' => true,
                                    'class' => 'paid-leave',
                                    'text' => 'L',
                                    'date' => $day,
                                ];
                            } else {
                                $attendance[] = [
                                    'multiple' => true,
                                    'class' => 'unpaid-leave',
                                    'text' => 'L',
                                    'date' => $day,
                                ];
                            }
                        } else {
                            if ($this_attendance->is_paid) {
                                $attendance[] = [
                                    'multiple' => false,
                                    'class' => 'paid-leave',
                                    'text' => 'L',
                                    'date' => $day,
                                ];
                            } else {
                                $attendance[] = [
                                    'multiple' => false,
                                    'class' => 'unpaid-leave',
                                    'text' => 'L',
                                    'date' => $day,
                                ];
                            }
                        }
                    } else {
                        $total_present_days += 1;
                        $attendance[] = [
                            'class' => 'present',
                            'text' => 'P',
                            'date' => $day,
                        ];
                    }
                } else {
                    $attendance[] = [
                        'class' => 'no-entry',
                        'text' => '-',
                        'date' => $day,
                    ];
                }
            }
            $data = [
                'department_slug' => $user->department->slug,
                'id' => $user->id,
                'name' => $user->name,
                'attendance' => $attendance,
                'total_working_days' => $total_working_days,
                'total_holidays' => $total_holidays,
                'total_present_days' => $total_present_days,
                'total_absent_days' => $total_absent_days
            ];
            $attendances[] = $data;
        }

        $month_info = [
            'total_day' => $period->count(),
            'first_month_eng' => $firstDay->format('M'),
            'last_month_eng' => $lastDay->format('M')
        ];

        $attendances_x = [];
        $departments = Department::with('holidays')->whereNotIn('is_default', [1])->get();
        foreach ($departments as $department) {
            $attendances_x[$department->slug] = [
                'department' => $department
            ];
        }
        // dd($attendances);
        foreach ($attendances as $attendance) {
            $attendances_x[$attendance['department_slug']]['users'][] = $attendance;
        }
        //For next
        if ($month == 12) {
            $next = [
                'year' => $year + 1,
                'month' => 1
            ];
        } else {
            $next = [
                'year' => $year,
                'month' => $month + 1
            ];
        }
        //For Prev
        if ($month == 1) {
            $prev = [
                'year' => $year - 1,
                'month' => 12
            ];
        } else {
            $prev = [
                'year' => $year,
                'month' => $month - 1
            ];
        }

        //For Prev
        $current = [
            'year' => $year,
            'month' => $month
        ];

        $is_salary_paid = SalaryPaid::whereMonth('date', $month)->whereYear('date', $year)->first();

        $is_real = false;
        if ($is_salary_paid) {
            $is_real = true;
        }


        if ($year == date('Y') && $month == date('m')) {
            $next['show'] = false;
        } else {
            $next['show'] = true;
        }
        return view('attendance.monthly')
            ->with('month_info', $month_info)
            ->with('users', $users)
            ->with('attendances', $attendances_x)
            ->with('headers', $headers)
            ->with('current', $current)
            ->with('prev', $prev)
            ->with('next', $next)
            ->with('is_real', $is_real);
    }

    public function today()
    {
        $users = User::where('department_id', '!=', 1)
            ->where('is_deleted', false)
            ->where('department_id', '!=', 1)
            ->with('today_attendance')
            ->get();
        $departments = Department::with('shifts')->where('is_default', false)->get();
        foreach ($departments as $department) {
            $attendances[$department->slug] = [
                'department' => $department
            ];
        }
        foreach ($users as $user) {
            $attendances[$user->department->slug]['users'][] = [
                'user' => $user
            ];
        }
        return view('attendance.today')->with('attendances', $attendances);
    }

    public function export()
    {

        if (request()->year && request()->month) {
            $date = Carbon::createFromDate(request()->year, request()->month, date('d'));
            $month = request()->month;
            $year = request()->year;
        } else {
            $date = Carbon::createFromDate(date('Y'), date('m'), date('d'));
            $month = date('m');
            $year = date('Y');
        }

        $users = User::where('department_id', '!=', 1)
            ->where('is_deleted', false)
            ->where('department_id', '!=', 1)
            ->with('leave_types')
            ->get();
        $firstDay = Carbon::createFromDate($year, $month, 1);
        $midDay = Carbon::createFromDate($year, $month, 1)->add(14, 'days');

        $lastDay = Carbon::createFromDate($year, $month, 1)->endofMonth();
        $period = CarbonPeriod::create($firstDay, $lastDay);
        $data['month'] = $midDay->format('M');
        $data['year'] = $midDay->format('Y');
        $filename = 'Timesheet ' . $date->format('Y-m') . ' ' . time() . '.xlsx';
        // Storage::disk('files')->delete('a.xlsx');
        $spreadsheet = new Spreadsheet();
        $sheet_count = 0;
        $company_name = Setting::firstOrCreate(
            ['key' => 'company-name'], ['value' => 'Hrlite']
        )->value;
        foreach ($users as $user) {
            $department = $user->department;
            $shift = $department->shifts->first();

            $total_worked_hr = 0;
            $min_working_hr = 0;
            $total_working_days = 0;
            $total_worked_days = 0;
            $total_worked_hr_code = "=SUM(";
            $sheet = $spreadsheet->setActiveSheetIndex($sheet_count);
            $sheet->setTitle($user->name);
            $sheet->getColumnDimension('A')->setWidth(15);
            $sheet->getColumnDimension('B')->setWidth(15);

            $sheet->getColumnDimension('E')->setWidth(60);
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->getColumnDimension('F')->setWidth(10);
            $sheet->getColumnDimension('G')->setWidth(13);
            $sheet->getColumnDimension('H')->setWidth(13);

            //First line
            $line = 1;
            $fontStyle = [
                'font' => [
                    'size' => 20,
                    'bold' => true,

                ]
            ];
            $sheet->getStyle('A' . $line . ':H' . $line)
                ->applyFromArray($fontStyle);
            $sheet->setCellValue('A' . $line, $company_name);
            $range1 = 'A' . $line;
            $range2 = 'H' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");
            $sheet->getStyle('A' . $line)->getAlignment()->setHorizontal('center');
            //First Line End

            //Second line
            $line += 1;
            $sheet->setCellValue('A' . $line, '');
            $range1 = 'A' . $line;
            $range2 = 'H' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");
            $sheet->getStyle('A' . $line)->getAlignment()->setHorizontal('center');
            //Second Line

            //Second line
            $fontStyle = [
                'font' => [
                    'size' => 18,
                    'bold' => true,
                    'underline' => true
                ]
            ];
            $line += 1;
            $sheet->setCellValue('A' . $line, 'Time Sheet')
                ->getStyle('A' . $line . ':H' . $line)
                ->applyFromArray($fontStyle);
            $range1 = 'A' . $line;
            $range2 = 'H' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");
            $sheet->getStyle('A' . $line)->getAlignment()->setHorizontal('center');

            //Second Line

            //Third
            $line += 1;
            $fontStyle = [
                'font' => [
                    'size' => 11,
                    'bold' => true
                ]
            ];
            $sheet->getStyle('A' . $line . ':H' . $line)
                ->applyFromArray($fontStyle);
            $sheet->setCellValue('A' . $line, 'Name:' . $user->name);
            $range1 = 'A' . $line;
            $range2 = 'E' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");
            $sheet->setCellValue('F' . $line, 'Month/Year:' . $data['month'] . ',' . $data['year']);
            $range1 = 'F' . $line;
            $range2 = 'H' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");
            $sheet->getStyle('A' . $line)->getAlignment()->setHorizontal('left');
            //Third

            //Fourth
            $line += 1;
            $fontStyle = [
                'font' => [
                    'size' => 11,
                    'bold' => true
                ]
            ];
            $sheet->getStyle('A' . $line . ':H' . $line)
                ->applyFromArray($fontStyle);

            $sheet->setCellValue('A' . $line, 'Designation: ' . $user->designation);
            $range1 = 'A' . $line;
            $range2 = 'E' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");

            $sheet->setCellValue('F' . $line, 'Office Time: ' . date("g:i a", strtotime($shift->clockin)) . '-' . date("g:i a", strtotime($shift->clockout)));
            $range1 = 'F' . $line;
            $range2 = 'H' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");
            $sheet->getStyle('A' . $line)->getAlignment()->setHorizontal('left');

            //Fourth

            //Header
            $line += 1;
            $fontStyle = [
                'font' => [
                    'size' => 12,
                    'bold' => true
                ],
                'borders' => array(
                    'outline' => array(
                        'color' => array('argb' => 'FFFF0000'),
                    ),
                ),
            ];
            $sheet->getStyle('A' . $line . ':H' . $line)
                ->applyFromArray($fontStyle);

            $sheet->setCellValue('A' . $line, 'AD')
                ->setCellValue('B' . $line, 'BS')
                ->setCellValue('C' . $line, 'Day')
                ->setCellValue('D' . $line, 'Clockin')
                ->setCellValue('E' . $line, 'Description of Work')
                ->setCellValue('F' . $line, 'Clockout')
                ->setCellValue('G' . $line, 'Actual Time')
                ->setCellValue('H' . $line, 'Worked Time');
            //HEader

            //Attendance
            $line += 1;
            $total_working_days = 0;
            $total_worked_days = 0;

            foreach ($period as $key => $date) {
                if ($key == 0) {
                    $total_worked_hr_code .= 'H' . $line;
                }

                if ($key == $period->count() - 1) {
                    $total_worked_hr_code .= ':H' . $line . ')';
                }
                $attendance = Attendance::where('user_id', $user->id)
                    ->whereDate('date', $date)
                    ->first();
                $nepali_date = NepaliDate::eng_to_nep($date->format('Y'), $date->format('m'), $date->format('d'));

                $clockin = '-';
                $clockout = '-';
                $description = "";
                $actual_time = 0;
                $worked_time = 0;
                if ($attendance) {
                    if ($attendance->is_holiday) {
                        if ($attendance->holiday_type == 01) {
                            $description = 'User Holiday:' . $attendance->holiday->day;
                        } elseif ($attendance->holiday_type == 10) {
                            $description = 'Department Holiday:' . $attendance->holiday->day;
                        }

                    } elseif ($attendance->is_leave) {
                        $total_working_days += 1;
                        $description = 'Leave: ';
                        if ($attendance->clockin != null) {
                            $description = 'Half Leave: ';
                            $clockin = date("g:i a", strtotime($attendance->clockin));
                            $total_worked_days += 0.5;

                            if ($attendance->clockout) {
                                $clockout = date("g:i a", strtotime($attendance->clockout));
                                $in = Carbon::parse($attendance->clockin);
                                $out = Carbon::parse($attendance->clockout);

                                $worked_time = $in->diffInSeconds($out) / (60 * 60);

                            } else {
                                $clockout = '-';
                            }

                            $reports = Report::where('user_id', $user->id)
                                ->whereDate('date', $date)
                                ->get();
                            if ($reports) {
                                foreach ($reports as $report) {
                                    $description .= $report->description . "\n";
                                }
                            }
                        }

                    } elseif ($attendance->is_absent) {
                        $total_working_days += 1;

                        $description = 'Absent';

                    } else {
                        $clockin = date("g:i a", strtotime($attendance->clockin));
                        $total_working_days += 1;
                        $total_worked_days += 1;

                        if ($attendance->clockout) {
                            $clockout = date("g:i a", strtotime($attendance->clockout));
                            $in = Carbon::parse($attendance->clockin);
                            $out = Carbon::parse($attendance->clockout);

                            $worked_time = $in->diffInSeconds($out) / (60 * 60);
                        } else {
                            $clockout = '-';
                        }

                        $reports = Report::where('user_id', $user->id)
                            ->whereDate('date', $date)
                            ->get();
                        if ($reports) {
                            foreach ($reports as $report) {
                                $description .= $report->description . "\n";
                            }
                        }
                    }
                } else {
                    $total_working_days += 1;
                    $description = 'No Entry';
                }
                $sheet->setCellValue('A' . $line, $date->format('Y-m-j'))
                    ->setCellValue('B' . $line, $nepali_date['year'] . '-' . $nepali_date['month'] . '-' . $nepali_date['date'])
                    ->setCellValue('C' . $line, $date->format('D'))
                    ->setCellValue('D' . $line, $clockin)
                    ->setCellValue('E' . $line, $description)
                    ->setCellValue('F' . $line, $clockout)
                    ->setCellValue('G' . $line, $actual_time)
                    ->setCellValue('H' . $line, $worked_time);
                $sheet->getStyle('E' . $line)->getAlignment()->setWrapText(true);

                $line += 1;
            }

            //Attendance

            //Footer
            $line += 1;
            $total_hr_line = $line;
            $sheet->setCellValue('E' . $line, 'Total Working Hours')
                ->setCellValue('H' . $line, $total_worked_hr_code)
                ->setCellValue('G' . $line, $total_worked_hr_code);

            $line += 1;
            $min_hr_line = $line;

            $sheet->setCellValue('E' . $line, 'Minimum Working Hours (Per Month)')
                ->setCellValue('H' . $line, '=40*4')
                ->setCellValue('G' . $line, '=40*4');

            $line += 1;
            $sheet->setCellValue('E' . $line, 'Difference  (Excess/Less)')
                ->setCellValue('G' . $line, '=G' . $total_hr_line . '-G' . $min_hr_line)
                ->setCellValue('H' . $line, '=H' . $total_hr_line . '-H' . $min_hr_line);


            $line += 1;
            $sheet->setCellValue('E' . $line, 'Total Working Days =' . $total_working_days);
            $range1 = 'F' . $line;
            $range2 = 'H' . $line;
            $sheet->mergeCells("{$range1}:{$range2}");
            $sheet->setCellValue('F' . $line, 'Total Worked Days =' . $total_worked_days);

            //Footer

            //Leave Section
            $line += 1;
            $fontStyle = [
                'font' => [
                    'size' => 11,
                    'bold' => true
                ]
            ];
            $sheet->getStyle('A' . $line . ':H' . $line)
                ->applyFromArray($fontStyle);
            $sheet->setCellValue('A' . $line, 'Type')
                ->setCellValue('B' . $line, 'Begin Bal')
                ->setCellValue('C' . $line, 'Taken')
                ->setCellValue('D' . $line, 'Ending Bal');

            $user_leave_types = [];
            $this_fiscal_year_start = Setting::where('key', 'fiscal-year-start')->first()->value;
            $this_fiscal_year_end = Setting::where('key', 'fiscal-year-end')->first()->value;
            $this_fiscal_year_start_year = date('Y');
            $this_fiscal_year_end_year = Carbon::now()->add(1, 'year')->format('Y');


            $fiscal_year_start = Carbon::parse($this_fiscal_year_start_year . '-' . $this_fiscal_year_start);
            $fiscal_year_end = Carbon::parse($this_fiscal_year_end_year . '-' . $this_fiscal_year_end);

            $fiscal_year = [
                'this_start' => Carbon::parse($this_fiscal_year_start_year . '-' . $this_fiscal_year_start)->format('Y-m-d'),
                'this_end' => Carbon::parse($this_fiscal_year_end_year . '-' . $this_fiscal_year_end)->format('Y-m-d')
            ];
            foreach ($user->leave_types as $user_leave_type) {
                $total_leave = $user_leave_type->days;
                $leave_taken = Attendance::where('user_id', $user->id)
                    ->where('is_leave', true)
                    ->where('leave_type_id', $user_leave_type->leave_type->id)
                    ->whereDate('date', '>=', $fiscal_year_start)
                    ->whereDate('date', '<=', $fiscal_year_end)
                    ->sum('leave_day');
                if ($user->joined->gt($fiscal_year_start)) { //Partial leave
                    $unavailable_days = $user->joined->diffInDays($fiscal_year_start);
                    $total_days = $fiscal_year_end->diffInDays($fiscal_year_start);
                    $available_days = $total_days - $unavailable_days;
                    $available_percent = ($available_days * 100) / $total_days;


                    $available_leave = ($available_percent / 100) * $total_leave;
                    $user_leave_types[] = [
                        'name' => $user_leave_type->leave_type->name,
                        'yearly' => $available_leave,
                        'taken' => $leave_taken,
                        'available' => $available_leave - $leave_taken
                    ];
                } else {//100% holiday
                    $user_leave_types[] = [
                        'name' => $user_leave_type->leave_type->name,
                        'yearly' => $total_leave,
                        'taken' => $leave_taken,
                        'available' => $total_leave - $leave_taken
                    ];
                }
            }
            foreach ($user_leave_types as $user_leave_type) {
                $line += 1;
                $sheet->setCellValue('A' . $line, $user_leave_type['name'])
                    ->setCellValue('B' . $line, $user_leave_type['yearly'])
                    ->setCellValue('C' . $line, $user_leave_type['taken'])
                    ->setCellValue('D' . $line, $user_leave_type['available']);
            }
            //Leave Section

            $sheet_count++;
            $spreadsheet->createSheet();
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('files/' . $filename);
        return response()->download(public_path('files/' . $filename));
        die;
        return Storage::download($url);
        return response()->download(storage_path('app/files/' . $filename));
    }

    public function getVerificationImage($name)
    {
        $file = Storage::disk('verification')->get($name);
        return new Response($file, 200);
    }

    public function getAttendanceDetail(Request $request)
    {
        $res['status'] = false;
        $res['title'] = '';
        $res['text'] = '';

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date'

        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $res['title'] = $errors->first();
        } else {
            $user = User::with('department', 'department.shifts')->where('id', $request->user_id)->first();
            $date = Carbon::parse($request->date);
            $nepali_date = NepaliDate::eng_to_nep($date->format('Y'), $date->format('m'), $date->format('d'));

            $attendances = Attendance::where('user_id', $user->id)->whereDate('date', $date)->get();
            $is_leave = false;
            $is_holiday = false;
            $is_absent = false;
            $is_present = false;
            $is_salary_paid = SalaryPaid::whereMonth('date', $date->format('m'))->whereYear('date', $date->format('y'))->first();
            $is_real = false;
            if ($is_salary_paid) {
                $is_real = true;
            }
            if ($attendances->count() == 0) { //No entry
                $res['status'] = true;
                $res['view'] = view('attendance.component.noentry-modal', compact('user', 'date', 'nepali_date', 'is_real'))->render();
            } elseif ($attendances->count() >= 1) { //Present //Absent //Holiday //Leave
                foreach ($attendances as $attendance) {
                    if ($attendance->is_holiday) {
                        $is_holiday = true;
                    } elseif ($attendance->is_absent) {
                        $is_absent = true;
                    } elseif ($attendance->is_leave) {
                        if ($attendance->clockin) {
                            $is_leave = true;
                            $is_present = true;
                        } else {
                            $is_leave = true;
                        }

                    } else {
                        $is_present = true;
                    }
                }
            }

            if ($is_present && $is_leave) {
                $res['view'] = view('attendance.component.present-modal', compact('user', 'attendances', 'date', 'nepali_date', 'is_leave', 'is_real'))->render();
            } elseif ($is_leave) {
                $leave_type = '';
                $reason = '';

                foreach ($attendances as $attendance) {
                    $leave_type = $attendance->leave_type->name;
                    $reason = $attendance->remarks;
                }
                $res['view'] = view('attendance.component.leave-modal', compact('user', 'attendances', 'date', 'nepali_date', 'is_leave', 'leave_type', 'reason', 'is_real'))->render();

            } elseif ($is_holiday) {
                $holiday_type = '';
                $holiday_reason = '';
                // 01->user
                // 10->department
                // 11->custom
                foreach ($attendances as $attendance) {
                    if ($attendance->holiday_type == 01) {
                        $holiday_type = 'user';
                        $day = $attendance->holiday->day;
                        $holiday_reason = $day;
                    } elseif ($attendance->holiday_type == 10) {
                        $holiday_type = 'department';
                        $day = $attendance->holiday->day;
                        $holiday_reason = $day;
                    } elseif ($attendance->holiday_type == 11) {
                        $holiday_type = 'custom';
                        $day = $attendance->holiday->day;
                        $holiday_reason = $day;
                    }
                }
                $res['view'] = view('attendance.component.holiday-modal', compact('user', 'attendances', 'date', 'nepali_date', 'holiday_type', 'holiday_reason'))->render();

            } elseif ($is_absent) {
                $res['view'] = view('attendance.component.absent-modal', compact('user', 'attendances', 'date', 'nepali_date', 'is_real'))->render();

            } elseif ($is_present) {
                $res['view'] = view('attendance.component.present-modal', compact('user', 'attendances', 'date', 'nepali_date', 'is_leave'))->render();
            }
            $res['data'] = [
                'present' => $is_present,
                'absent' => $is_absent,
                'holiday' => $is_holiday,
                'leave' => $is_leave,
            ];
            $res['at'] = $attendances;
            $res['status'] = true;

        }

        return json_encode($res);
    }

    public function verifyAttendance(Request $request)
    {
        $res['status'] = false;
        $res['title'] = '';
        $res['text'] = '';
        $attendance = Attendance::where('id', $request->attendanceId)->first();
        if ($attendance) {
            $remarks = $attendance->remarks;
            $additionalRemarks = "Actual clock-in time: " . $attendance->clockin . "Changed to: " . $attendance->actual_time;
            $newRemarks = $remarks . " " . $additionalRemarks;
            if ($request->action == 'accept') {
                $attendance->clockin = $attendance->actual_time;
                $attendance->status = 'verified';
                $attendance->remarks = $newRemarks . " Status:Accepted";
                $res['title'] = 'Approved';
                $res['text'] = 'Employee\'s attendance has been approved successfully';
            } elseif ($request->action == 'decline') {
                $attendance->status = 'verified';
                $attendance->remarks = $newRemarks . "Status:Declined";
                $res['title'] = 'Declined';
                $res['text'] = 'Employee\'s attendance has been declined successfully';
            }
            $attendance->remarks =
                $attendance->save();
            $res['status'] = true;
        } else {
            $res['title'] = 'Attendance not found';
            $res['text'] = 'Please try again later';
        }
        return json_encode($res);
    }

    public function workFromHome(Request $request)
    {
        $staff = User::where('slug', $request['slug'])->first();
        $shift = Shift::where('id', $request->shift_id)->first();
        if ($staff) {
            $attendance = new Attendance();
            $attendance->user_id = $staff->id;
            $attendance->shift_id = $request->shift_id;
            $attendance->date = Carbon::now()->format('Y-m-d');
            $attendance->clockin = $shift->clockin;
            $attendance->clockin_verification = $staff->profile_image ? $staff->profile_image : '';
            $attendance->clockout = $shift->clockout;
            $attendance->clockout_verification = $staff->profile_image ? $staff->profile_image : '';
            $attendance->remarks = '<pre>' . $request->remarks . '</pre>';
            $attendance->is_wfh = 1;
            $attendance->reviewed_by = Auth::user()->id;
            $attendance->save();
            toastr()->success('Selected employee is working from home', 'Success !!!');
            return redirect()->route('attendance.today');
        } else {
            toastr()->error('The staff does not exists', 'Error !!!');
            return redirect()->route('attendance.today');
        }
    }

    public function cancelWFH(Request $request)
    {
        //need to add function
        //seed for cancel absent function
    }
}
