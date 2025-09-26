<?php

namespace App\Http\Controllers\Backend;

use App\Enum\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Student;
use App\Repositories\StudentRepositoryEloquent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    protected $studentRepo;

    public function __construct(StudentRepositoryEloquent $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    public function student($id)
    {
        $student = Student::with([
            'classes',
            'courses',
            'payments' => function ($query) {
                $query->orderBy('payment_date', 'desc')->paginate(5);
            },
        ])->find($id);
        if (!$student) {
            flash()->error('Không tìm thấy thông tin');
            return back();
        }

        $payment_method = $student->payments->pluck('payment_method')->first();
        $payment_label = PaymentMethod::label()[$payment_method] ?? 'Chưa cập nhật';
        $template = 'backend.student.profile';
        foreach ($student->courses as $course) {
            $summary = $this->getTuitionStudent($student, $course->id);
        }
        return view('layouts.admin', compact('template', 'student', 'summary'));
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function getTuitionStudent($student, $course_id)
    {
        $fee_amount = $student->courses()
            ->where('course_id', $course_id)
            ->pluck('fee')
            ->first() ?? 0;

        $paid_amount = $student->payments()
            ->where('course_id', $course_id)
            ->sum('paid_amount');

        $remaining = $fee_amount - $paid_amount;

        $status = 'unpaid';
        if ($paid_amount == 0) {
            $status = 'unpaid';
        } elseif ($paid_amount < $fee_amount) {
            $status = 'partial';
        } else {
            $status = 'paid';
        }

        return [
            'fee' => $fee_amount,
            'paid_amount' => $paid_amount,
            'remaining' => $remaining,
            'fee_status' => $status,
        ];
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
