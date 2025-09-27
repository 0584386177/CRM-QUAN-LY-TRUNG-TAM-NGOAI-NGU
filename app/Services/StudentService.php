<?php

namespace App\Services;

use App\Models\Course;
use App\Models\PaymentHistoric;
use App\Repositories\StudentRepositoryEloquent;
use App\Services\Interfaces\StudentServiceInterface;
use App\Traits\UploadFileTrait;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class StudentService
 * @package App\Services
 */
class StudentService implements StudentServiceInterface
{
    use UploadFileTrait;
    protected $studentRepo;

    public function __construct(StudentRepositoryEloquent $studentRepo)
    {
        $this->studentRepo = $studentRepo;
    }

    public function create(array $payload)
    {
        DB::beginTransaction();
        try {

            if ($payload) {
                if (isset($payload['course_id'])) {
                    $course = Course::find($payload['course_id']);
                    if ($course) {
                        $fee_amount = $course->fee;
                        $payload['fee_amount'] = $fee_amount;
                    } else {
                        throw new Exception('Không tìm thấy khóa học');
                    }
                } else {
                    throw new Exception('Chưa chọn khóa học');
                }
                $paid_amount = $payload['paid_amount'] ?? 0; // ép về 0 nếu null
                $remaining = $payload['remaining'] ?? ($fee_amount - $paid_amount);
                $payment_method = $payload['payment_method'] ?? 'cash';

                // Lấy học phí từ khóa học đã chọn
                if (isset($payload['course_id'])) {
                    $course = Course::find($payload['course_id']);
                    if ($course) {
                        $fee_amount = $course->fee;
                        $payload['fee_amount'] = $fee_amount;
                    } else {
                        throw new Exception('Không tìm thấy khóa học');
                    }
                } else {
                    throw new Exception('Chưa chọn khóa học');
                }

                if (isset($payload['avatar']) && !empty($payload['avatar'])) {
                    $payload['avatar'] = $this->uploadAvatar($payload['avatar']);
                }
                $student = $this->studentRepo->create($payload);
                // ĐỒNG BỒ ID
                $student->classes()->sync($payload['class_id']);
                $student->courses()->sync($payload['course_id']);
                $student->teachers()->sync($payload['teacher_id']);

                // Khởi tạo mặc định
                $fee_status = 'unpaid';
                // CHƯA ĐÓNG TIỀN
                if ($paid_amount == 0 && $remaining == $fee_amount) {
                    $fee_status = 'unpaid';
                    // CÒN THIẾU
                } elseif ($paid_amount > 0 && $paid_amount < $fee_amount) {
                    $fee_status = 'partial';
                    // ĐÃ THANH TOÁN
                } elseif ($paid_amount == $fee_amount) {
                    $fee_status = 'paid';
                }

                PaymentHistoric::create([
                    'class_id' => $payload['class_id'],
                    'course_id' => $payload['course_id'],
                    'student_id' => $student->id,
                    'paid_amount' => $paid_amount,
                    'remaining' => $remaining,
                    'fee_status' => $fee_status,
                    'payment_method' => $payment_method,
                    'payment_date' => today(),
                ]);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollback();
            exit();
            return false;
        }
    }
    public function update($id, $payload)
    {

        $student = $this->studentRepo->find($id);
        DB::beginTransaction();
        try {
            if ($student) {
                $payload = $payload->except(['_token']);
                $student->courses()->sync($payload['course_id']);
                $student->classes()->sync($payload['class_id']);
                $student->teachers()->sync($payload['teacher_id']);
                $this->studentRepo->update($payload, $id);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function updateTuition($id, $payload)
    {
        $student = $this->studentRepo->find($id);

        DB::beginTransaction();
        try {
            if (!$student) {
                throw new Exception('Không tìm thấy thông tin học viên');
            }

            // Lấy lớp và học phí gốc từ bảng class_students
            $class = $student->classes()->first();
            $course = $student->courses()->first();
            if (!$class) {
                throw new Exception('Học viên chưa thuộc lớp nào');
            }

            $class_id = $class->id;
            $course_id = $course->id;
            $fee_amount = $course->fee;



            // Tính tổng số tiền đã đóng trước đó
            $total_paid = $student->payments()
                ->where('course_id', $course_id)
                ->sum('paid_amount');

            // Khoản đóng thêm
            $update_amount = $payload['tuition'];
            $payment_method = $payload['payment_method'];

            // Sau khi update
            $new_total_paid = $total_paid + $update_amount;
            $remaining = max($fee_amount - $new_total_paid, 0);

            // Xác định trạng thái
            $fee_status = 'unpaid';
            if ($new_total_paid == 0 || $fee_amount == $remaining) {
                $fee_status = 'unpaid';
            } elseif ($new_total_paid < $fee_amount) {
                $fee_status = 'partial';
            } else {
                $fee_status = 'paid';
            }

            // Thêm bản ghi vào payment_histories
            $student->payments()->create([
                'student_id' => $student->id,
                'course_id' => $course_id,
                'class_id' => $class_id,
                'paid_amount' => $update_amount,
                'remaining' => $remaining,
                'fee_status' => $fee_status,
                'payment_method' => $payment_method,
                'payment_date' => now(),
            ]);

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
